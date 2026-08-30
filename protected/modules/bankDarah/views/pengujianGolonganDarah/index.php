<?php

/**
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @digunakan   - digunakan sebagai view utama untuk menampilkan data atau form inputan untuk 
 * RSST-1471
 */
?>
<?php
$this->breadcrumbs = array(
    'Pengujian Golongan Darah',
);
?>
<style>
    .control-label {
        text-align: left !important;
        vertical-align: top !important;
    }
</style>
<div class="panel panel-gradient">

    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Pengujian Golongan Darah
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert');

        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pengujiankantongdarah-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onSubmit' => 'requiredCheck(this);'),
        ));
        echo CHtml::hiddenField("nama_komponen");

        echo $this->renderPartial($this->path_view . '_dataPasien', array('form' => $form, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran, 'model' => $model, 'modKunjungan' => $modKunjungan, 'modKirim' => $modKirim), true);

        echo $this->renderPartial($this->path_view . 'form/_formPemeriksaanABORhesus', array('form' => $form, 'modPasien' => $modPasien, 'modHasilUjiCocok' => $modHasilUjiCocok));

        
        echo $this->renderPartial($this->path_view . 'form/_formPemeriksaanUjiCocok', array('form' => $form, 'modPasien' => $modPasien, 'modHasilUjiCocok' => $modHasilUjiCocok));
        
        echo $this->renderPartial($this->path_view . 'form/_formPemeriksaanLembarKerja', array('form' => $form, 'modPasien' => $modPasien, 'modPemeriksaanGolDar' => $modPemeriksaanGolDar, 'modRiwayatGolDar' => $modRiwayatGolDar));

        echo $this->renderPartial($this->path_view . 'form/_formPemeriksaanGolonganDarah', array('form' => $form, 'modPasien' => $modPasien, 'modPemeriksaanDarah' => $modPemeriksaanDarah, 'modRiwayatGolDar' => $modRiwayatGolDar));

        // echo $this->renderPartial($this->path_view . 'form/_formScreeningAntibody', array('modPengujianDarah' => $modPengujianDarah, 'form' => $form), true);

        // echo $this->renderPartial($this->path_view . 'form/_formKompatibilitas', [
        //     'modUjiKompatibilitas' => $modUjiKompatibilitas,
        //     'modPengujianDarah' => $modPengujianDarah,
        //     'modPermantaanDetail' => $modPermintaanDetail
        // ]);

        // echo $this->renderPartial($this->path_view . 'form/_formPemesananDarah', array('model' => $model, 'form' => $form, 'modPermintaanDetail' => $modPermintaanDetail), true);

        echo $this->renderPartial($this->path_view . 'form/_formLainnya', array('model' => $model, 'form' => $form, 'modPendaftaran' => $modPendaftaran, 'modHasilUjiCocok' => $modHasilUjiCocok), true);

        echo $this->renderPartial($this->path_view . '_dialog', array('model' => $model), true);
        ?>

        <?php
        $this->endWidget();

        echo $this->renderPartial($this->path_view . '_jsFunction', array('model' => $model, 'modUjiDarahPasien' => $model, 'modPemeriksaanGolDar' => $modPemeriksaanGolDar), true);
        ?>
    </div>
</div>