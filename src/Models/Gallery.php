<?php

namespace SmartyStudio\SmartyCms\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
	protected $table = 'galleries';

	protected $fillable = [
		'title',
		'key',
		'product_id',
	];

	public function images()
	{
		return $this->hasMany(GalleryImage::class)->orderBy('order_number')->with('elements');
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
