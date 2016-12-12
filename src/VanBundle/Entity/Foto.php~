<?php

namespace VanBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Foto
 *
 * @ORM\Table(name="foto")
 * @ORM\Entity(repositoryClass="VanBundle\Repository\FotoRepository")
 */
class Foto
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="adi", type="string", length=255)
     */
    private $adi;


    /**
     * @ORM\OneToMany(targetEntity="VanBundle\Entity\Oto",mappedBy="foto")
     *
     */
    private $otolar;


    /**
     * @ORM\OneToMany(targetEntity="VanBundle\Entity\Emlak",mappedBy="foto")
     *
     */
    private $emlaklar;

    /**
     * @ORM\OneToMany(targetEntity="VanBundle\Entity\Reklam",mappedBy="foto")
     *
     */
    private $reklamlar;

    public function __construct()
    {
        $this->otolar = new ArrayCollection();
        $this->emlaklar = new ArrayCollection();
        $this->reklamlar=new ArrayCollection();
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
     * @return Foto
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
     * Add otolar
     *
     * @param \VanBundle\Entity\Oto $otolar
     *
     * @return Foto
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
     * Add emlaklar
     *
     * @param \VanBundle\Entity\Emlak $emlaklar
     *
     * @return Foto
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
     * Add reklamlar
     *
     * @param \VanBundle\Entity\Reklam $reklamlar
     *
     * @return Foto
     */
    public function addReklamlar(\VanBundle\Entity\Reklam $reklamlar)
    {
        $this->reklamlar[] = $reklamlar;

        return $this;
    }

    /**
     * Remove reklamlar
     *
     * @param \VanBundle\Entity\Reklam $reklamlar
     */
    public function removeReklamlar(\VanBundle\Entity\Reklam $reklamlar)
    {
        $this->reklamlar->removeElement($reklamlar);
    }

    /**
     * Get reklamlar
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReklamlar()
    {
        return $this->reklamlar;
    }
}
