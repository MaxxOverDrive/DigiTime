<?php

include("simple_html_dom.php");
$html = new simple_html_dom();

$modelNumber = "TWLB-60";

  $digitalBuyerURL = $html->load_file("https://www.digitalbuyer.com/catalogsearch/result/?dir=desc&order=relevance&q=.$modelNumber");
  $partDesc = $html->find("div.category-products ul.products-grid li h2.product-name a");
  $model = $partDesc[0]->plaintext;
  $partPrice = $html->find("div.category-products ul.products-grid li div.price-box div.uni-price-group div.uni-price-box div.uni-price-inner-box span.price");
  $price = $partPrice[0]->plaintext; ?>

  <table style='border: 1px solid black; text-align: center;'>
    <tr>
      <td style='border: 1px solid black; font-weight: 800; font-size: 125%;'>Model Number</td>
      <td style='border: 1px solid black; font-weight: 800; font-size: 125%;'>Price</td>
    </tr>

  <?php
  for($i = 0; $i < COUNT($modelNumber); $i++) {
      if(strpos($model, " ".$modelNumber." ")) { ?>
        <tr>
          <td style='border: 1px solid black;'><?php echo $modelNumber; ?></td>
          <td style='border: 1px solid black;'><?php echo $price; ?></td>
        </tr>
  <?php  }
}
echo "</table";


?>
