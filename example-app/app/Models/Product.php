<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'price', 'vat_id'];

    /**
     * Definicja relacji w modalu
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vat(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(VatModel::class, 'vat_id');
    }
}
