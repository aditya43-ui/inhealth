<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/sie.css" type="text/css" />
<div class="dashboard">
    <?php foreach ($menus as $i => $menu) { ?>
        <a class="shortcut-menu box span3" href="index.php?r=<?php echo $menu->menu_url ?>"><img width="48" height="48" src="images/icon_modul/<?php echo $menu->modulk->icon_modul ?>" alt=""><?php echo $menu->menu_nama ?></a>
        <!-- <a class="shortcut box span3" href="#" onClick="fasilitas()"><img width="48" height="48" src="images/icon_modul/1333095655_image.png" alt="">FASILITAS</a>
        <a class="shortcut box span3" href="#" onClick="asuransi()"><img width="48" height="48" src="images/icon_modul/1351501713_image.png" alt="">ASURANSI</a>
        <a class="shortcut box span3" href="#" onClick="kamarperawatan()"><img width="48" height="48" src="images/icon_modul/1333365562_image.png" alt="">KAMAR PERAWATAN</a>
        <a class="shortcut box span3" href="#" onClick="jadwaldokter()"><img width="48" height="48" src="images/icon_modul/1333351452_image.png" alt="">JADWAL DOKTER</a>
        <a class="shortcut box span3" href="#" onClick="paketpelayanan()"><img width="48" height="48" src="images/icon_modul/1351501713_image.png" alt="">PAKET PELAYANAN</a>
        <a class="shortcut box span3" href="#" onClick="infokamar()"><img width="48" height="48" src="images/icon_modul/1333365562_image.png" alt="">INFO KAMAR</a> -->
    <?php } ?>
</div>