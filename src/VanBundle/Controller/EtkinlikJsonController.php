<?php

namespace VanBundle\Controller;

use Hateoas\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use VanBundle\Entity\Etkinlik;
use VanBundle\Entity\Kategori;
use VanBundle\Factory\KnpPaginatorFactory;
use VanBundle\VanBundle;
use Symfony\Component\HttpFoundation\Response;

class EtkinlikJsonController extends Controller
{

    public function listeleAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();

        $etkinlik=$em->getRepository('VanBundle:Etkinlik')->findBy(array(),array('id' => 'DESC'));

        $pager=$this->get('knp_paginator');
        $paginated=$pager->paginate($etkinlik,$request->query->getInt('page',1),$request->query->getInt('limit',10));


        $factory=new KnpPaginatorFactory();
        $collection=$factory->createRepresentation($paginated,new Route('etkinlikjson_listele'),array());

        $serializer=$this->get('jms_serializer');

        $data=$serializer->serialize([
            'meta'=>$collection,
            'data'=>$paginated->getItems()
        ],'json');

        return new Response($data,200,[
            'content-type'=>'application/json'
        ]);
    }




    
    
    
}
