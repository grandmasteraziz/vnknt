<?php

namespace VanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use VanBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;

class UserRegisterController extends Controller
{
    public function saveUserAction(Request $request)
    {
        //Doctrini çağır
        $em=$this->getDoctrine()->getManager();

    try{

        // requestlerin alınması
        $kullaniciID=$request->get('id');
        $kullaniciAdi=$request->get('kadi');
        $kullaniciMail=$request->get('mail');
        $kullaniciSifre=$request->get('sifre');
        $kullaniciCinsiyet=$request->get('gender');
        $kullaniciTel=$request->get('tel');

        //jms
        $serialize=$this->get('jms_serializer');


        //üye id yi kontrole et
        if ($kullaniciID!=null){

            //üye varlığını kontrol etme
             $isMember= $em->getRepository('VanBundle:User')->findOneBy(array('facebookId'=>$kullaniciID));


            //üye yoksa
            if (!$isMember)
            {
                $user=new User();
                $user->setFacebookId($kullaniciID);
                $user->setUsername($kullaniciAdi);
                $user->setUsernameCanonical($kullaniciAdi);
                $user->setEmail($kullaniciMail);
                $user->setEmailCanonical($kullaniciMail);
                $user->setPlainPassword($kullaniciSifre);
                $user->setEnabled(true);
                $user->setRoles(array("ROLE_USER"));
                $user->setGender($kullaniciCinsiyet);
                $user->setTelefon($kullaniciTel);

                $em->persist($user);
                $em->flush();

            $data=$serialize->serialize($user->getId(),'json');


                return new Response($data,200,['content-type'=>'application/json']);

            }else{
                $data=$serialize->serialize( $isMember->getId(),'json');

                return new Response($data,200,['content-type'=>'application/json']);
            }

        }}catch (Exception $exception){

        $data=$serialize->serialize(['data'=>$exception->getMessage()],'json');

        return new Response($data,200,['content-type'=>'application/json']);
    }


    }
}
/*
 * Company: Koddata.com
 * Developer: Aziz ÇİFTÇİ
 * Mail: aziz.ciftci4@gmail.com
 * Enterprise Software Solution
 */