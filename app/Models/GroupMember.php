<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    use HasFactory;

    protected $with = ['member'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'group_id'
    ];

    protected $table = 'user_groups';

    public function group(){
        return $this->hasOne('App\Models\Group', 'id', 'group_id');
    }

    public function member(){
        return $this->hasMany('App\Models\User', 'id', 'user_id');
    }
}
