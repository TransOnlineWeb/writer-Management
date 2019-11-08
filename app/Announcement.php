<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Announcement extends Model
{
    use HasApiTokens;
    protected $guarded = [];
    protected $table = 'Announcements';
    protected $fillable = [
        'title', 'status', 'message',
    ];
}
