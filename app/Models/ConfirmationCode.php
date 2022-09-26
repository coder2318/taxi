<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ConfirmationCode extends Model
{
    protected $fillable = ['user_id', 'code'];

    public static function generateOTP($phoneCode, $mobile_number){
        $otp =  rand(100000, 999999);
        $user = User::getByPhoneNumber($phoneCode, $mobile_number);
        ConfirmationCode::updateOrCreate([
            'user_id' => $user->id
        ],[
            'user_id' => $user->id,
            'code' => $otp,
        ]);
        return $otp;
    }
}