<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/kan_bankasi/css/signup.css?key=<?=time()?>">
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
           
        
    <div class="signup_inputs">
        <div class="user_id">
            <input  type="text" autocomplete="off" pattern="[a-zA-Z<?=$trChars?>\s.]*"  required autofocus oninvalid="alert('Kullanıcı Adını Girmeniz Zorunludur!')" placeholder="Kullanıcı Adı" name="kadi" value="">
        </div>
        <div class="mail_id">
            <input  type="text" autocomplete="off"  required autofocus oninvalid="alert('E-mail Girmeniz Zorunludur!')" placeholder="E-mail" name="mail" value="">
        </div>
                        
        <div class="user_passwd">
            <input type="password"  placeholder="Şifre"  required autofocus oninvalid="alert('Şifre Alanını Girmeniz Zorunludur!')" name="ksifre" value="">
        </div>
        <div class="user_passwd_again">
            <input type="password"  placeholder="Şifre Tekrarı"   required autofocus oninvalid="alert('Şifre Tekrarını Girmeniz Zorunludur.')" name="ksifretkrar" value="">
        </div>
    </div>

<div class="signup_button">                                       
        <input class="btn"  type="submit"  value="Kaydol" >            
    
        <input  class="btn_1"  type="button" onclick="window.location.href='/kan_bankasi/login.php'" value="Zaten Bir Kullanıcı Hesabım Var!"> 
    
</div>                                                
                
        </div>
      

    </div>  
          
</div>
</form>
<?php 
require_once "includes/pdo.php";

$mail_kontrol;
$kullanici_adi;
$kullanici_info;
$hashing_sifre;
if($_POST){
    
$kullanici_adi = htmlentities(trim($_POST['kadi']));
$kullanici_sifre=htmlentities(trim($_POST['ksifre']));
$kullanici_sifre_tekrar=htmlentities(trim($_POST['ksifretkrar']));
$kullanici_email=htmlentities(trim($_POST['mail']));

   if(!empty($kullanici_adi) && !empty($kullanici_email)  && !empty($kullanici_sifre) && !empty($kullanici_sifre_tekrar)){// şifre ve şifre tekrarı birbirine eşitmi
    //$kullanici_info=$pdo->query("SELECT * FROM kayit WHERE kullanici_adi='$kullanici_adi' AND kullanici_sifre='$kullanici_sifre' AND  ")->fetch();
      if($kullanici_adi==$kullanici_sifre){
        echo "<script type='text/javascript'>alert('Kullanıcı Şifreniz Kullanıcı Girişi ile Aynı Olmamalıdır.');</script>";

      }
      else if($kullanici_adi==$kullanici_email){
        echo "<script type='text/javascript'>alert('Kullanıcı Adınız E-mailiniz  ile Aynı Olmamalıdır.');</script>";
      }
      else if($kullanici_adi!=$kullanici_sifre && $kullanici_adi!=$kullanici_email && $kullanici_sifre==$kullanici_sifre_tekrar){//// ŞİFRE VE ŞİFRE TEKRARI BİRBİRİ İLE UYUŞUYORSA DEVAMKEEE

        $sifre_array=str_split($kullanici_sifre);/////////////////////////// $sifreyi dizi olarak sifre_array değişkenine attım////////////////
        if(count($sifre_array)<6 ){//////////////////// ŞİFRE 6 HANEDEN AZ OLMAMALI GÜVENLİK AÇISINDAN/////////////////////////////////////////
            echo "<script type='text/javascript'>alert('Şifreniz en az 6 haneden oluşmalıdır.')</script>";            
        }
        else if($sifre_array>=6){
            // <<<<--------- MAİL KONTROL BAŞLANGIÇI OLACAK BUDA -------->>>>>
            if (filter_var($kullanici_email, FILTER_VALIDATE_EMAIL)) {
             // $kullanici_info=$pdo->query("SELECT * FROM kayit WHERE kullanici_adi='$kullanici_adi' AND kullanici_sifre='$kullanici_sifre'  ")->fetch();
               // <------------BU ALAN PASSWORD HASHİNG VE VERİ TABANINA KAYDETME ALANIDIR---------------->         
                               
                function encrypt_decrypt($action, $kullanici_sifre) {
	              $output = true;
	              $sifreleme_kodlari = 'AES-256-CTR'; 
	              $sifreleme_key = '25760'; 
	              $sifre_baslangici = '**109'; 
	              $key = hash('sha256', $sifreleme_key); 
	              $key_substr = substr(hash('sha256', $sifre_baslangici), 0, 16); 
	              if( $action == 'encrypt' ) {
		            $output = urlencode(serialize(base64_encode(gzcompress(openssl_encrypt($kullanici_sifre,$sifreleme_kodlari, $key, 0, $key_substr)))));
	              }	             
	              return $output;
                }           
                $hashing_sifre = encrypt_decrypt('encrypt',$kullanici_sifre); 
                // <-----------------BU ALAN PASSWORD HASHİNG BİTME ALANIDIR------------------------> 
                $kullanici_info=$pdo->query("SELECT * FROM kayit WHERE kullanici_adi='$kullanici_adi' ")->fetch();
                $mail_kontrol=$pdo->query("SELECT * FROM kayit WHERE email='$kullanici_email' ")->fetch();
                if($kullanici_info){  
                  echo"<script type='text/javascript'>alert('Girmiş Olduğunuz Kullanıcı Adı Zaten Kayıtlıdır!')</script>";    
                }
                else if($mail_kontrol==0){
                  try{
                  $sql=("INSERT INTO `kayit` (`kayit_id`, `kullanici_adi`, `kullanici_sifre`, `rol`, `email`) VALUES (NULL, '$kullanici_adi', '$hashing_sifre', '0', '$kullanici_email')");
                  $pdo->exec($sql);
                  echo "<script type='text/javascript'>alert('Başarıyla Kayıt Oldunuz,Giriş Sayfasına Yönlendiriliyorsunuz...')</script>";
                  header("Refresh: 0; url= login.php");
                  }
                  catch(PDOException $e) {
                    echo"<script type='text/javascript'>alert('Kayit İşleminiZ Gerçekleşememiştir Lütfen Bilgilerinizi Tekrar Giriniz!')</script>";
                    }
                }
                else {
                  echo"<script type='text/javascript'>alert('Böyle Bir $kullanici_email  E-mail Adresi Zaten Kayıtlıdır!')</script>";
                }
                
              //<<<<<<<<<<<<<<<------------------------VERİ TABANINA KAYDETME BİTİŞ---------------------------------->>>>>>>>>>>>>>><             

               
              } 
                else {
                echo "<script type='text/javascript'>alert('Kullanmış Olduğunuz $kullanici_email E-mail Adresi Geçerli Değildir');</script>"; 
              } 
        }
      }      
      else if($kullanici_sifre != $kullanici_sifre_tekrar) {
        echo "<script type='text/javascript'>alert('Şifreleriniz Birbiri İle Uyuşmamaktadır! Lütfen Aynı Olduğundan Emin Olunuz!');</script>";
      }   
   }
 
   
}

?>
</body>
</html>