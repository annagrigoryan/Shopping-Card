<?php

/**
 * Created by PhpStorm.
 * User: annagrigoryan
 * Date: 5/11/17
 * Time: 6:08 PM
 */

namespace ShoppingCardBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 */
class Product
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(name="name", type="string")
     * @Assert\NotBlank(message="Please enter a product name")
     */
    protected $name;

    /**
     * @MongoDB\Field(name="category", type="string")
     * @Assert\NotBlank(message="Please enter a product category")
     */
    protected $category;

    /**
     * @MongoDB\Field(name="price", type="float")
     * @Assert\NotBlank(message="Please enter a price")
     */
    protected $price;

    /**
     * @MongoDB\Field(name="description", type="string")
     * @Assert\NotBlank(message="Please enter a product description")
     */
    protected $description;


    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set category
     *
     * @param string $category
     * @return self
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * Get category
     *
     * @return string $category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return self
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Get price
     *
     * @return float $price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }
}

