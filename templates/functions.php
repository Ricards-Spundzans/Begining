<script>

// script that shows a description of selected product when page loads
$(document).ready(function(){
   var displayProduct = $("#selectProduct option:selected").val();
   $(".package").css('display','none');
   $("#" + displayProduct).css('display','block');

});

// script that shows a description of selected product without submitting the form (dynamically change)
   $("#selectProduct").change(function(){
      $(".errorType").css('display','none');
      var displayProduct = $("#selectProduct option:selected").val();
      $(".package").css('display','none');
      $("#" + displayProduct).css('display','block');
      $("#skuError").css('display','none');

  });

//script for a random SKU generation that meets requirements for the selected product type
   $("#skuL").click(function(){
      var skuPart1 = Math.floor(Math.random()*(999-100+1)+100);
      var skuPart2 = Math.floor(Math.random()*(999-100+1)+100);
      var displayProduct = $("#selectProduct option:selected").val();
      switch (displayProduct) {
         case '1':
            var sku = skuPart1.toString() + "CDC" + skuPart2.toString();
            $("#sku").val(sku);
         break;
         case '2':
            var sku = skuPart1.toString() + "FNF" + skuPart2.toString();
            $("#sku").val(sku);
         break;
         case '3':
            var sku = skuPart1.toString() + "BOB" + skuPart2.toString();
            $("#sku").val(sku);
         break;
      default:
    }
  });

// script for right price format
   $("#priceL").click(function(){
      var displayProduct = $("#selectProduct option:selected").val();
      var priceFormat="0.00";
      if(!displayProduct==""){
         $("#price").val(priceFormat);
      }

   });
</script>
