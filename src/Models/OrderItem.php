<?php

namespace SmartyStudio\SmartyCms\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
	protected $fillable = [
		'order_id',
		'product_id',
		'quantity',
		'discount',
		'custom_price',
	];

	public function order()
	{
		return $this->belongsTo(Order::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class)->withTrashed();
	}

	public function variations()
	{
		return $this->hasMany(OrderItemVariation::class);
	}
}
