<?php

namespace SmartyStudio\SmartyCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use SmartyStudio\SmartyCms\Facades\Cms as SystemSmartyCms;
use SmartyStudio\SmartyCms\Scopes\OrderScope;

class PageElement extends Model
{
	protected $fillable = [
		'key',
		'title',
		'content',
		'page_id',
		'page_element_type_id',
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

	public function __toString()
	{
		return (string) $this->content;
	}

	public function page()
	{
		return $this->belongsTo(Page::class);
	}

	public function getContentAttribute($value)
	{
		if (Request::is('administration/*')) {
			return $value;
		}

		switch ($this->page_element_type_id) {
			case 1:
				return nl2br($value);
				break;

			case 2:
				return $value;
				break;

			case 3:
				return SystemSmartyCms::getFile($value);
				break;

			default:
				return false;
				break;
		}
	}
}
