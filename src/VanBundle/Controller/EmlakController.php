<?php

namespace VanBundle\Controller;

use Proxies\__CG__\VanBundle\Entity\Kategori;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use VanBundle\Entity\Emlak;
use VanBundle\Entity\Foto;
use VanBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\FileBag;
use VanBundle\VanBundle;


class EmlakController extends Controller
{

    public function listeleAction(Request $request)
    {
        //Doctrine
        $em=$this->getDoctrine()->getManager();

        // Query -Category
        $kategori=$em->getRepository("VanBundle:Kategori")->findBy(array('parentID' => 3));

        // Query - fetch all Emlak
        $emlak=$em->getRepository('VanBundle:Emlak')->findAll();


        $paginator=$this->get('knp_paginator');

        $result= $paginator->paginate(
            $emlak,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',10)
        );
        // Query -Foto
         $foto=$em->getRepository("VanBundle:Foto")->findOneBy(array('emlak'=>$emlak));


        return $this->render('VanBundle:Emlak:listele.html.twig',array('kategoriler'=>$kategori,'emlaklar'=>$result,'fotolar'=>$foto));
    }

    public function ekleAction(Request $request)
    {
        //doctrini çağırdık
        $em=$this->getDoctrine()->getManager();

        // Giriş yapmış kullanıcının nesnesine ulaştık
        $user=$this->getUser();

        //posttan gelen veriler
        $adi=$request->request->get('adi');
        $tel=$request->request->get('usrtel');
        $aciklama=$request->request->get('aciklama');
        $fiyat=$request->request->get('fiyat');
        $fotom = $request->files->get('foto');
        $kapak_foto=$request->files->get('kapakFoto');
        $kategorim=$request->request->get('kategori');


        $kategori= $em->find("VanBundle:Kategori", $kategorim);

        $yeni_emlak=new Emlak();




        if ($tel!=null)
        {
            $yeni_emlak->setTelefon($tel);
        }else{
            $yeni_emlak->setTelefon("yok");
        }

        $yeni_emlak->setAdi($adi);
        $yeni_emlak->setAciklama($aciklama);
        $yeni_emlak->setFiyat($fiyat);
        $yeni_emlak->setKategori($kategori);
        $yeni_emlak->setUye($user);
        $yeni_emlak->setTelefon($tel);

        $fileName2 = md5(uniqid()) . '.' . $kapak_foto->guessExtension();

        $kapak_foto->move(
            $this->getParameter('brochures_directory'),
            $fileName2
        );

        $yeni_emlak->setKapakFoto($fileName2);


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


                // $yeni_emlak->setKapakFoto($fileName_kapak);





                $foto=new Foto();
                $yeni_emlak->addFotolar($foto);
                $foto->setAdi($fileName);
                $foto->setEmlak($yeni_emlak);
                foreach ($images as $uploadfileName){





                    $em->persist($yeni_emlak);
                    $em->persist($foto);
                    $em->flush();
                }
            }
          }

        return $this->redirect($this->generateUrl('emlak_listele'));
    }



    public function duzenleAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $emlak=$em->getRepository('VanBundle:Emlak')->findOneBy(array('id'=>$id));



        // Query -Category
        $kategori=$em->getRepository("VanBundle:Kategori")->findBy(array('parentID' => 3));

        $foto=$em->getRepository('VanBundle:Foto')->findBy(array('emlak'=>$id));

        return $this->render('@Van/Emlak/duzenle.html.twig',array('emlak'=>$emlak,'fotolar'=>$foto,'kategoriler'=>$kategori));
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
        $tel=$request->request->get('usrtel');
        $fiyat=$request->request->get('fiyat');
        $fotom = $request->files->get('foto');
        $kapak_foto=$request->files->get('kapakFoto');
        $kategorim=$request->request->get('kategori');
        $id=$request->request->get('id'); // bu satırı unutma :)


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

            $key = 0;


            // Çoklu Fotoğraf alma
            foreach ($fotom as $file) {


                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                $file->move(
                    $this->getParameter('brochures_directory'),
                    $fileName
                );
                $images[$key++] = $fileName;


                $foto = new Foto();
                $yeni_emlak->addFotolar($foto);
                $foto->setAdi($fileName);
                $foto->setEmlak($yeni_emlak);
            }


        $em->flush();


        return $this->redirect($this->generateUrl('emlak_listele'));
    }

    public function silAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $emlak=$em->getRepository('VanBundle:Emlak')->findOneBy(array('id'=>$id));

       // $foto=$em->getRepository('VanBundle:Foto')->findBy(array('emlak'=>$id));


        $em->remove($emlak);

        $em->flush();

        return $this->redirect($this->generateUrl('emlak_listele'));
    }



}
