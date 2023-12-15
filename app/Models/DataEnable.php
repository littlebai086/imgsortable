<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataEnable extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = ['title','enable'];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('project.data_enable');
    }

    
}
