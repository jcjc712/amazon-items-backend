<?php

namespace App\Http\Controllers;

use App\Category;
use App\Search;
use App\Sort;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function __construct(Category $category, Sort $sort, Search $search)
    {
        $this->category = $category;
        $this->sort = $sort;
        $this->search = $search;
    }

    public function index(Request $request){
        return response()->json([
            'categories' => $this->category->all(),
            'sorts' => $this->sort->all(),
            'searches' => $this->search->all(),
            'msg' => 'success'
        ]);
    }
}
