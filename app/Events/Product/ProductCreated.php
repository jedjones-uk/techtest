<?php namespace App\Events\Product;

use App\Models\Product;
use Illuminate\Queue\SerializesModels;

class ProductCreated {

    use SerializesModels;

    /**
     * @var Product
     */
    public Product $product;

    /**
     * ProductCreated constructor.
     * @param $product
     */
    public function __construct($product) {
        $this->product = $product;
    }
}
