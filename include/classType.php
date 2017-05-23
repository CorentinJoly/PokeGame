<?php

/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 24/03/2017
 * Time: 14:59
 */
class Type
{
    private $id;
    private $libelleType;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLibelleType()
    {
        return $this->libelleType;
    }

    /**
     * @param mixed $libelleType
     */
    public function setLibelleType($libelleType)
    {
        $this->libelleType = $libelleType;
    }
}