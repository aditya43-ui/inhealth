<?php
$sukses = null;
if (isset($_GET['sukses'])) {
    $sukses = $_GET['sukses'];
}
if ($sukses > 0)
    Yii::app()->user->setFlash('success', "Transaksi Pemakaian Ambulans berhasil disimpan!");

?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pemakaianambulans-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
    'focus' => '#' . CHtml::activeId($modPemakaian, 'norekammedis'),
)); ?>
<?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'table-riwayattindakan',
    'content' => array(
        'content-riwayattindakan' => array(
            'header' => '<b>Riwayat Tindakan</b>',
            'isi' => $this->renderPartial($this->path_view . '_tableRiwayatTindakan', array(
                'format' => $format,
                'modRiwayatTindakans' => $modRiwayatTindakans,
            ), true),
            'active' => true,
        ),
    ),
)); ?>

<fieldset class="" id="form-datapemakaian">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-briefcase"></i> Pemesanan Ambulans
                <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
            </div>
        </div>
        <div class="panel-body">
            <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                        ?></p>-->
            <?php echo $form->errorSummary($modPemakaian); ?>
            <div class="row">
                <?php $this->renderPartial($this->path_view . '_formPemesananAmbulan', array('form' => $form, 'modPemakaian' => $modPemakaian, 'instalasi' => $instalasi, 'modInstalasi' => $modInstalasi, 'format' => $format)); ?>
            </div>
        </div>
    </div>
</fieldset>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Tarif <b>Ambulans</b> <?php
                                                                    echo CHtml::htmlButton('<i class="entypo-search"></i>', array(
                                                                        'class' => 'btn btn-danger', 'onclick' => "$('#dialogTarif').dialog('open');",
                                                                        'id' => 'btnAddParamedis2', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                                                        'rel' => 'tooltip', 'title' => 'Klik untuk mencari Tarif Ambulans'
                                                                    ))
                                                                    ?></div>
    </div>
    <div class="panel-body table-responsive">
        <table id="tblTarifAmbulans" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th colspan="4" style='vertical-align:middle;text-align:center;'>Tujuan</th>
                    <th rowspan="2" style='vertical-align:middle;text-align:left;'>Jumlah KM</th>
                    <th rowspan="2" style='vertical-align:middle;text-align:left;'>Tarif / KM</th>
                    <th rowspan="2" style='vertical-align:middle;text-align:left;'>Total Tarif</th>
                </tr>
                <tr>
                    <th>Provinsi</th>
                    <th>Kabupaten</th>
                    <th>Kecamatan</th>
                    <th>Kelurahan</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count((array)$tarif['tarifAmbulans']); $i++) : ?>
                    <?php if (!empty($tarif['tarifAmbulans'][$i])) { ?>
                        <tr>
                            <td><input type="text" value="<?php echo $tarif['propinsi'][$i]; ?>" name="tarif[propinsi][]" class="span2" /></td>
                            <td><input type="text" value="<?php echo $tarif['kabupaten'][$i]; ?>" name="tarif[kabupaten][]" class="span2" /></td>
                            <td><input type="text" value="<?php echo $tarif['kecamatan'][$i]; ?>" name="tarif[kecamatan][]" class="span2" /></td>
                            <td><input type="text" value="<?php echo $tarif['kelurahan'][$i]; ?>" name="tarif[kelurahan][]" class="span2" /></td>
                            <td><input type="text" value="<?php echo $tarif['jmlKM'][$i]; ?>" name="tarif[jmlKM][]" class="span1 integer" />
                                <input type="hidden" value="<?php echo $tarif['daftartindakanId'][$i]; ?>" name="tarif[daftartindakanId][]" class="span1 integer" />
                            </td>
                            <td><input type="text" value="<?php echo $tarif['tarifKM'][$i]; ?>" name="tarif[tarifKM][]" class="span1 integer" /></td>
                            <td><input type="text" value="<?php echo $tarif['tarifAmbulans'][$i]; ?>" name="tarif[tarifAmbulans][]" class="span2 integer" /></td>
                        </tr>
                    <?php } ?>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="form-actions">
    <?php
    if ($modPemakaian->isNewRecord) {
        echo CHtml::htmlButton(
            $modPemakaian->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'setVerifikasi();', 'onkeypress' => 'setVerifikasi();')
        );
    } else {
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-danger', 'disabled' => true, 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
        );
    }
    ?>
    <?php // echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
    //                    $this->createUrl('Index'), 
    //                    array('class' => 'btn btn-default',
    //                          'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  
    ?>
    <?php
    if ($modPemakaian->isNewRecord) {
        echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
        //                    echo CHtml::link(Yii::t('mds', '{icon} Print Pemakaian BMHP', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('disabled'=>true,'class'=>'btn btn-info','onclick'=>"return false"));
    } else {
        echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatus();return false"));
        //                    echo CHtml::link(Yii::t('mds', '{icon} Print Pemakaian BMHP', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printPemakaianOa(".$_GET['pemakaian_id'].");return false"));
    }
    ?>
    <?php // $content = $this->renderPartial('../tips/transaksi_pemakaian',array(),true);
    //                  $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->renderPartial('_jsFunctions', array('modKunjungan' => $modKunjungan, 'modPemakaian' => $modPemakaian)); ?>
<?php $this->endWidget(); ?>

<?php
//========= Dialog buat daftar paramedis  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogParamedis1',
    'options' => array(
        'title' => 'Daftar Paramedis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
$modParamedis = new ParamedisV;
$modParamedis->unsetAttributes();
if (isset($_GET['ParamedisV'])) {
    $modParamedis->attributes = $_GET['ParamedisV'];
}
//    echo CHtml::hiddenField('paramedisKe','',array('readonly'=>true));
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'paramedis-t-grid',
    'dataProvider' => $modParamedis->search(),
    'filter' => $modParamedis,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                "id" => "selectPasien",
                                "onClick" => "inputParamedis1($data->pegawai_id,
                                \'$data->nama_pegawai\');return false;"))',
        ),
        'ruangan_nama',
        'nama_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar paramedis =============================

//========= Dialog buat daftar paramedis  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogParamedis2',
    'options' => array(
        'title' => 'Daftar Paramedis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
$modParamedis = new ParamedisV;
$modParamedis->unsetAttributes();
if (isset($_GET['ParamedisV'])) {
    $modParamedis->attributes = $_GET['ParamedisV'];
}
//    echo CHtml::hiddenField('paramedisKe','',array('readonly'=>true));
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'paramedis-t-grid',
    'dataProvider' => $modParamedis->search(),
    'filter' => $modParamedis,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                "id" => "selectPasien",
                                "onClick" => "inputParamedis2($data->pegawai_id,
                                \'$data->nama_pegawai\');return false;"))',
        ),
        'ruangan_nama',
        'nama_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar paramedis =============================

//========= Dialog buat daftar supir  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSupir',
    'options' => array(
        'title' => 'Daftar Supir',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
$this->renderPartial('_daftarSupir');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar supir =============================

//========= Dialog buat daftar pelaksana  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPelaksana',
    'options' => array(
        'title' => 'Daftar Pelaksana',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
$this->renderPartial('_daftarPelaksana');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar pelaksana =============================

//========= Dialog buat daftar ambulans  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKendaraan',
    'options' => array(
        'title' => 'Daftar Kendaraan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
$this->renderPartial('_daftarKendaraan');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar ambulans =============================

//========= Dialog buat daftar tarif ambulans  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTarif',
    'options' => array(
        'title' => 'Daftar Tarif Ambulans',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
$this->renderPartial('_daftarTarifAmbulans');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar tarif ambulans =============================
?>

<?php
//========= Dialog buat cari data obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'resizable' => false,
    ),
));

$modPasien = new InfopasienrirdambulansV('search');
$modPasien->unsetAttributes();
if (isset($_GET['InfopasienrirdambulansV'])) {
    $modPasien->attributes = $_GET['InfopasienrirdambulansV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-m-grid',
    'dataProvider' => $modPasien->search(),
    'filter' => $modPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPasien",
                "onClick" => "$(\"#BKPemakaianambulansT_norekammedis\").val(\"$data->no_rekam_medik\");
                  $(\"#BKPemakaianambulansT_pasien_id\").val(\"$data->pasien_id\");
                  $(\"#BKPemakaianambulansT_pendaftaran_id\").val(\"$data->pendaftaran_id\");
                  $(\"#BKPemakaianambulansT_namapasien\").val(\"$data->nama_pasien\");


                  $(\"#dialogPasien\").dialog(\"close\");    
            "))',
        ),
        'no_rekam_medik',
        'nama_pasien',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end obatAlkes dialog =============================
?>