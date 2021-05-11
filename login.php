<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/kan_bankasi/css/loginend.css?key=<?=time()?>">
</head>

<body>

<form action="" method="POST">
    
<div class="container"> 
    
   <div class="txt">
       <div class="txt_1">
    <h1 >Kan Bağışı Hayati Bir Önem Taşır</h1>
    <p> Kan bağışı; gönüllü ve sağlıklı bir bağışçıdan kan ve kan ürünlerini elde etmek amacıyla kan merkezleri tarafından kan alınması işlemidir.
"Bağışçı Bilgilendirme ve Onam Formu" ile "Bağışçı Sorgulama Formu" okunduktan sonra sorular yanıtlanır ve imzalanır. </p>
</div>   
    </div>
    
    <div class="panel">
        
        <div class="panel_1">
           
        
    <div class="login_inputs">
        <div class="user_id">
            <input  type="text" autocomplete="off"  placeholder="Kullanıcı Adı" name="kadi" value="">
        </div>
                
        <div class="user_passwd">
            <input type="password"  placeholder="Şifre" name="ksifre" value="">
        </div>
    </div>

<div class="login_button">        
        <input  class="btn"  type="submit"  value="Giriş" >                       
        <input class="btn_1"  type="button"   onclick="window.location.href='/kan_bankasi/signup.php'" value="Kaydol" >                     
        
</div>                                                
                    
                          
            
        </div>
      

    </div>  
          
</div>


</body>

<?php 
require_once "includes/pdo.php";

if($_POST){
$kullanici_adi=$_POST['kadi'];
$kullanici_sifre=$_POST['ksifre'];
$hashing_sifre;
function encrypt_decrypt($action, $kullanici_sifre) {
    $output = true;
    $sifreleme_kodlari = 'AES-256-CTR'; //sifreleme yontemi
    $sifreleme_key = '25760'; //sifreleme anahtari
    $sifre_baslangici = '**109'; //gerekli sifreleme baslama vektoru
    $key = hash('sha256', $sifreleme_key); //anahtar hast fonksiyonu ile sha256 algoritmasi ile sifreleniyor
    $key_substr = substr(hash('sha256', $sifre_baslangici), 0, 16); //0. ve 16. sifrelenmiş harfi göstermeyecek
    if( $action == 'encrypt' ) {
      $output = urlencode(serialize(base64_encode(gzcompress(openssl_encrypt($kullanici_sifre,$sifreleme_kodlari, $key, 0, $key_substr)))));
    }	             
    return $output;
  }           
  $hashing_sifre = encrypt_decrypt('encrypt',$kullanici_sifre);//ŞİFREmizi hashing sifre değişkenine aktarır

$rol1=1;
$rol2=0;

    $kullanici_kontrol= $pdo->query("SELECT * FROM kayit WHERE kullanici_adi='$kullanici_adi' AND kullanici_sifre='$hashing_sifre' AND rol='$rol2' ")->fetch();
    $admin_kontrol=$pdo->query("SELECT * FROM kayit WHERE kullanici_adi='$kullanici_adi' AND kullanici_sifre='$hashing_sifre' AND rol='$rol1' ")->fetch();
    if ($kullanici_kontrol){/// roll 0 ise index sayfasına atacak 0 demek kullanıcı demektir
	
    $_SESSION["isim"] = $kullanici_kontrol['kullanici_adi'];
    $_SESSION["kayitID"] = $kullanici_kontrol['kayit_id'];
        // echo "<script type='text/javascript'>alert('Anasayfaya Yönendiriliyorsunuz')</script>";
         header("Refresh: 0; url= index.php");
	
    }
    else if($admin_kontrol){ ///// roll 1 ise admin sayfasına atacak//////
        $_SESSION["admin"] = $admin_kontrol['kullanici_adi'];
        echo "<script type='text/javascript'>alert('Hoşgeldiniz, Sayın, $kullanici_adi Admin Sayfasına Yönendiriliyorsunuz')</script>";
        header("Refresh: 0; url= admin.php");

    }
    else{
        echo "<script type='text/javascript'>alert('Girmiş Olduğunuz Bilgiler Hatalıdır!')</script>";
        header("Refresh: 0; url= login.php");
    }
  
	

}

?>
</form>
</html>