<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectView extends Model
{
    use HasFactory;

    protected $fillable = ['tbl_projet_id', 'ip_address'];
}
