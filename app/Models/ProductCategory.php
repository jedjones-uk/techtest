<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use App\Models\Traits\HasTranslations;

class ProductCategory extends Model {

    use HasFactory, SoftDeletes, HasTranslations, HasTranslatableSlug;

    /**
     * @var string[]
     */
    protected $fillable = ['name', 'description'];

    /**
     * @var string[]
     */
    protected $translatable = ['name', 'description', 'slug'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * @return HasMany
     */
    public function products(): HasMany {
        return $this->hasMany(Product::class, 'product_category_id', 'id')->ordered();
    }

}
