<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

$loader = require_once __DIR__.'/app/bootstrap.php.cache';
Debug::enable();

require_once __DIR__.'/app/AppKernel.php';

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$kernel->boot();

$container = $kernel->getContainer();
$container->enterScope('request');
$container->set('request', $request);

use Bfvt\AreaBundle\Entity\Area;

$area = new Area();

$area->setName('Kismogyorosos');
$area->setDate( new \DateTime('tomorrow noon'));
$area->setLocation('NagyMogyoros');
//$area->setDetails('Naaaaaaaaaaagyon Fontoooooos');

$em = $container->get('doctrine')->getManager();
$em->persist($area);
$em->flush();

/*$templating = $container->get('templating');
echo $templating->render(
    'AreaBundle:Default:index.html.twig',
    array('name' => 'Vader', 'count' => 3)
);*/
