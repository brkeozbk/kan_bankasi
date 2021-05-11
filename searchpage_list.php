<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/kan_bankasi/css/search.css?key=<?=time()?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css?key=<?=time()?>">

    <title>Bulunan Kanlar</title>
</head>
<body>
<?php
 include_once 'content\headerMenu.php';
?>
  

    <div class="table">
    <table class="table table-dark table-striped"><!--   tablo -->
                                        <thead>
                                          <tr>
                                            <th>Ad</th>
                                            <th>Soyad</th>
                                            <th>İl</th>
                                            <th>İlçe</th>
                                            <th>Tel No</th>
                                            <th>Kan</th>
                                            <th>Email</th>
                                            
                                          </tr>
                                        </thead>
                                        <tbody>
                                        
                                           
                                        <?php
                                        require_once "includes/pdo.php";   //pdo.php formundan referans aldık bağlantı kodlarımız

   if(isset($_POST['bagis_ara'])){     // kullanıcının şehre ve kan grubuna arama yapmasını sağlamak için veritabanıyla değişkenlerimizi post ettik
     $sehirID = $_POST['sehirID'];
     $kan_gruplariID = $_POST['kan_gruplariID'];
    
$bagislayan_stmt = $pdo->query("SELECT * FROM bagislayan_bilgi where ilID = '$sehirID' AND kan_gruplariID= '$kan_gruplariID'"); // kullanıcının girdiği kan grubu ve ilçeye göre eşleştirmesini sağlayan kodlar
while($bagislayan_row = $bagislayan_stmt->fetch(PDO :: FETCH_ASSOC))
  {                          
    $ad = $bagislayan_row['ad'];
    $soyad = $bagislayan_row['soyad'];
    $ilID = $bagislayan_row['ilID'];
    $ilceID = $bagislayan_row['ilceID'];
    $tel_no = $bagislayan_row['tel_no'];
    $kan_gruplariID = $bagislayan_row['kan_gruplariID'];
    $kayit = $bagislayan_row['kayit_id'];




                                                     

                     $bagislayan_ilce_stmt = $pdo->query("SELECT * FROM ilce where ilceID='$ilceID'"); //ilçeyi döndürüp listeliyor
                 while($bagislayan_ilce_row = $bagislayan_ilce_stmt->fetch(PDO :: FETCH_ASSOC))
                       {  

                        $ilce = $bagislayan_ilce_row['isim'];
                                                       

      }

      $bagislayan_il_stmt = $pdo->query("SELECT * FROM il where ilID='$ilID'"); //ili döndürüp listeliyor (döndürmek = while döngüsü kullanıcının girdiği ili buluyor)
      while($bagislayan_il_row = $bagislayan_il_stmt->fetch(PDO :: FETCH_ASSOC))
      {  

       $il = $bagislayan_il_row['sehirler'];
        

      }

      $bagislayan_kan_stmt = $pdo->query("SELECT * FROM kan_gruplari where kan_gruplariID=' $kan_gruplariID'");
      while($bagislayan_kan_row = $bagislayan_kan_stmt->fetch(PDO :: FETCH_ASSOC))
      {  

       $kan = $bagislayan_kan_row['kan_gruplari'];
        

      }
                          
      $bagislayan_email_stmt = $pdo->query("SELECT * FROM kayit where kayit_id =' $kayit'");
      while($bagislayan_email_row = $bagislayan_email_stmt->fetch(PDO :: FETCH_ASSOC))
     {  

                       $email = $bagislayan_email_row['email'];
                

                      }
                                            

  
     echo ' <tr>'; //tabloya yazdırıyor
                                                   echo ' <td>'.$ad.'</td>';    
                                                   echo ' <td>'.$soyad.'</td>';
                                                   echo '<td>'.$il.'</td>';
                                                   echo '<td>'.$ilce.'</td>';
                                                   echo '<td>'.$tel_no.'</td>';
                                                   echo '<td>'.$kan.'</td>';
                                                   echo '<td>'.$email.'</td>';  
                                                   echo '</tr>';
                                                  }
                                                }               
?>
</table>
    </div>






</body>
</html>