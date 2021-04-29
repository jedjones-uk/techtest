<?php namespace App\Events\ProductCategory;

use App\Models\ProductCategory;
use Illuminate\Queue\SerializesModels;

class ProductCategoryUpdated {

    use SerializesModels;

    /**
     * @var ProductCategory
     */
    public ProductCategory $ProductCategory;

    /**
     * ProductCategoryCreated constructor.
     * @param $ProductCategory
     */
    public function __construct($ProductCategory) {
        $this->ProductCategory = $ProductCategory;
    }
}
