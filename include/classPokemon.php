<?php

class Pokemon{

    private $id;
    private $nom;
    private $type;
    private $evolution;

    /**
     * Pokemon constructor.
     * @param $id
     * @param $nom
     * @param $type
     * @param $evolution
     */
    public function __construct($id, $nom, $type, $evolution)
    {
        $this->id = $id;//Numero du pokemon
        $this->nom = $nom;
        $this->type = $type;
        $this->evolution = $evolution;
    }

    public function getPokemonByID($id){
        return $this->nom + $this->type + $this->evolution;

    }

    public function getNomEspeceByNumero($numero)
    {

    }

    public function getDetailsPkm(){

    }

    public function getPokemonbyDresseurId($idDresseur){
        
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function isEvolution()
    {
        return $this->evolution;
    }

    /**
     * @param mixed $evolution
     */
    public function setEvolution($evolution)
    {
        $this->evolution = $evolution;
    }


}