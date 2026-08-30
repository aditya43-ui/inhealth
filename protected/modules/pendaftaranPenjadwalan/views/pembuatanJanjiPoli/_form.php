<style type="text/css">
    .nav-tabs>.active>a,
    .nav-tabs>.active>a:hover,
    .nav-tabs>li>a {
        cursor: pointer;
    }
</style>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'form-buat-janji-poli',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>
<?php
if (isset($_GET['ok'])) {
    Yii::app()->user->setFlash('success', "Data Pasien " . $model->pasien->nama_pasien . " berhasil disimpan");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $form->errorSummary($model); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php
$this->widget('bootstrap.widgets.BootTabbable', array(
    'type' => 'tabs',
    'placement' => 'above', // 'above', 'right', 'below' or 'left'
    'tabs' => array(
        array('label' => 'Langkah 1: Data Janji Poliklinik', 'content' => $this->renderPartial('_formDataJanjiPoli', array('grid' => $grid, 'form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai), true)),
        array('label' => 'Langkah 2: Data Pasien', 'content' => $this->renderPartial('_formDataPasien', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai, 'modPenjamin' =>$modPenjamin), true)),
        // array('label' => 'Langkah 3: Data Rekam Medis', 'content' => $this->renderPartial('_formNoRM', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai), true)),

    ),
));
?>

<div class="form-actions">
    <?php
    $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
    $disableSave = false;
    $disableSave = (!empty($_GET['buatjanjipoli_id'])) ? true : (($sukses > 0) ? true : false);
    ?>
    <?php $disablePrint = isset($_GET['ok']) ? false : true; ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array(
            'title' => 'Simpan',
            'class' => 'btn btn-danger',
            'type' => 'submit',
            'onKeypress' => 'return formSubmit(this,event)',
            'id' => 'btn_simpan',
            'disabled' => $disableSave
        )
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Print Karcis', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printKarcis();return false", 'disabled' => $disablePrint)); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Kirim WhatsApp', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-succes', 'id' => 'tombolwa', 'onclick' => "kirimWA();return ", 'style' => 'background-color:green;')); ?>

    <?php
    $content = $this->renderPartial('../tips/transaksi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php
//========= Dialog buat cari data pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
    ),
));

$modDataPasien = new PPPasienM('searchWithDaerah');
$modDataPasien->unsetAttributes();
if (isset($_GET['PPPasienM'])) {
    $modDataPasien->attributes = $_GET['PPPasienM'];
    if (isset($_GET['PPPasienM']['tanggal_lahir'])) {
        $modDataPasien->tanggal_lahir = MyFormatter::formatDateTimeForDB($_GET['PPPasienM']['tanggal_lahir']);
    }
}
if (!empty($modDataPasien->tanggal_lahir)) {
    $modDataPasien->tanggal_lahir = MyFormatter::formatDateTimeForUser($modDataPasien->tanggal_lahir);
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-m-grid',
    'dataProvider' => $modDataPasien->searchWithDaerah(),
    'filter' => $modDataPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
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
				loadUmur(\"$data->tanggal_lahir\");
				setJenisKelaminPasien(\"$data->jeniskelamin\");
				setRhesusPasien(\"$data->rhesus\");
                                setAsuransiPasienLama(\"$data->pasien_id\");
				loadDaerahPasien($data->propinsi_id,$data->kabupaten_id,$data->kecamatan_id,$data->pasien_id);

			"))',
        ),
        'no_rekam_medik',
        'nama_pasien',
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
        // 'tanggal_lahir',
        'alamat_pasien',
        array(
            'header'=>'RT',
            'name'=>'rt',
            'type'=>'raw',
            'value'=>'$data->rt',

        ),
        // 'rt',
        array(
            'header'=>'RW',
            'name'=>'rw',
            'type'=>'raw',
            'value'=>'$data->rw',

        ),
        // 'rw',
        array(
            'name' => 'propinsiNama',
            'value' => '$data->propinsi->propinsi_nama',
        ),
        array(
            'name' => 'kabupatenNama',
            'value' => '$data->kabupaten->kabupaten_nama',
        ),
        array(
            'name' => 'kecamatanNama',
            'value' => '$data->kecamatan->kecamatan_nama',
        ),
        array(
            'name' => 'kelurahanNama',
            'value' => '(isset($data->kelurahan_id) ? $data->kelurahan->kelurahan_nama : "")',
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

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasienBadak',
    'options' => array(
        'title' => 'Pencarian No. Badge Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1060,
        'height' => 480,
        'resizable' => false,
    ),
));

$pasienBadak = new PPPasienM('searchDialog');
$pasienBadak->unsetAttributes();
$format = new MyFormatter();
$pasienBadak->ispasienluar = FALSE;
if (isset($_GET['PPPasienM'])) {
    $pasienBadak->attributes = $_GET['PPPasienM'];
           $modDataPasien->tanggal_lahir =  isset($_GET['PPPasienM']['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['PPPasienM']['tanggal_lahir']) : null;
    $pasienBadak->kelurahanNama = $_GET['PPPasienM']['kelurahanNama'];
    $pasienBadak->kecamatanNama = $_GET['PPPasienM']['kecamatanNama'];
    // $pasienBadak->nama_bin = $_GET['PPPasienM']['nama_bin'];

    $pasienBadak->tanggal_lahir = !empty($pasienBadak->tanggal_lahir) ? MyFormatter::formatDateTimeForDb($pasienBadak->tanggal_lahir) : null;

    if (isset($_GET['PPPasienM']['nomorindukpegawai'])) {
        $pasienBadak->nomorindukpegawai = $_GET['PPPasienM']['nomorindukpegawai'];
    }
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasienbadak-m-grid',
    'dataProvider' => $pasienBadak->searchDialogBadak(),
    'filter' => $pasienBadak,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
					"id" => "selectPasien",
					"onClick" => "
						$(\"#dialogPasienBadak\").dialog(\"close\");
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
                                                setAsuransiPasienLama(\"$data->pasien_id\");
						loadDaerahPasien($data->propinsi_id,$data->kabupaten_id,$data->kecamatan_id,$data->pasien_id);
					"))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'type' => 'raw',
            'value' => '!empty($data->pegawai_id)?$data->pegawai->nomorindukpegawai:""',
        ),
        'no_rekam_medik',
        'nama_pasien',
        'nama_bin',
        array(
            'name' => 'jeniskelamin',
            'type' => 'raw',
            'filter' => CHtml::dropDownList('PPPasienM[jeniskelamin]', $pasienBadak->jeniskelamin, LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --')),
            'value' => '$data->jeniskelamin'
        ),

        array(
            'name' => 'tanggal_lahir',
            'value' => '!empty($data->tanggal_lahir)?MyFormatter::formatDateTimeForUser($data->tanggal_lahir):""',
            'filter' => $this->widget(
                'MyDateTimePicker',
                array(
                    'model' => $pasienBadak,
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
            'value' => '$data->kecamatan->kecamatan_nama'
        ),
        'norm_lama',
        array(
            'name' => 'statusrekammedis',
            'type' => 'raw',
            'filter' => CHtml::dropDownList('PPPasienM[statusrekammedis]', $pasienBadak->jeniskelamin, LookupM::getItems('statusrekammedis'), array('empty' => '-- Pilih --')),
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
<script>
    $(document).ready(function() {
        jQuery("input#tanggal_lahir").datepicker(jQuery.extend({
            showMonthAfterYear: false
        }, jQuery.datepicker.regional["id"], {
            "dateFormat": "dd M yy",
            "maxDate": "d",
            "timeText": "Waktu",
            "hourText": "Jam",
            "minuteText": "Menit",
            "secondText": "Detik",
            "showSecond": true,
            "timeOnlyTitle": "Pilih Waktu",
            "timeFormat": "hh:mm:ss",
            "changeYear": true,
            "changeMonth": true,
            "showAnim": "fold",
            "yearRange": "-80y:+20y"
        }));
        //        jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tgl_pendaftaran') . '_date").on("click", function(){jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tgl_pendaftaran') . '").datepicker("show");});
        jQuery("input#tanggal_lahir").datepicker({
            "maxDate": "' . date('m/d/Y') . '",
            "showDropdowns": true,
        });

        // setPlaceHolderNomor();
    });

    function showDateTime() {
        $("#PPPasienM_tanggal_lahir").datepicker();
    }

    function setMultiRuangan() {

        var ruangan = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');	
           jQuery(ruangan).multiselect({
                   includeSelectAllOption: false,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();
    }

    function setMultiPegawai() {

    var pegawai = jQuery('#<?php echo CHtml::activeId($model, 'pegawai_id') ?>');	
       jQuery(pegawai).multiselect({
               includeSelectAllOption: false,
               buttonClass: "form-control",
               maxHeight: 300,
               buttonWidth: '182px',
               enableCaseInsensitiveFiltering: true
       }).hide();
    }

    $(document).ready(function () {

        setMultiRuangan();
        setMultiPegawai();

        <?php if(isset($_GET['ok'])):?>
            $('a[href^="#yw2_tab_2"]').trigger('click');
        <?php else:?>
            $('.form-actions').addClass('hide');
        <?php endif;?>

        $('a[href^="#yw2_tab_1"]').click(function() {
            $('.form-actions').addClass('hide');
        });

        $('a[href^="#yw2_tab_2"]').click(function() {
            $('.form-actions').removeClass('hide');
            $('#ui-datepicker-div').addClass('hide');
            if(!requiredCheck($('#fieldsetPoli'))) {
                $('.form-actions').addClass('hide');
                return false;
            }
        });

        $('#PPBuatJanjiPoliT_tgljadwal_0').click(function() {
            $('#ui-datepicker-div').removeClass('hide');
        });
        
    });
</script>