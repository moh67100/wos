<?php
/**
 * This file is part of the World Of Shinobi (Minegame).
 *
 * Copyright (c) 2017. Vincent Glize <vincent.glize@live.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * BatimentType
 *
 * @ORM\Table(name="building_type")
 * @ORM\Entity(repositoryClass="GameBundle\Repository\BuildingTypeRepository")
 */
class BuildingType
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_ressource", type="boolean", nullable=true)
     */
    private $isRessource;

    /**
     * @var string
     *
     * @ORM\Column(name="descr", type="text")
     */
    private $descr;

    /**
     * @ORM\ManyToOne(targetEntity="Ressource")
     * @ORM\JoinColumn(name="ressource_id", referencedColumnName="id")
     */
    private $ressource;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Image", cascade={"persist"})
     * @Assert\Valid()
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="Building", mappedBy="buildingType")
     */
    private $buildings;

    /**
     * @ORM\OneToMany(targetEntity="TownBuilding", mappedBy="buildingType")
     */
    private $towns;

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
     * Set name
     *
     * @param string $name
     *
     * @return BatimentType
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
     * Set descr
     *
     * @param string $descr
     *
     * @return BatimentType
     */
    public function setDescr($descr)
    {
        $this->descr = $descr;

        return $this;
    }

    /**
     * Get descr
     *
     * @return string
     */
    public function getDescr()
    {
        return $this->descr;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->buildings = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set isRessource
     *
     * @param boolean $isRessource
     *
     * @return BuildingType
     */
    public function setIsRessource($isRessource)
    {
        $this->isRessource = $isRessource;

        return $this;
    }

    /**
     * Get isRessource
     *
     * @return boolean
     */
    public function getIsRessource()
    {
        return $this->isRessource;
    }

    /**
     * Add building
     *
     * @param \GameBundle\Entity\Building $building
     *
     * @return BuildingType
     */
    public function addBuilding(\GameBundle\Entity\Building $building)
    {
        $this->buildings[] = $building;

        return $this;
    }

    /**
     * Remove building
     *
     * @param \GameBundle\Entity\Building $building
     */
    public function removeBuilding(\GameBundle\Entity\Building $building)
    {
        $this->buildings->removeElement($building);
    }

    /**
     * Get buildings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBuildings()
    {
        return $this->buildings;
    }

    /**
     * Set ressource
     *
     * @param \GameBundle\Entity\Ressource $ressource
     *
     * @return BuildingType
     */
    public function setRessource(\GameBundle\Entity\Ressource $ressource = null)
    {
        $this->ressource = $ressource;

        return $this;
    }

    /**
     * Get ressource
     *
     * @return \GameBundle\Entity\Ressource
     */
    public function getRessource()
    {
        return $this->ressource;
    }


    /**
     * Add town
     *
     * @param \GameBundle\Entity\TownBuilding $town
     *
     * @return BuildingType
     */
    public function addTown(\GameBundle\Entity\TownBuilding $town)
    {
        $this->towns[] = $town;

        return $this;
    }

    /**
     * Remove town
     *
     * @param \GameBundle\Entity\TownBuilding $town
     */
    public function removeTown(\GameBundle\Entity\TownBuilding $town)
    {
        $this->towns->removeElement($town);
    }

    /**
     * Get towns
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTowns()
    {
        return $this->towns;
    }

    /**
     * Set image
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return BuildingType
     */
    public function setImage(\AppBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \AppBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }
}
