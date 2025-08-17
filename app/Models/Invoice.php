<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    protected $fillable = ['total', 'discount', 'vat', 'payable', 'user_id', 'customer_id'];

    // Invoice.php
public function customer() {
    return $this->belongsTo(Customer::class, 'customer_id');
}

public function invoiceProducts() {
    return $this->hasMany(InvoiceProduct::class, 'invoice_id');
}

}
