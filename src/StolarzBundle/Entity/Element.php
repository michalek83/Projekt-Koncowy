<?php

namespace StolarzBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Element
 *
 * @ORM\Table(name="element")
 * @ORM\Entity(repositoryClass="StolarzBundle\Repository\ElementRepository")
 */
class Element
{
    /**
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="element")
     */
    private $order;

    /**
     * @ORM\ManyToOne(targetEntity="Material", inversedBy="id")
     */
    private $material;

    /**
     * @ORM\ManyToOne(targetEntity="Edge", inversedBy="id")
     */
    private $edgeLenght1;

    /**
     * @ORM\ManyToOne(targetEntity="Edge", inversedBy="id")
     */
    private $edgeLenght2;

    /**
     * @ORM\ManyToOne(targetEntity="Edge", inversedBy="id")
     */
    private $edgeWidth1;

    /**
     * @ORM\ManyToOne(targetEntity="Edge", inversedBy="id")
     */
    private $edgeWidth2;

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
     * @ORM\Column(name="lenght", type="decimal", precision=5, scale=1)
     */
    private $lenght;

    /**
     * @var string
     *
     * @ORM\Column(name="width", type="decimal", precision=5, scale=1)
     */
    private $width;

    /**
     * @var string
     *
     * @ORM\Column(name="elementName", type="string", length=255, nullable=true)
     */
    private $elementName;

    /**
     * @var string
     *
     * @ORM\Column(name="positionName", type="string", length=255, nullable=true)
     */
    private $positionName;


    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var bool
     *
     * @ORM\Column(name="rotatable", type="boolean")
     */
    private $rotatable;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->material = new \Doctrine\Common\Collections\ArrayCollection();
        $this->edge = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set lenght
     *
     * @param string $lenght
     * @return Element
     */
    public function setLenght($lenght)
    {
        $this->lenght = $lenght;

        return $this;
    }

    /**
     * Get lenght
     *
     * @return string 
     */
    public function getLenght()
    {
        return $this->lenght;
    }

    /**
     * Set width
     *
     * @param string $width
     * @return Element
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return string 
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return string
     */
    public function getElementName()
    {
        return $this->elementName;
    }

    /**
     * @param string $elementName
     */
    public function setElementName($elementName)
    {
        $this->elementName = $elementName;
    }

    /**
     * @return string
     */
    public function getPositionName()
    {
        return $this->positionName;
    }

    /**
     * @param string $positionName
     */
    public function setPositionName($positionName)
    {
        $this->positionName = $positionName;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return Element
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set rotatable
     *
     * @param boolean $rotatable
     * @return Element
     */
    public function setRotatable($rotatable)
    {
        $this->rotatable = $rotatable;

        return $this;
    }

    /**
     * Get rotatable
     *
     * @return boolean 
     */
    public function getRotatable()
    {
        return $this->rotatable;
    }

    /**
     * Set order
     *
     * @param \StolarzBundle\Entity\Order $order
     * @return Element
     */
    public function setOrder(\StolarzBundle\Entity\Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \StolarzBundle\Entity\Order 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set material
     *
     * @param \StolarzBundle\Entity\Material $material
     *
     * @return Element
     */
    public function setMaterial(\StolarzBundle\Entity\Material $material = null)
    {
        $this->material = $material;

        return $this;
    }

    /**
     * Get material
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * Remove material
     *
     * @param \StolarzBundle\Entity\Material $material
     */
    public function removeMaterial(\StolarzBundle\Entity\Material $material)
    {
        $this->material->removeElement($material);
    }

    /**
     * Set edgeLenght1
     *
     * @param \StolarzBundle\Entity\Edge $edgeLenght1
     *
     * @return Element
     */
    public function setEdgeLenght1(\StolarzBundle\Entity\Edge $edgeLenght1 = null)
    {
        $this->edgeLenght1 = $edgeLenght1;

        return $this;
    }

    /**
     * Get edgeLenght1
     *
     * @return \StolarzBundle\Entity\Edge
     */
    public function getEdgeLenght1()
    {
        return $this->edgeLenght1;
    }

    /**
     * Set edgeLenght2
     *
     * @param \StolarzBundle\Entity\Edge $edgeLenght2
     *
     * @return Element
     */
    public function setEdgeLenght2(\StolarzBundle\Entity\Edge $edgeLenght2 = null)
    {
        $this->edgeLenght2 = $edgeLenght2;

        return $this;
    }

    /**
     * Get edgeLenght2
     *
     * @return \StolarzBundle\Entity\Edge
     */
    public function getEdgeLenght2()
    {
        return $this->edgeLenght2;
    }

    /**
     * Set edgeWidth1
     *
     * @param \StolarzBundle\Entity\Edge $edgeWidth1
     *
     * @return Element
     */
    public function setEdgeWidth1(\StolarzBundle\Entity\Edge $edgeWidth1 = null)
    {
        $this->edgeWidth1 = $edgeWidth1;

        return $this;
    }

    /**
     * Get edgeWidth1
     *
     * @return \StolarzBundle\Entity\Edge
     */
    public function getEdgeWidth1()
    {
        return $this->edgeWidth1;
    }

    /**
     * Set edgeWidth2
     *
     * @param \StolarzBundle\Entity\Edge $edgeWidth2
     *
     * @return Element
     */
    public function setEdgeWidth2(\StolarzBundle\Entity\Edge $edgeWidth2 = null)
    {
        $this->edgeWidth2 = $edgeWidth2;

        return $this;
    }

    /**
     * Get edgeWidth2
     *
     * @return \StolarzBundle\Entity\Edge
     */
    public function getEdgeWidth2()
    {
        return $this->edgeWidth2;
    }
}
