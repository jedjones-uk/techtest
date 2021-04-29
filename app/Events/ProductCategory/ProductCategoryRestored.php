<?php namespace App\Events\ProductCategory;

use App\Models\ProductCategory;
use Illuminate\Queue\SerializesModels;

class ProductCategoryRestored {

    use SerializesModels;

    /**
     * @var ProductCategory
     */
    public ProductCategory $ProductCategory;

    /**
     * ProductCategoryRestored constructor.
     * @param $ProductCategory
     */
    public function __construct($ProductCategory) {
        $this->ProductCategory = $ProductCategory;
    }
}
