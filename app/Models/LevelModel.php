<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelModel extends Model
{
    use HasFactory;

    protected $table = 'm_level'; //mendefinisikan nama tabel yang digunakan oleh model ini 
    protected $primaryKey = 'level_id'; //mendefinisikan primary key dari tabel yang digunakan
    /**
     * The attributes that are mass assignable
     * @var array
     */
    protected $fillable = ['level_name'];
}