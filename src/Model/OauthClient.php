<?php

declare(strict_types=1);

namespace Aimating\Auth\Model;



/**
 * @property string $id 
 * @property string $user_id 
 * @property string $name 
 * @property string $secret 
 * @property string $provider 
 * @property string $redirect 
 * @property boolean $personal_access_client 
 * @property boolean $password_client 
 * @property boolean $revoked 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class OauthClient extends SnowflakeModel
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'oauth_clients';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['name', 'secret', 'provider', 'redirect', 'personal_access_client', 'password_client', 'revoked'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['personal_access_client' => 'boolean', 'password_client' => 'boolean', 'revoked' => 'boolean', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
