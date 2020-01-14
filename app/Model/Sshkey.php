<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Sshkey extends Model
{
    public $primaryKey='id';
    protected $guarded = [];
    protected $table = 'sshkey';
    public $timestamps = false;
}
