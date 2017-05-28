<?php

namespace VanBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reklam
 *
 * @ORM\Table(name="reklam")
 * @ORM\Entity(repositoryClass="VanBundle\Repository\ReklamRepository")
 */
class Reklam
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
     * @ORM\Column(name="telefon", type="string", length=255)
     */
    private $telefon;

    /**
     * @var string
     *
     * @ORM\Column(name="aciklama", type="text")
     */
    private $aciklama;



    /**
     *One-To-Many, Bidirectional
     *
     *@var ArrayCollection $fotolar
     *
     * @ORM\OneToMany(targetEntity="VanBundle\Entity\Foto",mappedBy="reklam",cascade={"persist"})
     *
     */
    protected $fotolar;

    /**
     * @ORM\ManyToOne(targetEntity="VanBundle\Entity\ReklamKategori",inversedBy="reklamlar")
     * @ORM\JoinColumn(referencedColumnName="id",name="kategori_id")
     */
    private $kategori;


    /**
     * @var string
     *
     * @ORM\Column(name="kapak_foto", type="string", length=255)
     */
    private $kapak_foto;

    public function __construct()
    {
        $this->fotolar=new ArrayCollection();
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
     * @return Reklam
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
     * Set telefon
     *
     * @param string $telefon
     *
     * @return Reklam
     */
    public function setTelefon($telefon)
    {
        $this->telefon = $telefon;

        return $this;
    }

    /**
     * Get telefon
     *
     * @return string
     */
    public function getTelefon()
    {
        return $this->telefon;
    }

    /**
     * Set aciklama
     *
     * @param string $aciklama
     *
     * @return Reklam
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
     * @return Reklam
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
     * Add fotolar
     *
     * @param \VanBundle\Entity\Foto $fotolar
     *
     * @return Reklam
     */
    public function addFotolar(\VanBundle\Entity\Foto $fotolar)
    {
        $this->fotolar[] = $fotolar;

        return $this;
    }

    /**
     * Remove fotolar
     *
     * @param \VanBundle\Entity\Foto $fotolar
     */
    public function removeFotolar(\VanBundle\Entity\Foto $fotolar)
    {
        $this->fotolar->removeElement($fotolar);
    }

    /**
     * Get fotolar
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFotolar()
    {
        return $this->fotolar;
    }

    /**
     * Set kategori
     *
     * @param \VanBundle\Entity\ReklamKategori $kategori
     *
     * @return Reklam
     */
    public function setKategori(\VanBundle\Entity\ReklamKategori $kategori = null)
    {
        $this->kategori = $kategori;

        return $this;
    }

    /**
     * Get kategori
     *
     * @return \VanBundle\Entity\ReklamKategori
     */
    public function getKategori()
    {
        return $this->kategori;
    }
}
