<?php

namespace Bfvt\AreaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Bfvt\AreaBundle\Entity\Area;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class Controller extends BaseController
{
    /**
     * @return \Symfony\Component\Security\Core\Authorization\AuthorizationChecker
     */
    public function getSecurityContext(){
        return $securityContext = $this->get('security.authorization_checker');
    }

    public function enforceOwnerSecurity(Area $area){
        $user = $this->getUser();

        if ($user != $area->GetOwner()){
            throw new AccessDeniedException('You need to be the owner.');
        }
    }
}