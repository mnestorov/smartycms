<?php

namespace SmartyStudio\SmartyCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SmartyStudio\SmartyCms\Scopes\OrderScope;

class Product extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];

	public $fillable = [
		'product_category_id',
		'brand_id',
		'title',
		'slug',
		'excerpt',
		'description',
		'long_description',
		'thumb',
		'image',
		'video',
		'pdf',
		'gallery_id',
		'price',
		'shipment_price',
		'menu_order',
		'visible',
		'featured',
		'stock',
		'sku',
		'seo_title',
		'seo_description',
		'seo_keywords',
		'max_quantity',
		'thumb_hover',
		'image_hover',
		'order_number',
		'length',
		'width',
		'height',
		'weight',
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

	public function category()
	{
		return $this->belongsTo(ProductCategory::class, 'product_category_id');
	}

	public function gallery()
	{
		return $this->belongsTo(Gallery::class, 'gallery_id');
	}

	public function comments()
	{
		return $this->hasMany(ProductComment::class)->orderBy('created_at', 'desc');
	}

	public function similar()
	{
		return $this->hasMany(SimilarProduct::class)->orderBy('created_at', 'desc');
	}

	public function variations()
	{
		return $this->hasMany(ProductVariation::class)->orderBy('created_at', 'desc');
	}

	public function getVariationsByGroup($group)
	{
		return $this->hasMany(ProductVariation::class)->whereGroup($group)->get();
	}

	public function scopeVisible($query)
	{
		return $query->whereVisible(1);
	}
}
