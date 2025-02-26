<?php

declare(strict_types=1);

namespace Aimating\Auth\Model;


/**
 * @property string $id 
 * @property string $user_id 
 * @property string $client_id 
 * @property string $scopes 
 * @property boolean $revoked 
 * @property string $expires_at 
 */
class OauthAuthCode extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'oauth_auth_codes';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ["id", "user_id", "client_id", "scopes", "revoked", "expires_at"];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['revoked' => 'boolean'];
}
