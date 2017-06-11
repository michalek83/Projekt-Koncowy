<?php

namespace StolarzBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Order
 *
 * @ORM\Table(name="orderElements")
 * @ORM\Entity(repositoryClass="StolarzBundle\Repository\OrderRepository")
 */
class Order
{
    /**
     * @ORM\ManyToMany(targetEntity="Material")
     */
    private $material;

    /**
     * @ORM\ManyToMany(targetEntity="Edge")
     */
    private $edge;

    /**
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="order")
     */
    private $customer;

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
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var bool
     *
     * @ORM\Column(name="lenghtEdge1", type="boolean")
     */
    private $lenghtEdge1;

    /**
     * @var bool
     *
     * @ORM\Column(name="lenghtEdge2", type="boolean")
     */
    private $lenghtEdge2;

    /**
     * @var bool
     *
     * @ORM\Column(name="widthEdge1", type="boolean")
     */
    private $widthEdge1;

    /**
     * @var bool
     *
     * @ORM\Column(name="widthEdge2", type="boolean")
     */
    private $widthEdge2;

    /**
     * @var bool
     *
     * @ORM\Column(name="rotatable", type="boolean")
     */
    private $rotatable;


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
     * @return Order
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
     * @return Order
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
     * Set quantity
     *
     * @param integer $quantity
     * @return Order
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
     * Set lenghtEdge1
     *
     * @param boolean $lenghtEdge1
     * @return Order
     */
    public function setLenghtEdge1($lenghtEdge1)
    {
        $this->lenghtEdge1 = $lenghtEdge1;

        return $this;
    }

    /**
     * Get lenghtEdge1
     *
     * @return boolean 
     */
    public function getLenghtEdge1()
    {
        return $this->lenghtEdge1;
    }

    /**
     * Set lenghtEdge2
     *
     * @param boolean $lenghtEdge2
     * @return Order
     */
    public function setLenghtEdge2($lenghtEdge2)
    {
        $this->lenghtEdge2 = $lenghtEdge2;

        return $this;
    }

    /**
     * Get lenghtEdge2
     *
     * @return boolean 
     */
    public function getLenghtEdge2()
    {
        return $this->lenghtEdge2;
    }

    /**
     * Set widthEdge1
     *
     * @param boolean $widthEdge1
     * @return Order
     */
    public function setWidthEdge1($widthEdge1)
    {
        $this->widthEdge1 = $widthEdge1;

        return $this;
    }

    /**
     * Get widthEdge1
     *
     * @return boolean 
     */
    public function getWidthEdge1()
    {
        return $this->widthEdge1;
    }

    /**
     * Set widthEdge2
     *
     * @param boolean $widthEdge2
     * @return Order
     */
    public function setWidthEdge2($widthEdge2)
    {
        $this->widthEdge2 = $widthEdge2;

        return $this;
    }

    /**
     * Get widthEdge2
     *
     * @return boolean
     */
    public function getWidthEdge2()
    {
        return $this->widthEdge2;
    }

    /**
     * Set rotatable
     *
     * @param boolean $rotatable
     * @return Order
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
     * Constructor
     */
    public function __construct()
    {
        $this->material = new \Doctrine\Common\Collections\ArrayCollection();
        $this->edge = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add material
     *
     * @param \StolarzBundle\Entity\Material $material
     * @return Order
     */
    public function addMaterial(\StolarzBundle\Entity\Material $material)
    {
        $this->material[] = $material;

        return $this;
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
     * Get material
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * Add edge
     *
     * @param \StolarzBundle\Entity\Edge $edge
     * @return Order
     */
    public function addEdge(\StolarzBundle\Entity\Edge $edge)
    {
        $this->edge[] = $edge;

        return $this;
    }

    /**
     * Remove edge
     *
     * @param \StolarzBundle\Entity\Edge $edge
     */
    public function removeEdge(\StolarzBundle\Entity\Edge $edge)
    {
        $this->edge->removeElement($edge);
    }

    /**
     * Get edge
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEdge()
    {
        return $this->edge;
    }

    /**
     * Set customer
     *
     * @param \StolarzBundle\Entity\Customer $customer
     * @return Order
     */
    public function setCustomer(\StolarzBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \StolarzBundle\Entity\Customer 
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
