<?php

namespace Api\Models;

/**
 * @Entity @Table(name="Products")
 **/
class Product
{

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     **/
    protected $id;

    /**
     * @Column(type="string")
     **/
    protected $name;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName()
        );
    }

}