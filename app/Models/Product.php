<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'image',
        'glb_model',
        'usdz_model',
        'ar_enabled',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'ar_enabled' => 'boolean',
    ];

    /**
     * Check if the product has AR models available.
     *
     * @return bool
     */
    public function hasArModels(): bool
    {
        return !empty($this->glb_model) || !empty($this->usdz_model);
    }

    /**
     * Get the full path for the GLB model.
     *
     * @return string|null
     */
    public function getGlbModelUrl(): ?string
    {
        return $this->glb_model ? asset('uploads/models/' . $this->glb_model) : null;
    }

    /**
     * Get the full path for the USDZ model.
     *
     * @return string|null
     */
    public function getUsdzModelUrl(): ?string
    {
        return $this->usdz_model ? asset('uploads/models/' . $this->usdz_model) : null;
    }
}
