<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'buyer_nip',
        'seller_nip',
        'product_name',
        'product_price',
        'issue_date',
        'edit_date',
    ];

}
