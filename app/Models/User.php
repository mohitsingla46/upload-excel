<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'roll_no',
        'address'
    ];

    public static function createOrUpdate($data, $setting = null)
    {
        if (is_null($setting)) {
            $setting = new User;
        }
        if (isset($data['name'])) {
            $setting->name = $data['name'];
        }
        if (isset($data['email'])) {
            $setting->email = $data['email'];
        }
        if (isset($data['phone'])) {
            $setting->phone = $data['phone'];
        }
        if (isset($data['roll_no'])) {
            $setting->roll_no = $data['roll_no'];
        }
        if (isset($data['address'])) {
            $setting->address = $data['address'];
        }
        $setting->save();
        return $setting;
    }
}
