<?php

namespace SmartyStudio\SmartyCms\Models;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
	protected $fillable = [
		'title',
		'key',
		'description',
		'zoom',
		'latitude',
		'longitude',
	];

	public function locations()
	{
		return $this->hasMany(Location::class, 'map_id');
	}
}
