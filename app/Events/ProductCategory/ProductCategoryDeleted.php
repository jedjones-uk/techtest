<?php namespace App\Events\ProductCategory;

use App\Models\ProductCategory;
use Illuminate\Queue\SerializesModels;

class ProductCategoryDeleted {

    use SerializesModels;

    /**
     * @var ProductCategory
     */
    public ProductCategory $ProductCategory;

    /**
     * ProductCategoryDeleted constructor.
     * @param $ProductCategory
     */
    public function __construct($ProductCategory) {
        $this->ProductCategory = $ProductCategory;
    }
}
