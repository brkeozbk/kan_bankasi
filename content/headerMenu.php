<?php require_once "includes/pdo.php"; 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/headermenu.css?key=<?=time()?>">
     
    <title>menu</title>
   <style>
   
   </style>
</head>
<body>

 <div class="topnav"> <!--   menü kodlarımız -->
 <a  href="index.php">Ana Sayfa</a> 
<a href="aboutus.php">Bağış Hakkında</a> 
<a href="contact.php">İletişim</a>

<?php

if( (!isset($_SESSION['isim'])) && (!isset($_SESSION['admin'])) ) // menüde kullanıcı adını ekrana yazdık
{
	
                       
                          echo '<a id="main" href ="login.php">Giriş Yap</a></li>';        
                                			
                         }else{
							 echo '<a id="main" href ="logout.php">Çıkış Yap</a></li>';
                                echo  '<p class = "girenKullanici">Hoşgeldiniz '.$_SESSION["isim"]. '</p>' ;	
                            // echo  '<p class = "girenKullanici">' .$_SESSION["kayitID"]. '</p>' ;	
                             }
                             
 ?>




  
    
   
</div>
</body>
</html>