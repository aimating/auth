<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace Aimating\Auth\Model;

use Hyperf\DbConnection\Model\Model as BaseModel;
use Aimating\Oauth2\Contract\ModelRepositoryInterface;
use Hyperf\Snowflake\Concern\Snowflake as BaseSnowflake;
use League\OAuth2\Server\Entities\ClientEntityInterface;
abstract class Model extends BaseModel implements ModelRepositoryInterface
{
    public bool $timestamps = false;
 
    public function getEntityByUserCredentials($password, $hash,ClientEntityInterface $client =null):bool
   {
        return password_verify($password, $hash);
   } 
     
  
   public function getEntityId():?string
   {
       return (string)$this->getAttribute($this->getKeyName());
   }
   
}
