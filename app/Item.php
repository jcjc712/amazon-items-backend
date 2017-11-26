<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function matchWithLocalItems($thirdPartyResponse){
        /*TODO if user is logge in do...*/
        /*TODO match my items with these...*/
        return $thirdPartyResponse;
    }
}
