<?php

namespace VanBundle\Controller;



use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VanBundle\Entity\Yasam;
use Hateoas\Configuration;
use VanBundle\Factory\KnpPaginatorFactory;


class YasamJsonController extends Controller
{
//hocam ben knppaginatorfactory i şuraya kopyaladım gerek yo khocam orası sunucuya filan deploy ederken silinceği için buraya koymka
//daha mantıklı
// önerdiğiniz symfony kaynakları var mı? türkçe kaynağı geçtim doğru düzgün ingilizce kaynak bile bulamıyorum stackoverflowdan
//milletin hatalarını düzelterek öğreniyorum
//bende başlarda öyle başladım sonra knpbundles comdaki bundları bi hatim ettim millet nasıl kullanıyor ne yapıyor
//servisleri nasıl bağlıyor maili nasıl yolluyor derken baya bi birikim olmus
//bu gist eski kalmıştı :)



    public function acilAction(Request $request)
    {
        //doctrini çağırdık
        $em=$this->getDoctrine()->getManager();
        //listelenecek bütün Yasam
        $yasam_list=$em->getRepository("VanBundle:Yasam")->findBy(array('kategori'=>16),array('id' => 'DESC'));



        $pager=$this->get('knp_paginator');
        $serializer = $this->get('jms_serializer');
        if (count($yasam_list>0)) {
            $paginated = $pager->paginate($yasam_list, $request->query->getInt('page', 1), $request->query->getInt('limit', 10));

            $factory = new KnpPaginatorFactory();
            $collection = $factory->createRepresentation($paginated, new Configuration\Route('yasamjson_acil'), array());


            $data = $serializer->serialize([
                'meta' => $collection,
                'data' => $paginated->getItems()
            ], 'json');
        }else{

            $data = $serializer->serialize([
                'data' => false
            ], 'json');
        }

//burada default gelicek otogetir gelicek vs.. gibi
        // tane tane seçmen lazım şimdi serilazier sadece otogetir olanları getirmeye çalıştı
        // ama yasam tablosunda hiç bulamadığından
        // kategorisine bile gitmeidi ama yaşam tablosunda
        // groups attrsi ve otogetir diye alan olsa idi getiricekti
        // gerci yine getirmez cünkü biz paginator kullandık şuraya groups diye eklemek lazım default veya otogetiri

       return new Response($data,200,[
           'content-type'=>'application/json'
       ]);

    }

    //iptal
    public function listeleAction(Request $request)
    {
        $page = $request->query->get('page', 1);


        //doctrini çağırdık
        $em = $this->getDoctrine()->getManager();
        //listelenecek bütün Yasam
        $yasam_list = $em->getRepository("VanBundle:Yasam")->findAll();




        $response = new Response(json_encode(array('yasam' => $yasam_list), JSON_UNESCAPED_UNICODE));
        $response->headers->set('Content-type', 'application/json; charset=utf-8');
        $response->setStatusCode(200);
        return $response;

    }

    public function belediyeListeleAction(Request $request)
    {
        //Doctrine i çağır
        $em=$this->getDoctrine()->getManager();

        //Belediyeleri Listele id=15
        $belediye_list=$em->getRepository("VanBundle:Yasam")->findBy(array('kategori'=>15),array('id' => 'DESC'));

        //knp and jms
        $pager=$this->get('knp_paginator');
        $serializer=$this->get('jms_serializer');

        if (count($belediye_list)>0)
        {
           $paginated=$pager->paginate($belediye_list,$request->query->getInt('page',1),$request->query->getInt('limit',10));

            $factory=new KnpPaginatorFactory();
            $collection=$factory->createRepresentation($paginated,new Configuration\Route('yasamjson_belediye'),array());

            $data=$serializer->serialize([
                'meta'=>$collection,
                'data'=>$paginated->getItems()
            ],'json');


        }else{
            $data=$serializer->serialize(['data'=>false],'json');
        }

        return new Response($data,200,['content-type'=>'application/json']);
    }
    public function okulListeleAction(Request $request)
    {
        //Doctrine i çağır
        $em=$this->getDoctrine()->getManager();

        //Belediyeleri Listele id=15
        $okul_list=$em->getRepository("VanBundle:Yasam")->findBy(array('kategori'=>19),array('id' => 'DESC'));

        //knp and jms
        $pager=$this->get('knp_paginator');
        $serializer=$this->get('jms_serializer');



        if (count($okul_list)>0)
        {
          $paginated=$pager->paginate($okul_list,$request->query->getInt('page',1),$request->query->getInt('limit',10));

          $factory=new KnpPaginatorFactory();
          $collection=$factory->createRepresentation($paginated,new Configuration\Route('yasamjson_okul'),array());

          $data=$serializer->serialize(['meta'=>$collection,'data'=>$paginated->getItems()],'json');

        }else{

            $data=$serializer->serialize(['data'=>false],'json');
        }


        return new Response($data,200,['content-type'=>'applications/json']);
    }


    //iptal edildi
    public function eczaneListeleAction()
    {
        //Doctrine i çağır
        $em=$this->getDoctrine()->getManager();

        //Belediyeleri Listele id=15
        $eczane_list=$em->getRepository("VanBundle:Yasam")->findBy(array('kategori'=>14),array('id' => 'DESC'));

        if (count($eczane_list)>0)
        {
            $yanit=array();
            foreach ($eczane_list as $meta)
            {
                $new_yasam=array();
                $new_yasam['id']=$meta->getId();
                $new_yasam['adi']=$meta->getAdi();
                $new_yasam['adres']=$meta->getAdres();

                array_push($yanit,$new_yasam);
            }

            }else{
            $yanit["success"] =  "Bu kategoriye en kısa sürede veri eklenecektir. ";

        }



        $response=new Response(json_encode(array('eczane' =>$yanit),JSON_UNESCAPED_UNICODE));
        $response->headers->set('Content-type','application/json; charset=utf-8');
        $response->setStatusCode(200);
        return $response;
    }



}

/*
 * Company : Koddata Yazılım Bilgi Teknolojileri
 * Programmer : Aziz ÇİFTÇİ
 * Date : 04.03. 2017 dd/mm/yy
 *
 */
