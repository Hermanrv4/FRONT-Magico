<?php

namespace App\Http\Models\Database;
use App\Http\Models\Base\BaseAuthModel;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends BaseAuthModel implements JWTSubject
{
    // <editor-fold desc="Attributes" defaultstate="collapsed">
    protected $table = 'users';
    protected $table_reference = 'user';
    protected $fillable = ['id','dni','first_name','last_name','phone','email','password','facebook_id','provider_id','is_admin','created_at','updated_at'];
    protected $string_json = [];
    protected $hidden = ['password', 'created_at', 'updated_at'];
    // </editor-fold>

    // <editor-fold desc="Relationship HasMany" defaultstate="collapsed">
    // </editor-fold>
    // <editor-fold desc="Relationship BelongsTo" defaultstate="collapsed">
    // </editor-fold>

    // <editor-fold desc="JWT AUTH" defaultstate="collapsed">
    public function getJWTIdentifier(){
        return $this->getKey();
    }
    public function getJWTCustomClaims(){
        return [];
    }
    // </editor-fold>

    public static function GetByEmailAndPassword($email,$password){
        return User::whereRaw('email like ? and password like ?',[$email,$password])->first();
    }
    public static function GetByFacebookId($facebook_id){
        return User::whereRaw('facebook_id like ?',[$facebook_id])->first();
    }

}
