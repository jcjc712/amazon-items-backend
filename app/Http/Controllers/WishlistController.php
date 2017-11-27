<?php

namespace App\Http\Controllers;

use App\Item;
use App\User;
use App\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function __construct(User $user, Item $item)
    {
        $this->user = $user;
        $this->item = $item;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*TODO quitar id hardcodeado*/
        $user = $this->user->find(1);
        return response()->json($user->listOfItems($request), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*TODO quitar id hardcodeado*/
        $user = $this->user->find(1);
        $nonexistentItems = $this->item->whichItemsNonExistent($request->item);
        $responseItems = $this->item->lookForItems($nonexistentItems);
        $this->item->saveItems($responseItems);
        $this->item->attachOrDetachItem($request->item, $request->action, $user);
        return response()->json([
            "msg"=>"success"
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return response()->json([
            "row"=>$item,
            "msg"=>"success"
        ], 200);
    }

}
