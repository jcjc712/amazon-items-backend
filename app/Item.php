<?php

namespace App;

use App\Models\ThirdPartyItems\ThirdPartyFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        "asin",
        "detailPageURL",
        "smallImage",
        "largeImage",
        "price",
        "pages",
        "title",
        "studio",
        "author"
    ];
    public function matchWithLocalItems($thirdPartyResponse){
        /*TODO if user is logge in do...*/
        /*TODO match my items with these...*/
        $userId = 1;
        $user = User::find(1);

        $matches = $user->items()->whereIn('asin',$thirdPartyResponse['asinList'])->get();
        foreach ($matches as  $localItem){
            foreach ($thirdPartyResponse['rows'] as $index => $item){
                if($item['asin'] == $localItem->asin){
                    $thirdPartyResponse['rows'][$index]['follow'] = 1;
                    break;
                }
            }
        }

        return $thirdPartyResponse;
    }

    public function whichItemsNonExistent($wishedItems){
        $matchItems = $this->select('asin')->whereIn('asin', $wishedItems)->pluck('asin')->toArray();
        $result = array_diff($wishedItems, $matchItems);
        return $result;
    }

    public function lookForItems($lookForItems){
        $lookForItems = implode (", ", $lookForItems);
        $service = 'SpecificAmazon';
        $thirdParty = ThirdPartyFactory::create($service);
        /*Make the request to the thirdparty*/
        $response = $thirdParty->makeRequest($lookForItems);
        $processResponse = $thirdParty->processResponse($response);
        return $processResponse;
    }

    public function saveItems($responseItems){
        /*Create item with images*/
        foreach ($responseItems['rows'] as $responseItem){
            $images = $responseItem['img'];
            unset($responseItem['img']);
            $item = $this->create($responseItem);
            foreach ($images as $img){
                $img['item_id'] = $item->id;
                Media::create($img);
            }
        }
    }

    public function attachOrDetachItem($items, $action, $user){
        $localItems = $this->select('items.id')
            ->whereIn('asin', $items)
            ->pluck('items.id')->toArray();
        if($action == 'attach') {
            $user->items()->attach($localItems);
        }
        else {
            $user->items()->detach($localItems);
        }
    }

    public function user(){
        return $this->belongsToMany('App\User', 'wishlists', 'user_id', 'item_id');
    }

    public function images(){
        return $this->hasMany('App\Media', 'item_id', 'id');
    }
}
