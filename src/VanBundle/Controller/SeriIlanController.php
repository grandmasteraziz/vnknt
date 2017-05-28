<?php

namespace VanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VanBundle\Entity\Seri_ilan;

class SeriIlanController extends Controller
{
    public function indexAction($name)
    {


        return $this->render('', array('name' => $name));
    }

    public function listeleAction(Request $request)
    {
        //doctrini çağırdık
        $em=$this->getDoctrine()->getManager();

        // Query -Category for select option
        $kategori=$em->getRepository("VanBundle:Kategori")->findBy(array('parentID' => 1));

        //listelenecek bütün ilanlar
        $seri_list=$em->getRepository("VanBundle:Seri_ilan")->findAll();

        $paginator=$this->get('knp_paginator');

        $result= $paginator->paginate(
            $seri_list,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',10)
        );

        return $this->render('VanBundle:Seri:listele.html.twig',array('kategoriler'=>$kategori,'ilanlar'=>$result));
    }



    public function ekleAction(Request $request)
    {
        //doctrini çağırdık
        $em=$this->getDoctrine()->getManager();


        //posttan gelen verilerin alınması
        $adi=$request->request->get('adi');
        $aciklama=$request->request->get('aciklama');
        $kategorim=$request->request->get('kategori');
        $tel=$request->request->get('usrtel');

        $kategori= $em->find("VanBundle:Kategori", $kategorim);

        // Giriş yapmış kullanıcının id sini alınması
        $user=$this->getUser();


        $seri_ilan=new Seri_ilan();


        if ($tel==null)
        {
            $seri_ilan->setTelefon("yok");
        }else{
            $seri_ilan->setTelefon($tel);
        }

        $seri_ilan->setAdi($adi);
        $seri_ilan->setAciklama($aciklama);
        $seri_ilan->setKategori($kategori);
        $seri_ilan->setUye($user);

        $em->persist($seri_ilan);
        $em->flush();


        return $this->redirect($this->generateUrl('seriilan_listele'));
    }


    public function duzenleAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        // Query -Category for select option
        $kategori=$em->getRepository("VanBundle:Kategori")->findBy(array('parentID' => 1));


        $ilan=$em->getRepository('VanBundle:Seri_ilan')->findOneBy(array('id'=>$id));

        return $this->render('@Van/Seri/duzenle.html.twig',array('ilanlar'=>$ilan,'kategoriler'=>$kategori));
    }

    public function guncelleAction(Request $request)
    {
        //doctrini çağırdık
        $em=$this->getDoctrine()->getManager();


        //posttan gelen verilerin alınması
        $adi=$request->request->get('adi');
        $aciklama=$request->request->get('aciklama');
        $kategorim=$request->request->get('kategori');
        $id=$request->request->get('id');
        $tel=$request->request->get('usrtel');


        $kategori= $em->find("VanBundle:Kategori", $kategorim);




        $seri_ilan= $em->getRepository('VanBundle:Seri_ilan')->findOneBy(array('id'=>$id));

        if ($tel==null)
        {
            $seri_ilan->setTelefon("yok");
        }else{
            $seri_ilan->setTelefon($tel);
        }

        $seri_ilan->setAdi($adi);
        $seri_ilan->setAciklama($aciklama);
        $seri_ilan->setKategori($kategori);



        $em->flush();

        return $this->redirect($this->generateUrl('seriilan_listele'));
    }

    public function silAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $ilan=$em->getRepository('VanBundle:Seri_ilan')->findOneBy(array('id'=>$id));

        $em->remove($ilan);
        $em->flush();

        return $this->redirect($this->generateUrl('seriilan_listele'));
    }



}
