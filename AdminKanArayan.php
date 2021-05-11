<?php
session_start();
ob_start();
require_once "includes/pdo.php";
if(!isset($_SESSION["admin"])){  echo "<script type='text/javascript'>alert('Öncelikle Giriş Yapmanız Gerekmektedir!')</script>";
  header("LOCATION: login.php");}
       
        else{
           header("Refresh: 9999999999; url= AdminKanArayan.php");
        }
       ?>
<!DOCTYPE html>
<html lang="en">
<head>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Kan Arayan</title>        
        <link rel="stylesheet" href="/kan_bankasi/css/adminKanBgs_kulln-aryn.css?key=<?=time()?>">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css?key=<?=time()?>">

       

</head>
<body>
         <?php 
       include_once('includes/adminMenu.php')
       ?>
       <h1 class="AdmiBarTittle">Güncel Kan Arayanlar</h1>
                        </div>
                        <div class="AdminSectionInner">  <!--   güncel kan arayanları listeleyen kodlar -->
                                <div class="AdminSectionTable">
                                <table class="table table-dark table-striped">
                                        <thead>
                                          <tr>
                                            
                                            <th>Sıra No</th>
                                            <th>Ad</th>
                                            <th>Soyad</th>
                                            <th>Telefon</th>
                                            <th>İl</th>
                                            <th>İlçe</th>
                                            <th>Aradığı Kan Grubu</th>
                                            <th>Mail</th>
                                            <th>Sil</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <?php

                                                $sonuc=mysqli_query($baglanti,"SELECT * from ihtiyac_bilgi");  //kan arayan kişilerin veri tabanından admin sayfasına çekilmesi
                                                mysqli_set_charset($baglanti, "utf8");
                                                while($arayan_row=mysqli_fetch_assoc($sonuc))
                                                  { 
                                                    $arayan_id = $arayan_row['ihtiyac_id'];                         
                                                    $ad = $arayan_row['ad'];
                                                    $soyad = $arayan_row['soyad'];
                                                    $ilID = $arayan_row['ilID'];
                                                    $ilceID = $arayan_row['ilceID'];
                                                    $tel_no = $arayan_row['tel_no'];
                                                    $kan_gruplariID = $arayan_row['kan_gruplariID'];
                                                    $kayit = $arayan_row['kayit_id'];
                                                  
                                                    $arayan_il_stmt = $pdo->query("SELECT * FROM il where ilID='$ilID'");
                                                     while($arayan_il_row = $arayan_il_stmt->fetch(PDO :: FETCH_ASSOC))
                                                     {  

                                                      $il = $arayan_il_row['sehirler'];
                                                       

                                                     }

                                                     $arayan_ilce_stmt = $pdo->query("SELECT * FROM ilce where ilceID='$ilceID'");
                                                     while($arayan_ilce_row = $arayan_ilce_stmt->fetch(PDO :: FETCH_ASSOC))
                                                     {  

                                                      $ilce = $arayan_ilce_row['isim'];
                                                       

                                                     }

                                                     $arayan_kan_stmt = $pdo->query("SELECT * FROM kan_gruplari where kan_gruplariID=' $kan_gruplariID'");
                                                     while($arayan_kan_row = $arayan_kan_stmt->fetch(PDO :: FETCH_ASSOC))
                                                     {  

                                                      $kan = $arayan_kan_row['kan_gruplari'];
                                                       

                                                     }

                                                     $arayan_email_stmt = $pdo->query("SELECT * FROM kayit where kayit_id =' $kayit'");
                                                     while($arayan_email_row = $arayan_email_stmt->fetch(PDO :: FETCH_ASSOC))
                                                     {  

                                                      $email = $arayan_email_row['email'];
                                                       

                                                     }
                                                   echo '<form action="" method="POST">'; 
                                                   echo '<input type ="hidden" name ="arayan_id" value = "'.$arayan_id.'">';
                                                   echo ' <tbody>';
                                                   echo ' <tr>';
                                                   echo ' <td>'.$arayan_id.'</td>';
                                                   echo ' <td>'.$ad.'</td>';
                                                   echo ' <td>'.$soyad.'</td>';
                                                   echo '<td>'.$il.'</td>';
                                                   echo '<td>'.$ilce.'</td>';
                                                   echo '<td>'.$tel_no.'</td>';
                                                   echo '<td>'.$kan.'</td>';
                                                   echo '<td>'.$email.'</td>';                       
                                                   echo ' <td><input type="submit"  name="sil" value="Sil"></td>';
                                                   echo ' </tr>';
                                                   echo '</tbody>';
                                                   echo '</form>';
                                                  }
                                               
                                                    ?>
                                            </table>
                                            
                                <?php
                                if(isset($_POST['sil'])){
                                  $arayan_id = $_POST['arayan_id'];
                                  $sql = "DELETE FROM ihtiyac_bilgi WHERE ihtiyac_id='$arayan_id'";
                                  $sonuc=mysqli_query($baglanti,"SELECT * from ihtiyac_bilgi where ihtiyac_id='$arayan_id'");
                                  $satir=mysqli_fetch_assoc($sonuc);
                                      if (mysqli_query($baglanti, $sql)) {   
                                    echo "Record deleted successfully";
                                    header('LOCATION: AdminKanArayan.php');
                                  } else {
                                  echo "Error deleting record: " . mysqli_error($baglanti);
                                  }
                          
                                  }  
                                 
                                 ?>
                                        </div>
                        </div>

                </div>

        </div>

        </form>
</body>
</html>
<?php
ob_end_flush();
?>