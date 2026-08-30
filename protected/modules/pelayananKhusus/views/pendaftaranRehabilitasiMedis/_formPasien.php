<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/protected/extensions/jpegcam/assets/webcam.js'); ?>
<?php
    $nama_kapital = ((Yii::app()->user->getState('nama_huruf_capital') == true) ? "all-caps":"");
    $alamat_kapital = ((Yii::app()->user->getState('alamat_huruf_capital') == true) ? "all-caps":"");
?>

<div class = "col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("Cari ".$modPasien->getAttributeLabel('no_rekam_medik'), 'no_rekam_medik', array('class'=>'control-label'))?>
        <div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'name'=>'cari_no_rekam_medik',
                                'value'=>$modPasien->no_rekam_medik,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompletePasienLama').'",
                                                   dataType: "json",
                                                   data: {
                                                       no_rekam_medik: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 3,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            setPasienLama(ui.item.pasien_id,ui.item.no_rekam_medik);
                                            return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogPasien'),
                                'htmlOptions'=>array('placeholder'=>'Ketik No. Rekam Medik','rel'=>'tooltip','title'=>'Ketik No. RM untuk mencari pasien',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
//                                    'onblur'=>"if($(this).val()=='') setPasienBaru(); else setPasienLama('',this.value)",
                                    'class'=>'all-caps'),
                            )); 
            ?>
            <?php echo $form->error($modPasien,'no_rekam_medik'); ?>                        
            <?php echo $form->hiddenField($modPasien,'pasien_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
        </div>
    </div>

    <div class="control-group ">
        <?php echo $form->labelEx($modPasien,'no_identitas_pasien', array('class'=>'control-label refreshable')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPasien,'jenisidentitas', LookupM::getItems('jenisidentitas'),  
                        array(
                            'empty'=>'-- Pilih --', 
                            'onkeyup'=>"return $(this).focusNextInputField(event)", 
                            'class'=>'span1',
                            'style'=>'float:left; width:80px',
                            'onchange'=>'cekLength(this);')); ?>   
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modPasien,
                                'attribute'=>'no_identitas_pasien',
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompletePasienLama').'",
                                                   dataType: "json",
                                                   data: {
                                                       no_identitas_pasien: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 3,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.no_identitas_pasien);
                                            setPasienLama(ui.item.pasien_id);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array(                                    
                                    'placeholder'=>'No. Identitas Pasien',
                                    'rel'=>'tooltip',
                                    'title'=>'Ketik No. Identitas untuk masukan data / mencari pasien',
                                    'onkeyup'=>"setNumbersOnly(this);return $(this).focusNextInputField(event);",
                                    'class'=>'span3  all-caps nik'),
                            )); 
            ?>

            <?php echo $form->error($modPasien,'jenisidentitas'); ?>
            <?php echo $form->error($modPasien,'no_identitas_pasien'); ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo $form->labelEx($modPasien,'nama_pasien', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPasien,'namadepan', LookupM::getItems('namadepan'),  
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1','style'=>'float:left; width:80px')); ?>   
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modPasien,
                                'attribute'=>'nama_pasien',
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompletePasienLama').'",
                                                   dataType: "json",
                                                   data: {
                                                       nama_pasien: request.term,
                                                       tanggal_lahir: $("#'.CHtml::activeId($modPasien,'tanggal_lahir').'").val(),
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 3,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.nama_pasien);
                                            setPasienLama(ui.item.pasien_id);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array(
                                    'placeholder'=>'Nama Lengkap Pasien',
                                    'rel'=>'tooltip',
                                    'title'=>'Ketik Nama untuk masukan data / mencari pasien',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                    'onblur'=>'setNamaPemilikUntukCaraBayar()',
                                    'class'=>'span3 '.$nama_kapital
                                ),
                            )); 
            ?>
            <?php echo $form->error($modPasien,'namadepan'); ?>
            <?php echo $form->error($modPasien,'nama_pasien'); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($modPasien,'nama_bin',array('placeholder'=>'Alias / Nama Panggilan Pasien','class'=>'span3 '.$nama_kapital, 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($modPasien,'tempat_lahir',array('placeholder'=>'Kota/Kabupaten Kelahiran','class'=>'span3 all-caps', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>25)); ?>
    <div class="control-group ">
        <?php echo $form->labelEx($modPasien,'tanggal_lahir', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php   
            $modPasien->tanggal_lahir = (!empty($modPasien->tanggal_lahir) ? date("d/m/Y",strtotime($modPasien->tanggal_lahir)) : null);
            $this->widget('MyDateTimePicker',array(
                                    'model'=>$modPasien,
                                    'attribute'=>'tanggal_lahir',
                                    'mode'=>'date',
                                    'options'=> array(
//                                            'dateFormat'=>Params::DATE_FORMAT,
                                        'showOn' => false,
                                        'maxDate' => 'd',
                                        'onkeyup'=>"js:function(){setUmur(this.value);}",
                                        'onSelect'=>'js:function(){setUmur(this.value);}',
                                        'yearRange'=> "-150:+0",
                                    ),
                                    'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onblur'=>'setUmur(this.value);','onkeyup'=>"return $(this).focusNextInputField(event)"
                                    ),
            )); ?>
            <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
        </div>
    </div>

    <?php echo $form->textFieldRow($model,'umur',array('placeholder'=>'00 Thn 00 Bln 00 Hr','class'=>'span3 umur', 'onblur'=>'setTglLahir(this);','onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>

    <?php echo $form->radioButtonListInlineRow($modPasien, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup'=>"return $(this).focusNextInputField(event)", 'onchange'=>"setNamaDepan()", 'class'=>'')); ?>
    <div class="control-group ">
        <?php echo $form->labelEx($modPasien,'golongandarah', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPasien,'golongandarah', LookupM::getItems('golongandarah'),  
                                          array('empty'=>'- Pilih -', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1')); ?>   
            <div class="radio inline">
                <div class="form-inline">
                <?php echo $form->radioButtonList($modPasien,'rhesus',LookupM::getItems('rhesus'), array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'rhesus')); ?>            
                </div>
            </div>
            <?php echo $form->error($modPasien, 'golongandarah'); ?>
            <?php echo $form->error($modPasien, 'rhesus'); ?>
        </div>
    </div>
    <?php echo $form->dropDownListRow($modPasien,'statusperkawinan', LookupM::getItems('statusperkawinan'),array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'onchange'=>'setNamaDepan()','class'=>'span3')); ?>
    <?php echo $form->textFieldRow($modPasien,'nama_ibu',array('placeholder'=>'Nama Ibu Kandung Pasien','class'=>'span3 '.$nama_kapital, 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
</div>
<div class = "col-sm-6">
    <?php echo  $form->hiddenField($modPasien,'photopasien',array('readonly'=>true,'class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
        <div align="center">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ambil Foto',array('{icon}'=>'<i class="icon-camera icon-white"></i>')), 
                        array('class'=>'btn btn-primary','onclick'=>"$('#dialog-addphoto').dialog('open');",
                              'id'=>'btn-addphoto','onkeyup'=>"return $(this).focusNextInputField(event)",
                              'rel'=>'tooltip','title'=>'Klik untuk Ambil Foto')) ?>
            <br>
            <?php 
            $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory()."kecil_".$modPasien->photopasien : Params::urlPhotoPasienDirectory()."no_photo.jpeg");
            ?>
            <img id="photo-preview" src="<?php echo $url_photopasien?>"width="84px"/> 
        </div>
    <?php echo $form->textAreaRow($modPasien,'alamat_pasien',array('placeholder'=>'Alamat Lengkap Pasien','rows'=>2, 'cols'=>50, 'class'=>'span3 '.$alamat_kapital, 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <div class="control-group ">
        <?php echo $form->labelEx($modPasien,'rt', array('class'=>'control-label inline')) ?>
        <div class="controls">
            <?php echo $form->textField($modPasien,'rt', array('onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numbers-only','maxlength'=>3,'placeholder'=>'RT')); ?>   / 
            <?php echo $form->textField($modPasien,'rw', array('onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numbers-only','maxlength'=>3,'placeholder'=>'RW')); ?>            
            <?php echo $form->error($modPasien, 'rt'); ?>
            <?php echo $form->error($modPasien, 'rw'); ?>
        </div>
    </div>

    <div class="control-group ">
        <?php echo $form->labelEx($modPasien,'propinsi_id', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPasien,'propinsi_id', CHtml::listData($modPasien->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), 
                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                'ajax'=>array('type'=>'POST',
                                            'url'=>$this->createUrl('SetDropdownKabupaten',array('encode'=>false,'model_nama'=>get_class($modPasien))),
                                            'update'=>"#".CHtml::activeId($modPasien, 'kabupaten_id'),
                                ),
                                'onchange'=>"setClearDropdownKelurahan();setClearDropdownKecamatan();",));?>
            <?php echo $form->error($modPasien, 'propinsi_id'); ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo $form->labelEx($modPasien,'kabupaten_id', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPasien,'kabupaten_id', CHtml::listData($modPasien->getKabupatenItems($modPasien->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), 
                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                'ajax'=>array('type'=>'POST',
                                            'url'=>$this->createUrl('SetDropdownKecamatan',array('encode'=>false,'model_nama'=>get_class($modPasien))),
                                            'update'=>"#".CHtml::activeId($modPasien, 'kecamatan_id'),
                                ),
                                'onchange'=>"setClearDropdownKelurahan();",));?>
            <?php echo $form->error($modPasien, 'kabupaten_id'); ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo $form->labelEx($modPasien,'kecamatan_id', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPasien,'kecamatan_id', CHtml::listData($modPasien->getKecamatanItems($modPasien->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'), 
                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                'ajax'=>array('type'=>'POST',
                                            'url'=>$this->createUrl('SetDropdownKelurahan',array('encode'=>false,'model_nama'=>get_class($modPasien))),
                                            'update'=>"#".CHtml::activeId($modPasien, 'kelurahan_id'),
                                ),
                                'onchange'=>"",));?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo $form->labelEx($modPasien,'kelurahan_id', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php // $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id))?$modPasien->kelurahan_id:Yii::app()->user->getState('kelurahan_id');?>
            <?php echo $form->dropDownList($modPasien,'kelurahan_id',CHtml::listData($modPasien->getKelurahanItems($modPasien->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'),
                                              array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->error($modPasien, 'kelurahan_id'); ?>
        </div>
    </div>

    <?php echo $form->textFieldRow($modPasien,'no_mobile_pasien',array('placeholder'=>'No. Ponsel yang bisa dihubungi','class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
    <?php echo $form->textFieldRow($modPasien,'no_telepon_pasien',array('placeholder'=>'No. Telepon yang bisa dihubungi','class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>15)); ?>
	<div class="control-group ">
		<?php echo $form->labelEx($modPasien,'pekerjaan_id', array('class'=>'control-label refreshable')) ?>
		<div class="controls">
			<?php echo $form->dropDownList($modPasien,'pekerjaan_id', CHtml::listData($modPasien->getPekerjaanItems(), 'pekerjaan_id', 'pekerjaan_nama'),array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
		</div>
	</div>    
    <?php echo $form->dropDownListRow($modPasien,'warga_negara', LookupM::getItems('warganegara'),array('class'=>'span3','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
	<div class="control-group ">
		<?php echo $form->labelEx($modPasien,'agama', array('class'=>'control-label refreshable')) ?>
		<div class="controls">
			<?php echo $form->dropDownList($modPasien,'agama', LookupM::getItems('agama'),array('class'=>'span3','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
		</div>
	</div>
    
</div>
<div class="clear"></div>
<div class = "col-sm-6">
        
        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'form-detailpasien',
            'content'=>array(
                'content-detailpasien'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan detail pasien')).'<b> Detail Pasien</b>',
                    'isi'=>$this->renderPartial($this->path_view.'_formDetailPasien',array(
                            'form'=>$form,
                            'model'=>$model,
                            'modPasien' => $modPasien,
                            'nama_kapital' => $nama_kapital,
                            ),true),
                    'active'=>false,
                    ),   
                ),
        )); ?>

</div>
        

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogPasien',
        'options'=>array(
            'title'=>'Pencarian Data Pasien Rehabilitasi Medis',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>960,
            'height'=>480,
            'resizable'=>false,
        ),
    ));
        $modDataPasien = new RMPasienM('searchDialog');
        $modDataPasien->unsetAttributes();
        if(isset($_GET['RMPasienM'])) {
            $modDataPasien->attributes = $_GET['RMPasienM'];
            $modDataPasien->cari_kelurahan_nama = $_GET['RMPasienM']['cari_kelurahan_nama'];
            $modDataPasien->cari_kecamatan_nama = $_GET['RMPasienM']['cari_kecamatan_nama'];
        }
        $modDataPasien->ispasienluar = true;
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
					'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
									"id" => "selectPasien",
									"onClick" => "
										setPasienLama(\"$data->pasien_id\");
										$(\"#dialogPasien\").dialog(\"close\");
									"))',
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
				'alamat_pasien',
				array(
					'header'=>'RT',
					'name'=>'rt',
					'type'=>'raw',
					'value'=>'$data->rt'
				),
				array(
					'header'=>'RW',
					'name'=>'rw',
					'type'=>'raw',
					'value'=>'$data->rw'
				),					
				array(
					'header'=>'Nama Kelurahan',
					'name'=>'cari_kelurahan_nama',
					'type'=>'raw',
					'value'=>'isset($data->kelurahan_id) ? $data->kelurahan->kelurahan_nama : ""'
				),
				array(
					'header'=>'Nama Kecamatan',
					'name'=>'cari_kecamatan_nama',
					'type'=>'raw',
					'value'=>'$data->kecamatan->kecamatan_nama'
				),
				'norm_lama',
				array(
					'name'=>'statusrekammedis',
					'type'=>'raw',
					'filter'=> LookupM::getItems('statusrekammedis'),
					'value'=>'$data->statusrekammedis',
				),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
        $this->endWidget();
?>
<?php
//================= dialog webcam =====================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialog-addphoto',
    'options'=>array(
        'title'=>'Ambil Photo',
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
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ambil',array('{icon}'=>'<i class="icon-camera icon-white"></i>')),array('id'=>'btn_ambil_gambar','class'=>'btn btn-mini btn-primary', 'type'=>'button', 'onclick'=>'ambilGambar();','style'=>'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Simpan',array('{icon}'=>'<i class="icon-download-alt icon-white"></i>')),array('id'=>'btn_simpan_gambar','disabled'=>true,'class'=>'btn btn-mini btn-primary', 'type'=>'button', 'onclick'=>'simpanGambar();','style'=>'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('id'=>'btn_ulang_gambar','class'=>'btn btn-mini btn-danger', 'type'=>'button', 'onclick'=>'ulangGambar();','style'=>'font-size:10px; width:76px; height:24px;')); ?>
    <div id="upload_results" style="background-color:#eee; margin-top:10px"></div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
<?php
    $random=rand(000000000, 999999999);
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
});
</script>

<?php //================= end dialog webcam ===================== ?>