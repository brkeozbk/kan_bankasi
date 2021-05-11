<?php
require_once "includes/pdo.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="conandabaout.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="css/contact.css?key=<?=time()?>">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   
    <title>Document</title>
    <style>
    
    
    </style>
</head>
<body>
<?php include_once('content/headerMenu.php');?>
    
    <!--   bizimle iletişime geçin sayfası bootsraple tasarladık -->
    <form action="" method="POST">
    <div class="container contact">
        <div class="row">
            <div class="col-md-3">
                <div class="contact-info">
                    <img class="img" src="images/indir.jpg" alt="image"/>
                    <h2 class="iletisime_gec">Bizimle İletişime Geçin</h2>
                    <h4></h4>
                </div>
            </div>
            <div class="col-md-9">
                <div class="contact-form">
                    <div class="form-group">
                      <label class="control-label col-sm-2 " for="fname">Adınız:</label>
                      <div class="col-sm-10">          
                        <input type="text" class="form-control ad" id="fname" placeholder="Adınızı Giriniz.." name="ad">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="lname">Soyadınız:</label>
                      <div class="col-sm-10">          
                        <input type="text" class="form-control soyad" id="lname" placeholder="Soyadınızı Giriniz.." name="soyad">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="email">Email:</label>
                      <div class="col-sm-10">
                        <input type="email" class="form-control email" id="email" placeholder="kullanici12@example.com" name="email">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="comment">Mesajınız:</label>
                      <div class="col-sm-10">
                      <p>
                        <textarea class="form-control mesaj" name="mesaj" rows="5" id="comment"></textarea>
                        </p>
                      </div>
                    </div>
                    <div class="form-group">        
                      <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Gönder</button>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<?php
                        if($_POST){                     // veritabanına kayıt php kodları
                            $ad =   htmlentities(trim($_POST['ad']));
                            $soyad = htmlentities(trim($_POST['soyad']));
                            $email = htmlentities(trim($_POST['email']));
                            $mesaj = htmlentities(trim($_POST['mesaj']));

                            if(empty($ad) || empty($soyad)  || empty($email) || empty($mesaj)   ) {
                              echo "<script type='text/javascript'>alert('Lütfen Gerekli Yerlerin Dolu Olduğundan Emin Olunuz');</script>";
                            }
                      
                            else{
                             $addForms_stmt = $pdo->prepare("INSERT INTO iletisim (ad, soyad, email, mesaj) VALUES (:ad, :soyad, :email, :mesaj) ");
                                  $addForms_stmt->execute(array(
                                  ':ad' => $ad,
                                  ':soyad' => $soyad,
                                  ':email' => $email,
                                  ':mesaj' => $mesaj
                                  
                                  
                                  ));
                              
                                  echo "<script type='text/javascript'>alert('Girdiğiniz bilgiler kaydedildi, size dönüş yapacağız.');</script>";
                              }
                          }
?>

</body>
</html>