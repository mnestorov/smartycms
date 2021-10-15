<?php

namespace SmartyStudio\SmartyCms\Models;

use Illuminate\Database\Eloquent\Model;
use SmartyStudio\SmartyCms\Scopes\OrderScope;

class ProductVariation extends Model
{
	protected $fillable = [
		'product_id',
		'title',
		'content',
		'image',
		'key',
		'group',
		'price',
		'order_number',
	];

	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope(new OrderScope());
	}
}
