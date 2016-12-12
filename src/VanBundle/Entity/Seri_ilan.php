<?php

namespace VanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Seri_ilan
 *
 * @ORM\Table(name="seri_ilan")
 * @ORM\Entity(repositoryClass="VanBundle\Repository\Seri_ilanRepository")
 */
class Seri_ilan
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
     * @ORM\ManyToOne(targetEntity="VanBundle\Entity\Kategori",inversedBy="seri_ilanlar")
     * @ORM\JoinColumn(referencedColumnName="id",name="kategori_id")
     */
    private $kategori;

    /**
     * @ORM\ManyToOne(targetEntity="VanBundle\Entity\User",inversedBy="seri_ilanlar")
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
     * @return Seri_ilan
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
     * @return Seri_ilan
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
     * Set kategori
     *
     * @param \VanBundle\Entity\Kategori $kategori
     *
     * @return Seri_ilan
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
     * @return Seri_ilan
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
