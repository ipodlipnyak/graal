<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class MainDB extends Model
{

    protected $connection = 'main_db';

    public $timestamps = false;
}