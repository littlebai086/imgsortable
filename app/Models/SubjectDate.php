<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectDate extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['date','subject', 'intro', 'content','multiple_img','start_date','sort'];
    

}
