
    <?php
       //ana veri tabanı bağlantımız heryerde kullandığımız pdo yöntemiyle bağlandık çünkü günümüz dünyasında hacklenmesi zor bir bağlantı
       $pdo = new PDO ('mysql:host=localhost; port=3306;  dbname=kan_bankasi;charset=utf8','root','');
       $pdo ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
       $baglanti = new mysqli("localhost", "root","", "kan_bankasi");
      
        
        ?>