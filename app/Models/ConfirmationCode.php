<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ConfirmationCode extends Model
{
    const TYPE_REGISTRATION = 1;

    protected $fillable = ['user_id', 'code', 'type'];

    public static function generateOTP($phoneCode, $mobile_number){
        $otp =  rand(100000, 999999);
        $user = User::getByPhoneNumber($phoneCode, $mobile_number);
        ConfirmationCode::updateOrCreate([
            'user_id' => $user->id,
            'type' => self::TYPE_REGISTRATION
        ],[
            'user_id' => $user->id,
            'code' => $otp,
            'type' => self::TYPE_REGISTRATION
        ]);
        return $otp;
    }

    public static function checkOTP($request){
        $user = User::getByPhoneNumber($request->country_code, $request->mobile_number);
        if($user){
            $confirmation = ConfirmationCode::where('user_id', $user->id)
                ->where('code', $request->code)
                ->where('type', $request->type)
                ->first();
            return (boolean)$confirmation;
        }
        return false;
    }
}