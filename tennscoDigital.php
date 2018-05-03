<?php

$conn = mysqli_connect("$db_host", "$db_username", "$db_pass", "$db_name");

  if(!$conn) {
    die('error msg' . mysqli_connect_error());
  }
  else {
    $tennscoInfoSQL = "SELECT modelNum, listPrice FROM Competitors";
    $tennscoInfoResult = mysqli_query($conn, $tennscoInfoSQL);

    if(mysqli_num_rows($tennscoInfoResult) > 0) {
      $GLOBALS['tennscoInfoResult'] = $tennscoInfoResult;
    }
  }

  $tennscoInfoVar = $GLOBALS['tennscoInfoResult'];

  while($tennscoInfoRow = mysqli_fetch_assoc($tennscoInfoVar)) {
    $modelNumber[] = $tennscoInfoRow['modelNum'];
    $listPrice[] = $tennscoInfoRow['listPrice'];
    $ourCost[] = ($tennscoInfoRow['listPrice'] * 0.45);
  }

include("simple_html_dom.php");
$html = new simple_html_dom(); ?>
  <table style="border: 1px solid black; text-align: center;">
    <tr>
      <td style="border: 1px solid black; font-weight: 800; font-size: 125%;">Model Number</td>
      <td style="border: 1px solid black; font-weight: 800; font-size: 125%;">List Price</td>
      <td style="border: 1px solid black; font-weight: 800; font-size: 125%;">Our Cost</td>
      <td style="border: 1px solid black; font-weight: 800; font-size: 125%;">Digital Buyer</td>
    </tr>

<?php
for($i = 0; $i <= COUNT($modelNumber); $i++) {
  ini_set('max_execution_time', 300);
  $digitalBuyerURL = $html->load_file("https://www.digitalbuyer.com/catalogsearch/result/?dir=desc&order=relevance&q=.$modelNumber[$i]");
  $partDesc = $html->find("div.category-products ul.products-grid li h2.product-name a");
  $model = $partDesc[0]->plaintext;
  $partPrice = $html->find("div.category-products ul.products-grid li div.price-box div.uni-price-group div.uni-price-box div.uni-price-inner-box span.price");
  $price = $partPrice[0]->plaintext;

    if(strpos($model, " ".$modelNumber[$i]." ")) { ?>
      <tr>
        <td style="border: 1px solid black;"><?php echo $modelNumber[$i]; ?></td>
        <td style="border: 1px solid black;"><?php echo round($listPrice[$i], 2); ?></td>
        <td style="border: 1px solid black;"><?php echo round($ourCost[$i], 2); ?></td>
        <td style='border: 1px solid black;'><?php echo $price; ?></td>
      </tr>
  <?php  }
    else { ?>
      <tr>
        <td style="border: 1px solid black;"><?php echo $modelNumber[$i]; ?></td>
        <td style="border: 1px solid black;"><?php echo round($listPrice[$i], 2); ?></td>
        <td style="border: 1px solid black;"><?php echo round($ourCost[$i], 2); ?></td>
        <td style='border: 1px solid black;'>None</td>
      </tr>
  <?php  }

  } ?>

</table>

<?php mysqli_close($conn); ?>
