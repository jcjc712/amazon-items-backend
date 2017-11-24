<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/parse', function (){


});
Route::get('/', function () {
// Your Access Key ID, as taken from the Your Account page
    $access_key_id = "AKIAJMQR4HOSKT5AMSIA";

// Your Secret Key corresponding to the above ID, as taken from the Your Account page
    $secret_key = "dcwfMUcJ2nJVl0h2xoWi9GIdyQ13XrXfMWUZc+Ky";

// The region you are interested in
    $endpoint = "webservices.amazon.com.mx";

    $uri = "/onca/xml";

    $params = array(
        "Service" => "AWSECommerceService",
        "Operation" => "ItemSearch",
        "AWSAccessKeyId" => "AKIAJMQR4HOSKT5AMSIA",
        "AssociateTag" => "103573b-20",
        "SearchIndex" => "VideoGames",
        "ResponseGroup" => "Images,ItemAttributes,Offers",
        "Title" => "horizon"
    );

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

    $client = new \GuzzleHttp\Client();
    $response = $client->request('GET', $request_url, [
        'headers' => ['Accept' => 'application/xml'],
        'timeout' => 120
    ])->getBody()->getContents();

    $responseXml = simplexml_load_string($response);


    foreach($responseXml->Items->Item as $item){
        //dd($item);
        echo("id:".(string)$item->ASIN."<br>");
        echo("detailUrl:".(string)$item->DetailPageURL."<br>");
        echo("smallImage:".(string)$item->SmallImage->URL."<br>");
        echo("largeImage:".(string)$item->LargeImage->URL."<br>");
        echo("price:".(string)$item->ItemAttributes->ListPrice->FormattedPrice."<br>");
        echo("pages:".(string)$item->ItemAttributes->NumberOfPages."<br>");
        echo("title:".(string)$item->ItemAttributes->Title."<br>");
        echo("studio:".(string)$item->ItemAttributes->Studio."<br>");
        echo("author:".(string)$item->ItemAttributes->Author."<br>");
        //ImageSets->ImageSet foreach

        //Offers Offer OfferListing  Price FormattedPrice
        echo "<br>";
    }
});
