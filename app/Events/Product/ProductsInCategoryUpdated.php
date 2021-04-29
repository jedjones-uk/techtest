<?php namespace App\Events\Product;

use Illuminate\Queue\SerializesModels;

class ProductsInCategoryUpdated {

    use SerializesModels;

    private $categorySlug;

    private $updated;

    /**
     * ProductsInCategoryUpdated constructor.
     * @param $updated
     * @param $categorySlug
     */
    public function __construct($updated, $categorySlug) {
        $this->categorySlug = $categorySlug;
        $this->updated = $updated;
    }
}
