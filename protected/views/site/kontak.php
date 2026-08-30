
<?php
    $kontaks = KontakS::model()->findAll();
    foreach($kontaks as $i=>$kontak) {
        echo "<h4>$kontak->jeniskontak</h4>";
        echo $kontak->namakontak."<br/>";
        echo "Telp : $kontak->tlpkontak<br/>";
        echo "email : $kontak->emailkontak<br/>";
        echo $kontak->pinkontak."<br/>";
        echo $kontak->ym."<br/>";
    }
?>


