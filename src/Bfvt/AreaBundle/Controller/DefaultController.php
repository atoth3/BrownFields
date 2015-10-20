<?php

namespace Bfvt\AreaBundle\Controller;

class DefaultController extends Controller
{
    public function indexAction($count, $firstName)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AreaBundle:Area');

        $area = $repo->findOneBy(array(
            'name' => 'Kismogyorosos'
        ));

        return $this->render(
            'AreaBundle:Default:index.html.twig',
            array('name' => $firstName, 'count' => $count, 'area' => $area)
        );

/*        $data = array(
            'count' => $count,
            'firstName' => $firstName,
            'ackbar' => 'It\'s a traaaaap!'
        );

        $json = json_encode($data);

        $response = new Response($json);
        $response->headers->set('Content-Type', 'application/json');

        return $response;*/
    }
}
