<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Message extends Model
{
    use HasApiTokens;
    protected $guarded= [];
    protected $table = 'messages';
    public function fromContact()
    {
        return $this->hasOne(User::class, 'id', 'from');
    }
    public function fromContacts()
    {
        return $this->hasOne(Files::class,'id','Oder_id');

    }
}
