<?php

namespace VanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use VanBundle\VanBundle;

class DefaultController extends Controller
{
    // anasayfa
    public function indexAction()
    {
        $em=$this->getDoctrine()->getManager();

        //number of advertising
        $reklam=$em->getRepository("VanBundle:Reklam")->findAll();

        //oto-vasita(number of oto)
        $oto=$em->getRepository("VanBundle:Oto")->findAll();


        // Yasam- Number
        $yasam= $em->getRepository("VanBundle:Yasam")->findAll();

        //etkinlik
        $etkinlik=$em->getRepository("VanBundle:Etkinlik")->findAll();

        //Seri ilan
        $seri_ilan=$em->getRepository("VanBundle:Seri_ilan")->findAll();

        //emlak
        $emlak=$em->getRepository("VanBundle:Emlak")->findAll();

        //Counts
        $reklamSayisi=count($reklam);
        $otoSayisi=count($oto);
        $yasamSayisi=count($yasam);
        $etkinlikSayisi=count($etkinlik);
        $seri_ilanSayisi=count($seri_ilan);
        $emlakSayisi=count($emlak);


        return $this->render('VanBundle:Default:index.html.twig',
            array('reklam' => $reklamSayisi, 'oto' => $otoSayisi, 'yasam' => $yasamSayisi,
                'etkinlik' => $etkinlikSayisi, 'seri' => $seri_ilanSayisi, 'emlak' => $emlakSayisi));
    }

    public function listeleAction()
    {
        return $this->render('VanBundle:Default:404.html.twig');
    }
}
