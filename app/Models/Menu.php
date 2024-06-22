<?php

namespace App\Models;

use App\Enums\MenuHeaderType;
use App\Enums\MenuSectionPosition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'file_name', 'header_type', 'header_content', 'header_position'];

    protected $casts = [
        'header_type' => MenuHeaderType::class,
        'header_position' => MenuSectionPosition::class
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(MenuSection::class);
    }

    public function headerPositionCssClass(): string
    {
        return match ($this->header_position) {
            MenuSectionPosition::Center => 'justify-center',
            MenuSectionPosition::Right => 'justify-end',
            default => 'justify-start',
        };
    }
}
