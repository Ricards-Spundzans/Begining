<div class="discForm" >

   <br>
   <label class="addingLabel">Size:</label>
   <input type="text" name="dvdSize" value="<?php echo htmlspecialchars($parameter_1)?>">
   <div class ='error' >
    <?php echo $errors['parametr_1'] ?>
   </div>
   <br>

   <div class="chooseHelp">
      Please provide size of DVD-disc in "MB". Size should be written in integer form. <br>
      In case you want to generate right form of SKU, press label "SKU" in the first row.<br>
      (SKU must contain "CDC" in order to get saved as DVD) <br>
   </div>

</div>
