<?php

namespace VanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AcilisJsonController extends Controller
{
    public function randomListAction()
    {

        //Doctrine
        $em=$this->getDoctrine()->getManager();

        $acilis=$em->getRepository('VanBundle:Acilis')->findAll();

        foreach ($acilis as $acil)
        {
            $idList[]= $acil->getId();
        }

        // Dizideki anahtarlar ve degerleri yer değiştir
        // $id = array_flip($idList);

    //    var_dump($idList[array_rand($idList)]);
      //  die();

        //diziden rastgele anahtar seç
        $rastgele_id = $idList[array_rand($idList)];







        $rastgeleCek=$em->getRepository('VanBundle:Acilis')->findOneBy(array('id'=>$rastgele_id));



        return $this->render('@Van/Acilis/reklam.html.twig',array('acilis'=>$rastgeleCek));
    }
}
