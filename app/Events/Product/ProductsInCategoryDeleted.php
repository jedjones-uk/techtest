<?php namespace App\Events\Product;

use Illuminate\Queue\SerializesModels;

class ProductsInCategoryDeleted {

    use SerializesModels;

    private $categorySlug;

    private $deleted;

    /**
     * ProductsInCategoryDeleted constructor.
     * @param $deleted
     * @param $categorySlug
     */
    public function __construct($deleted, $categorySlug) {
        $this->categorySlug = $categorySlug;
        $this->deleted = $deleted;
    }
}
