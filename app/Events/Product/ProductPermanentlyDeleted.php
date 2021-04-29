<?php namespace App\Events\Product;

use App\Models\Product;
use Illuminate\Queue\SerializesModels;

class ProductPermanentlyDeleted {

    use SerializesModels;

    /**
     * @var Product
     */
    public Product $product;

    /**
     * ProductPermanentlyDeleted constructor.
     * @param $product
     */
    public function __construct($product) {
        $this->product = $product;
    }
}
