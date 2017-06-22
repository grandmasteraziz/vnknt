<?php

namespace VanBundle\Controller;

use Hateoas\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VanBundle\Factory\KnpPaginatorFactory;
use VanBundle\VanBundle;

class SearchController extends Controller
{
    //For Json
    public function emlakSearchAllAction($keyword,Request $request)
    {
        $em=$this->getDoctrine()->getManager();

        $search = $em->createQuery('SELECT u FROM VanBundle:Emlak u WHERE u.adi=');
        $users = $search->getResult();

        //jms and knp
        $pager=$this->get('knp_paginator');
        $serialize=$this->get('jms_serializer');

        if (count($search)>0)
        {
           $paginated=$pager->paginate($search,$request->query->getInt('page',1),$request->query->getInt('limit',10));

           $factory=new KnpPaginatorFactory();
           $collection=$factory->createRepresentation($paginated,new Route('search_json_emlak'),array());

            $data=$serialize->serialize([
                'meta'=>$collection,
                'data'=>$paginated->getItems()
            ],'json');

        }else{
            $data=$serialize->serialize(['data'=>false],'json');
        }

        return new Response($data,200,[
            'content-type'=>'application/json'
        ]);
    }

  public function otoSearchAllAction(Request $request)
    {
        //Doctrine
        $em=$this->getDoctrine()->getManager();

        //Serializer
        $serialize=$this->get('jms_serializer');

        //Post değerinin alınması
        $keyword=$request->get('keyword');


        if ($keyword !=null){
             $search=$em->getRepository("VanBundle:Oto")->findBy(array('aciklama' => $keyword ),array ('adi'=>$keyword));


            if (count($search)>0){
                $data=$serialize->serialize(['data'=>$search],'json');

            }
        }else{

            $data=$serialize->serialize(['data'=>false],'json');

        }
        return new Response($data,200,[
            'content-type'=>'application/json'
        ]);
    }

  public function seriSearchAllAction($keyword)
    {
        $em=$this->getDoctrine()->getManager();

        try{
            $search=$em->getRepository("VanBundle:Seri_ilan")->findBy(array('adi' => $keyword, 'aciklama' => $keyword));
            return new JsonResponse([
                'success' => true,
                'data'=>[$search]
            ]);

        }catch (Exception $exception){

            return new JsonResponse([

                'success' => false,
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        }
    }


}
