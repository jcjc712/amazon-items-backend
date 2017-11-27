<?php
namespace App\Models\ThirdPartyItems;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use function GuzzleHttp\Psr7\str;

/**
 * Created by PhpStorm.
 * User: juancarlosjosecamacho
 * Date: 11/25/17
 * Time: 00:41
 */
class SearchAmazonItems implements ThirdPartyIterface
{
    public function makeRequest($paramsRequest){
        // Your Secret Key corresponding to the above ID, as taken from the Your Account page
        $secret_key = env('AWS_SECRET_KEY');
        // The region you are interested in
        $endpoint = env('AWS_URL');
        $uri = "/onca/xml";
        $params = array(
            "Service" => "AWSECommerceService",
            "Operation" => "ItemSearch",
            "AWSAccessKeyId" => env('AWS_ACCESS_KEY_ID'),
            "AssociateTag" => env('AWS_ASSOCIATE_TAG'),
            "SearchIndex" => $paramsRequest->searchIndex,
            "ResponseGroup" => "Images,ItemAttributes,Offers",
            "Keywords" => $paramsRequest->keywords,
            "Sort" => $paramsRequest->sort,
            "ItemPage" => $paramsRequest->itemPage
        );
        /*To add more filters*/
        if(isset($paramsRequest->filters)){
            foreach ($paramsRequest->filters as $index => $item){
                $params[$index] = $item;
            }
        }

        // Set current timestamp if not set
        if (!isset($params["Timestamp"])) {
            $params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
        }
        // Sort the parameters by key
        ksort($params);
        $pairs = array();
        foreach ($params as $key => $value) {
            array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
        }
        // Generate the canonical query
        $canonical_query_string = join("&", $pairs);
        // Generate the string to be signed
        $string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;
        // Generate the signature required by the Product Advertising API
        $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $secret_key, true));
        // Generate the signed URL
        $request_url = 'http://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);
        /*Make request*/
        $client = new Client();
        $response = $client->request('GET', $request_url, [
            'headers' => ['Accept' => 'application/xml'],
            'timeout' => 120
        ])->getBody()->getContents();
        /*parses xml*/
        return simplexml_load_string($response);
    }

    public function processResponse($response){
        $respPrecess = [];
        $count = 0;
        $asinList = [];
        foreach($response->Items->Item as $index => $item){
            array_push($asinList,(string)$item->ASIN);
            $respPrecess[] = [
                "asin" => (string)$item->ASIN,
                "detailPageURL" => (string)$item->DetailPageURL,
                "smallImage" => (string)$item->MediumImage->URL,
                "largeImage" => (string)$item->LargeImage->URL,
                "price" => (string)$item->ItemAttributes->ListPrice->FormattedPrice,
                "pages" => (string)$item->ItemAttributes->NumberOfPages,
                "title" => (string)$item->ItemAttributes->Title,
                "studio" => (string)$item->ItemAttributes->Studio,
                "author" => (string)$item->ItemAttributes->Author,
                "follow" => 0,

            ];
            /*To get many images for media*/
            foreach ($item->ImageSets as $index => $image) {
                $respPrecess[$count]['img'][] = [
                    "mediumImage" => (string)$image->ImageSet->MediumImage->URL,
                    "largeImage" => (string)$image->ImageSet->LargeImage->URL
                ];
            }
            /*List of offers*/
            foreach ($item->Offers as $idex => $offer){
                if(isset($offer->Offer->OfferListing->Price->FormattedPrice)){
                    $respPrecess[$count]['offers'][] = [
                        "offerPrice" => (string)$offer->Offer->OfferListing->Price->FormattedPrice,
                    ];
                }
            }
            $count += 1;
        }
        return [
            "msg"=>"success",
            "rows"  =>  $respPrecess,
            "totalResults"  =>  (string)$response->Items->TotalResults,
            "totalPages"    =>  (string)$response->Items->TotalPages,
            "currentPage"   =>  (string)$response->Items->Request->ItemSearchRequest->ItemPage,
            "asinList"      => $asinList
        ];
    }
}