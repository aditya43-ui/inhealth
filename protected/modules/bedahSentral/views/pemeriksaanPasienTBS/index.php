<?php
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
    }
    $this->widget('bootstrap.widgets.BootAlert');
?>


<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Pemeriksaan Pasien <b><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Daftar Pasien' => Yii::app()->request->urlReferrer,
            'Pemeriksaan Pasien',
        );
        ?>
        <?php
        $this->renderPartial($this->path_view . '_dataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien));
        $this->renderPartial('_tabMenu', array());
        $this->renderPartial($this->path_view . '_jsFunctions', array("modPasien" => $modPasien)); 
        $this->renderPartial($this->path_view . '_jsTabulasi', array("modPasien" => $modPasien));
        ?>
        <div>
            <iframe id="frame" src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>
        </div>
    </div>
</div>