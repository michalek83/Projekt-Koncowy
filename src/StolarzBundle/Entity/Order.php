<?php

namespace StolarzBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Order
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity(repositoryClass="StolarzBundle\Repository\OrderRepository")
 */
class Order
{
    /**
     * @ORM\OneToMany(targetEntity="Element", mappedBy="order", cascade={"persist", "remove"})
     */
    private $element;


    /**
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="order")
     */
    private $customer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="orderDateTime", type="datetime")
     */
    private $orderDateTime;

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
     * @ORM\Column(name="orderName", type="string", length=255)
     */
    private $orderName;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->element = new \Doctrine\Common\Collections\ArrayCollection();
        $this->orderDateTime = date_create();
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
     * @return string
     */
    public function getOrderName()
    {
        return $this->orderName;
    }

    /**
     * @param string $orderName
     */
    public function setOrderName($orderName)
    {
        $this->orderName = $orderName;
    }

    /**
     * Add element
     *
     * @param \StolarzBundle\Entity\Element $element
     * @return Order
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

    /**
     * Get orderDateTime
     *
     * @return \DateTime
     */
    public function getOrderDateTime()
    {
        return $this->orderDateTime;
    }
}
