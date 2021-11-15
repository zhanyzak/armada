<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Models\Store;
use App\Models\Banner;
use App\Models\Catalog;
use App\Models\BannerType;
use App\Models\Subcatalog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Services\Service;
use App\Http\Controllers\Controller;
use App\Http\Services\BannerService;

class BannerControllerAdmin extends Controller
{
    protected $service;
    protected $bannerService;

    public function __construct(Service $service,BannerService $bannerService)
    {
        $this->service = $service;
        $this->bannerService = $bannerService;
    }

    public function index()
    {
        $banners = Banner::with('type')->get();
        return view('admin.banners.index',compact('banners'));
    }

    public function create()
    {
        $stores = Store::whereNotNull('title')
            ->select('id','title')
            ->orderBy('title')
            ->get();

        $storesArray = [];

        foreach ($stores as $store) {
            $storesArray[$store->id] = $store->title;
        }

        $types = BannerType::isActive()->get();

        $cats = Catalog::select('id', 'title')->get();
        $subcats = Subcatalog::select('id', 'title')->get();
        $items = Item::select('id', 'title')->get();
        return view('admin.banners.credit', compact('types','storesArray','cats', 'subcats','items'));
    }

    public function store(Request $request)
    {
        $data = Banner::add($request->all());
        $data->start_at = Str::before($request->period, ' - ');//$this->bannerService->dateStart($request->period);
        $data->end_at = Str::after($request->period, ' - ');
        $data->uploadDataImage($request->images_1920x550, 'images_1920x550','jpeg','banners');
        $data->uploadDataImage($request->images_1580x550, 'images_1580x550','jpeg','banners');
        $data->uploadDataImage($request->images_1280x450, 'images_1280x450','jpeg','banners');
        $data->uploadDataImage($request->images_1024x450, 'images_1024x450','jpeg','banners');
        $data->uploadDataImage($request->images_768x495, 'images_768x495','jpeg','banners');
        $data->uploadDataImage($request->images_576x350, 'images_576x350','jpeg','banners');
        $data->isBoolean($request,'archive');
        $data->isBoolean($request,'pause');
//        dd(123);
        $data->save();

        return redirect()->route('admin.banners.index')->with('success','Информация сохранена');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = Banner::find($id);
        $types = BannerType::isActive()->get();
        $stores = Store::whereNotNull('title')
            ->select('id','title')
            ->orderBy('title')
            ->get();

        $storesArray = [];

        foreach ($stores as $store) {
            $storesArray[$store->id] = $store->title;
        }
        $cats = Catalog::select('id', 'title')->get();
        $subcats = Subcatalog::select('id', 'title')->get();
        $items = Item::select('id', 'title')->get();

        return view('admin.banners.credit',compact('data','types', 'storesArray', 'cats', 'subcats', 'items'));
    }

    public function update(Request $request, $id)
    {
        //return $request->all();
        $data = Banner::find($id);
        $data->edit($request->all());
        //$data->catalog = $request->catalog;
        $data->start_at = $this->bannerService->dateStart($data,$request->period);
        $data->end_at = $this->bannerService->dateend($data,$request->period);
        $data->uploadDataImage($request->images_1920x550, 'images_1920x550','jpeg','banners');
        $data->uploadDataImage($request->images_1580x550, 'images_1580x550','jpeg','banners');
        $data->uploadDataImage($request->images_1280x450, 'images_1280x450','jpeg','banners');
        $data->uploadDataImage($request->images_1024x450, 'images_1024x450','jpeg','banners');
        $data->uploadDataImage($request->images_768x495, 'images_768x495','jpeg','banners');
        $data->uploadDataImage($request->images_576x350, 'images_576x350','jpeg','banners');
        $data->isBoolean($request,'archive');
        $data->isBoolean($request,'pause');
        $data->save();

        return redirect()->route('admin.banners.index')->with('success','Информация сохранена');
    }

    public function destroy($id)
    {
        $id = explode(',', $id);

        if(!is_array($id))
        {
            $id[] = $id;
        }

        foreach ($id as $item)
        {
            $data = Banner::find($item);

            $data->delete();
        }

        if(count($id) > 1) {
            return back()->with('success','Банера удалены');
        } else {
            return back()->with('success','Банер удалён');
        }
    }
}
