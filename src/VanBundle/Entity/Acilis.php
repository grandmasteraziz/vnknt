<?php

namespace VanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acilis
 *
 * @ORM\Table(name="acilis")
 * @ORM\Entity(repositoryClass="VanBundle\Repository\AcilisRepository")
 */
class Acilis
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
     * @ORM\Column(name="adi", type="string", length=150)
     */
    private $adi;

    /**
     * @var string
     *
     * @ORM\Column(name="kapak_foto", type="string", length=255)
     */
    private $kapakFoto;


    /**
     * Get id
     *
     * @return int
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
     * @return Acilis
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
     * Set kapakFoto
     *
     * @param string $kapakFoto
     *
     * @return Acilis
     */
    public function setKapakFoto($kapakFoto)
    {
        $this->kapakFoto = $kapakFoto;

        return $this;
    }

    /**
     * Get kapakFoto
     *
     * @return string
     */
    public function getKapakFoto()
    {
        return $this->kapakFoto;
    }
}

