<?php

namespace VanBundle\Controller;

use Hateoas\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VanBundle\Entity\Foto;
use VanBundle\Entity\Reklam;
use VanBundle\Factory\KnpPaginatorFactory;

class ReklamJsonController extends Controller
{


    //Ana kategorileri listele GET isteği
    public function anaKategoriAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $serialize=$this->get('jms_serializer');

        $kategori=$em->getRepository('VanBundle:ReklamKategori')->findBy(array('parentID' => 0));

        $pager=$this->get('knp_paginator');
        $paginated=$pager->paginate($kategori,$request->query->getInt('page',1),$request->query->getInt('limit',10));

        $factory=new KnpPaginatorFactory();
        $collection=$factory->createRepresentation($paginated,new Route('reklam_json_ana'),array());


       $data= $serialize->serialize([
           'meta'=>$collection,'data'=>$paginated->getItems()
            ],'json');

        return new Response($data,200,['content-type'=>'application/json']);
    }

    //Alt kategori listele -POST isteği
    public function altKategoriAction(Request $request, $id, $serialize)
    {

        $em=$this->getDoctrine()->getManager();
        $serialize=$this->get('jms_serializer');
        $kategori=$em->getRepository('VanBundle:ReklamKategori')->findBy(array('parentID'=>$id));
        $pager=$this->get('knp_paginator');




        if (!$kategori){
            $paginated=$pager->paginate($kategori,$request->query->getInt('page',1),$request->query->getInt('limit',10));


            $factory=new KnpPaginatorFactory();
            $collection=$factory->createRepresentation($paginated,new Route('reklam_json_alt'),array());

            $data=$serialize->serialize([
                'meta'=>$collection,
                'data'=>$paginated->getItems()
            ],'json');
        }else{
            $data= $serialize->serialize(['data'=>$kategori],'json');
        }



        return new Response($data,200,['content-type'=>'application/json']);

    }
    public function reklamListeleAction(Request $request,$id)
    {

        $em=$this->getDoctrine()->getManager();
        $serialize=$this->get('jms_serializer');
       // $id=$request->get('id');

        $kategori=$em->getRepository('VanBundle:Reklam')->findBy(array('kategori'=>$id));
        $pager=$this->get('knp_paginator');




        if (!$kategori){
            $paginated=$pager->paginate($kategori,$request->query->getInt('page',1),$request->query->getInt('limit',10));


            $factory=new KnpPaginatorFactory();
            $collection=$factory->createRepresentation($paginated,new Route('reklam_json_reklamlistele'),array());

            $data=$serialize->serialize([
                'meta'=>$collection,
                'data'=>$paginated->getItems()
            ],'json');
        }else{
            $data= $serialize->serialize(['data'=>$kategori],'json');
        }

        return new Response($data,200,[
            'content-type'=>'application/json'
        ]);
    }


    public function reklamAramaAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $serialize=$this->get('jms_serializer');
        $id=$request->get('keyword');

        $kategori=$em->getRepository('VanBundle:Reklam')->findBy(array('adi'=>$id));

        $data= $serialize->serialize(['data'=>$kategori],'json');

        return new Response($data,200,[
            'content-type'=>'application/json'
        ]);
    }


  /*  public function ekleAction(Request $request)
    {
        //doctrini çağırdık
        $em=$this->getDoctrine()->getManager();



        //posttan gelen veriler
        $adi=$request->get('adi');
        $tel=$request->get('usrtel');
        $aciklama=$request->get('aciklama');
        $fotom = $request->files->get('foto');
        $kapak_foto=$request->files->get('kapakFoto');
        $kategorim=$request->get('kategori');

        $kategori= $em->find("VanBundle:ReklamKategori", $kategorim);

        $reklam=new Reklam();


        try{

        if ($tel!=null)
        {
            $reklam->setTelefon($tel);
        }else{
            $reklam->setTelefon("yok");
        }

        $reklam->setAdi($adi);
        $reklam->setAciklama($aciklama);

        $reklam->setKategori($kategori);
        $reklam->setTelefon($tel);

        $fileName2 = md5(uniqid()) . '.' . $kapak_foto->guessExtension();

        $kapak_foto->move(
            $this->getParameter('brochures_directory'),
            $fileName2
        );

        $reklam->setKapakFoto($fileName2);


        $images = array();
        if($fotom != null) {
            $key = 0;


            // Çoklu Fotoğraf alma
            foreach ($fotom as $file)
            {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                $file->move(
                    $this->getParameter('brochures_directory'),
                    $fileName
                );
                $images[$key++] = $fileName;



                $foto=new Foto();
                $reklam->addFotolar($foto);
                $foto->setAdi($fileName);
                $foto->setReklam($reklam);
                foreach ($images as $uploadfileName){





                    $em->persist($reklam);
                    $em->persist($foto);
                    $em->flush();
                }
            }
        }
            return new JsonResponse([
                'success' => true
            ]);

        }catch (Exception $exception){

            return new JsonResponse([

                'success' => false,
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);

        }
    }

    public function duzenleAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $reklam=$em->getRepository('VanBundle:Reklam')->findOneBy(array('id'=>$id));



        // Query -Category
        $kategori=$em->getRepository('VanBundle:ReklamKategori')->findAll();


        $foto=$em->getRepository('VanBundle:Foto')->findBy(array('reklam'=>$id));

        return $this->render('@Van/Reklam/duzenle.html.twig',array('Reklam'=>$reklam,'fotolar'=>$foto,'kategoriler'=>$kategori));
    }


    public function guncelleAction(Request $request)
    {
        //doctrini çağırdık
        $em=$this->getDoctrine()->getManager();

        //posttan gelen veriler
        $adi=$request->get('adi');
        $aciklama=$request->get('aciklama');
        $tel=$request->get('usrtel');
        $fotom = $request->files->get('foto');
        $kapak_foto=$request->files->get('kapakFoto');
        $kategorim=$request->get('kategori');
        $id=$request->get('id'); // bu satırı unutma :)

        try {

            $kategori = $em->find("VanBundle:ReklamKategori", $kategorim);


            $reklam = $em->getRepository('VanBundle:Reklam')->findOneBy(array('id' => $id));

            if ($tel == null) {
                $reklam->setTelefon("yok");
            } else {
                $reklam->setTelefon($tel);
            }
            $reklam->setAdi($adi);
            $reklam->setAciklama($aciklama);
            $reklam->setKategori($kategori);


            if ($kapak_foto != null) {
                $fileName2 = md5(uniqid()) . '.' . $kapak_foto->guessExtension();

                $kapak_foto->move(
                    $this->getParameter('brochures_directory'),
                    $fileName2
                );

                $reklam->setKapakFoto($fileName2);
            }

            $images = array();
            if ($fotom != null && count($fotom) > 0) {
                $key = 0;


                // Çoklu Fotoğraf alma
                foreach ($fotom as $file) {
                    if (count($file) > 0) {
                        $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                        $file->move(
                            $this->getParameter('brochures_directory'),
                            $fileName
                        );
                        $images[$key++] = $fileName;


                        $foto = new Foto();
                        $reklam->addFotolar($foto);
                        $foto->setAdi($fileName);
                        $foto->setReklam($reklam);


                    }
                }
            }
            $em->flush();

            return new JsonResponse([
                'success' => true
            ]);

        }catch (Exception $exception){
            return new JsonResponse([

                'success' => false,
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);

        }
    }

    public function silAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        try{

        $reklam=$em->getRepository('VanBundle:Reklam')->findOneBy(array('id'=>$id));
        $em->remove($reklam);
        $em->flush();

            return new JsonResponse([
                'success' => true
            ]);

        }catch (Exception $exception){

            return new JsonResponse([

                'success' => false,
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        }

    } */


}
