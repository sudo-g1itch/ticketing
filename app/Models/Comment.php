<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public $primaryKey = 'id';

    public function ticket(){
        return $this->belongsTo(Ticket::class , 'id' , 'ticket_id');
    }

    public function user(){
        return $this->hasOne(User::class , 'id' , 'owner_id');
    } 
}
