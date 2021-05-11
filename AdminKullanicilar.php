<?php
session_start();
ob_start();
require_once "includes/pdo.php";
if(!isset($_SESSION["admin"])){  echo "<script type='text/javascript'>alert('Öncelikle Giriş Yapmanız Gerekmektedir!')</script>";
  header("LOCATION: AdminKullanicilar.php");}
       
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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

       

</head>
<body>
<?php 
       include_once('includes/adminMenu.php')
       ?>
       <h1 class="AdmiBarTittle">Güncel Kullanıcılar</h1>
                       
                        </div>
                        <div class="AdminSectionInner">
                                <div class="AdminSectionTable">
                                
                                        <table class="table table-dark table-striped">
                                                <thead>
                                                  <tr>
                                                  <th>Sıra No</th>
                                                    <th>Kullanıcı Adı</th>
                                                    <th>E-mail</th> 
                                                    <th>Kullanıcı Rol</th>
                                                    <th>Parola</th>                                                                                                 
                                                    <th>Sil</th>
                                                    <th>Düzenle</th>
                                                  </tr>
                                                </thead>
                                               
                                                 <?php                                                
                                                 $unhashing_sifre;
                                                 function encrypt_decrypt($action, $kullanici_sifre) {
                                                     $output = true;
                                                     $sifreleme_kodlari = 'AES-256-CTR'; //sifreleme yontemi
                                                     $sifreleme_key = '25760'; //sifreleme anahtari
                                                     $sifre_baslangici = '**109'; //gerekli sifreleme baslama vektoru
                                                     $key = hash('sha256', $sifreleme_key); //anahtar hast fonksiyonu ile sha256 algoritmasi ile sifreleniyor
                                                     $key_substr = substr(hash('sha256', $sifre_baslangici), 0, 16); //0. ve 16. sifrelenmiş harfi göstermeyecek
                                                     if( $action == 'decrypt' ) {
                                                      $output = openssl_decrypt(gzuncompress(base64_decode(unserialize(urldecode($kullanici_sifre)))),$sifreleme_kodlari, $key, 0, $key_substr);
                                                     }	             
                                                     return $output;
                                                   }           
                                                 
                                                $sonuc=mysqli_query($baglanti,"SELECT * from kayit");
                                                mysqli_set_charset($baglanti, "utf8");                                                
                                                while($kullanici_row=mysqli_fetch_assoc($sonuc))
                                                  {
                                                    $kullanici_id=$kullanici_row['kayit_id'];  
                                                    $kullanici_sifre=$kullanici_row['kullanici_sifre'];
                                                   
                                                   $unhashing_sifre =  encrypt_decrypt('decrypt',$kullanici_sifre);///// database'deki şifrelerin asıl yazılışı  
                                                   echo '<form action="" method="POST">';
                                                   echo '<input type="hidden" name="kayit_id" value="'.$kullanici_id.'">';
                                                   echo ' <tbody>';
                                                   echo ' <tr>';
                                                   echo ' <td>'.$kullanici_row['kayit_id'].'</td>';
                                                   echo ' <td>'.$kullanici_row['kullanici_adi'].'</td>';
                                                   echo ' <td>'.$kullanici_row['email'].'</td>';
                                                   echo '<td>'.$kullanici_row['rol'].'</td>';
                                                   echo '<input type="hidden" name="rol" value="'.$kullanici_row['rol'].'">';
                                                   echo '<td>'.$unhashing_sifre.'</td>';                                                                       
                                                   echo ' <td><input type="submit"  name="sil" value="Sil"></td>';
                                                   echo '<td><input type="submit"  name="guncelle" value="Rol Değiştir"></td>';
                                                   echo ' </tr>';
                                                   echo '</tbody>';
                                                   echo '</form>';
                                                  }
                                               
                                                  ?>
                                          </table>
                                          
                              <?php
                              if(isset($_POST['sil'])){
                            $kayit_id = $_POST['kayit_id'];
                            $sql = "DELETE FROM kayit WHERE kayit_id='$kayit_id'";
                            $sonuc=mysqli_query($baglanti,"select * from kayit where kayit_id='$kayit_id'");
                            $satir=mysqli_fetch_assoc($sonuc);
                                if (mysqli_query($baglanti, $sql)) {  // 
                              echo "Record deleted successfully";
                              header('LOCATION: AdminKullanicilar.php');
                            } else {
                            echo "Error deleting record: " . mysqli_error($baglanti);
                            }
                    
                            }
                               
                            if(isset($_POST['guncelle'])){
                              $kayit_id = $_POST['kayit_id']; 
                              $rol_kontrol=$_POST['rol'];
                              $rol='0';
                              $rol1='1';
                              if($rol_kontrol == 1){
                                   $sql = "update kayit set rol = '$rol' where kayit_id ='$kayit_id'";
                                  if($baglanti->query($sql) ==   true){
                                    header('LOCATION: AdminKullanicilar.php');
                                  }else {
                                    echo "Hata : ". $baglanti->error;
                                    header('LOCATION: AdminKullanicilar.php');
                                  }
                              }

                             else if($rol_kontrol == 0){
                              $sql = "update kayit set rol = '$rol1' where kayit_id ='$kayit_id'";
                              if($baglanti->query($sql) ==   true){
                                header('LOCATION: AdminKullanicilar.php');
                              }else {
                                echo "Hata : ". $baglanti->error;
                                header('LOCATION: AdminKullanicilar.php');
                              }

                               }
                             
                              }
                               ?>
                                                </div>

                        </div>

                </div>

        </div>

       
</body>
</html>
<?php
ob_end_flush();
?>