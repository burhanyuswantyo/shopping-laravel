<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use HasFactory, HasSlug;

    // Mendefinisikan nama kolom yang boleh diisi
    // protected $fillable = [];

    // Mendefinisikan nama kolom yang tidak boleh diisi
    protected $guarded = ['id'];

    // Mengubah image menjadi full URL menggunakan mutator
    public function image(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => asset("storage/$value")
        );
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    // Relasi ke model Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function OrderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
