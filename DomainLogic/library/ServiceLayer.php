<?php
/**
 * Service to work with domain entities
 * 
 * @author Patrick Schwisow
 * @copyright 2012
 */
class ServiceLayer
{
    /**
     * Entity manager
     * 
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;
    
    /**
     * Sets entity manager for service
     * 
     * @param \Doctrine\ORM\EntityManager $em entity manager
     * @return void
     */
    public function setEntityManager(\Doctrine\ORM\EntityManager $em)
    {
        $this->_em = $em;
    }
    
    /**
     * Get entity manager
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->_em;
    }
    
    /**
     * Insert entity operation
     * 
     * @param string $entityName entity name
     * @param array  $data       data to insert
     * @return mixed
     */
    public function insert($entityName, array $data)
    {
        $entity = new $entityName();
        foreach ($data as $key => $value) {
            if (method_exists($entity, 'set' . $key)) {
                $entity->{'set' . $key}($value);
                continue;
            }
        }
        if (method_exists($entity, 'isValid') && !$entity->isValid()) {
            throw new \DomainException("Invalid data for {$entity}");
        }
        $this->_em->persist($entity);
        $this->_em->flush();
        return $entity;
    }
    
    /**
     * Insert entity operation
     * 
     * @param string $entityName entity name
     * @param array  $data       data to insert
     * @return mixed
     */
    public function insertProduct(array $data)
    {
        if (!empty($data['brand_id'])) {
            $data['Brand'] = $this->find('Entity\Brand', $data['brand_id']);
        }
        return $this->insert('Entity\Product', $data);
    }
    
    /**
     * Update entity operation
     * 
     * @param string $entityName entity name
     * @param string $id         entity id
     * @param array  $data       updated data
     * @throws \InvalidArgumentException
     * @return mixed
     */
    public function update($entityName, $id, array $data)
    {
        $entity = $this->_em->find($entityName, $id);
        if (is_null($entity)) {
            throw new \InvalidArgumentException("$entityName with id " . $id . ' for update not found');
        }
        foreach ($data as $key => $value) {
            if (method_exists($entity, 'set' . $key)) {
                $entity->{'set' . $key}($value);
                continue;
            }
        }
        if (method_exists($entity, 'isValid') && !$entity->isValid()) {
            throw new \DomainException("Invalid data for {$entity}");
        }
        $this->_em->flush();
        return $entity;
    }
    
    /**
     * Get entity by primary key
     * 
     * @param string $entityName entity name
     * @param string $id         entity id
     * @return mixed
     */
    public function find($entityName, $id)
    {
        $entity = $this->_em->find($entityName, $id);
        return $entity;
    }
    
    /**
     * Gets repository for given entity
     * 
     * @param string $entityName entity name
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository($entityName)
    {
        return $this->_em->getRepository($entityName);
    }
    
    /**
     * Gets brand options
     * 
     * @return array
     */
    public function getBrandOptions()
    {
        $brands = $this->_em->getRepository('Entity\Brand')->findAll();
        $out = array();
        foreach ($brands as $brand) {
            $out[$brand->getBrandId()] = $brand->getName();
        }
        return $out;
    }
}