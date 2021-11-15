<?php

namespace App\Http\Controllers\Api\Catalog;

use App\Models\Item;
use App\Models\Catalog;
use App\Models\Subcatalog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CatalogController extends Controller
{
    public function get(Request $request)
    {
        $catalogs = Catalog::select('id', 'title')->get();

        if(count($catalogs) > 0)
        {
            return response()->json(['success' => true, 'catalogs' => $catalogs]);
        }

        return response()->json(['success' => false, 'data' => []]);
    }

    public function getSub(Request $request)
    {
        $subs = Subcatalog::where('catalog_id', $request->id)->select('id', 'title')->get();

        if(count($subs) > 0)
        {
            return response()->json(['success' => true, 'subs' => $subs]);
        }

        return response()->json(['success' => false, 'data' => []]);
    }

    public function getItem(Request $request)
    {
        $items = Item::where('subcatalog_id', $request->id)->select('id', 'title')->get();

        if(count($items) > 0)
        {
            return response()->json(['success' => true, 'items' => $items]);
        }

        return response()->json(['success' => false, 'data' => []]);
    }
}
