<?php

    namespace VanBundle\Entity;

    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\ORM\Mapping as ORM;

    /**
     * Emlak
     *
     * @ORM\Table(name="emlak")
     * @ORM\Entity(repositoryClass="VanBundle\Repository\EmlakRepository")
     */
    class Emlak
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
         * @var string
         *
         * @ORM\Column(name="telefon", type="string", length=255)
         */
        private $telefon;



        /**
         * One-To-Many, Bidirectional
         *
         *@var ArrayCollection $fotolar
         *
         * @ORM\OneToMany(targetEntity="VanBundle\Entity\Foto",mappedBy="emlak",cascade={"persist"})
         *
         */
        protected $fotolar;

        /**
         * @ORM\ManyToOne(targetEntity="VanBundle\Entity\Kategori",inversedBy="emlaklar")
         * @ORM\JoinColumn(referencedColumnName="id",name="kategori_id")
         */
        private $kategori;

        /**
         * @ORM\ManyToOne(targetEntity="VanBundle\Entity\User",inversedBy="emlaklar")
         * @ORM\JoinColumn(referencedColumnName="id",name="uye_id")
         */
        private $uye;



        /**
         * @var string
         *
         * @ORM\Column(name="kapak_foto", type="string", length=255)
         */
        private $kapak_foto=null;

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
     * @return Emlak
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
     * @return Emlak
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
     * @return Emlak
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
     * Set telefon
     *
     * @param string $telefon
     *
     * @return Emlak
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
     * Set kapakFoto
     *
     * @param string $kapakFoto
     *
     * @return Emlak
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
     * @return Emlak
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
     * @param \VanBundle\Entity\Kategori $kategori
     *
     * @return Emlak
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
     * @return Emlak
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
