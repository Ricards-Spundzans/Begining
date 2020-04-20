<div class="bookForm" >

 <!-- product - books-->

<!-- input for books only parameter -->
   <br>
   <label class="addingLabel">Weight:</label>
   <input type="text" name="bookWeight" value="<?php echo htmlspecialchars($_POST['bookWeight'] ?? '' )?>">

   <div class ='error' >
      <?php echo $errors['bookWeight'] ?? '' ?>
   </div>
   <br>

<!-- short help for user with details about input -->
   <div class="chooseHelp">
      <li>Please provide weight of the book in "g".</li>
      <li>Weight should be written in integer form.</li>
      <li>In case you want to generate right format of SKU, press label "SKU" in the first row.</li>
      <li>Press label "Price" to generate right format of price.</li>
      <li>(SKU must contain "BOB" in order to get saved as Book)</li>
   </div>

</div>
