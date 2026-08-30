<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
if(!empty($modPegawai)){
?>
<?php } ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'kppengorganisasi-r-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>
<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
<?php echo $form->errorSummary($modPegawai); ?>
<fieldset>
    <legend>Data Pegawai</legend>
    <table class="table">
        <tr>
            <!--====================== kolom ke-1 ==============================================-->
            <td>
                <?php echo $form->textFieldRow($modPegawai,'nomorindukpegawai',array('readonly'=>true,'id'=>'NIP')); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Nama Pegawai','namapegawai',array('class'=>'control-label')) ?>
                    <div class="controls">
                            <?php echo $form->hiddenField($modPegawai,'pegawai_id',array('readonly'=>true,'id'=>'pegawai_id')) ?>
                             <?php $this->widget('MyJuiAutoComplete',array(
                                        'name'=>'namapegawai',
                                        'value'=>$modPegawai->nama_pegawai,
                                        'sourceUrl'=> Yii::app()->createUrl('ActionAutoComplete/Pegawairiwayat'),
                                        'options'=>array(
                                           'showAnim'=>'fold',
                                           'minLength' => 4,
                                           'focus'=> 'js:function( event, ui ) {
                                                $("#pegawai_id").val( ui.item.value );
                                                $("#namapegawai").val( ui.item.nama_pegawai );
                                                return false;
                                            }',
                                           'select'=>'js:function( event, ui ) {
                                                $("#pegawai_id").val( ui.item.value );
                                                $("#NIP").val( ui.item.nomorindukpegawai);
                                                $("#tempatlahir_pegawai").val( ui.item.tempatlahir_pegawai);
                                                $("#tgl_lahirpegawai").val( ui.item.tgl_lahirpegawai);
                                                $("#namapegawai").val( ui.item.nama_pegawai);
                                                $("#jeniskelamin").val( ui.item.jeniskelamin);
                                                $("#statusperkawinan").val( ui.item.statusperkawinan);
                                                $("#alamat_pegawai").val( ui.item.alamat_pegawai);
                                                $("#KPPengorganisasiR_nama_pegawai").val(ui.item.nama_pegawai);   
                                                $("#KPPengorganisasiR_pegawai_id").val(ui.item.pegawai_id);
                                                $("#KPSusunankelM_nama_pegawai").val(ui.item.nama_pegawai);   
                                                $("#KPSusunankelM_pegawai_id").val(ui.item.pegawai_id);
                                                $("#KPPrestasikerjaR_nama_pegawai").val(ui.item.nama_pegawai);   
                                                $("#KPPrestasikerjaR_pegawai_id").val(ui.item.pegawai_id);
                                                $("#KPPrestasirjaR_nama_pegawai").val(ui.item.nama_pegawai);   
                                                $("#KPPerjalanandinasR_nama_pegawai").val(ui.item.nama_pegawai);   
                                                $("#KPPerjalanandinasR_pegawai_id").val(ui.item.pegawai_id);
                                                $("#KPKenaikanpangkatT_nama_pegawai").val(ui.item.nama_pegawai);   
                                                $("#KPKenaikanpangkatT_pegawai_id").val(ui.item.pegawai_id);
                                                return false;
                                            }',

                                        ),
                                        'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 '),
                                        'tombolDialog'=>array('idDialog'=>'dialogPegawai','idTombol'=>'tombolPasienDialog'),
                            )); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($modPegawai,'tempatlahir_pegawai',array('readonly'=>true,'id'=>'tempatlahir_pegawai')); ?>
                <?php echo $form->textFieldRow($modPegawai, 'tgl_lahirpegawai',array('readonly'=>true,'id'=>'tgl_lahirpegawai')); ?>
            </td>
            <!--=========================== kolom ke 2 ======================================-->
            <td>
                <?php echo $form->textFieldRow($modPegawai, 'jeniskelamin',array('readonly'=>true,'id'=>'jeniskelamin')); ?>
                <?php echo $form->textFieldRow($modPegawai,'statusperkawinan',array('readonly'=>true,'id'=>'statusperkawinan')); ?>
                <?php echo $form->textFieldRow($modPegawai,'jabatan_id',array('readonly'=>true,'id'=>'jabatan')); ?>
                <?php echo $form->textAreaRow($modPegawai,'alamat_pegawai',array('readonly'=>true,'id'=>'alamat_pegawai')); ?>
            </td>
            <td>
                <?php 
                    if(!empty($modPegawai->photopasien)){
                        echo CHtml::image(Params::urlPasienTumbsDirectory().'kecil_'.$modPegawai->photopasien, 'Foto pasien', array('id'=>'photo_pasien','width'=>150));
                    } else {
                        echo CHtml::image(Params::urlPhotoPasienDirectory().'no_photo.jpeg', 'Foto pasien', array('id'=>'photo_pasien','width'=>150));
                    }
                ?> 
            </td>
        </tr>
    </table>
</fieldset>

<fieldset id="divRiwayatPendidikanpegawai">
    <div>
        <legend class="accord1" style="width:460px;"><?php echo CHtml::checkBox('cekRiwayatpegawai',false, array('onkeypress'=>"return $(this).focusNextInputField(event)",'onclick'=>'ViewRiwayatJabatan()')) ?> Riwayat Pengalaman Organisasi </legend>
            <table class="table table-bordered table-striped table-condensed" style="display:none;" id="tableRiwayatJabatan">
                <thead>
                    <tr>
                        <th>Nama Organisasi</th>
-                        <th>Kedudukan</th>
-                        <th>Tanggal Mulai</th>
-                        <th>Lama</th>
-                        <th>Tempat</th>
-                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
    </div>
</fieldset>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawai',
    'options'=>array(
        'title'=>'Daftar Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawai = new PegawaiM;
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawai-m-grid',
	'dataProvider'=>$modPegawai->search(),
	'filter'=>$modPegawai,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                        "id" => "selectPasien",
                                        "href"=>"",
                                        "onClick" => "$(\"#NIP\").val(\"$data->nomorindukpegawai\");
                                                      $(\"#pegawai_id\").val(\"$data->pegawai_id\");
                                                      $(\"#KPPengorganisasiR_nama_pegawai\").val(\"$data->nama_pegawai\");   
                                                      $(\"#KPPengorganisasiR_pegawai_id\").val($data->pegawai_id);
                                                      $(\"#KPSusunankelM_nama_pegawai\").val(\"$data->nama_pegawai\");   
                                                      $(\"#KPSusunankelM_pegawai_id\").val($data->pegawai_id);
                                                      $(\"#KPPrestasikerjaR_nama_pegawai\").val(\"$data->nama_pegawai\");   
                                                      $(\"#KPPrestasikerjaR_pegawai_id\").val($data->pegawai_id);
                                                      $(\"#KPPerjalanandinasR_nama_pegawai\").val(\"$data->nama_pegawai\");   
                                                      $(\"#KPPerjalanandinasR_pegawai_id\").val($data->pegawai_id);
                                                      $(\"#KPKenaikanpangkatT_nama_pegawai\").val(\"$data->nama_pegawai\");   
                                                      $(\"#KPKenaikanpangkatT_pegawai_id\").val($data->pegawai_id);
                                                      $(\"#KPKenaikanpangkatT_pangkat\").val(\"$data->pangkat->pangkat_nama\");
                                                      $(\"#KPKenaikanpangkatT_jabatan\").val(\"$data->jabatan->jabatan_nama\");
                                                      $(\"#namapegawai\").val(\"$data->nama_pegawai\");
                                                      $(\"#tempatlahir_pegawai\").val(\"$data->tempatlahir_pegawai\");
                                                      $(\"#tgl_lahirpegawai\").val(\"$data->tgl_lahirpegawai\");
                                                      $(\"#jeniskelamin\").val(\"$data->jeniskelamin\");
                                                      $(\"#statusperkawinan\").val(\"$data->statusperkawinan\");
                                                      $(\"#alamat_pegawai\").val(\"$data->alamat_pegawai\");
                                                      $(\"#dialogPegawai\").dialog(\"close\")";    
                                                      return false;
                                            "))',
                    ),
                'nomorindukpegawai',
                'nama_pegawai',
                'tempatlahir_pegawai',
                'tgl_lahirpegawai',
                'jeniskelamin',
                'statusperkawinan',
                'jabatan.jabatan_nama',
                'alamat_pegawai',
            ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>

