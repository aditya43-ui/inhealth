<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'ppbuat-janji-poli-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($modPPBuatJanjiPoli); ?>
     
        
                    <?php echo $this->renderPartial($this->path_view.'_formPasien', array('model'=>$model,'form'=>$form,'modPasien'=>$modPasien,'format'=>$format)); ?>
                
                    <fieldset>
                        <legend class="rim"> 
			Masukan Data Janji &nbsp;

													<?php  echo $form->checkBox($modPPBuatJanjiPoli,'byphone', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
													<i class="icon-phone"></i> <?php echo $modPPBuatJanjiPoli->getAttributeLabel('byphone'); ?>
                                                    <?php echo $form->error($modPPBuatJanjiPoli, 'byphone'); ?>


						</legend>
						
						
						
						
                            <table>
                                <tr>

                                    <td>
                                            <?php echo $form->dropDownListRow($modPPBuatJanjiPoli,'ruangan_id', CHtml::listData($modPPBuatJanjiPoli->getRuanganItems(), 'ruangan_id', 'ruangan_nama') ,
                                                                          array('empty'=>'-- Pilih --',
                                                                                 'onchange'=>"listDokterRuangan(this.value);",
                                                                                 'ajax'=>array(),

                                                                                'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>    
                                            <?php echo $form->dropDownListRow($modPPBuatJanjiPoli,'pegawai_id', array() ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>

                                            <div class="control-group ">
                                                <?php echo $form->labelEx($modPPBuatJanjiPoli,'tgljadwal', array('class'=>'control-label')) ?>
                                                    <div class="controls">
                                                        <?php   
                                                                $this->widget('MyDateTimePicker',array(
                                                                                'model'=>$modPPBuatJanjiPoli,
                                                                                'attribute'=>'tgljadwal',
                                                                                'mode'=>'datetime',
                                                                                'options'=> array(
                                                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                                                    'minDate' => 'd',
                                                                                    'onkeypress'=>"js:function(){getUmur(this);}",
                                                                                    'onSelect'=>'js:function(){hariBaru(this);}',
                                                                                ),
                                                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                                                ),
                                                        )); ?>
                                                        <?php echo $form->error($modPPBuatJanjiPoli, 'tgljadwal'); ?>
                                                    </div>
                                      </div>
                                                        <?php echo $form->textFieldRow($modPPBuatJanjiPoli,'harijadwal',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20,'readonly'=>TRUE)); ?>
                                                        <?php echo $form->textAreaRow($modPPBuatJanjiPoli,'keteranganbuatjanji',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                                        <?php  //echo $form->checkBoxRow($modPPBuatJanjiPoli,'byphone', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
											
                                    </td>
                                </tr>
                            </table>
                    </fieldset>
                </td>
            </tr>
        </table>
   
             <div class="form-actions">
                 <?php
                 if ($modPPBuatJanjiPoli->isNewRecord) {
	    echo CHtml::htmlButton($modPPBuatJanjiPoli->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)'));
                 } else {
	    echo CHtml::htmlButton($modPPBuatJanjiPoli->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','disabled'=>true));
                 }
                 ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('buatJanjiPoliT/create'), array('class'=>'btn btn-danger')); ?>
                  <?php if((!$modPPBuatJanjiPoli->isNewRecord) AND (Yii::app()->user->getState('printkartulsng')==TRUE))                   {
                          
                ?>
                            <script>
                                print(<?php echo $modPPBuatJanjiPoli->buatjanjipoli_id ?>);
                            </script>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"print('$modPPBuatJanjiPoli->buatjanjipoli_id');return false",'disabled'=>FALSE  )); 
                       }else{
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), '#', array('class'=>'btn btn-info','disabled'=>TRUE  )); 
                       } 
                ?>
				<?php 
$content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.transaksi',array(),true);
$this->widget('UserTips',array('type'=>'create','content'=>$content));?>
	</div>

<?php $this->endWidget(); ?>
<?php 
//========= Dialog buat cari data pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPasien',
    'options'=>array(
        'title'=>'Pencarian Data Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>1000,
        'height'=>500,
        'resizable'=>false,
    ),
));

$modDataPasien = new PPPasienM('searchWithDaerah');
$modDataPasien->unsetAttributes();
if(isset($_GET['PPPasienM'])) {
    $modDataPasien->attributes = $_GET['PPPasienM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pasien-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modDataPasien->searchWithDaerah(),
	'filter'=>$modDataPasien,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                        array(
                            'header'=>'Pilih',
                            'type'=>'raw',
                            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                            "id" => "selectPasien",
                                            "onClick" => "
                                                $(\"#dialogPasien\").dialog(\"close\");
                                                $(\"#'.CHtml::activeId($modPPBuatJanjiPoli,'pasien_id').'\").val(\"$data->pasien_id\");
                                                $(\"#no_rekam_medik\").val(\"$data->no_rekam_medik\");
                                                $(\"#'.CHtml::activeId($modPasien,'nama_pasien').'\").val(\"$data->nama_pasien\");
                                                $(\"#'.CHtml::activeId($modPasien,'jenisidentitas').'\").val(\"$data->jenisidentitas\");
                                                $(\"#'.CHtml::activeId($modPasien,'no_identitas_pasien').'\").val(\"$data->no_identitas_pasien\");
                                                $(\"#'.CHtml::activeId($modPasien,'namadepan').'\").val(\"$data->namadepan\");
                                                $(\"#'.CHtml::activeId($modPasien,'nama_pasien').'\").val(\"$data->nama_pasien\");
                                                $(\"#'.CHtml::activeId($modPasien,'nama_bin').'\").val(\"$data->nama_bin\");
                                                $(\"#'.CHtml::activeId($modPasien,'tempat_lahir').'\").val(\"$data->tempat_lahir\");
                                                $(\"#'.CHtml::activeId($modPasien,'tanggal_lahir').'\").val(\"$data->tanggal_lahir\");
                                                $(\"#'.CHtml::activeId($modPasien,'kelompokumur_id').'\").val(\"$data->kelompokumur_id\");
                                                $(\"#'.CHtml::activeId($modPasien,'jeniskelamin').'\").val(\"$data->jeniskelamin\");
                                                $(\"#'.CHtml::activeId($modPasien,'statusperkawinan').'\").val(\"$data->statusperkawinan\");
                                                $(\"#'.CHtml::activeId($modPasien,'golongandarah').'\").val(\"$data->golongandarah\");
                                                $(\"#'.CHtml::activeId($modPasien,'rhesus').'\").val(\"$data->rhesus\");
                                                $(\"#'.CHtml::activeId($modPasien,'alamat_pasien').'\").val(\"$data->alamat_pasien\");
                                                $(\"#'.CHtml::activeId($modPasien,'rt').'\").val(\"$data->rt\");
                                                $(\"#'.CHtml::activeId($modPasien,'rw').'\").val(\"$data->rw\");
                                                $(\"#'.CHtml::activeId($modPasien,'propinsi_id').'\").val(\"$data->propinsi_id\");
                                                $(\"#'.CHtml::activeId($modPasien,'kabupaten_id').'\").val(\"$data->kabupaten_id\");
                                                $(\"#'.CHtml::activeId($modPasien,'kecamatan_id').'\").val(\"$data->kecamatan_id\");
                                                $(\"#'.CHtml::activeId($modPasien,'kelurahan_id').'\").val(\"$data->kelurahan_id\");
                                                $(\"#'.CHtml::activeId($modPasien,'no_telepon_pasien').'\").val(\"$data->no_telepon_pasien\");
                                                $(\"#'.CHtml::activeId($modPasien,'no_mobile_pasien').'\").val(\"$data->no_mobile_pasien\");
                                                $(\"#'.CHtml::activeId($modPasien,'suku_id').'\").val(\"$data->suku_id\");
                                                $(\"#'.CHtml::activeId($modPasien,'alamatemail').'\").val(\"$data->alamatemail\");
                                                $(\"#'.CHtml::activeId($modPasien,'anakke').'\").val(\"$data->anakke\");
                                                $(\"#'.CHtml::activeId($modPasien,'jumlah_bersaudara').'\").val(\"$data->jumlah_bersaudara\");
                                                $(\"#'.CHtml::activeId($modPasien,'pendidikan_id').'\").val(\"$data->pendidikan_id\");
                                                $(\"#'.CHtml::activeId($modPasien,'pekerjaan_id').'\").val(\"$data->pekerjaan_id\");
                                                $(\"#'.CHtml::activeId($modPasien,'agama').'\").val(\"$data->agama\");
                                                $(\"#'.CHtml::activeId($modPasien,'warga_negara').'\").val(\"$data->warga_negara\");
                                                loadUmur(\"$data->tanggal_lahir\");
                                                setJenisKelaminPasien(\"$data->jeniskelamin\");
                                                setRhesusPasien(\"$data->rhesus\");
                                                loadDaerahPasien($data->propinsi_id,$data->kabupaten_id,$data->kecamatan_id,$data->kelurahan_id);
                                               
                                            "))',
                        ),
                'no_rekam_medik',
                'nama_pasien',
                'nama_bin',
                'alamat_pasien',
                'rw',
                'rt',
                array(
                    'name'=>'propinsiNama',
                    'value'=>'$data->propinsi->propinsi_nama',
                ),
                array(
                    'name'=>'kabupatenNama',
                    'value'=>'$data->kabupaten->kabupaten_nama',
                ),
                array(
                    'name'=>'kecamatanNama',
                    'value'=>'$data->kecamatan->kecamatan_nama',
                ),
                array(
                    'name'=>'kelurahanNama',
                    'value'=>'$data->kelurahan->kelurahan_nama',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();


$urlGetTglLahir = $this->createUrl('GetTglLahir');
$urlGetUmur = $this->createUrl('GetUmur');
$urlGetDaerah = Yii::app()->createUrl('ActionAjax/getListDaerahPasien');
$idTagUmur = CHtml::activeId($modPasien,'umur');
$urlListDokterRuangan = Yii::app()->createUrl('actionDynamic/listDokterRuangan');
$urlGetHari = Yii::app()->createUrl('ActionAjax/GetHari');
$urlPrintKartuJanjiPoli = Yii::app()->createUrl('print/lembarJanjiPoli',array('idBuatJanjiPoli'=>''));
$urlGetHari = $this->createUrl('GetHari');

$cekKartuPasien=Yii::app()->user->getState('printkartulsng');
if(!empty($cekKartuPasien)){ //Jika Kunjungan Pasien diisi TRUE
    $statusKartuPasien=$cekKartuPasien;
}else{ //JIka Print Kunjungan Diset FALSE
    $statusKartuPasien=0;
}

$js = <<< JS

function print(idBuatJanjiPoli)
{
        if (idBuatJanjiPoli=='') {
            myAlert("kosong");
        }
        if(${statusKartuPasien}==1){ //JIka di Konfig Systen diset TRUE untuk Print kunjungan
             window.open('${urlPrintKartuJanjiPoli}'+idBuatJanjiPoli,'printwin','left=100,top=100,width=400,height=400');
        }             
}

function hariBaru()
    {
        var tanggal = $('#PPBuatJanjiPoliT_tgljadwal').val();
            $.post("${urlGetHari}",{tanggal: tanggal},
            function(data){

               $('#PPBuatJanjiPoliT_harijadwal').val(data.hari); 

       },"json");
       
    
    }

function listDokterRuangan(idRuangan)
{
    $.post("${urlListDokterRuangan}", { idRuangan: idRuangan },
        function(data){
            $('#PPBuatJanjiPoliT_pegawai_id').html(data.listDokter);
    }, "json");
}

function loadUmur(tglLahir)
{
    $.post("${urlGetUmur}",{tglLahir: tglLahir},
        function(data){
           $("#${idTagUmur}").val(data.umur);
    },"json");
}

function setJenisKelaminPasien(jenisKelamin)
{
    $('input[name="PPPasienM[jeniskelamin]"]').each(function(){
            if(this.value == jenisKelamin)
                $(this).attr('checked',true);
        }
    );
}

function setRhesusPasien(rhesus)
{
    $('input[name="PPPasienM[rhesus]"]').each(function(){
            if(this.value == rhesus)
                $(this).attr('checked',true);
        }
    );
}

function loadDaerahPasien(idProp,idKab,idKec,idKel)
{
    $.post("${urlGetDaerah}", { idProp: idProp, idKab: idKab, idKec: idKec, idKel: idKel },
        function(data){
            $('#PPPasienM_propinsi_id').html(data.listPropinsi);
            $('#PPPasienM_kabupaten_id').html(data.listKabupaten);
            $('#PPPasienM_kecamatan_id').html(data.listKecamatan);
            $('#PPPasienM_kelurahan_id').html(data.listKelurahan);
    }, "json");
}
JS;
Yii::app()->clientScript->registerScript('fungsipasien',$js,CClientScript::POS_BEGIN);
$js = <<< JS
$('#isPasienLama').click(function(){
    if ($(this).is(':checked'))
      {
         $('#no_rekam_medik').removeAttr('disabled');
         $('#buttonSearch').removeAttr('disabled');
      }
    else
      {
        $('#no_rekam_medik').attr('disabled','true');
        $('#no_rekam_medik').val('');
        $('#buttonSearch').attr('disabled','true');
        $('#PPPasienM_kabupaten_id').html('<option value=\'\'>--Pilih--</option>');
        $('#PPPasienM_kecamatan_id').html('<option value=\'\'>--Pilih--</option>');
        $('#PPPasienM_kelurahan_id').html('<option value=\'\'>--Pilih--</option>');
//        $('#isPasienLama').attr('checked',true);
         
       }

       
      
});
JS;
Yii::app()->clientScript->registerScript('fungsipasien',$js,CClientScript::POS_READY);
?>
