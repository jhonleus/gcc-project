<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaintenanceFaqs extends Model
{
    //
	protected $table   = 'maintenance_faqs';
	protected $fillable = [
		'question', 'answer'
	];
}
