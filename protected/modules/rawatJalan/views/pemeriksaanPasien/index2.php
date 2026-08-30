<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fa fa-stethoscope"></i> Pemeriksaan Pasien <b><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Daftar Pasien' => Yii::app()->request->urlReferrer,
            'Pemeriksaan Pasien',
        );
        ?>
        <?php $this->renderPartial($this->path_view . '_dataPasien2', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>
        <?php
    //    $this->renderPartial($this->path_view . '_tabMenu', array('modPendaftaran'=>$modPendaftaran));
        $this->renderPartial($this->path_view . '_jsFUnctions2', array("modPasien" => $modPasien)); ?>
        <div>
            <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; "></iframe>
        </div>
    </div>
</div>

<?php  // $this->renderPartial("rawatJalan.views.pemeriksaanPasien.validasi.handle-tab.index",[], true); ?>

<?php
//========= Dialog Detail Tindakan, Terapi dan Pemakaian Bahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailDataPenunjang',
    'options' => array(
        'title' => 'Detail Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 600,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detailDialogPenunjang" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>