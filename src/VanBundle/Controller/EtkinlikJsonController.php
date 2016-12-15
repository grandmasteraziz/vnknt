<?php

namespace VanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VanBundle\Entity\Etkinlik;
use VanBundle\Entity\Kategori;
use VanBundle\VanBundle;

class EtkinlikJsonController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('VanBundle:Etkinlik:index.html.twig');
    }

    public function listeleAction()
    {
        $em=$this->getDoctrine()->getManager();

        $etkinlik=$em->getRepository('VanBundle:Etkinlik')->findAll();


        $yanit=array();
        foreach ($etkinlik as $meta)
        {
            $newEtkinlik=array();
            $newEtkinlik['id']=$meta->getId();
            $newEtkinlik['adi']=$meta->getAd();
            $newEtkinlik['adres']=$meta->getAdres();
            $newEtkinlik['aciklama']=$meta->getAciklama();
            array_push($yanit,$newEtkinlik);
        }

        $response=new Response(json_encode($yanit,JSON_UNESCAPED_UNICODE));
        $response->headers->set('Content-type','application/json; charset=utf-8');
        $response->setStatusCode(200);
        return $response;
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


        $yeni_etkinlik=new Etkinlik();
        $yeni_etkinlik->setAdi($adi);
        $yeni_etkinlik->setAdres($adres);
        $yeni_etkinlik->setAciklama($aciklama);

        // relate this Etkinlik to the Kategori
        $yeni_etkinlik->setKategori($kategori);

        $em->merge($yeni_etkinlik);
        $em->flush();

        return null;
    }

    public function duzenleAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $etkinlik=$em->getRepository('VanBundle:Etkinlik')->findOneBy(array('id'=>$id));

        return null;
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



        $yeni_etkinlik=$em->getRepository('VanBundle:Etkinlik')->findOneBy(array('id'=>$id));
        $yeni_etkinlik->setAdi($adi);
        $yeni_etkinlik->setAdres($adres);
        $yeni_etkinlik->setAciklama($aciklama);

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


        return null;
    }
}
