<?php

namespace VanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VanBundle\Entity\Acilis;
use VanBundle\Factory\Validation;

class AcilisController extends Controller
{
    public function ekleAction(Request $request)
    {
        //doctrine
        $em=$this->getDoctrine()->getManager();

        // posttan gelen veriler
        $adi=$request->request->get('adi');
        $kapakFoto=$request->files->get('kapakFoto');

        $acilis=new Acilis();

        if ($adi!=null && $kapakFoto!=null)
        {
            $fileName2 = md5(uniqid()) . '.' . $kapakFoto->guessExtension();

            $kapakFoto->move(
                $this->getParameter('brochures_directory'),
                $fileName2
            );

            //object

            $acilis->setAdi($adi);
            $acilis->setKapakFoto($fileName2);


        }else{

            $acilis->setKapakFoto("resimbulunamadi.png");
        }

        $em->persist($acilis);
        $em->flush();

        return $this->redirect($this->generateUrl('acilis_listele'));
    }


    public function listeleAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();

        $acilislar=$em->getRepository('VanBundle:Acilis')->findAll();

        $paginator=$this->get('knp_paginator');

        $result= $paginator->paginate(
            $acilislar,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',15)
        );

        return $this->render('VanBundle:Acilis:listele.html.twig',array('acilis'=>$result));
    }

    public function duzenleAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $acilis=$em->getRepository('VanBundle:Acilis')->findOneBy(array('id'=>$id));

        return $this->render('@Van/Acilis/duzenle.html.twig',array('acilis'=>$acilis));
    }

    public function guncelleAction(Request $request)
    {

        //doctrine
        $em=$this->getDoctrine()->getManager();

        //posttan gelen veriler
        $id=$request->request->get('id');
        $adi=$request->request->get('adi');
        $kapakFoto=$request->files->get('kapakFoto');


        $acilis=$em->getRepository('VanBundle:Acilis')->findOneBy(array('id'=>$id));
        $acilis->setAdi($adi);


        if ($kapakFoto!=null)
        {
            $fotoAdi=$acilis->getKapakFoto();
            $brochuresDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/brochures';
            unlink($brochuresDir.'/'.$fotoAdi );

            $fileName2 = md5(uniqid()) . '.' . $kapakFoto->guessExtension();

            $kapakFoto->move(
                $this->getParameter('brochures_directory'),
                $fileName2
            );
            $acilis->setKapakFoto($fileName2);
        }

        $em->flush();

        return $this->redirect($this->generateUrl('acilis_listele'));
    }

    public function silAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $acilis=$em->getRepository('VanBundle:Acilis')->findOneBy(array('id'=>$id));

        $em->remove($acilis);
        $em->flush();

        return $this->redirect($this->generateUrl('acilis_listele'));
    }
}
