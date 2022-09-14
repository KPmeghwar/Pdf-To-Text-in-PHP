<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>file</title>
</head>
<body>
	<form method="post" enctype="multipart/form-data">
    <div class="form-input">
        <label for="pdf_file">PDF File</label>
        <input type="file" name="pdf_file" placeholder="Select a PDF file" required="">
    </div>
    <input type="submit" name="submit"  value="Extract Text">
</form>
</body>
</html>
<?php 
  $pdfText = ''; 
  if(isset($_POST['submit'])){ 
      if(!empty($_FILES["pdf_file"]["name"])){ 
          $fileName = basename($_FILES["pdf_file"]["name"]); 
          $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
          $allowTypes = array('pdf'); 
          if(in_array($fileType, $allowTypes)){ 
              include 'vendor/autoload.php'; 
              $parser = new \Smalot\PdfParser\Parser(); 
              $file = $_FILES["pdf_file"]["tmp_name"]; 
              $pdf = $parser->parseFile($file); 
              $text = $pdf->getText();
              $text = preg_replace("/\s\s+/", " ", $text);
              echo "<br><br><br>"; 
              function GetData($text, $first, $last, $first_plus) {
                  $game_one= substr($text, strpos($text, $first) + $first_plus);
                  $game_two = explode($last, $game_one, 2);
                  $return = $game_two[0];
                  $return = trim($return);
                  return $return;
              }
              $ip_no = GetData($text, "", "Book ", 15);
              ?>
	              <label for="pdf_file">IP NO:</label>
	              <input type="text" name="ip_no" id="ip_no" value="<?php echo $ip_no;?>" size="100"><br>
              <?php

              $validity_from = GetData($text, "Validity P eriod", ":", 20);
              ?>
	              <label for="pdf_file">Validity From:</label>
	              <input type="text" name="validity_from" id="validity_from" value="<?php echo $validity_from;?>"  size="100"><br>
              <?php

              $validity_to = GetData($text, " to.", " In", 6);
              ?>
                 <label for="pdf_file">Validity To:</label>
                 <input type="text" name="validity_to" id="validity_to" value="<?php echo $validity_to;?>"  size="100"><br>
              <?php
              $importer_name = GetData($text, " importer (consignee)", " 2. Name",21);
              ?>
                 <label for="pdf_file">Importer Name:</label>
                 <input type="text" name="importer_name" id="importer_name" value="<?php echo $importer_name;?>"  size="100"><br>
              <?php
              $exporter_name = GetData($text, " exporter (consignor)", "3. Country", 22);
              ?>
                 <label for="pdf_file">Exporter Name:</label>
                 <input type="text" name="exporter_name" id="exporter_name" value="<?php echo $exporter_name;?>"  size="100"><br>
              <?php
              $re_export = GetData($text, "Country of origin ", "4. P", 32);
              ?>
                 <label for="pdf_file">Re-Export:</label>
                 <input type="text" name="re_export" id="re_export"  value="<?php echo $re_export;?>"  size="100"><br>
              <?php

              $foreign_shipment = GetData($text, "Port of for", "6. Means", 25);
              ?>
                 <label for="pdf_file">Foreign Shipment:</label>
                 <input type="text" name="foreign_shipment" value="<?php echo $foreign_shipment;?>"  size="100"><br>
              <?php
              $qunatity = GetData($text, "(Wt.Vol)", "-- 9", 25);
              ?>
                 <label for="pdf_file">Qunatity:</label>
                 <input type="text" name="qunatity" id="qunatity" value="<?php echo $qunatity;?>"  size="100"><br>
              <?php
              $plant_parts= GetData($text, "Plant or plant", "11. The", 35);
              ?>
                 <label for="pdf_file">Plant Parts:</label>
                 <input type="text" name="plant_parts" id="plant_parts" value="<?php echo $plant_parts;?>"  size="100" ><br>
              <?php             
          }else{ 
              echo  '<p>Sorry, only PDF file is allowed to upload.</p>'; 
          } 
      }else{ 
          echo '<p>Please select a PDF file to extract text.</p>'; 
      }
  } 
?>
	
