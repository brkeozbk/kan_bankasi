<?php
require_once "includes/pdo.php";
include_once('content/headerMenu.php');
if( (!isset($_SESSION['isim'])) && (!isset($_SESSION['admin']))){  echo "<script type='text/javascript'>alert('Öncelikle Giriş Yapmanız Gerekmektedir!')</script>";
 header("Refresh: 0; url= login.php");;}

 else{
    header("Refresh: 9999999999; url= main.php");
 }
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="keywords" content="html,css,php">
    <link rel="stylesheet" type="text/css" href="/kan_bankasi/css/search.css?key=<?=time()?>">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Kan Arama</title>
</head>
<body>
<?php include_once('content/headerMenu.php');?>     <!--   contentteki menüyüreferans alıp getiren kod -->
    


<form action="searchpage_list.php" method="POST">

<div class="container">                 <!--   kana ihtiyacı olan kişileri veritabanına kaydetmeye yarıyan html kodları -->
    <div class="kaplayan_alan" >
        <div class="bagislayan_bilgi">
            

 

            <div class="textler"  >
                    
                        

                          <select id="sehirler" name ="sehirID" >
                          <option value="">Bir Şehir Seçiniz</option>
                          <?php
                                $sehir_stmt = $pdo->query("SELECT * FROM il");
                                while($sehir_row = $sehir_stmt->fetch(PDO :: FETCH_ASSOC))
                                 {                          
                                    $sehirler = $sehir_row['sehirler'];
                                    $sehirID = $sehir_row['ilID'];
                                    echo '<option value = '.$sehirID.'> '.$sehirler.' </option>';
                                }
                        ?>
                      </select>

                          <select id="ilceler" name="ilceID" >
                          <option value="">Bir İlçe Seçiniz</option>
                         </select>

                                 

                             <select id="box6" name="kan_gruplariID" class="kan_grubu">
                             <option value="">Kan Grubunuzu Seçiniz</option>
                             <?php
                                $kan_stmt = $pdo->query("SELECT * FROM kan_gruplari");
                                while($kan_row = $kan_stmt->fetch(PDO :: FETCH_ASSOC))
                                 {                          
                                    $kan_gruplari = $kan_row['kan_gruplari'];
                                    $kan_gruplariID = $kan_row['kan_gruplariID'];
                                    echo '<option value = '.$kan_gruplariID.'> '.$kan_gruplari.' </option>';
                                }

                        ?>

                         </select>

                         
            </div>
        </div>
                
        <input class="button" type="submit" name="bagis_ara" value="Ara" > 
        
        <a class="button" href="bagisisteyen.php">Veya İstek Oluşturun</a>
               
    </div>
</div>
</form>




       


        
      
<script>
      $(document).ready(function() {
    $('#sehirler').on('change', function() {
        var country_id = this.value;
        $.ajax({
            url: "includes/post.php",
            type: "POST",
            data: {
                country_id: country_id
            },
            cache: false,
            success: function(ilce_stmt) {
                $("#ilceler").html(ilce_stmt);
               
            }
        });
    });
 
});
      </script>

</body>
</html>
