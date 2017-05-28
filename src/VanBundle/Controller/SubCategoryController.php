<?php

namespace VanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SubCategoryController extends Controller
{
 public function kategori_listele($id,$adi,$parentID)
 {
     $em=$this->getDoctrine()->getManager();

     $tumSonuclar=$em->getRepository("VanBundle:Kategori")->findBy(array('parentID' => 4));



     global $toplamSatirSayisi;

     //kategorinin, alt kategori sayısını öğreniyoruz:
     $altKategoriSayisi = 0;
     for ($i = 0; $i < count($toplamSatirSayisi); $i++) {
         if ($tumSonuclar[i]->getParentID() == $id) {
             $altKategoriSayisi++;
         }
     }

     if ($altKategoriSayisi > 0) { //alt kategorisi varsa onları da listele


         for ($i = 0; $i < count($toplamSatirSayisi); $i++) {

             if ($tumSonuclar[$i]->getParentID() == $id) {
                 kategori_listele($tumSonuclar[$i]->getId(), $tumSonuclar[$i]->getAdi(), $tumSonuclar[$i]->getParentID());
             }
         }

 }


}}
