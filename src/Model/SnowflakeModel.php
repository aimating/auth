<?php

declare(strict_types=1);

namespace Aimating\Auth\Model;
use Hyperf\DbConnection\Model\Model as BaseModel;
use Aimating\Oauth2\Contract\ModelRepositoryInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
class SnowflakeModel extends BaseModel implements ModelRepositoryInterface
{
    use Snowflake;
    public bool $timestamps = false;

    public function creating($event)
    {
        $this->createKey();
    }

    public function getEntityByUserCredentials($password, $hash,ClientEntityInterface $clientEntity = null) {
        return password_verify($password, $hash);
   }  

   public function getEntityId():?string
   {
       return (string)$this->getAttribute($this->getKeyName());
   }
   
    
}
