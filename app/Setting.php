<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $table ='settings';
    
	protected $fillable =['facebook_url','twitter_url','youtube_url','contact_us','notification','phone_number'];
}
