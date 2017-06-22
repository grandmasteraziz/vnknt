<?php

namespace VanBundle\Controller;

use Hateoas\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VanBundle\Factory\KnpPaginatorFactory;

class UserShareListController extends Controller
{

    public function indexAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $user_list=$em->getRepository("VanBundle:User")->findOneBy(array('id'=>$id));

        //  jms
        $serializer=$this->get('jms_serializer');

        if ($user_list !=null){
            $data=$serializer->serialize([

                'data'=>$user_list
            ],'json');
        }else{
            $data=$serializer->serialize([

                'data'=>$user_list
            ],'json');
        }




        return new Response($data,200,['content-type'=>'application/json']);
    }
}









/*
 * Company : Koddata Yazılım Bilgi Teknolojileri
 * Programmer : Aziz ÇİFTÇİ
 * Date : 04.03. 2017 dd/mm/yy
 *
 */