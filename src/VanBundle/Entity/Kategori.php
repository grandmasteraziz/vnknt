<?php

namespace VanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

/**
 * Kategori
 *
 * @ORM\Table(name="kategori")
 * @ORM\Entity(repositoryClass="VanBundle\Repository\KategoriRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Kategori
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose
     */
    private $id;

    /**
     * @var string
     * @JMS\Expose
     * @ORM\Column(name="adi", type="string", length=255)
     */
    private $adi;

    /**
     * @var int
     *
     * @ORM\Column(name="parentID", type="smallint")
     *
     */
    private $parentID;

    /**
     * @ORM\OneToMany(targetEntity="VanBundle\Entity\Emlak",mappedBy="kategori")
     *
     */
    private $emlaklar;

    //mesela bunlarada arasıra ihtiyacın olabilir kategorinin latındaki arabalrı getir gibisinden bunlarıda gruplayabilirisn
    //şu şekilde
    //şimdi bu gelmez
    //ama eğer burada yasam tablosuyla ilişkili olmadığı için olabilir mi?
    // yok bu grup değerini şu şekilde planlamak lazım en başta
    // default diye bi grup tanımlamak lazım her halükarda gelicek olan alanları tek tek ayarlıcaksın
    // bu şekilde yasam tablosuna eklenmesi gerek default değerlerin sonrasında
    //

    /**
     * @ORM\OneToMany(targetEntity="VanBundle\Entity\Oto",mappedBy="kategori")
     * @JMS\Groups({"otogetir","default"})
     */
    private $otolar;

    /**
     * @ORM\OneToMany(targetEntity="VanBundle\Entity\Etkinlik",mappedBy="kategori")
     *
     */
    private $etkinlikler;

    /**
     * @ORM\OneToMany(targetEntity="VanBundle\Entity\Yasam",mappedBy="kategori")
     *
     */
    private $yasamlar;

    /**
     * @ORM\OneToMany(targetEntity="VanBundle\Entity\Seri_ilan",mappedBy="kategori")
     *
     */
    private $seri_ilanlar;


    public function __construct()
    {

        $this->emlaklar = new ArrayCollection();
        $this->otolar=new ArrayCollection();
        $this->etkinlikler=new ArrayCollection();
        $this->yasamlar=new ArrayCollection();
        $this->seri_ilanlar=new ArrayCollection();
    }



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set adi
     *
     * @param string $adi
     *
     * @return Kategori
     */
    public function setAdi($adi)
    {
        $this->adi = $adi;

        return $this;
    }

    /**
     * Get adi
     *
     * @return string
     */
    public function getAdi()
    {
        return $this->adi;
    }

    /**
     * Set parentID
     *
     * @param integer $parentID
     *
     * @return Kategori
     */
    public function setParentID($parentID)
    {
        $this->parentID = $parentID;

        return $this;
    }

    /**
     * Get parentID
     *
     * @return integer
     */
    public function getParentID()
    {
        return $this->parentID;
    }

    /**
     * Add emlaklar
     *
     * @param \VanBundle\Entity\Emlak $emlaklar
     *
     * @return Kategori
     */
    public function addEmlaklar(\VanBundle\Entity\Emlak $emlaklar)
    {
        $this->emlaklar[] = $emlaklar;

        return $this;
    }

    /**
     * Remove emlaklar
     *
     * @param \VanBundle\Entity\Emlak $emlaklar
     */
    public function removeEmlaklar(\VanBundle\Entity\Emlak $emlaklar)
    {
        $this->emlaklar->removeElement($emlaklar);
    }

    /**
     * Get emlaklar
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmlaklar()
    {
        return $this->emlaklar;
    }

    /**
     * Add otolar
     *
     * @param \VanBundle\Entity\Oto $otolar
     *
     * @return Kategori
     */
    public function addOtolar(\VanBundle\Entity\Oto $otolar)
    {
        $this->otolar[] = $otolar;

        return $this;
    }

    /**
     * Remove otolar
     *
     * @param \VanBundle\Entity\Oto $otolar
     */
    public function removeOtolar(\VanBundle\Entity\Oto $otolar)
    {
        $this->otolar->removeElement($otolar);
    }

    /**
     * Get otolar
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOtolar()
    {
        return $this->otolar;
    }

    /**
     * Add etkinlikler
     *
     * @param \VanBundle\Entity\Etkinlik $etkinlikler
     *
     * @return Kategori
     */
    public function addEtkinlikler(\VanBundle\Entity\Etkinlik $etkinlikler)
    {
        $this->etkinlikler[] = $etkinlikler;

        return $this;
    }

    /**
     * Remove etkinlikler
     *
     * @param \VanBundle\Entity\Etkinlik $etkinlikler
     */
    public function removeEtkinlikler(\VanBundle\Entity\Etkinlik $etkinlikler)
    {
        $this->etkinlikler->removeElement($etkinlikler);
    }

    /**
     * Get etkinlikler
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtkinlikler()
    {
        return $this->etkinlikler;
    }

    /**
     * Add yasamlar
     *
     * @param \VanBundle\Entity\Yasam $yasamlar
     *
     * @return Kategori
     */
    public function addYasamlar(\VanBundle\Entity\Yasam $yasamlar)
    {
        $this->yasamlar[] = $yasamlar;

        return $this;
    }

    /**
     * Remove yasamlar
     *
     * @param \VanBundle\Entity\Yasam $yasamlar
     */
    public function removeYasamlar(\VanBundle\Entity\Yasam $yasamlar)
    {
        $this->yasamlar->removeElement($yasamlar);
    }

    /**
     * Get yasamlar
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getYasamlar()
    {
        return $this->yasamlar;
    }

    /**
     * Add seriIlanlar
     *
     * @param \VanBundle\Entity\Seri_ilan $seriIlanlar
     *
     * @return Kategori
     */
    public function addSeriIlanlar(\VanBundle\Entity\Seri_ilan $seriIlanlar)
    {
        $this->seri_ilanlar[] = $seriIlanlar;

        return $this;
    }

    /**
     * Remove seriIlanlar
     *
     * @param \VanBundle\Entity\Seri_ilan $seriIlanlar
     */
    public function removeSeriIlanlar(\VanBundle\Entity\Seri_ilan $seriIlanlar)
    {
        $this->seri_ilanlar->removeElement($seriIlanlar);
    }

    /**
     * Get seriIlanlar
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSeriIlanlar()
    {
        return $this->seri_ilanlar;
    }
}
