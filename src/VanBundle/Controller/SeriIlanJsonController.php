<?php

namespace VanBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VanBundle\Entity\Seri_ilan;
use VanBundle\Factory\KnpPaginatorFactory;

class SeriIlanJsonController extends Controller
{



    public function listeleAction()
    {
        //doctrini çağırdık
        $em=$this->getDoctrine()->getManager();

        //listelenecek bütün ilanlar
        $seri_list=$em->getRepository("VanBundle:Seri_ilan")->findAll();



        $yanit=array();
        foreach ($seri_list as $meta)
        {
            $seri_list=array();
            $seri_list['id']=$meta->getId();
            $seri_list['adi']=$meta->getAdi();
            $seri_list['kategori']=$meta->getKategori()->getAdi();
            $seri_list['aciklama']=$meta->getAciklama();
            $seri_list['uye']=$meta->getUye();
            array_push($yanit,$seri_list);
        }

        $response=new Response(json_encode(array('seri_ilanlar' =>$yanit),JSON_UNESCAPED_UNICODE));
        $response->headers->set('Content-type','application/json; charset=utf-8');
        $response->setStatusCode(200);

        return $response;
    }

    public function silAction($id)
    {
        $em=$this->getDoctrine()->getManager();


        // id ye göre bir tane
        $ilan=$em->getRepository('VanBundle:Seri_ilan')->findOneBy(array('id'=>$id));




             $em->remove($ilan);
             $em->flush();



        return new JsonResponse("Basarılı");
    }

             //dropdown için kategori listesi
    public function seriKategoriListeleAction()
    {
        //doctrini çağırdık
        $em=$this->getDoctrine()->getManager();

        // Query -Category for select option
        $kategori=$em->getRepository("VanBundle:Kategori")->findBy(array('parentID' => 1));

        $yanit=array();


        if( count($kategori)>0){

            foreach ($kategori as $meta)
            {
                $kategori=array();

                $kategori['kategori']=$meta->getAdi();
                array_push($yanit,$kategori);
            }
            $yanit["success"] = 1;

        }else{
            $sonuc["success"] = 0;
        }
        $response=new Response(json_encode(array('etkinlikler' =>$yanit),JSON_UNESCAPED_UNICODE));
        $response->headers->set('Content-type','application/json; charset=utf-8');
        $response->setStatusCode(200);
        return  $response;
    }



    public function ekleAction(Request $request)
    {

            //doctrini çağırdık
              $em=$this->getDoctrine()->getManager();

            // veriye ulaştık servis tüm json requestleri decode ediyor parametr olarak alabilirsin.
             $adi = $request->get('adi');
             $aciklama=$request->get('aciklama');
             $kategorim=$request->get('kategori');


            //telefon
            $tel=$request->get('usrtel');

             // kullanıcının id varlığını sorgulayıp set ediyoruz
             $user=$request->get('uyeID');
             $uye= $em->getRepository("VanBundle:User")->findOneBy(array('id' => $user));


        $kategori= $em->getRepository("VanBundle:Kategori")->findOneBy(array('id' => $kategorim));


        $seri_ilan=new Seri_ilan();
        $seri_ilan->setAdi($adi);
        $seri_ilan->setAciklama($aciklama);
        $seri_ilan->setKategori($kategori);
        $seri_ilan->setUye($uye);


		if($tel !=null){
			$seri_ilan->setTelefon($tel);
		}else{
			
        $seri_ilan->setTelefon("yok");
		}
		
		
		

        $em->persist($seri_ilan);
        $em->flush();


          return new JsonResponse(array('success' => true));

    }
    public function duzenleAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        // Query -Category for select option
        $kategori=$em->getRepository("VanBundle:Kategori")->findBy(array('parentID' => 1));


        $ilan=$em->getRepository('VanBundle:Seri_ilan')->findOneBy(array('id'=>$id));



        $yanit=array();
        foreach ($ilan as $meta)
        {
            $ilan=array();
            $ilan['id']=$meta->getId();
            $ilan['adi']=$meta->getAdi();
            $ilan['kategori']=$meta->getKategori()->getAdi();
            $ilan['aciklama']=$meta->getAciklama();
            $ilan['uye']=$meta->getUye();

            array_push($yanit,$ilan);
        }

        $response=new Response(json_encode(array('seri_ilanlar' =>$yanit),JSON_UNESCAPED_UNICODE));
        $response->headers->set('Content-type','application/json; charset=utf-8');
        $response->setStatusCode(200);


        return $response;
    }
    public function guncelleAction(Request $request)
    {
        //doctrini çağırdık
        $em=$this->getDoctrine()->getManager();


        //posttan gelen verilerin alınması
        $adi=$request->get('adi');
        $aciklama=$request->get('aciklama');
        $kategorim=$request->get('kategori');
        $id=$request->get('id');
        $tel=$request->get('usrtel');
        $uyeID=$request->get('uye_id');


        $kategori= $em->find("VanBundle:Kategori", $kategorim);
        $uye= $em->find("VanBundle:User", $uyeID);




        $seri_ilan= $em->getRepository('VanBundle:Seri_ilan')->findOneBy(array('id'=>$id));
        $seri_ilan->setAdi($adi);
        $seri_ilan->setAciklama($aciklama);
        $seri_ilan->setKategori($kategori);
        $seri_ilan->setTelefon($tel);
        $seri_ilan->setUye($uye);


        $em->flush();


       $serializer=$this->get('jms_serializer');


       $data=$serializer->serialize("Başarılı",'json');

        return new Response($data,200,['content-type'=>'application/json']);
    }

    public function evArkadasiAction(Request $request)
    {
        //Doctrine i çağır
        $em=$this->getDoctrine()->getManager();

        // id=12
        $evArkadasi_list=$em->getRepository("VanBundle:Seri_ilan")->findBy(array('kategori'=>12),array('id' => 'DESC'));

        //knp and jms
        $pager=$this->get('knp_paginator');
        $serializer=$this->get('jms_serializer');


        if (count($evArkadasi_list)>0)
        {
            $paginated=$pager->paginate($evArkadasi_list,$request->query->getInt('page',1),$request->query->getInt('limit',10));
            $factory=new KnpPaginatorFactory();
            $collection=$factory->createRepresentation($paginated,new \Hateoas\Configuration\Route('seriilan_json_evarkadasi'),array());

            $data=$serializer->serialize([
                'meta'=>$collection,
                'data'=>$paginated->getItems()
            ],'json');



        }else{
            $data=$serializer->serialize([

                'data'=>false
            ],'json');

        }




        return new Response($data,200,['content-type'=>'application/json']);
    }

    public function isArayanlarAction(Request $request)
    {
        //Doctrine i çağır
        $em=$this->getDoctrine()->getManager();

        // id=10
        $isArayan_list=$em->getRepository("VanBundle:Seri_ilan")->findBy(array('kategori'=>10),array('id' => 'DESC'));

        //jms serializer instance
        $serializer=$this->get('jms_serializer');

        //knp instansce
        $pager=$this->get('knp_paginator');

        if (count($isArayan_list)>0)
        {
          $paginated=$pager->paginate($isArayan_list,$request->query->getInt('sayfa',1),$request->query->getInt('limit',10));

          $factory=new KnpPaginatorFactory();
          $collection=$factory->createRepresentation($paginated,new \Hateoas\Configuration\Route('seriilan_json_isarayan'),array());

          $data=$serializer->serialize([
              'meta'=>$collection,
              'data'=>$paginated->getItems()
          ],'json');


        }else{

            $data=$serializer->serialize(['data'=>false],'json');
        }




        return new Response($data,200,[
            'content-type'=>'application/json'
        ]);
    }

    // iş veren
     public function isVerenAction(Request $request)
    {
        //Doctrine i çağır
        $em=$this->getDoctrine()->getManager();

        // Listele id=11
        $isveren_list=$em->getRepository("VanBundle:Seri_ilan")->findBy(array('kategori'=>11));

        //jms serializer instance
        $serializer=$this->get('jms_serializer');

        //knp instansce
        $pager=$this->get('knp_paginator');


        if (count($isveren_list)>0){

            $paginated=$pager->paginate($isveren_list,$request->query->getInt('page',1),$request->query->getInt('limit',10));

            $factory=new KnpPaginatorFactory();
            $collection=$factory->createRepresentation($paginated,new \Hateoas\Configuration\Route('seriilan_json_isveren'),array());

            $data=$serializer->serialize([
                'meta'=>$collection,
                'data'=>$paginated->getItems()
            ],'json');

        }else{
            $data=$serializer->serialize(['data'=>false],'json');
        }


        return new Response($data,200,[
            'content-type'=>'application/json'
        ]);
    }



}
