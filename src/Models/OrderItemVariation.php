<?php

namespace SmartyStudio\SmartyCms\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItemVariation extends Model
{
	protected $fillable = [
		'order_item_id',
		'product_variation_id',
	];

	public function orderItem()
	{
		return $this->belongsTo(OrderItem::class);
	}

	public function productVariation()
	{
		return $this->belongsTo(ProductVariation::class);
	}
}
