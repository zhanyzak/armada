<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $products = DB::table('products_last')->where('status', 1)->get();

       return count($products);

        $chunk_array = array_chunk($products->toArray(), 5000);

        foreach ($chunk_array as $products)
        {
            foreach($products as $product)
            {
                DB::table('products_new')
                    ->insert(
                        [
                            'id'               => $product->id,
                            'status'           => $product->status,
                            'isActive'         => $product->status,
                            'user_id'          => 0,
                            'store_id'         => $product->store_id,
                            'catalog_id'       => $product->catalog_id,
                            'subcatalog_id'    => $product->subcatalog_id,
                            'item_id'          => $product->item_id,
                            'slug'             => $product->slug,
                            'title'            => $product->title,
                            'price'            => $product->price,
                            'description'      => $product->description,
                            'articul'          => $product->articul,
                            'images'           => $product->images,
                            'colors'           => $product->colors,
                            'manufacture'      => $product->manufacture,
                            'width'            => $product->width,
                            'height'           => $product->height,
                            'origin'           => $product->origin,
                            'depth'            => $product->depth,
                            'seo_title'        => $product->seo_title,
                            'meta_description' => $product->meta_description,
                            'meta_tags'        => $product->meta_tags,
                            'hits'             => $product->hits,
                            'fiver'            => $product->fiver,
                            'used'             => $product->used,
                            'update_date'      => $product->update_date,
                            'updated_at'       => now(),
                            'created_at'       => $product->created_at,
                        ]);
            }
        }
    }
}
