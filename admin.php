<?php
session_start();        
require_once "includes/pdo.php"; //veritabanı bağlantısı için yazılan kod
if(!isset($_SESSION["admin"])){  echo "<script type='text/javascript'>alert('Öncelikle Giriş Yapmanız Gerekmektedir!')</script>";
        header("LOCATION: login.php");
        //eğer admin bilgileri doğru yazılırsa admin sayfasına yönlendirme kodu
        }
       
        else{
           header("Refresh: 9999999999; url= admin.php");
        }
       ?>
     
<!DOCTYPE html>
<html lang="en">
<head>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Sayfası</title>
        <link rel="stylesheet" href="/kan_bankasi/css/adminKanBgs_kulln-aryn.css?key=<?=time()?>">
       

</head>
<body>
<?php 
       include_once('includes/adminMenu.php')
       ?>                 
           
                                <h1>HOŞGELDİNİZ</h1>
                        </div>
                        <div class="AdminSectionInner">
                        

                        </div>
                      

                </div>

        </div>
       
 </div>

        
</body>
</html>