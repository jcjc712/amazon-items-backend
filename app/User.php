<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function items(){
        return $this->belongsToMany('App\Item', 'wishlists', 'user_id', 'item_id');
    }

    public function listOfItems($request){
        $total = count($this->allItems());
        $page = isset($request->itemPage)?$request->itemPage:1;
        $limit = 10;
        $rows = $this->items()->skip(($page-1)*$limit)->take($limit)->get();
        foreach ($rows as $index => $itemx){
            $rows[$index]['follow'] = 1;
        }
        return [
            "msg"=>"success",
            "rows"  =>  $rows,
            "totalResults"  =>  $total,
            "totalPages"    =>  ceil($total/$limit),
            "currentPage"   =>  $page,
        ];
    }

    public function allItems(){
        return $this->items->all();
    }

    public function authAcessToken(){
        return $this->hasMany('\App\OauthAccessToken');
    }
}
