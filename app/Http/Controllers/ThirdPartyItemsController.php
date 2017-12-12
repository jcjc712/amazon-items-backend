<?php

namespace App\Http\Controllers;

use App\Item;
use App\Models\ThirdPartyItems\ThirdPartyFactory;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;

class ThirdPartyItemsController extends Controller
{
    private $localItems;
    public function __construct(Item $localItems)
    {
        $this->localItems = $localItems;
    }

    public function index(Request $request){
        $user = null;
        /*If you are login*/
        if ( $request->has('Authorization') || $request->header('Authorization') ) {
            $user = Auth::guard('api')->user();
        }
        /*Validation of request parameters*/
        $validator = Validator::make($request->all(), [
            'service' => 'required|max:20',
            'searchIndex' => 'required|exists:categories,name',
            'keywords' => 'required|min:2',
            'sort' => 'required',
            'itemPage' => 'required|integer|between:1,10'
        ]);
        /*If the validation fails return errors in a json*/
        if ($validator->fails()) {
            return response()->json($validator->errors(),200);
        }
        $thirdParty = ThirdPartyFactory::create($request->service);
        /*Make the request to the thirdparty*/
        $response = $thirdParty->makeRequest($request);
        $processResponse = $thirdParty->processResponse($response);
        /*return an array*/
        return response()->json($this->localItems->matchWithLocalItems($user,$processResponse),200);
    }

}
