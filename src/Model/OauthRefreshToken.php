<?php

declare(strict_types=1);

namespace Aimating\Auth\Model;



/**
 * @property string $id 
 * @property string $user_id 
 * @property string $access_token_id 
 * @property boolean $revoked 
 * @property string $expires_at 
 */
class OauthRefreshToken extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'oauth_refresh_tokens';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'user_id', 'access_token_id', 'revoked', 'expires_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['revoked' => 'boolean'];
}
