<?php

namespace SmartyStudio\SmartyCms\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
	protected $fillable = [
		'blog_category_id',
		'slug',
		'title',
		'thumb',
		'content',
		'excerpt',
		'visible',
		'meta_title',
		'meta_description',
		'meta_keywords',
		'cover',
		'published_at',
		'author',
	];

	protected $dates = ['published_at'];

	public function comments()
	{
		return $this->hasMany(BlogPostComment::class, 'blog_post_id');
	}

	public function categories()
	{
		return $this->belongsTo(BlogCategory::class, 'blog_category_id');
	}
}
