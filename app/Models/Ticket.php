<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    public $primaryKey = 'id';

    public $timestamps = true;

    public function user(){
        return $this->hasOne(User::class , 'id', 'owner_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class, 'ticket_id', 'id');

    }
}
