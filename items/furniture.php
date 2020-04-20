<div class="furnitureForm" >


   <!-- product - furniture -->


<!-- input for furniture only parameter -->
   <br>
   <label class="addingLabel">Height:</label>
   <input type="text" name="parameter_1" value="<?php echo htmlspecialchars($_POST['parameter_1'] ?? '' )?>">

   <div class ='error' >
      <?php echo $errors['parameter_1'] ?? '' ?>
   </div>
   <br>
   <label class="addingLabel">Width:</label>
   <input type="text" name="parameter_2" value="<?php echo htmlspecialchars($_POST['parameter_2'] ?? '' )?>">

   <div class ='error' >
      <?php echo $errors['parameter_2'] ?? '' ?>
   </div>
   <br>
   <label class="addingLabel">Lenght:</label>
   <input type="text" name="parameter_3" value="<?php echo htmlspecialchars($_POST['parameter_3'] ?? '' )?>">

   <div class ='error' >
      <?php echo $errors['parameter_3'] ?? '' ?>
   </div>
   <br>

<!-- short help for user with details about input -->
   <div class="chooseHelp">
      <li>Please provide dimension of the furniture in "mm".</li>
      <li>Height, width and lenght should be written in integer form.</li>
      <li>In case you want to generate right format of SKU, press label "SKU" in the first row.</li>
      <li>Press label "Price" to generate right format of price.</li>
      <li>(SKU must contain "FNF" in order to get saved as Furniture)</li>
   </div>

</div>
