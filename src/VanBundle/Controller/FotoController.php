<?php

namespace VanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class FotoController extends Controller
{
    public function fotoSilAction($id)
    {

        $em=$this->getDoctrine()->getManager();

        $foto=$em->getRepository('VanBundle:Foto')->findOneBy(array('id'=>$id));


            $ad=$foto->getAdi();
            $brochuresDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/brochures';
            unlink($brochuresDir.'/'.$ad );

            $em->remove($foto);
            $em->flush();


        return new JsonResponse(array('id'=>$id));
    }


}
