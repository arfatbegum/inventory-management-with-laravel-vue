<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceProduct extends Model
{
    protected $fillable = [
        'invoice_id',
        'product_id',
        'user_id',
        'qty',
        'sale_price',
    ];

    public function product() {
    return $this->belongsTo(Product::class, 'product_id');
}

}
