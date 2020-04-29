<?php

// class for every product ( show products)
class productDisplay {
   private $id;
   private $sku;
   private $name;
   private $price;
   private $type;
   private $parameterAll;
   private $created_at;
   private $typeName;
   private $dimension;

   public function __construct($thing){
// common properties of products
   $this->id = $thing['id'];
   $this->sku = $thing['sku'];
   $this->name = $thing['name'];
   $this->price = $thing['price'];
   $this->type = $thing['type'];
   $this->created_at = $thing['created_at'];
   }

//getters
   public function getId(){
      return $this->id;
   }
   public function getSku(){
      return $this->sku;
   }
   public function getName(){
      return $this->name;
   }
   public function getPrice(){
      return $this->price;
   }
   public function getType(){
      return $this->type;
   }
   public function getParameter(){
      return $this->parameterAll;
   }
   public function getCreatedAt(){
      return $this->created_at;
   }
   public function getTypeName(){
      return $this->typeName;
   }
   public function getDimension(){
      return $this->dimension;
   }

//setters
   public function setParameters($parameterAll){
      return $this->parameterAll = $parameterAll;
   }
   public function setType($typeName){
      return $this->typeName = $typeName;
   }
   public function setDimension($dimension){
      return $this->dimension = $dimension;
   }

}

// setting unique parameters for products
function setProperties($oneProduct, $thing){

   switch ($oneProduct->getType()) {
// case if it is DVD
      case '1':
// setting parameter digits and type of measurement
         $oneProduct->setParameters($thing['parameter_1'] . ' MB') ;
// name of that type of product
         $typeName = "DVD";
// type of measurement
         $productDimension = "Size";
      break;

      case '2':
// case if it is Furniture
         $oneProduct->setParameters($thing['parameter_1'] . ' x ' . $thing['parameter_2'] . ' x ' . $thing['parameter_3'] . 'mm');
         $typeName = "Furniture";
         $productDimension = "Dimension";
      break;

      case '3':
// case if it is Book
         $oneProduct->setParameters($thing['parameter_1'] . ' g');
         $typeName = "Book";
         $productDimension = "Weight";
      break;
      default:
         echo 'error';
      break;
   }

$oneProduct->setType($typeName);
$oneProduct->setDimension($productDimension);



}

 ?>
