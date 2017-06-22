<?php

namespace VanBundle\Controller;

use Hateoas\Configuration\Route;
use Proxies\__CG__\VanBundle\Entity\Kategori;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use VanBundle\Entity\Emlak;
use VanBundle\Entity\Foto;
use VanBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Response;
use VanBundle\Factory\KnpPaginatorFactory;
use VanBundle\VanBundle;


class EmlakJsonController extends Controller
{


    // kiralık emlak
    public function kiralikAction(Request $request){

        $em=$this->getDoctrine()->getManager();

        // Query - fetch all Emlak
        $emlak=$em->getRepository('VanBundle:Emlak')->findBy(array('kategori'=>7),array('id' => 'DESC'));

        //knp and jms
        $pager=$this->get('knp_paginator');
        $serializer=$this->get('jms_serializer');


        if (count($emlak)>0)
        {
            $paginated=$pager->paginate($emlak,$request->query->getInt('page',1),$request->query->getInt('limit',10));

            $factory=new KnpPaginatorFactory();
            $collection=$factory->createRepresentation($paginated,new Route('emlak_json_kiralık'),array());

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

    // apart emlak
    public function apartAction(Request $request){

        $em=$this->getDoctrine()->getManager();

        // Query - fetch all Emlak
        $emlak=$em->getRepository('VanBundle:Emlak')->findBy(array('kategori'=>9),array('id' => 'DESC'));

        //knp and jms
        $pager=$this->get('knp_paginator');
        $serializer=$this->get('jms_serializer');


        if (count($emlak)>0)
        {
            $paginated=$pager->paginate($emlak,$request->query->getInt('page',1),$request->query->getInt('limit',10));

            $factory=new KnpPaginatorFactory();
            $collection=$factory->createRepresentation($paginated,new Route('emlak_json_apart'),array());

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

    // satılık emlak
    public function satilikAction(Request $request){

        $em=$this->getDoctrine()->getManager();

        // Query - fetch all Emlak
        $emlak=$em->getRepository('VanBundle:Emlak')->findBy(array('kategori'=>8),array('id' => 'DESC'));

        //knp and jms
        $pager=$this->get('knp_paginator');
        $serializer=$this->get('jms_serializer');


        if (count($emlak)>0)
        {
            $paginated=$pager->paginate($emlak,$request->query->getInt('page',1),$request->query->getInt('limit',10));

            $factory=new KnpPaginatorFactory();
            $collection=$factory->createRepresentation($paginated,new Route('emlak_json_satilik'),array());

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



    public function listeleAction()
    {
        //Doctrine
        $em=$this->getDoctrine()->getManager();


        // Query - fetch all Emlak
        $emlak=$em->getRepository('VanBundle:Emlak')->findBy(array(),array('id' => 'DESC'));


        $yanit=array();
        foreach ($emlak as $meta)
        {
            $newEtkinlik=array();
            $newEtkinlik['id']=$meta->getId();
            $newEtkinlik['adi']=$meta->getAdi();
            $newEtkinlik['fiyat']=$meta->getFiyat();
            $newEtkinlik['aciklama']=$meta->getAciklama();
            $newEtkinlik['telefon']=$meta->getTelefon();
            $newEtkinlik['kategori']=$meta->getKategori()->getId();
            $newEtkinlik['uyeID']=$meta->getUye()->getId();
            $newEtkinlik['kapakFoto']=$meta->getKapakFoto();


            array_push($yanit,$newEtkinlik);
        }



        $response=new Response(json_encode(array('emlaklar' =>$yanit),JSON_UNESCAPED_UNICODE));
        $response->headers->set('Content-type','application/json; charset=utf-8');
        $response->setStatusCode(200);

        return $response;

    }

    public function ekleAction(Request $request)
    {
        //doctrini çağırdık
        $em=$this->getDoctrine()->getManager();





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



        $kategori= $em->getRepository("VanBundle:Kategori")->findOneBy(array('id'=>$kategorim));
        $user2=$em->getRepository("VanBundle:User")->findOneBy(array('id'=>$user));
        $serializer=$this->get('jms_serializer');



        try {
            $emlak = new Emlak();
            $emlak->setAdi($adi);
            $emlak->setAciklama($aciklama);
            $emlak->setFiyat($fiyat);
            $emlak->setKategori($kategori);
            $emlak->setUye($user2);


            if (!$telefon) {
                $emlak->setTelefon("yok");
            } else {
                $emlak->setTelefon($telefon);
            }


            $fileName2 = md5(uniqid()) . '.' . $kapak_foto->guessExtension();

            $kapak_foto->move(
                $this->getParameter('brochures_directory'),
                $fileName2
            );

            $emlak->setKapakFoto($fileName2);
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
                    $emlak->addFotolar($foto);
                    $foto->setAdi($fileName);
                    $foto->setEmlak($emlak);

                    foreach ($images as $uploadfileName) {


                        $em->persist($emlak);
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

        $emlak=$em->getRepository('VanBundle:Emlak')->findOneBy(array('id'=>$id));


        // Query -Category
        $kategori=$em->getRepository("VanBundle:Kategori")->findBy(array('parentID' => 3));

        $foto=$em->getRepository('VanBundle:Foto')->findBy(array('emlak'=>$id));

        return  new JsonResponse(array('emlak'=>$emlak,'fotolar'=>$foto,'kategoriler'=>$kategori));
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
        $tel=$request->get('usrtel');
        $fiyat=$request->get('fiyat');
        $fotom = $request->files->get('foto');
        $kapak_foto=$request->files->get('kapakFoto');
        $kategorim=$request->get('kategori');
        $id=$request->get('id'); // bu satırı unutma :)


        $kategori= $em->find("VanBundle:Kategori", $kategorim);

        $yeni_emlak=$em->getRepository('VanBundle:Emlak')->findOneBy(array('id'=>$id));

        if ($tel==null)
        {
            $yeni_emlak->setTelefon("yok");
        }else {
            $yeni_emlak->setTelefon($tel);
        }
        $yeni_emlak->setAdi($adi);
        $yeni_emlak->setAciklama($aciklama);
        $yeni_emlak->setFiyat($fiyat);
        $yeni_emlak->setKategori($kategori);
        $yeni_emlak->setUye($user);


        if($kapak_foto != null) {
            $fileName2 = md5(uniqid()) . '.' . $kapak_foto->guessExtension();

            $kapak_foto->move(
                $this->getParameter('brochures_directory'),
                $fileName2
            );

            $yeni_emlak->setKapakFoto($fileName2);
        }

        $images = array();
        if($fotom != null && count($fotom)>0) {
            $key = 0;


            // Çoklu Fotoğraf alma
            foreach ($fotom as $file)
            {
                if (count($file)>0){
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                $file->move(
                    $this->getParameter('brochures_directory'),
                    $fileName
                );
                $images[$key++] = $fileName;


                $foto=new Foto();


                $yeni_emlak->addFotolar($foto);
                $foto->setAdi($fileName);
                $foto->setEmlak($yeni_emlak);


            }}
        }
        $em->flush();


        return $this->redirect($this->generateUrl('emlak_listele'));
    }

    public function silAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $emlak=$em->getRepository('VanBundle:Emlak')->findOneBy(array('id'=>$id));

        $serialize=$this->get('jms_serializer');

        if (count($emlak)>0){
            $em->remove($emlak);
            $em->flush();

            $data=$serialize->serialize(['data'=>true],'json');
        }else{
            $data=$serialize->serialize(['data'=>false],'json');
        }


        return new Response($data,200,['content-type'=>'application/json']);
    }


}
