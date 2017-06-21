<?php

namespace StolarzBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Edge
 *
 * @ORM\Table(name="edge")
 * @ORM\Entity(repositoryClass="StolarzBundle\Repository\EdgeRepository")
 */
class Edge
{
    /**
     * @ORM\ManyToMany(targetEntity="Element", mappedBy="edge")
     */
    private $element;

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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="thickness", type="decimal", precision=2, scale=1)
     */
    private $thickness;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;


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
     * @return Edge
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
     * Set thickness
     *
     * @param string $thickness
     * @return Edge
     */
    public function setThickness($thickness)
    {
        $this->thickness = $thickness;

        return $this;
    }

    /**
     * Get thickness
     *
     * @return string 
     */
    public function getThickness()
    {
        return $this->thickness;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Edge
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get nameThickness
     *
     * @return string
     */
    public function getNameThickness()
    {
        $nameThickness = $this->getName() . " " . $this->getThickness();
        return $nameThickness;
    }
}
