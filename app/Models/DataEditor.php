<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataEditor extends Model
{
    use HasFactory;
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = ['title','intro'];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('project.data_editor');
    }
}
