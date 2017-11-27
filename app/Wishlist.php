<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlists';

    public function item(){
        return $this->belongsTo('App\Item',  'item_id', 'id');
    }

    public function specificItem(){
        $item = $this->item->toArray();
        $item['img'] = $this->item->images->toArray();
        return $item;
    }
}
