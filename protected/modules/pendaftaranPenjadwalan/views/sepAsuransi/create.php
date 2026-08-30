<?php
$this->breadcrumbs = array(
    'Assep Ts' => array('index'),
    'Create',
);
?>
<div class="panel panel-gradient form-sep-new">
    <div class="panel-heading">
        <div class="panel-title">Tambah Surat Eligibilitas Peserta <b>(SEP)</b></div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_form', array('model' => $model, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modInfoKunjungan' => $modInfoKunjungan, 'modPengajuanApproval' => $modPengajuanApproval)); ?>
        <?php echo $this->renderPartial('_jsFunctions', array('model' => $model, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modPengajuanApproval' => $modPengajuanApproval)); ?>
        
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogNoRujukan',
    'options' => array(
        'title' => 'Pencarian Rujukan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial('_pencarianRujukan', array('model' => $model));
$this->endWidget();
?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDpjpMelayani',
    'options' => array(
        'title' => 'Pencarian Dokter DPJP yang Melayani',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial('_pencarianDpjpMelayani');
$this->endWidget();
?>