<?php

namespace VanBundle\Controller;

use Hateoas\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use VanBundle\Entity\Foto;
use VanBundle\Entity\Oto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\FileBag;
use VanBundle\Factory\KnpPaginatorFactory;
use VanBundle\Factory\reArrayFiles;

class OtoJsonController extends Controller
{
    public function kiralikAction(Request $request)
    {
        //Doctrine
        $em=$this->getDoctrine()->getManager();

        // Query - fetch all
        $oto=$em->getRepository('VanBundle:Oto')->findBy(array('kategori'=>17),array('id' => 'DESC'));

        //knp and jms
        $pager=$this->get('knp_paginator');
        $serializer=$this->get('jms_serializer');

        $paginated=$pager->paginate($oto,$request->query->getInt('page',1),$request->query->getInt('limit',10));

        if (count($oto)>0){

            $factory=new KnpPaginatorFactory();
            $collection=$factory->createRepresentation($paginated,new Route('oto_json_kiralik'),array());

            $data=$serializer->serialize([
                'meta'=>$collection,
                'data'=>$paginated->getItems()
            ],'json');

        }else{
            $data=$serializer->serialize(['data'=>false],'json');
        }

        return new Response($data,200,['content-type'=>'application/json']);
    }

    public function satilikAction(Request $request)
    {
        //Doctrine
        $em=$this->getDoctrine()->getManager();

        // Query - fetch all
        $oto=$em->getRepository('VanBundle:Oto')->findBy(array('kategori'=>18),array('id' => 'DESC'));

        //knp and jms
        $pager=$this->get('knp_paginator');
        $serializer=$this->get('jms_serializer');

        $paginated=$pager->paginate($oto,$request->query->getInt('page',1),$request->query->getInt('limit',10));

        if (count($oto)>0){

            $factory=new KnpPaginatorFactory();
            $collection=$factory->createRepresentation($paginated,new Route('oto_json_satilik'),array());

            $data=$serializer->serialize([
                'meta'=>$collection,
                'data'=>$paginated->getItems()
            ],'json');

        }else{
            $data=$serializer->serialize(['data'=>false],'json');
        }

        return new Response($data,200,['content-type'=>'application/json']);
    }

  public function listeleAction()
    {
        //Doctrine
        $em=$this->getDoctrine()->getManager();

        // Query -Category
        $kategori=$em->getRepository("VanBundle:Kategori")->findBy(array('parentID' => 2));

        // Query - fetch all Emlak
        $oto=$em->getRepository('VanBundle:Oto')->findAll();

        // Query -Foto
        $foto=$em->getRepository("VanBundle:Foto")->findOneBy(array('oto'=>$oto));


        return new JsonResponse(array('kategoriler'=>$kategori,'otolar'=>$oto,'fotolar'=>$foto));
    }
    public function ekleAction(Request $request)
    {
        //doctrini çağırdık
        $em=$this->getDoctrine()->getManager();
// gösterdiğim yerden çekiyorum.

        //   $a=var_dump(base64_decode($_FILES)); bu yöntem doğru çalışıyor değil mi?


        //posttan gelen veriler

        $data = json_decode($request->get('formData'),true);


        $adi=$data['adi'];
        $aciklama=$data['aciklama'];
        $fiyat=$data['fiyat'];
        $fotom = $request->files->get('foto');
        $kapak_foto=$request->files->get('kapakFoto');
        $kategorim=$data['kategori'];
        $telefon=$data['usrtel'];
        $user=$data['uye_id'];

        //  $a=var_dump(base64_decode($_FILES));

        $kategori= $em->getRepository("VanBundle:Kategori")->findOneBy(array('id'=>$kategorim));
        $user2=$em->getRepository("VanBundle:User")->findOneBy(array('id'=>$user));
        $serializer=$this->get('jms_serializer');

//         $kapak_foto= base64_decode($kapak_foto);
//         $fotom= base64_decode($fotom);

        try {
            $oto = new Oto();
            $oto->setAdi($adi);
            $oto->setAciklama($aciklama);
            $oto->setFiyat($fiyat);
            $oto->setKategori($kategori);
            $oto->setUye($user2);


            if ($telefon == null) {
                $oto->setTelefon("yok");
            } else {
                $oto->setTelefon($telefon);
            }


            $fileName2 = md5(uniqid()) . '.' . $kapak_foto->guessExtension();

            $kapak_foto->move(
                $this->getParameter('brochures_directory'),
                $fileName2
            );

            $oto->setKapakFoto($fileName2);
            $images = array();
            if ($fotom != null) {
                $key = 0;


                //burası şuani için array değil
                // Çoklu Fotoğraf alma
                foreach ($fotom as $file) {
              //  $file = $fotom;
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                $file->move(
                    $this->getParameter('brochures_directory'),
                    $fileName
                );
                $images[$key++] = $fileName;


                $foto = new Foto();
                $oto->addFotolar($foto);
                $foto->setAdi($fileName);
                $foto->setOto($oto);

                foreach ($images as $uploadfileName) {


                    $em->persist($oto);
                    $em->persist($foto);
                    $em->flush();

                }
            }
            }

            $data=$serializer->serialize("Başarılı",'json');

            return new Response($data,200,['content-type'=>'application/json']);

        }catch (Exception $exception){

            $data=$serializer->serialize($exception->getMessage(),'json');

            return new Response($data,200,['content-type'=>'application/json']);
        }
    }



    public function duzenleAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $oto=$em->getRepository('VanBundle:Oto')->findOneBy(array('id'=>$id));

        //$foto=$em->find("VanBundle:Foto",$id);

        // Query -Category
        $kategori=$em->getRepository("VanBundle:Kategori")->findBy(array('parentID' => 2));

        $foto=$em->getRepository('VanBundle:Foto')->findBy(array('oto'=>$id));




        return $this->render('@Van/Oto/duzenle.html.twig',array('oto'=>$oto,'fotolar'=>$foto,'kategoriler'=>$kategori));
    }


    public function guncelleAction(Request $request)
    {
        //doctrini çağırdık
        $em=$this->getDoctrine()->getManager();

        // Giriş yapmış kullanıcının nesnesine ulaştık
        $user=$this->getUser();

        //posttan gelen veriler
        $adi=$request->get('adi');
        $aciklama=$request->get('aciklama');
        $fiyat=$request->get('fiyat');
        $fotom = $request->files->get('foto');
        $kapak_foto=$request->files->get('kapakFoto');
        $kategorim=$request->get('kategori');
        $id=$request->get('id'); // bu satırı unutma :)
        $telefon=$request->get('usrtel');


        $kategori= $em->find("VanBundle:Kategori", $kategorim);

        $oto=$em->getRepository('VanBundle:Oto')->findOneBy(array('id'=>$id));

        try {
            if ($telefon == null) {
                $oto->setTelefon("yok");
            } else {
                $oto->setTelefon($telefon);
            }


            $oto->setAdi($adi);
            $oto->setAciklama($aciklama);
            $oto->setFiyat($fiyat);
            $oto->setKategori($kategori);
            $oto->setUye($user);


            if ($kapak_foto != null) {
                $fileName2 = md5(uniqid()) . '.' . $kapak_foto->guessExtension();

                $kapak_foto->move(
                    $this->getParameter('brochures_directory'),
                    $fileName2
                );

                $oto->setKapakFoto($fileName2);
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
                        $oto->addFotolar($foto);
                        $foto->setAdi($fileName);
                        $foto->setOto($oto);


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

        $oto=$em->getRepository('VanBundle:Oto')->findOneBy(array('id'=>$id));

        try {

            $em->remove($oto);

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


/*
 * company : Koddata.com
 * user: Aziz ÇİFTÇİ
 * mail: aziz.ciftci4@gmail.ccom
 * enterprise software solution
 */

}
