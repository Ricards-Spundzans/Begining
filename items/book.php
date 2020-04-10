<div class="bookForm" >

   <br>
   <label class="addingLabel">Weight:</label>
   <input type="text" name="bookWeight" value="<?php echo htmlspecialchars($parameter_1)?>">
   <div class ='error' >
      <?php echo $errors['parametr_1'] ?>
   </div>
   <br>

   <div class="chooseHelp">
      Please provide weight of the book in "g". Weight should be written in integer form. <br>
      In case you want to generate right form of SKU, press label "SKU" in the first row. <br>
      (SKU must contain "BOB" in order to get saved as Book) <br>
   </div>

</div>
