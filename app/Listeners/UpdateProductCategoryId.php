<?php

namespace App\Listeners;

use App\Events\CategoryDeleted;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateProductCategoryId
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CategoryDeleted $event)
    {
        $category = $event->category;

        Product::where('category_id', $category->id)->update(['category_id' => null]);
    }
}
