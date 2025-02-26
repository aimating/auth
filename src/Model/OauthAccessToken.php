<?php

declare(strict_types=1);

namespace Aimating\Auth\Model;



/**
 * @property string $id 
 * @property string $user_id 
 * @property string $client_id 
 * @property string $name 
 * @property string $scopes 
 * @property boolean $revoked 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $expires_at 
 */
class OauthAccessToken extends Model
{
    
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'oauth_access_tokens';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'user_id', 'client_id', 'name', 'scopes', 'revoked', 'expires_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['revoked' => 'boolean', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
