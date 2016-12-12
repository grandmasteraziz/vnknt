<?php

namespace VanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Oto
 *
 * @ORM\Table(name="oto")
 * @ORM\Entity(repositoryClass="VanBundle\Repository\OtoRepository")
 */
class Oto
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
     * @ORM\Column(name="aciklama", type="text")
     */
    private $aciklama;

    /**
     * @var string
     *
     * @ORM\Column(name="fiyat", type="string", length=100)
     */
    private $fiyat;




    /**
     * @ORM\ManyToOne(targetEntity="VanBundle\Entity\Foto",inversedBy="otolar")
     * @ORM\JoinColumn(referencedColumnName="id",name="foto_id")
     */
    private $foto;


    /**
     * @ORM\ManyToOne(targetEntity="VanBundle\Entity\Kategori",inversedBy="otolar")
     * @ORM\JoinColumn(referencedColumnName="id",name="kategori_id")
     */
    private $kategori;


    /**
     * @ORM\ManyToOne(targetEntity="VanBundle\Entity\User",inversedBy="otolar")
     * @ORM\JoinColumn(referencedColumnName="id",name="uye_id")
     */
    private $uye;

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
     * @return Oto
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
     * Set aciklama
     *
     * @param string $aciklama
     *
     * @return Oto
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
     * Set fiyat
     *
     * @param string $fiyat
     *
     * @return Oto
     */
    public function setFiyat($fiyat)
    {
        $this->fiyat = $fiyat;

        return $this;
    }

    /**
     * Get fiyat
     *
     * @return string
     */
    public function getFiyat()
    {
        return $this->fiyat;
    }

    /**
     * Set foto
     *
     * @param \VanBundle\Entity\Foto $foto
     *
     * @return Oto
     */
    public function setFoto(\VanBundle\Entity\Foto $foto = null)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return \VanBundle\Entity\Foto
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set kategori
     *
     * @param \VanBundle\Entity\Kategori $kategori
     *
     * @return Oto
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

    /**
     * Set uye
     *
     * @param \VanBundle\Entity\User $uye
     *
     * @return Oto
     */
    public function setUye(\VanBundle\Entity\User $uye = null)
    {
        $this->uye = $uye;

        return $this;
    }

    /**
     * Get uye
     *
     * @return \VanBundle\Entity\User
     */
    public function getUye()
    {
        return $this->uye;
    }
}
