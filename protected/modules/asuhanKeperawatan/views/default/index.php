<!--<div class="new-container">
    <div class="dashboard">
            <div class="block">
                    <div><h6><?php echo $this->module->id; ?></h6></div>
                    <?php
                    //                    $menus = $this->module->menu;
                    //                    foreach($menus AS $i => $menu){
                    //                        if($menu->kelmenu_id == Params::KELMENU_ID_DASHBOARD){
                    //                            echo "<a href=".Yii::app()->createUrl($menu->menu_url,array('modul_id'=>$menu->modul_id))." class='shortcut'>";
                    //                            echo "<img height='48' width='48' alt='' src='".Params::urlIconModulDirectory().(empty($menu->menu_icon) ? "tampilAntrian.png" : $menu->menu_icon)."'>";
                    //                            echo "$menu->menu_namalainnya</a>";
                    //                        }
                    //                    } 
                    ?>
            </div>
    </div>
</div>-->

<?php
// $modul_nama = ModulK::model()->findByPk(Yii::app()->user->getState('modul_id'));
$modul_nama = ModulK::model()->findByPk(Yii::app()->user->getState('modul_id'))->modul_nama;
$nama_peg = (!empty(Yii::app()->user->getState('nama_pegawai')) ? Yii::app()->user->getState('nama_pegawai') : Yii::app()->user->getState('nama_pemakai'))
?>
<div class="well">
    <h1><?php echo date('d') . ' ' . MyFormatter::getMonthId(date('m')) . ' ' . date('Y'); ?></h1>
    <h3>Selamat Datang di Modul <?php echo $modul_nama; ?>, <b><?php echo $nama_peg; ?></b></h3>
</div>