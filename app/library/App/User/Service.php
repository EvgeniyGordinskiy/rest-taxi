<?php

namespace App\User;

use App\Constants\AclRoles;
use App\Model\User;

class Service extends \PhalconApi\User\Service
{
    protected $detailsCache = [];

    public function getRole()
    {
        /** @var User $userModel */
        $userModel = $this->getDetails();
        
        $role = $this->retrieveRoleFromCache() ?? AclRoles::UNAUTHORIZED;


        if($userModel && in_array($userModel->role, AclRoles::ALL_ROLES)){
            $role = $userModel->role;
        }
        $role = ucfirst(trim($role));
        return $role;
    }
    
    protected function retrieveRoleFromCache(){
        $token = $this->request->getToken() ?? '';
        $hash = $this->cache->get($token);
        if($hash) {
            $decodedHash = explode(',', (new AuthService)->decode($hash));
            if(isset($decodedHash[1])) {
                return $decodedHash[1];
            }
        }
        
        return false;
    }

    protected function getDetailsForIdentity($identity)
    {
        if (array_key_exists($identity, $this->detailsCache)) {
            return $this->detailsCache[$identity];
        }

        $details = User::findFirst((int)$identity);
        $this->detailsCache[$identity] = $details;

        return $details;
    }
}