<?php

namespace SmartyStudio\SmartyCms\Models;

use Illuminate\Database\Eloquent\Model;
use SmartyStudio\SmartyCms\Facades\Cms as SmartyCmsFacade;
use SmartyStudio\SmartyCms\Scopes\OrderScope;

class GalleryImage extends Model
{
	protected $fillable = [
		'gallery_id',
		'source',
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

	public function getUrlAttribute()
	{
		return SmartyCmsFacade::getFile($this->source);
	}

	public function getAllElements()
	{
		return $this->hasMany(GalleryElement::class, 'image_id');
	}

	public function elements()
	{
		return $this->getAllElements();
	}

	public function gallery()
	{
		return $this->belongsTo(Gallery::class);
	}
}
