<?php


namespace VanBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @JMS\ExclusionPolicy("all")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose
     */
    protected $id;



    /**
     * @var string
     *
     * @ORM\Column(name="telefon", type="string", length=255,nullable=false)
     */
    private $telefon;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_id", type="string", length=255,nullable=false)
     * @JMS\Expose
     */
    private $facebookId;


    /**
     * @var string
     *
     * @ORM\Column(name="cinsiyet", type="string", length=100,nullable=false)
     */
    private $gender;


    /**
     * @ORM\OneToMany(targetEntity="VanBundle\Entity\Seri_ilan",mappedBy="uye")
     * @JMS\Expose
     */
    private $seri_ilanlar;


    /**
     * @ORM\OneToMany(targetEntity="VanBundle\Entity\Oto",mappedBy="uye")
     * @JMS\Expose
     */
    private $otolar;


    /**
     * @ORM\OneToMany(targetEntity="VanBundle\Entity\Emlak",mappedBy="uye")
     * @JMS\Expose
     */
    private $emlaklar;

    public function __construct()
    {
        $this->seri_ilanlar=new ArrayCollection();
        $this->otolar=new ArrayCollection();
        $this->emlaklar=new ArrayCollection();

        parent::__construct();
        // your own logic
    }




    /**
     * Set telefon
     *
     * @param string $telefon
     *
     * @return User
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
     * Set facebookId
     *
     * @param string $facebookId
     *
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Add seriIlanlar
     *
     * @param \VanBundle\Entity\Seri_ilan $seriIlanlar
     *
     * @return User
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

    /**
     * Add otolar
     *
     * @param \VanBundle\Entity\Oto $otolar
     *
     * @return User
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
     * @return User
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
}
