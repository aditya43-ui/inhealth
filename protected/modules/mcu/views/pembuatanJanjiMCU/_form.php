<style type="text/css">
    .nav-tabs>.active>a,
    .nav-tabs>.active>a:hover,
    .nav-tabs>li>a {
        cursor: pointer;
    }
</style>
<?php

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'form-buat-janji-poli',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);', 'onkeyup' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '', 'onclick' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : ''),
    'focus' => '#',
)); ?>
<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data janji poli berhasil dibuat!");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<?php echo $form->errorSummary($model); ?>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php
$this->widget('bootstrap.widgets.BootTabbable', array(
    'type' => 'tabs',
    'placement' => 'above', // 'above', 'right', 'below' or 'left'
    'tabs' => array(
        array('label' => 'Langkah 1: No. Rekam Medik', 'content' => $this->renderPartial($this->path_view . '_formNoRM', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai), true)),
        array('label' => 'Langkah 2: Data Pasien', 'content' => $this->renderPartial($this->path_view . '_formDataPasien', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai), true)),
        array('label' => 'Langkah 3: Data Janji MCU', 'content' => $this->renderPartial('_formDataJanjiMCU', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai), true)), //tidak menggunakan $this->path_view karena dicopy juga di modul kecantikan
    ),
));
?>

<div class="form-actions">
    <?php
    $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
    $disableSave = false;
    $disableSave = (!empty($_GET['buatjanjipoli_id'])) ? true : (($sukses > 0) ? true : false);
    ?>
    <?php $disablePrint = ($disableSave) ? false : true; ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'title' => 'Simpan', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'disabled' => (isset($_GET['sukses'])) ? true : false)
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl(''),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Print Karcis', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printKarcis();return false", 'disabled' => $disablePrint)); ?>

    <?php
    $tips = array(
        '0' => 'simpan',
        '1' => 'ulang',
        '2' => 'print',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1060,
        'height' => 480,
        'resizable' => false,
    ),
));

$modDataPasien = new PPPasienM();
$modDataPasien->unsetAttributes();
$format = new MyFormatter();
$modDataPasien->ispasienluar = FALSE;
if (isset($_GET['PPPasienM'])) {
    $modDataPasien->attributes = $_GET['PPPasienM'];
    //        if(isset($_GET['PPPasienM']['tanggal_lahir'])){
    //			$modDataPasien->tanggal_lahir =  isset($_GET['PPPasienM']['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['PPPasienM']['tanggal_lahir']) : null;
    //		}
    if (isset($_GET['PPPasienM']['cari_kelurahan_nama'])) {
        $modDataPasien->cari_kelurahan_nama = $_GET['PPPasienM']['cari_kelurahan_nama'];
    }
    if (isset($_GET['PPPasienM']['cari_kecamatan_nama'])) {
        $modDataPasien->cari_kecamatan_nama = $_GET['PPPasienM']['cari_kecamatan_nama'];
    }
    if (isset($_GET['PPPasienM']['nomorindukpegawai'])) {
        $modDataPasien->nomorindukpegawai = $_GET['PPPasienM']['nomorindukpegawai'];
    }
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-m-grid',
    'dataProvider' => $modDataPasien->searchDialog1(),
    'filter' => $modDataPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
					"id" => "selectPasien",
					"onClick" => "
						$(\"#dialogPasien\").dialog(\"close\");
						$(\"#' . CHtml::activeId($model, 'pasien_id') . '\").val(\"$data->pasien_id\");
						$(\"#no_rekam_medik\").val(\"$data->no_rekam_medik\");
						$(\"#' . CHtml::activeId($modPasien, 'nama_pasien') . '\").val(\"$data->nama_pasien\");
						$(\"#' . CHtml::activeId($modPasien, 'jenisidentitas') . '\").val(\"$data->jenisidentitas\");
						$(\"#' . CHtml::activeId($modPasien, 'no_identitas_pasien') . '\").val(\"$data->no_identitas_pasien\");
						$(\"#' . CHtml::activeId($modPasien, 'namadepan') . '\").val(\"$data->namadepan\");
						$(\"#' . CHtml::activeId($modPasien, 'nama_pasien') . '\").val(\"$data->nama_pasien\");
						$(\"#' . CHtml::activeId($modPasien, 'nama_bin') . '\").val(\"$data->nama_bin\");
						$(\"#' . CHtml::activeId($modPasien, 'tempat_lahir') . '\").val(\"$data->tempat_lahir\");
						$(\"#' . CHtml::activeId($modPasien, 'tanggal_lahir') . '\").val(\"$data->tanggal_lahir\");
						$(\"#' . CHtml::activeId($modPasien, 'kelompokumur_id') . '\").val(\"$data->kelompokumur_id\");
						$(\"#' . CHtml::activeId($modPasien, 'jeniskelamin') . '\").val(\"$data->jeniskelamin\");
						$(\"#' . CHtml::activeId($modPasien, 'statusperkawinan') . '\").val(\"$data->statusperkawinan\");
						$(\"#' . CHtml::activeId($modPasien, 'golongandarah') . '\").val(\"$data->golongandarah\");
						$(\"#' . CHtml::activeId($modPasien, 'rhesus') . '\").val(\"$data->rhesus\");
						$(\"#' . CHtml::activeId($modPasien, 'alamat_pasien') . '\").val(\"$data->alamat_pasien\");
						$(\"#' . CHtml::activeId($modPasien, 'rt') . '\").val(\"$data->rt\");
						$(\"#' . CHtml::activeId($modPasien, 'rw') . '\").val(\"$data->rw\");
						$(\"#' . CHtml::activeId($modPasien, 'propinsi_id') . '\").val(\"$data->propinsi_id\");
						$(\"#' . CHtml::activeId($modPasien, 'kabupaten_id') . '\").val(\"$data->kabupaten_id\");
						$(\"#' . CHtml::activeId($modPasien, 'kecamatan_id') . '\").val(\"$data->kecamatan_id\");
						$(\"#' . CHtml::activeId($modPasien, 'kelurahan_id') . '\").val(\"$data->kelurahan_id\");
						$(\"#' . CHtml::activeId($modPasien, 'no_telepon_pasien') . '\").val(\"$data->no_telepon_pasien\");
						$(\"#' . CHtml::activeId($modPasien, 'no_mobile_pasien') . '\").val(\"$data->no_mobile_pasien\");
						$(\"#' . CHtml::activeId($modPasien, 'suku_id') . '\").val(\"$data->suku_id\");
						$(\"#' . CHtml::activeId($modPasien, 'alamatemail') . '\").val(\"$data->alamatemail\");
						$(\"#' . CHtml::activeId($modPasien, 'anakke') . '\").val(\"$data->anakke\");
						$(\"#' . CHtml::activeId($modPasien, 'jumlah_bersaudara') . '\").val(\"$data->jumlah_bersaudara\");
						$(\"#' . CHtml::activeId($modPasien, 'pendidikan_id') . '\").val(\"$data->pendidikan_id\");
						$(\"#' . CHtml::activeId($modPasien, 'pekerjaan_id') . '\").val(\"$data->pekerjaan_id\");
						$(\"#' . CHtml::activeId($modPasien, 'agama') . '\").val(\"$data->agama\");
						$(\"#' . CHtml::activeId($modPasien, 'warga_negara') . '\").val(\"$data->warga_negara\");
						setNip(\"$data->pegawai_id\"); checkedRM(); pilihNoRm();
						loadUmur(\"$data->tanggal_lahir\");
						setJenisKelaminPasien(\"$data->jeniskelamin\");
						setRhesusPasien(\"$data->rhesus\");
						loadDaerahPasien($data->propinsi_id,$data->kabupaten_id,$data->kecamatan_id,$data->pasien_id);
					"))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'type' => 'raw',
            'value' => 'isset($data->pegawai->nomorindukpegawai) ? $data->pegawai->nomorindukpegawai : ""',
        ),
        'no_rekam_medik',
        'nama_pasien',
        'nama_bin',
        array(
            'name' => 'jeniskelamin',
            'type' => 'raw',
            //				'filter'=> LookupM::model()->getItems('jeniskelamin'),
            'filter' => CHtml::dropDownList('PPPasienM[jeniskelamin]', $modDataPasien->jeniskelamin, LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --')),
            'value' => '$data->jeniskelamin'
        ),
        array(
            'name' => 'tanggal_lahir',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
            'filter' => $this->widget(
                'MyDateTimePicker',
                array(
                    'model' => $modDataPasien,
                    'attribute' => 'tanggal_lahir',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => false, 'class' => 'span3 dtPicker3', 'id' => 'tanggal_lahir', 'placeholder' => '23 Jan 1993'),
                ),
                true
            ),
            'htmlOptions' => array('width' => '80', 'style' => 'text-align:center'),
        ),
        'alamat_pasien',
        'rw',
        'rt',
        array(
            'header' => 'Nama Kelurahan',
            'name' => 'cari_kelurahan_nama',
            'type' => 'raw',
            'value' => 'isset($data->kelurahan_id) ? $data->kelurahan->kelurahan_nama : ""'
        ),
        array(
            'header' => 'Nama Kecamatan',
            'name' => 'cari_kecamatan_nama',
            'type' => 'raw',
            'value' => 'isset($data->kecamatan_id) ? $data->kecamatan->kecamatan_nama : ""'
        ),
        'norm_lama',
        array(
            'name' => 'statusrekammedis',
            'type' => 'raw',
            //				'filter'=> LookupM::getItems('statusrekammedis'),
            'filter' => CHtml::dropDownList('PPPasienM[statusrekammedis]', $modDataPasien->statusrekammedis, LookupM::model()->getItems('statusrekammedis'), array('empty' => '-- Pilih --')),
            'value' => '$data->statusrekammedis',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
			 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
			 jQuery(\'#tanggal_lahir\').datepicker(jQuery.extend({
					showMonthAfterYear:false}, 
					jQuery.datepicker.regional[\'id\'], 
				   {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
				   \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
				   \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
			jQuery(\'#tanggal_lahir_date\').on(\'click\', function(){jQuery(\'#tanggal_lahir\').datepicker(\'show\');});

		}',
));
$this->endWidget();
?>