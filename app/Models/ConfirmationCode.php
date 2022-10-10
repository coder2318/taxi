<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ConfirmationCode extends Model
{
    const TYPE_REGISTRATION = 1;
    const TYPE_LOGIN = 2;

    protected $fillable = ['user_id', 'code', 'type'];

    public static function generateOTP(){
        return rand(100000, 999999);
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