<?php
/**
 * Created by PhpStorm.
 * User: atoth3
 * Date: 2015.10.19.
 * Time: 19:21
 */

namespace Bfvt\UserBundle\Controller;

use Bfvt\UserBundle\Entity\User;
use Bfvt\UserBundle\Form\RegisterFromType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     * @Template()
     */
    public function registerAction(Request $request){
        $this->enforceUserSecurity();

        $user = new User();

        $form = $this->createForm(new RegisterFromType(), $user);

        $form->handleRequest($request);
        if ($form->isValid()){
            $user = $form->getData();

            $user->setPassword( $this->encodePassword($user, $user->getplainPassword()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashbag()
                ->add('success', 'Welcome in the admin page '.$user->getUsername());

            $url = $this->generateUrl('area');

            return $this->redirect($url);
        }

        return array('form' => $form->CreateView());
    }


    private function encodePassword(User $user, $plainTextPassword){
        $encoder = $this->container->get('security.password_encoder');

        return $encoder->encodePassword($user, $plainTextPassword);
    }

    private function enforceUserSecurity(){
        $securityContext = $this->get('security.authorization_checker');
        if (!$securityContext->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Need ROLE_ADMIN');
        }
    }
}