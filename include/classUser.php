<?php
class User {
    private $nom;
    private $password;
    private $age;
    private $type;
 
    public function __construct(string $nom, string $password) {
      $this->nom = $nom;
      $this->password = $password;
    }
 
   
    public function __toString() {
      return  "$this->nom $this->password";
    }
 
    public function getNom() {
      return $this->nom;
    }
 
    public function getpassword() {
      return $this->password;
    }
 
  }