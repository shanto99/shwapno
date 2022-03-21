<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "UserManager";
    protected $primaryKey = "UserID";
    public $keyType = "string";
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "UserID",
        'UserName',
        'Email',
        'Phone',
        'UserType',
        'UserID',
        'UserNID',
        'UserLicense',
        'Password',
        'DeviceToken',
        'OutletCode'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'Password',
        'remember_token',
    ];

    public function Deliveries()
    {
        return $this->hasMany(Delivery::class, 'RiderID', 'UserID')->with('Customer');
    }
}
