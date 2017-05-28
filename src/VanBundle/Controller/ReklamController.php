<?php

namespace VanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VanBundle\Entity\Foto;
use VanBundle\Entity\Reklam;

class ReklamController extends Controller
{

    public function listeleAction(Request $request)
    {
        //Doctrine
        $em=$this->getDoctrine()->getManager();

        // Query -Category
        $kategori=$em->getRepository('VanBundle:ReklamKategori')->findAll();

        // Query - fetch all Emlak
        $reklam=$em->getRepository('VanBundle:Reklam')->findAll();

        $paginator=$this->get('knp_paginator');

        $result= $paginator->paginate(
            $reklam,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',15)
        );

        // Query -Foto
        $foto=$em->getRepository("VanBundle:Foto")->findOneBy(array('reklam'=>$reklam));


        return $this->render('VanBundle:Reklam:listele.html.twig',array('kategoriler'=>$kategori,'reklamlar'=>$result,'fotolar'=>$foto));
    }


    public function ekleAction(Request $request)
    {
        //doctrini çağırdık
        $em=$this->getDoctrine()->getManager();



        //posttan gelen veriler
        $adi=$request->request->get('adi');
        $tel=$request->request->get('usrtel');
        $aciklama=$request->request->get('aciklama');
        $fotom = $request->files->get('foto');
        $kapak_foto=$request->files->get('kapakFoto');
        $kategorim=$request->request->get('kategori');


        $kategori= $em->find("VanBundle:ReklamKategori", $kategorim);

        $reklam=new Reklam();




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

        return $this->redirect($this->generateUrl('reklam_listele'));
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
        $adi=$request->request->get('adi');
        $aciklama=$request->request->get('aciklama');
        $tel=$request->request->get('usrtel');
        $fotom = $request->files->get('foto');
        $kapak_foto=$request->files->get('kapakFoto');
        $kategorim=$request->request->get('kategori');
        $id=$request->request->get('id'); // bu satırı unutma :)


        $kategori= $em->find("VanBundle:ReklamKategori", $kategorim);

        $reklam=$em->getRepository('VanBundle:Reklam')->findOneBy(array('id'=>$id));

        if ($tel==null)
        {
            $reklam->setTelefon("yok");
        }else {
            $reklam->setTelefon($tel);
        }
            $reklam->setAdi($adi);
            $reklam->setAciklama($aciklama);
            $reklam->setKategori($kategori);



            if($kapak_foto != null) {
                $fileName2 = md5(uniqid()) . '.' . $kapak_foto->guessExtension();

                $kapak_foto->move(
                    $this->getParameter('brochures_directory'),
                    $fileName2
                );

                $reklam->setKapakFoto($fileName2);
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
                        $reklam->addFotolar($foto);
                        $foto->setAdi($fileName);
                        $foto->setReklam($reklam);


                    }}
            }
        $em->flush();


        return $this->redirect($this->generateUrl('reklam_listele'));
    }

    public function silAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $reklam=$em->getRepository('VanBundle:Reklam')->findOneBy(array('id'=>$id));



        $em->remove($reklam);
        $em->flush();

        return $this->redirect($this->generateUrl('reklam_listele'));
    }


}
