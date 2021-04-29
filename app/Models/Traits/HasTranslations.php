<?php namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations as BaseHasTranslations;

/**
 * Trait HasTranslations
 * @package App\Models\Traits
 * @mixin Model
 */
trait HasTranslations {

    use BaseHasTranslations;

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray() {
        $attributes = parent::toArray();
        foreach ($this->getTranslatableAttributes() as $field) {
            $attributes[$field] = $this->getTranslation($field, \App::getLocale());
        }
        return $attributes;
    }
}
