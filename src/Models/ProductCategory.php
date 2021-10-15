<?php

namespace SmartyStudio\SmartyCms\Models;

use Illuminate\Database\Eloquent\Model;
use SmartyStudio\SmartyCms\Scopes\OrderScope;

class ProductCategory extends Model
{
	public $fillable = [
		'title',
		'subtitle',
		'thumb',
		'thumb_hover',
		'image',
		'image_hover',
		'video',
		'excerpt',
		'description',
		'order_number',
		'slug',
		'parent_id',
		'seo_title',
		'seo_description',
		'seo_keywords',
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

	public function products()
	{
		return $this->hasMany(Product::class);
	}

	public function children()
	{
		return $this->hasMany(ProductCategory::class, 'parent_id');
	}

	public function parent()
	{
		return $this->belongsTo(ProductCategory::class, 'parent_id', 'id');
	}
}
