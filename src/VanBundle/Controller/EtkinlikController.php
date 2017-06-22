<?php

namespace VanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VanBundle\Entity\Etkinlik;
use VanBundle\Entity\Kategori;
use VanBundle\VanBundle;

class EtkinlikController extends Controller
{


    public function listeleAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();

        $etkinlik=$em->getRepository('VanBundle:Etkinlik')->findAll();

        $paginator=$this->get('knp_paginator');

        $result= $paginator->paginate(
            $etkinlik,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',10)
        );

        return $this->render('VanBundle:Etkinlik:listele.html.twig',array('etkinlikler'=>$result));
    }

    public function ekleAction(Request $request)
    {
        //doctrini çağırdık
        $em=$this->getDoctrine()->getManager();


        // Kategori Bilgisini Al
        $kategori= $em->find("VanBundle:Kategori", 6);


        //posttan gelen verilerin alınması
        $adi=$request->request->get('adi');
        $adres=$request->request->get('adres');
        $aciklama=$request->request->get('aciklama');
        $kapakFoto=$request->files->get('kapakFoto');



        $yeni_etkinlik=new Etkinlik();
        $yeni_etkinlik->setAdi($adi);
        $yeni_etkinlik->setAdres($adres);
        $yeni_etkinlik->setAciklama($aciklama);

        if ($kapakFoto!=null)
        {

            $fileName2 = md5(uniqid()) . '.' . $kapakFoto->guessExtension();

            $kapakFoto->move(
                $this->getParameter('brochures_directory'),
                $fileName2);

            $yeni_etkinlik->setKapakFoto($fileName2);
        }else{
            $yeni_etkinlik->setKapakFoto("resimbulunamadi.png");
        }

        // relate this Etkinlik to the Kategori
        $yeni_etkinlik->setKategori($kategori);

        $em->merge($yeni_etkinlik);
        $em->flush();

        return $this->redirect($this->generateUrl('etkinlik_listele'));
    }

    public function duzenleAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $etkinlik=$em->getRepository('VanBundle:Etkinlik')->findOneBy(array('id'=>$id));

        return $this->render('@Van/Etkinlik/duzenle.html.twig',array('etkinlikler'=>$etkinlik));
    }

    public function guncelleAction(Request $request)
    {
        //doctrini çağırdık
        $em=$this->getDoctrine()->getManager();


        // Kategori Bilgisini Al
        $kategori= $em->find("VanBundle:Kategori", 6);

        //posttan gelen verilerin alınması
        $adi=$request->request->get('adi');
        $adres=$request->request->get('adres');
        $aciklama=$request->request->get('aciklama');
        $id=$request->request->get('id');
        $kapakFoto=$request->files->get('kapakFoto');



        $yeni_etkinlik=$em->getRepository('VanBundle:Etkinlik')->findOneBy(array('id'=>$id));
        $yeni_etkinlik->setAdi($adi);
        $yeni_etkinlik->setAdres($adres);
        $yeni_etkinlik->setAciklama($aciklama);

        if ($kapakFoto!=null)
        {

            $fotoAdi=$yeni_etkinlik->getKapakFoto();
            $brochuresDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/brochures';
            unlink($brochuresDir.'/'.$fotoAdi );


            $fileName2 = md5(uniqid()) . '.' . $kapakFoto->guessExtension();

            $kapakFoto->move(
                $this->getParameter('brochures_directory'),
                $fileName2
            );

            $yeni_etkinlik->setKapakFoto($fileName2);
        }

        // relate this Etkinlik to the Kategori
        $yeni_etkinlik->setKategori($kategori);

        $em->flush();

        return $this->redirect($this->generateUrl('etkinlik_listele'));
    }
    public function silAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $etkinlik=$em->getRepository('VanBundle:Etkinlik')->findOneBy(array('id'=>$id));

        $em->remove($etkinlik);
        $em->flush();

        return $this->redirect($this->generateUrl('etkinlik_listele'));
    }
}
