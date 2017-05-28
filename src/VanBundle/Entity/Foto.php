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
     *Many-To-One, Bidirectional
     *
     * @var Oto $oto
     *
     * @ORM\ManyToOne(targetEntity="VanBundle\Entity\Oto",inversedBy="fotolar")
     * @ORM\JoinColumn(referencedColumnName="id",name="oto_id",onDelete="CASCADE")
     */
    protected $oto=null;



    /**
     *Many-To-One, Bidirectional
     *
     * @var Emlak $emlak
     *
     *
     * @ORM\ManyToOne(targetEntity="VanBundle\Entity\Emlak",inversedBy="fotolar")
     * @ORM\JoinColumn(referencedColumnName="id",name="emlak_id",onDelete="CASCADE")
     */
    protected $emlak=null;

    /**
     *
     *Many-To-One, Bidirectional
     *
     * @var Reklam $reklam
     * @ORM\ManyToOne(targetEntity="VanBundle\Entity\Reklam",inversedBy="fotolar")
     * @ORM\JoinColumn(referencedColumnName="id",name="reklam_id",onDelete="CASCADE")
     */
    protected $reklam=null;




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
     * Set oto
     *
     * @param \VanBundle\Entity\Oto $oto
     *
     * @return Foto
     */
    public function setOto(\VanBundle\Entity\Oto $oto = null)
    {
        $this->oto = $oto;

        return $this;
    }

    /**
     * Get oto
     *
     * @return \VanBundle\Entity\Oto
     */
    public function getOto()
    {
        return $this->oto;
    }

    /**
     * Set emlak
     *
     * @param \VanBundle\Entity\Emlak $emlak
     *
     * @return Foto
     */
    public function setEmlak(\VanBundle\Entity\Emlak $emlak = null)
    {
        $this->emlak = $emlak;

        return $this;
    }

    /**
     * Get emlak
     *
     * @return \VanBundle\Entity\Emlak
     */
    public function getEmlak()
    {
        return $this->emlak;
    }

    /**
     * Set reklam
     *
     * @param \VanBundle\Entity\Reklam $reklam
     *
     * @return Foto
     */
    public function setReklam(\VanBundle\Entity\Reklam $reklam = null)
    {
        $this->reklam = $reklam;

        return $this;
    }

    /**
     * Get reklam
     *
     * @return \VanBundle\Entity\Reklam
     */
    public function getReklam()
    {
        return $this->reklam;
    }
}
