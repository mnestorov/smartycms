<?php

namespace SmartyStudio\SmartyCms\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPostComment extends Model
{
	protected $fillable = [
		'blog_post_id',
		'name',
		'email',
		'content',
		'approved',
	];

	public function post()
	{
		return $this->belongsTo(BlogPost::class, 'blog_post_id');
	}
}
