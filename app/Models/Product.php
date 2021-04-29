<?php namespace App\Models;

use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model {

    use HasFactory, SoftDeletes, HasTranslations;

    /**
     * @var string
     */
    protected $primaryKey = 'product_id';

    /**
     * @var string[]
     */
    protected $fillable = ['product_name', 'product_desc', 'product_category_id', 'product_price'];

    /**
     * @var string[]
     */
    public $translatable = ['product_name', 'product_desc'];

    /**
     * @return BelongsTo
     */
    public function productCategory(): BelongsTo {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id')->withTrashed();
    }

}
