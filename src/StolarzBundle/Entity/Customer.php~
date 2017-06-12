<?php

namespace StolarzBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Customer
 *
 * @ORM\Table(name="customer")
 * @ORM\Entity(repositoryClass="StolarzBundle\Repository\CustomerRepository")
 */
class Customer
{

    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="customer")
     */
    private $order;

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
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

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
     * @return Customer
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
     * Set address
     *
     * @param string $address
     * @return Customer
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Customer
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
     * Constructor
     */
    public function __construct()
    {
        $this->element = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add element
     *
     * @param \StolarzBundle\Entity\Element $element
     * @return Customer
     */
    public function addElement(\StolarzBundle\Entity\Element $element)
    {
        $this->element[] = $element;

        return $this;
    }

    /**
     * Remove element
     *
     * @param \StolarzBundle\Entity\Element $element
     */
    public function removeElement(\StolarzBundle\Entity\Element $element)
    {
        $this->element->removeElement($element);
    }

    /**
     * Get element
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * Add order
     *
     * @param \StolarzBundle\Entity\Order $order
     * @return Customer
     */
    public function addOrder(\StolarzBundle\Entity\Order $order)
    {
        $this->order[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \StolarzBundle\Entity\Order $order
     */
    public function removeOrder(\StolarzBundle\Entity\Order $order)
    {
        $this->order->removeElement($order);
    }

    /**
     * Get order
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrder()
    {
        return $this->order;
    }
}
