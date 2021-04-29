<?php namespace App\Events\Product;

use App\Models\Product;
use Illuminate\Queue\SerializesModels;

class ProductDeleted {

    use SerializesModels;

    /**
     * @var Product
     */
    public Product $product;

    /**
     * ProductDeleted constructor.
     * @param $product
     */
    public function __construct($product) {
        $this->product = $product;
    }
}
