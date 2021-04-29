<?php namespace App\Events\Product;

use App\Models\Product;
use Illuminate\Queue\SerializesModels;

class ProductRestored {

    use SerializesModels;

    /**
     * @var Product
     */
    public Product $product;

    /**
     * ProductRestored constructor.
     * @param $product
     */
    public function __construct($product) {
        $this->product = $product;
    }
}
