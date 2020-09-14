<?php

namespace SmartyStudio\SmartyCms\Models;

use Illuminate\Database\Eloquent\Model;

class SimilarProduct extends Model
{
	protected $fillable = ['product_id', 'product_similar_id'];

	public function product()
	{
		return $this->belongsTo(Product::class, 'product_similar_id');
	}
}
