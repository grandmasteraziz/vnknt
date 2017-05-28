<?php

namespace VanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VanBundle\Entity\Kategori;
use VanBundle\Entity\ReklamKategori;

class ReklamKategoriController extends Controller
{
    public function ekleAction(Request $request)
    {
        //posttan gelen veri
        $ad=$request->request->get('adi');
        $kategoriID=$request->request->get('kategori');


        //kategori nesnesi oluşturup gerekli alanların set edilmesi
        $kategori=new ReklamKategori();
        $kategori->setName($ad);
        $kategori->setParentID($kategoriID);


        $em=$this->getDoctrine()->getManager();

        $em->persist($kategori);
        $em->flush();

        return $this->redirect($this->generateUrl('reklamKategori_listele'));
    }
    public function listeleAction()
    {

        $em=$this->getDoctrine()->getManager();



        $kategori=$em->getRepository("VanBundle:ReklamKategori")->findAll();


        return $this->render('VanBundle:ReklamKategori:listele.html.twig',array('kategoriler'=>$kategori));

    }
    public function silAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $reklamKategori=$em->getRepository('VanBundle:ReklamKategori')->findOneBy(array('id'=>$id));



        $em->remove($reklamKategori);

        $em->flush();

        return $this->redirect($this->generateUrl('reklamKategori_listele'));
    }


    public function duzenleAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        // Query -Category
        $kategori=$em->getRepository("VanBundle:ReklamKategori")->findAll();

        $reklamKategori=$em->getRepository('VanBundle:ReklamKategori')->findOneBy(array('id'=>$id));


        return $this->render('@Van/ReklamKategori/duzenle.html.twig',array('ReklamKategori'=>$reklamKategori,'kategori'=>$kategori));
    }

    public function guncelleAction(Request $request)
    {
        //doctrini çağırdık
        $em = $this->getDoctrine()->getManager();

        //posttan gelen veriler
        $adi = $request->request->get('adi');
        $id=$request->request->get('id'); // bu satırı unutma :)


        $kategori = $em->getRepository('VanBundle:ReklamKategori')->findOneBy(array('id' => $id));
        $kategori->setName($adi);
        $kategori->setParentID(4);

        $em->flush();
    }




    }
