<?php 
//OOP Class
class Mobile {
   //attributes
   public $name;
   public $brand;
   public $price;
   public $color;
   public $image;

   //constructor
   public function __construct($name, $brand, $price, $color, $image)
   {
      $this->name = $name;
      $this->brand = $brand;
      $this->price = $price;
      $this->color = $color;
      $this->image = $image;
   }

   //getter
   public function getName() {
      return $this->name;
   }

   //setter
   public function setName($name) {
      $this->name = $name;
   }
}
?>