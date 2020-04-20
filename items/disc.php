<div class="discForm" >


   <!-- product - disc-->


<!-- input for CD only parameter -->
   <br>
   <label class="addingLabel">Size:</label>
   <input type="text" name="dvdSize" value="<?php echo htmlspecialchars($_POST['dvdSize'] ?? '' )?>">

   <div class ='error' >
      <?php echo $errors['dvdSize'] ?? '' ?>
   </div>
   <br>

<!-- short help for user with details about input -->
   <div class="chooseHelp">
      <li>Please provide size of DVD-disc in "MB".</li>
      <li>Size should be written in integer form.</li>
      <li>In case you want to generate right format of SKU, press label "SKU" in the first row.</li>
      <li>Press label "Price" to generate right format of price.</li>
      <li>(SKU must contain "CDC" in order to get saved as DVD) </li>
   </div>

</div>
