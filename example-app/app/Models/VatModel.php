<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VatModel extends Model
{
    use HasFactory;

    protected $table = 'vat';

    protected $fillable = ['label', 'code', 'value'];
}
