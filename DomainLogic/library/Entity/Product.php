<?php
/**
 * Product domain entity
 * 
 * @author      Patrick Schwisow
 * @copyright   2012
 */
namespace Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Product domain entity
 * 
 * @author      Patrick Schwisow
 * @copyright   2012
 * 
 * Entity\Product
 * 
 * @ORM\Table(name="product")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Product
{
    /**
     * Primary id
     * 
     * @var integer productId
     * 
     * @ORM\Column(name="product_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $productId;
    
    /**
     * Product name
     * 
     * @var string $name
     * 
     * @ORM\Column(name="name", type="string")
     */
    protected $name;
    
    /**
     * SKU
     * 
     * @var string $sku
     * 
     * @ORM\Column(name="sku", type="string")
     */
    protected $sku;
    
    /**
     * Price
     * 
     * @var float $price
     * 
     * @ORM\Column(name="price", type="decimal")
     */
    protected $price;
    
    /**
     * Brand
     * 
     * @var Entity\Brand $brand
     * 
     * @ORM\ManyToOne(targetEntity="Entity\Brand")
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="brand_id")
     */
    protected $Brand;
    
    /**
     * Updated at time
     * 
     * @var \DateTime updatedAt
     * 
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;
    
    /**
     * Get productId
     *
     * @return integer $productId
     */
    public function getProductId()
    {
        return $this->productId;
    }
    
    /**
     * Set name
     * 
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * Set SKU
     * 
     * @param string $sku
     * @return void
     */
    public function setSku($sku)
    {
        if (!preg_match('/[A-Z]{2}-[A-Z0-9]{2}-[A-Za-z0-9\-]+/', $sku)) {
            throw new \DomainException("Invalid SKU: '$sku'");
        }
        $this->sku = $sku;
    }
    
    /**
     * Get SKU
     * 
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }
    
    /**
     * Set Price
     * 
     * @param float $price
     * @return void
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
    
    /**
     * Get Price
     * 
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }
    
    /**
     * Set Brand
     * 
     * @param Entity\Brand $brand
     * @return void
     */
    public function setBrand(Brand $brand)
    {
        $this->Brand = $brand;
    }
    
    /**
     * Get Brand
     * 
     * @return Entity\Brand
     */
    public function getBrand()
    {
        return $this->Brand;
    }
    
    /**
     * Set updatedAt
     * 
     * @param \DateTime|string $updatedAt - user last update
     * @return void
     */
    public function setUpdatedAt($updatedAt)
    {
        if (is_string($updatedAt)) {
            $this->updatedAt = new \DateTime($updatedAt);
        } else {
            $this->updatedAt = $updatedAt;
        }
    }
    
    /**
     * Get updatedAt
     * 
     * @return \DateTime $updatedAt - user last update
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * Automatically set updatedAt for new entity
     * 
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->setUpdatedAt('now');
    }
    
    /**
     * Automatically set updatedAt for updated entity
     * 
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->setUpdatedAt('now');
    }
}