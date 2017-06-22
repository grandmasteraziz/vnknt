<?php

namespace VanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

/**
 * ReklamKategori
 *
 * @ORM\Table(name="reklam_kategori")
 * @ORM\Entity(repositoryClass="VanBundle\Repository\ReklamKategoriRepository")
 * @JMS\ExclusionPolicy("all")
 */
class ReklamKategori
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
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @JMS\Expose
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="parentID", type="smallint")
     * @JMS\Expose
     */
    private $parentID;

    /**
     * @ORM\OneToMany(targetEntity="VanBundle\Entity\Reklam",mappedBy="kategori")
     *
     */
    private $reklamlar;


    public function __construct()
    {
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
     * Set name
     *
     * @param string $name
     *
     * @return ReklamKategori
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set parentID
     *
     * @param integer $parentID
     *
     * @return ReklamKategori
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
     * Add reklamlar
     *
     * @param \VanBundle\Entity\Reklam $reklamlar
     *
     * @return ReklamKategori
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
