<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jpegcam/assets/webcam.js'); ?>
<?php
    $nama_kapital = ((Yii::app()->user->getState('nama_huruf_capital') == true) ? "all-caps":"");
    $alamat_kapital = ((Yii::app()->user->getState('alamat_huruf_capital') == true) ? "all-caps":"");
    
    $konSys = KonfigsystemK::model()->find();
?>
<style>
.ui-autocomplete {
    max-height: 300px;
    overflow-y: auto;
}
</style>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->label($modJanjipoli, 'no_buatjanji2', array('class'=>'control-label',
            'label'=>'Scan Barcode'))?>
        <div class="controls">
            <?php echo $form->textField($modJanjipoli, 'no_buatjanji2', array(
                'onkeyup'=>"return $(this).focusNextInputField(event)",
                'onblur'=>"setPasienJanjiPoli(this.value);",
                'class'=>'span3',
                'readonly'=>true,
            )); ?>
        </div>
    </div>
    
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->label($modJanjipoli, 'no_buatjanji', array('class'=>'control-label',
            'label'=>'No. Buat Janji'))?>
        <div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'name'=>'no_buatjanji',
                                'value'=>$modJanjipoli->no_buatjanji,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('autocompleteJanjipoli').'",
                                                   dataType: "json",
                                                   data: {
                                                       term: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 4,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            setPasienJanjiPoli(ui.item);
                                            return false;
                                        }',
                                ),
                                // 'tombolDialog'=>array('idDialog'=>'dialogPasien'),
                                'htmlOptions'=>array('placeholder'=>'No. Buat Janji','rel'=>'tooltip','title'=>'No. RM untuk mencari pasien',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                    'onblur'=>"setPasienJanjiPoli(this.value);",
                                    'class'=>'span3'),                                    
                            )); 
            ?>                      
            <?php echo $form->hiddenField($modJanjipoli,'buatjanjipoli_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
        </div>
    </div>
</div>

<div class="clear"></div>

<div class="col-sm-6">
    
    <div class="control-group">
        <?php echo CHtml::label($modPasien->getAttributeLabel('no_rekam_medik'), 'no_rekam_medik', array('class'=>'control-label'))?>
        <div class="controls">
            <?php 
                echo $form->textField($modPasien, 'no_rekam_medik', array(
                    'class'=>'span3', 'readonly'=>true,
                )); 
            ?>
            <?php echo $form->error($modPasien,'no_rekam_medik'); ?>                        
            <?php echo $form->hiddenField($modPasien,'pasien_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($modPasien,'nama_pasien', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php 
                echo $form->textField($modPasien, 'nama_pasien', array(
                    'class'=>'span3', 'readonly'=>true,
                )); 
            ?>
        </div>
    </div>

    <?php echo $form->textFieldRow($modPasien, 'jeniskelamin',  array("readonly"=>true,'onkeyup'=>"return $(this).focusNextInputField(event)", 'onchange'=>"setNamaDepan()", 'class'=>'form-control required span3')); ?>
    
</div>
<div class="col-sm-6">
    <?php echo $form->textFieldRow($model,'umur',array("readonly"=>true,'class'=>'form-control span3 umur', 'onblur'=>'setTglLahir(this);','onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20, 'readonly'=>true)); ?>

    <?php echo $form->textAreaRow($modPasien,'alamat_pasien',array("readonly"=>true, 'placeholder'=>'Alamat Lengkap Pasien','rows'=>2, 'cols'=>60, 'class'=>'form-control autogrow span3 '.$alamat_kapital, 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    
</div>
<br>
        

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogPasien',
        'options'=>array(
            'title'=>'Pencarian Janji Poli',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>1060,
            'height'=>800,
            'resizable'=>false,
        ),
    ));
    $kec_id = null;
    $modDataPasien = new PPBuatJanjiPoliT('search');
    $modDataPasien->unsetAttributes();
    $format = new MyFormatter();
    if(isset($_GET['PPBuatJanjiPoliT'])) {
        $modDataPasien->attributes = $_GET['PPBuatJanjiPoliT'];
    }
    
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pasien-m-grid',
            'dataProvider'=>$modDataPasien->searchDialog(),
            'filter'=>$modDataPasien,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $p = PasienM::model()->findByPk($data->pasien_id);
                            return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                            "id" => "selectPasien",
                            "onClick" => "
                                setPasienJanjiPoli(\"$data->pasien_id\", ".CJSON::encode($data->attributes).");
                                $(\"#dialogPasien\").dialog(\"close\");
                            "));
                        },
                    ),
                    array(
                        'name'=>'tglbuatjanji',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglbuatjanji)',
                        'filter'=>false,
                    ),
                    array(
                        'header'=>'No. Buat Janji',
                        'name'=>'no_buatjanji',
                        'type'=>'raw',
                        'value'=>'isset($data->no_buatjanji) ? $data->no_buatjanji : ""',
                    ),
                    array(
                        'name'=>'ruangan_id',
                        'value'=>'(isset($data->ruangan->ruangan_nama) ? $data->ruangan->ruangan_nama : "-")',
                        'filter'=>CHtml::activeDropDownList($modDataPasien, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll("instalasi_id = 2 order by ruangan_nama"), 'ruangan_id', 'ruangan_nama'), array(
                            'empty'=>'-- Pilih --',
                        ))
                    ),

                     array(
                       'header'=>'No. Rekam <br> Medik',
                       'name'=>'no_rekam_medik',
                       'type'=>'raw',
                       'value'=>'(isset($data->pasien_id) ? $data->pasien->no_rekam_medik : "-") ',
                       'htmlOptions'=>array('style'=>'text-align: left')
                    ),
                    array(
                        'header'=>'Nama Pasien',
                        'name'=>'nama_pasien',
                        'type'=>'raw',
                        'value'=>'$data->getNamaAlias($data->pasien->nama_pasien,$data->pasien->nama_bin)',
                    ),
                    array(
                        'name'=>'tgljadwal',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgljadwal)',
                        'filter'=>false,
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){
                 jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
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
    
    $kec_id = null;
    $modDataPasien2 = new PPPasienM('searchDialog');
    $modDataPasien2->unsetAttributes();
    $format = new MyFormatter();
    $modDataPasien2->ispasienluar = FALSE;
    if(isset($_GET['PPPasienM'])) {
        $modDataPasien2->attributes = $_GET['PPPasienM'];
//        $modDataPasien->tanggal_lahir =  isset($_GET['PPPasienM']['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['PPPasienM']['tanggal_lahir']) : null;
        $modDataPasien2->cari_kelurahan_nama = $_GET['PPPasienM']['cari_kelurahan_nama'];
        $modDataPasien2->cari_kecamatan_nama = $_GET['PPPasienM']['cari_kecamatan_nama'];
		if(isset($_GET['PPPasienM']['nomorindukpegawai'])){
			$modDataPasien2->nomorindukpegawai = $_GET['PPPasienM']['nomorindukpegawai'];
		}
        
        $kec = KecamatanM::model()->findByAttributes(array(
            'kecamatan_nama' => $modDataPasien2->cari_kecamatan_nama
        ));
        
        if (empty($kec)) $kec_id = null;
        else $kec_id = $kec->kecamatan_id;
        
    }
    
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogPasienBadak',
        'options'=>array(
            'title'=>'Pencarian Data Pasien',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>1060,
            'height'=>800,
            'resizable'=>false,
        ),
    ));
	
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pasienbadak-m-grid',
            'dataProvider'=>$modDataPasien2->searchDialogBadak(),
            'filter'=>$modDataPasien2,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPasien",
                                        "onClick" => "
                                            setPasienLama(\"$data->pasien_id\");
                                            $(\"#dialogPasienBadak\").dialog(\"close\");
                                        "))',
                    ),
                    array(
                        'header'=>'NIP',
						'name'=> 'nomorindukpegawai',
                        'type'=>'raw',
                        'value'=>'$data->pegawai->nomorindukpegawai',
                    ),
                    'no_rekam_medik',
                    'nama_pasien',
                    'nama_bin',
                    array(
                        'name'=>'jeniskelamin',
                        'type'=>'raw',
                        'filter'=> LookupM::model()->getItems('jeniskelamin'),
                        'value'=>'$data->jeniskelamin'
                    ),
                
//                    array(
//                        'name'=>'tanggal_lahir',
//                        'type'=>'raw',
//                        'value'=>'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
//                    ),
                    array(
                        'name'=>'tanggal_lahir',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
                        'filter'=>$this->widget('MyDateTimePicker',array(
                                        'model'=>$modDataPasien2,
                                        'attribute'=>'tanggal_lahir',
                                        'mode'=>'date',
                                        'options'=> array(
                                                                'dateFormat'=>Params::DATE_FORMAT,
                                                            ),
                                        'htmlOptions'=>array('readonly'=>false, 'class'=>'dtPicker3','id'=>'tanggal_lahir','placeholder'=>'23 Jan 1993'),
                                        ),true
                                    ),
                        'htmlOptions'=>array('width'=>'80','style'=>'text-align:center'),
                    ),
                    'alamat_pasien',
                    //'rw',
                    //'rt',
                    array(
                        'header'=>'Nama Kecamatan',
                        'name'=>'cari_kecamatan_nama',
                        'type'=>'raw',
                        'value'=>'$data->kecamatan->kecamatan_nama',
                        'filter'=>CHtml::activeDropDownList($modDataPasien2, 'cari_kecamatan_nama', 
                                CHtml::listData(KecamatanM::model()->findAll(array(
                                    'condition'=>'kecamatan_aktif = true',
                                    'order'=>'kecamatan_nama asc',
                                )), 'kecamatan_nama', 'kecamatan_nama'), array(
                                    'empty'=>'-- Pilih --',
                                )),
                    ),
                    array(
                        'header'=>'Nama Kelurahan',
                        'name'=>'cari_kelurahan_nama',
                        'type'=>'raw',
                        'value'=>'isset($data->kelurahan_id) ? $data->kelurahan->kelurahan_nama : ""',
                        'filter'=>CHtml::activeDropDownList($modDataPasien2, 'cari_kelurahan_nama', 
                                CHtml::listData(KelurahanM::model()->findAllByAttributes(array(
                                    'kecamatan_id'=>$kec_id,
                                ), array(
                                    'condition'=>'kelurahan_aktif = true',
                                    'order'=>'kelurahan_nama asc',
                                )), 'kelurahan_nama', 'kelurahan_nama'), array(
                                    'empty'=>'-- Pilih --',
                                )),
                    ),
                    'norm_lama',
                    array(
                        'name'=>'statusrekammedis',
                        'type'=>'raw',
                        'filter'=> LookupM::getItems('statusrekammedis'),
                        'value'=>'$data->statusrekammedis',
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){
                 jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
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
// Dialog untuk menambah data provinsi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialog-addpropinsi',
    'options'=>array(
        'title'=>'Menambah data Provinsi',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>450,
        'minHeight'=>300,
        'resizable'=>false,
    ),
));

echo '<div class="dialog-content"></div>';

$this->endWidget();
//========= end propinsi dialog =============================

// Dialog buat nambah data kabupaten =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialog-addkabupaten',
    'options'=>array(
        'title'=>'Menambah data Kabupaten',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>450,
        'height'=>300,
        'resizable'=>false,
    ),
));

echo '<div class="dialog-content"></div>';

$this->endWidget();
//========= end kabupaten dialog =============================

// Dialog buat nambah data kecamatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogAddKecamatan',
    'options'=>array(
        'title'=>'Menambah data Kecamatan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>450,
        'height'=>300,
        'resizable'=>false,
    ),
));

echo '<div class="dialog-content"></div>';

$this->endWidget();
//========= end kecamatan dialog =============================

// Dialog buat nambah data kelurahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialog-addkelurahan',
    'options'=>array(
        'title'=>'Menambah data Kelurahan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>450,
        'height'=>300,
        'resizable'=>false,
    ),
));

echo '<div class="dialog-content"></div>';

$this->endWidget();
//========= end kelurahan dialog =============================
?>
<?php
//================= dialog webcam =====================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialog-addphoto',
    'options'=>array(
        'title'=>'Ambil Foto',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>360,
        'minHeight'=>420,
        'resizable'=>false,
    ),
));
?>

<div id="dialog-content" style="text-align: center;">
    <div id="cam-preview"></div>
    <br>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-cog icon-white"></i>')),array('rel'=>'tooltip','title'=>'Konfigurasi Kamera','class'=>'btn btn-mini btn-primary', 'type'=>'button', 'onclick'=>'webcam.configure();','style'=>'font-size:10px; width:32px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ambil',array('{icon}'=>'<i class="entypo-camera"></i>')),array('id'=>'btn_ambil_gambar','class'=>'btn btn-mini btn-primary', 'type'=>'button', 'onclick'=>'ambilGambar();','style'=>'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Simpan',array('{icon}'=>'<i class="icon-download-alt icon-white"></i>')),array('id'=>'btn_simpan_gambar','disabled'=>true,'class'=>'btn btn-mini btn-primary', 'type'=>'button', 'onclick'=>'simpanGambar();','style'=>'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('id'=>'btn_ulang_gambar','class'=>'btn btn-mini btn-danger', 'type'=>'button', 'onclick'=>'ulangGambar();','style'=>'font-size:10px; width:76px; height:24px;')); ?>
    <div id="upload_results" style="background-color:#eee; margin-top:10px"></div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
<?php
    $random=rand(0000000000000000, 9999999999999999);
?>
/**
 * ambil gambar pada webcam
 * @returns {Boolean}
 */
function ambilGambar(){
    webcam.freeze();
    $("#btn_ambil_gambar").attr("disabled",true);
    $("#btn_simpan_gambar").removeAttr("disabled");
}
/**
 * menyimpan / meng-upload gambar
 * @returns {undefined}
 */
function simpanGambar() {
    $("#btn_simpan_gambar").attr("disabled",true);
    document.getElementById('upload_results').innerHTML = '<h3>Proses Penyimpanan...</h3>';
//    webcam.snap(); << sering bugs hasil photo blank putih
    webcam.upload();
}
/**
 * mengulang pengambilan gambar
 * @returns {undefined}
 */
function ulangGambar(){
    $("#btn_ambil_gambar").removeAttr("disabled");
    $("#btn_simpan_gambar").attr("disabled",true);
    webcam.reset();
}
/**
 * keterangan setelah berhasil ambil gambar webcam
 * @returns {Boolean}
 */
function suksesUpload(msg) {
    if (msg == 'OK'){
            $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
            setTimeout(function(){
                document.getElementById('upload_results').innerHTML = '';
                $("#<?php echo CHtml::activeId($modPasien,'photopasien') ?>").val("<?php echo $random ?>.jpg")
                $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_".$random;?>.jpg');
                $('#dialog-addphoto').dialog('close');
            },3000);
            
    }else{
        myAlert("PHP Error: " + msg);
    }
}
$( document ).ready(function(){
    /**
    * set webcam
    * @returns {Boolean}
    */
    <?php if(!isset($_GET['sukses'])){ ?>
		function setWebcam(){
			webcam.set_api_url( 'index.php?r=photoWebCam/jpegcam.saveJpg&random=<?php echo $random;?>&pathTumbs=<?php echo Params::pathPasienTumbsDirectory();?>&path=<?php echo Params::pathPasienDirectory(); ?>' );
			webcam.set_quality( 90 );
			webcam.set_shutter_sound( false );
			webcam.set_stealth( 1 );
			webcam.set_swf_url('<?php echo Yii::app()->baseUrl.'/js/jpegcam/assets/'; ?>webcam.swf');
			$('#cam-preview').append(webcam.get_html(303, 320));
			webcam.set_hook( 'onComplete', 'suksesUpload' );
		}
		setWebcam();
	<?php } ?>
});
</script>
<script>
    function showDateTime(){
        $( "#PPPasienM_tanggal_lahir").datepicker();
    }
</script>

<?php //================= end dialog webcam ===================== 

if(Yii::app()->user->getState('is_finger_pasien')){
    echo $this->renderPartial('pendaftaranPenjadwalan.views.daftarSidikJariPasien._jsFunctionsFinger', array( 'modPasien'=>$modPasien,'modul_akses'=>'pendaftaran')); 
}

?>

<?php
// Dialog cetak label gelang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogLabelGelang',
    'options' => array(
        'title' => 'Label Gelang Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 640,
        'height' => 280,
        'resizable' => true,        
    ),
));
?>
<iframe name='frameLabelGelang' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
