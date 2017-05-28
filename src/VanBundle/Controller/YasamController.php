<?php

namespace VanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VanBundle\Entity\Yasam;

class YasamController extends Controller
{




    public function listeleAction(Request $request)
    {
        //doctrini çağırdık
        $em=$this->getDoctrine()->getManager();

        // Query -Category for select option
        $kategori=$em->getRepository("VanBundle:Kategori")->findBy(array('parentID' => 5));

        //listelenecek bütün ilanlar
        $yasam_list=$em->getRepository("VanBundle:Yasam")->findAll();

       $paginator=$this->get('knp_paginator');

        $result= $paginator->paginate(
            $yasam_list,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',10)
        );



        return $this->render('VanBundle:Yasam:listele.html.twig',array('kategoriler'=>$kategori,'yasamlar'=>$result));
    }
    public function ekleAction(Request $request)
    {
        //doctrini çağırdık
        $em=$this->getDoctrine()->getManager();


        //posttan gelen verilerin alınması
        $adi=$request->request->get('adi');
        $aciklama=$request->request->get('aciklama');
        $kategorim=$request->request->get('kategori');

        $kategori= $em->find("VanBundle:Kategori", $kategorim);



       $yasam=new Yasam();
        $yasam->setAdi($adi);
        $yasam->setAdres($aciklama);
        $yasam->setKategori($kategori);


        $em->persist($yasam);
        $em->flush();


        return $this->redirect($this->generateUrl('yasam_listele'));
    }

    public function duzenleAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        // Query -Category for select option
        $kategori=$em->getRepository("VanBundle:Kategori")->findBy(array('parentID' => 5));


        $yasam=$em->getRepository('VanBundle:Yasam')->findOneBy(array('id'=>$id));

        return $this->render('@Van/Yasam/duzenle.html.twig',array('yasamlar'=>$yasam,'kategoriler'=>$kategori));
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


        $kategori= $em->find("VanBundle:Kategori", $kategorim);




        $yasam= $em->getRepository('VanBundle:Yasam')->findOneBy(array('id'=>$id));
        $yasam->setAdi($adi);
        $yasam->setAdres($aciklama);
        $yasam->setKategori($kategori);



        $em->flush();

        return $this->redirect($this->generateUrl('yasam_listele'));
    }
    public function silAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $yasam=$em->getRepository('VanBundle:Yasam')->findOneBy(array('id'=>$id));

        $em->remove($yasam);
        $em->flush();

        return $this->redirect($this->generateUrl('yasam_listele'));
    }
}
