<?php

// main class used to create products ( add them )
class Product{
   private $data;
   private $classErrors = [];

   public function __construct($post_data){
      $this->data = $post_data;
   }
//getters
   public function getSku(){
      return $this->data['sku'];
   }
   public function getName(){
      return $this->data['name'];
   }
   public function getPrice(){
      return $this->data['price'];
   }
   public function getType(){
      return $this->data['selectProduct'];
   }
   public function getParameter($number){
      return $this->data['parameter'][$number];
   }
   public function getErrors(){
      return $this->classErrors;
   }

//setters
   public function setPrice($price){
      return $this->data['price'] = $price;
   }
   public function setType($type){
      return $this->data['selectProduct'] = $type;
   }
//  setter - function for error output. Errors are put into the linked array
   public function setError($key, $reason){
      return $this->classErrors[$key] = $reason;
   }
}

// function that calls function to check Sku, Price, Name, Type - whether it is in the right format (regular expression)
function checkAll($mainObject,$skuPart,$things){
   checkSku($mainObject, $skuPart, $things);
   checkPrice($mainObject);
   checkName($mainObject);
   checkType($mainObject);

}


// check of the sku - whether it is inputed and not same with already existing
function checkSku($oneProduct, $skuPart, $things){
   $tempSku = trim($oneProduct->getSku());
// case if Sku is not inputed
   if(empty($tempSku)){
      $oneProduct->setError('sku', 'Sku is empty');
      return;
   }
// case if sku does not contain needed key word
   if(preg_match('/'.$skuPart. '/',$oneProduct->getSku()) == '0' ){
      $oneProduct->setError('sku', 'SKU does not contain '. $skuPart);
      return;
   }
// comparing to the already existing SKU - sku must be unique
   foreach ($things as $thing) {
      if($thing['sku'] == $oneProduct->getSku()){
         $oneProduct->setError('sku', 'SKU is already taken');
         return;
      }
   }

}
// check if the price is inputed and is in the right format
function checkPrice($oneProduct){
// pattern for price
   $pattern = '/^(0|[1-9]\d*)(\.\d{1,2})?$/';
   $tempPrice = trim($oneProduct->getPrice());

// case if price is not inputed
   if(empty($tempPrice)){
      $oneProduct->setError('price', 'Price is empty');
      return;
   }
// case if price is inputed in wrong format
   if(preg_match($pattern,$tempPrice) == '0'){
      $oneProduct->setError('price', 'Wrong price format. Use integers and only 2 digits after "." <br/>
                                 (Use "." to separate dollars and cents.)');
      return;
   }else{
// case if price is in right format - adding extra digits, so it would look like price
      $oneProduct->setPrice(number_format($tempPrice, 2, '.', ''));
      $_POST['price'] = $oneProduct->getPrice();
      return;
   }

}

// check if the name is inputed
function checkName($oneProduct){
   $tempName = trim($oneProduct->getName());
// case if there is no name
   if(empty($tempName)){
      $oneProduct->setError('name', 'Name is empty');
      return;
   }
}

// check if the type is selected
function checkType($oneProduct){
// case if there is no type
   if(empty($oneProduct->getType())){
      $oneProduct->setError('type', 'Type not selected');
      return;
   }
}

// check of parameter - 1) calss object, 2) parameter which is checked, 3)label that will show message in case of error 4) name of that parameter (size, dimension etc.)
function checkParameter($oneProduct, $paremeter, $label, $property){
// pattern for regular expresion for parameters
   $patternParameters = '/^[0-9]*$/';
// case if there is no parameter inputed
   if(empty($paremeter)){
      $oneProduct->setError($label,  'Input "'. $property.  '" is empty');
      return;
   }
// case if parameter is inputed in wrong format
   if(preg_match($patternParameters,$paremeter) == '0'){
      $oneProduct->setError($label, 'Wrong input of '.  $property);
      return;
   }

}

 ?>
