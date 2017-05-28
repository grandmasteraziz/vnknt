<?php

namespace VanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use VanBundle\Entity\Foto;
use VanBundle\Entity\Oto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\FileBag;

class OtoController extends Controller
{
    public function listeleAction(Request $request)
    {
        //Doctrine
        $em=$this->getDoctrine()->getManager();

        // Query -Category
        $kategori=$em->getRepository("VanBundle:Kategori")->findBy(array('parentID' => 2));

        // Query - fetch all Emlak
        $oto=$em->getRepository('VanBundle:Oto')->findAll();

        $paginator=$this->get('knp_paginator');

        $result= $paginator->paginate(
            $oto,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',10)
        );

        // Query -Foto
        $foto=$em->getRepository("VanBundle:Foto")->findOneBy(array('oto'=>$oto));


        return $this->render('VanBundle:Oto:listele.html.twig',array('kategoriler'=>$kategori,'otolar'=>$result,'fotolar'=>$foto));
    }

    public function ekleAction(Request $request)
    {
        //doctrini çağırdık
        $em=$this->getDoctrine()->getManager();

        // Giriş yapmış kullanıcının nesnesine ulaştık
        $user=$this->getUser();

        //posttan gelen veriler
        $adi=$request->request->get('adi');
        $aciklama=$request->request->get('aciklama');
        $fiyat=$request->request->get('fiyat');
        $fotom = $request->files->get('foto');
        $kapak_foto=$request->files->get('kapakFoto');
        $kategorim=$request->request->get('kategori');
        $telefon=$request->request->get('usrtel');

        $kategori= $em->find("VanBundle:Kategori", $kategorim);


        $oto=new Oto();
        $oto->setAdi($adi);
        $oto->setAciklama($aciklama);
        $oto->setFiyat($fiyat);
        $oto->setKategori($kategori);
        $oto->setUye($user);


        if ($telefon==null){
            $oto->setTelefon("yok");
        }else{
            $oto->setTelefon($telefon);
        }

        $fileName2 = md5(uniqid()) . '.' . $kapak_foto->guessExtension();

        $kapak_foto->move(
            $this->getParameter('brochures_directory'),
            $fileName2
        );

        $oto->setKapakFoto($fileName2);


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
                $oto->addFotolar($foto);
                $foto->setAdi($fileName);
                $foto->setOto($oto);

                foreach ($images as $uploadfileName){





                    $em->persist($oto);
                    $em->persist($foto);
                    $em->flush();
                }
            }
        }





        return $this->redirect($this->generateUrl('oto_listele'));
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
        $adi=$request->request->get('adi');
        $aciklama=$request->request->get('aciklama');
        $fiyat=$request->request->get('fiyat');
        $fotom = $request->files->get('foto');
        $kapak_foto=$request->files->get('kapakFoto');
        $kategorim=$request->request->get('kategori');
        $id=$request->request->get('id'); // bu satırı unutma :)
        $telefon=$request->request->get('usrtel');


        $kategori= $em->find("VanBundle:Kategori", $kategorim);

        $oto=$em->getRepository('VanBundle:Oto')->findOneBy(array('id'=>$id));

        if ($telefon==null){
            $oto->setTelefon("yok");
        }else{
            $oto->setTelefon($telefon);
        }



        $oto->setAdi($adi);
        $oto->setAciklama($aciklama);
        $oto->setFiyat($fiyat);
        $oto->setKategori($kategori);
        $oto->setUye($user);


        if($kapak_foto != null) {
            $fileName2 = md5(uniqid()) . '.' . $kapak_foto->guessExtension();

            $kapak_foto->move(
                $this->getParameter('brochures_directory'),
                $fileName2
            );

            $oto->setKapakFoto($fileName2);
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
                    $oto->addFotolar($foto);
                    $foto->setAdi($fileName);
                    $foto->setOto($oto);


                }}
        }
        $em->flush();


        return $this->redirect($this->generateUrl('oto_listele'));
    }

    public function silAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $oto=$em->getRepository('VanBundle:Oto')->findOneBy(array('id'=>$id));



        $em->remove($oto);

        $em->flush();

        return $this->redirect($this->generateUrl('oto_listele'));
    }




}
