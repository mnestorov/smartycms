<?php

namespace SmartyStudio\SmartyCms\Models;

use Illuminate\Database\Eloquent\Model;
use SmartyStudio\SmartyCms\Scopes\OrderScope;

class Location extends Model
{
	protected $fillable = [
		'title',
		'url',
		'key',
		'map_id',
		'description',
		'address',
		'latitude',
		'longitude',
		'image',
		'thumb_image',
		'marker_image',
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
