<?php

declare(strict_types=1);

namespace Aimating\Auth\Model;
use League\OAuth2\Server\Entities\ClientEntityInterface;

/**
 * @property int $id 
 * @property string $username 
 * @property string $password 
 * @property string $nickname 
 * @property string $email 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class AdminUser extends SnowflakeModel implements \Aimating\Oauth2\Contract\UserProviderInterface
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'admin_users';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'username', 'password', 'nickname', 'email'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function getEntityByUserCredentials($username, $password,ClientEntityInterface $clientEntity = null)
    {
        $model =  $this->where('username', $username)->first();
        if($model == null) return null;
      
        if(!password_verify($password, $model->password)) return null;

        return $model;
    }

    public function clients()
    {
        return $this->hasOne(OauthClient::class,'user_id','id');
    }


}
