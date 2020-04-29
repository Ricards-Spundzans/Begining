<div class="furnitureForm" >


   <!-- product - furniture -->


<!-- input for furniture only parameter -->
   <br>
   <label class="addingLabel">Height:</label>
   <input type="text" name="parameter[]" value="<?php echo htmlspecialchars($_POST['parameter'][1] ?? '' )?>">

   <div class ='error' >
      <?php echo $errors['furnitureHeight'] ?? '' ?>
   </div>
   <br>
   <label class="addingLabel">Width:</label>
   <input type="text" name="parameter[]" value="<?php echo htmlspecialchars($_POST['parameter'][2] ?? '' )?>">

   <div class ='error' >
      <?php echo $errors['furnitureWidth'] ?? '' ?>
   </div>
   <br>
   <label class="addingLabel">Lenght:</label>
   <input type="text" name="parameter[]" value="<?php echo htmlspecialchars($_POST['parameter'][3] ?? '' )?>">

   <div class ='error' >
      <?php echo $errors['furnitureLenght'] ?? '' ?>
   </div>
   <br>

<!-- short help for user with details about input -->
   <div class="chooseHelp">
      <li>Please provide dimension of the furniture in "mm".</li>
      <li>Height, width and lenght  <?php echo $dimensionForm ?></li>
      <li><?php echo $skuForm ?></li>
      <li><?php echo $priceForm ?></li>
      <li>(SKU must contain "FNF" in order to get saved as Furniture)</li>
   </div>

</div>
