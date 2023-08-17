<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class UserDetails extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'profile_img_url',
        'user_id',
    ];

    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

     /**
     * Get the user profile image url. Returns a placeholder if no null
     */
    protected function getProfileImgUrlAttribute($value)
    {
        return $value ?? URL::to('/')."/placeholders/profile-placeholder.jpg";
    }
    
    /**
     * Get related user credentials
     */
    public function user() {
        return $this->hasOne('App\Models\User', 'id', 'sender_id');
    }
}
