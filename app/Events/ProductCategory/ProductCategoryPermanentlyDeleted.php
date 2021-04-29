<?php namespace App\Events\ProductCategory;

use App\Models\ProductCategory;
use Illuminate\Queue\SerializesModels;

class ProductCategoryPermanentlyDeleted {

    use SerializesModels;

    /**
     * @var ProductCategory
     */
    public ProductCategory $ProductCategory;

    /**
     * ProductCategoryPermanentlyDeleted constructor.
     * @param $ProductCategory
     */
    public function __construct($ProductCategory) {
        $this->ProductCategory = $ProductCategory;
    }
}
