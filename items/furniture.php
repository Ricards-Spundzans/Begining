<div class="furnitureForm" >

  <br>
  <label class="addingLabel">Height:</label>
  <input type="text" name="parametr_1" value="<?php echo htmlspecialchars($_POST['parametr_1'] ?? '' )?>">
  <div class ='error' >
      <?php echo $errors['parametr_1'] ?? '' ?>
  </div>
  <br>
  <label class="addingLabel">Width:</label>
  <input type="text" name="parametr_2" value="<?php echo htmlspecialchars($_POST['parametr_2'] ?? '' )?>">
  <div class ='error' >
      <?php echo $errors['parametr_2'] ?? '' ?>
  </div>
  <br>
  <label class="addingLabel">Lenght:</label>
  <input type="text" name="parametr_3" value="<?php echo htmlspecialchars($_POST['parametr_3'] ?? '' )?>">
  <div class ='error' >
      <?php echo $errors['parametr_3'] ?? '' ?>
  </div>
  <br>

  <div class="chooseHelp">
      Please provide dimension of the furniture in "mm". Height, width and lenght should be written in integer form. <br>
      In case you want to generate right form of SKU, press label "SKU" in the first row. <br>
      (SKU must contain "FNF" in order to get saved as Furniture) <br>
  </div>

</div>
