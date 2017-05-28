<?php

namespace VanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etkinlik
 *
 * @ORM\Table(name="etkinlik")
 * @ORM\Entity(repositoryClass="VanBundle\Repository\EtkinlikRepository")
 */
class Etkinlik
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
     * @var string
     *
     * @ORM\Column(name="adres", type="text")
     */
    private $adres;

    /**
     * @var string
     *
     * @ORM\Column(name="aciklama", type="text")
     */
    private $aciklama;

    /**
     * @ORM\ManyToOne(targetEntity="VanBundle\Entity\Kategori",inversedBy="etkinlikler")
     * @ORM\JoinColumn(referencedColumnName="id",name="kategori_id")
     */
    private $kategori;

    /**
     * @var string
     *
     * @ORM\Column(name="kapak_foto", type="string", length=255)
     */
    private $kapak_foto;


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
     * @return Etkinlik
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
     * Set adres
     *
     * @param string $adres
     *
     * @return Etkinlik
     */
    public function setAdres($adres)
    {
        $this->adres = $adres;

        return $this;
    }

    /**
     * Get adres
     *
     * @return string
     */
    public function getAdres()
    {
        return $this->adres;
    }

    /**
     * Set aciklama
     *
     * @param string $aciklama
     *
     * @return Etkinlik
     */
    public function setAciklama($aciklama)
    {
        $this->aciklama = $aciklama;

        return $this;
    }

    /**
     * Get aciklama
     *
     * @return string
     */
    public function getAciklama()
    {
        return $this->aciklama;
    }

    /**
     * Set kapakFoto
     *
     * @param string $kapakFoto
     *
     * @return Etkinlik
     */
    public function setKapakFoto($kapakFoto)
    {
        $this->kapak_foto = $kapakFoto;

        return $this;
    }

    /**
     * Get kapakFoto
     *
     * @return string
     */
    public function getKapakFoto()
    {
        return $this->kapak_foto;
    }

    /**
     * Set kategori
     *
     * @param \VanBundle\Entity\Kategori $kategori
     *
     * @return Etkinlik
     */
    public function setKategori(\VanBundle\Entity\Kategori $kategori = null)
    {
        $this->kategori = $kategori;

        return $this;
    }

    /**
     * Get kategori
     *
     * @return \VanBundle\Entity\Kategori
     */
    public function getKategori()
    {
        return $this->kategori;
    }
}
