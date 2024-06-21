<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price'];

    public function menuSections(): BelongsToMany
    {
        return $this->belongsToMany(MenuSection::class, 'products_menu_sections');
    }
}
