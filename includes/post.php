<?php
 require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/kan_bankasi/includes/pdo.php');



// seçilen ile göre ilçelerin gelmesi ajax yöntemi ile yapıldı(javascript) post diye sayfa açtık ilin id sini buraya getirdik ile göre ilçe listeleme

$country_id=$_POST["country_id"];
 


$ilce_stmt = $pdo->query("SELECT * FROM ilce where ilID = '$country_id'");
 while($ilce_row = $ilce_stmt->fetch(PDO :: FETCH_ASSOC))
  {                          
   $ilceler = $ilce_row['isim'];
   $ilceID = $ilce_row['ilceID'];


  echo '<option value = '.$ilceID.' > '.$ilceler.' </option>';
  
  }


?>