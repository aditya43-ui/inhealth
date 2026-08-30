<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"> Pegawai yang diusulkan</div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model,'nomorindukpegawai',array('readonly'=>true,'id'=>'NIP')); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Nama Pegawai','namapegawai',array('class'=>'control-label')) ?>
                    <div class="controls">
                            <?php echo $form->hiddenField($model,'pegawai_id',array('readonly'=>true,'id'=>'pegawai_id')) ?>
                            <?php $this->widget('MyJuiAutoComplete',array(
                                        'model'=>$model, 
//                                        'name'=>'namapegawai',
                                        'attribute'=>'nama_pegawai',
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
                                                $("#'.CHtml::activeId($model, 'jabatan').'").val(ui.item.jabatan_nama)
                                                $("#jeniskelamin").val( ui.item.jeniskelamin);
                                                $("#statusperkawinan").val( ui.item.statusperkawinan);
                                                $("#jabatan").val( ui.item.jabatan_nama);
                                                $("#alamat_pegawai").val( ui.item.alamat_pegawai);
                                                if(ui.item.photopegawai != null){
                                                    $("#photo_pasien").attr(\'src\',\''.Params::urlPegawaiTumbsDirectory().'kecil_\'+ui.item.photopegawai);
                                                } else {
                                                    $("#photo_pasien").attr(\'src\',\'http://localhost/simrs/data/images/pasien/no_photo.jpeg\');
                                                }
                                                return false;
                                            }',

                                        ),
                                        'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 '),
                                        'tombolDialog'=>array('idDialog'=>'dialogPegawai','idTombol'=>'tombolPasienDialog'),
                            )); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model,'tempatlahir_pegawai',array('readonly'=>true,'id'=>'tempatlahir_pegawai')); ?>
                <?php echo $form->textFieldRow($model, 'tgl_lahirpegawai',array('readonly'=>true,'id'=>'tgl_lahirpegawai')); ?>
                <?php echo $form->textFieldRow($model, 'jeniskelamin',array('readonly'=>true,'id'=>'jeniskelamin')); ?>
                <?php echo $form->textFieldRow($model,'statusperkawinan',array('readonly'=>true,'id'=>'statusperkawinan')); ?>
            </div>
            <!--=========================== kolom ke 2 ======================================-->
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model,'jabatan_nama',array('readonly'=>true,'id'=>'jabatan')); ?>
                <?php echo $form->textFieldRow($model,'pangkat_nama',array('readonly'=>true,'id'=>'pangkat')); ?>
                <?php echo $form->textFieldRow($model,'pendidikan_id',array('readonly'=>true,'id'=>'pendidikan')); ?>
                <?php echo $form->textAreaRow($model,'alamat_pegawai',array('readonly'=>true,'id'=>'alamat_pegawai')); ?>            
                <?php 
                    if(!empty($model->photopasien)){
                        echo CHtml::image(Params::urlPasienTumbsDirectory().'kecil_'.$model->photopasien, 'Foto pasien', array('id'=>'photo_pasien','width'=>150));
                    } else {
                        echo CHtml::image(Params::urlPhotoPasienDirectory().'no_photo.jpeg', 'Foto pasien', array('id'=>'photo_pasien','width'=>150));
                    }
                ?> 
            </div>
            
        </div>
    </div>
</div>
<?php
/**
 * Dialog untuk nama Pegawai
 */
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

$modPegawai = new KPRegistrasifingerprint('search');
$modPegawai->unsetAttributes();
if(isset($_GET['KPRegistrasifingerprint'])) {
    $modPegawai->attributes = $_GET['KPRegistrasifingerprint'];
}
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
                        'value'=>function($data) use ($model) {
                            return CHtml::Link("<i class='icon-form-check'></i>","",array("class"=>"btn-small", 
                                        "id" => "selectPegawai",
                                        "href"=>"",
                                        "onClick" => "
                                            $('#NIP').val('".$data->nomorindukpegawai."');
                                            $('#pegawai_id').val('".$data->pegawai_id."');
                                            $('#".CHtml::activeId($model, 'nama_pegawai')."').val('".$data->nama_pegawai."');
                                            $('#tempatlahir_pegawai').val('".$data->tempatlahir_pegawai."');
                                            $('#tgl_lahirpegawai').val('".$data->tgl_lahirpegawai."');
                                            $('#jeniskelamin').val('".$data->jeniskelamin."');
                                            $('#jabatan').val('".(empty($data->jabatan_id)?"":$data->jabatan->jabatan_nama)."');
                                            $('#pangkat').val('".(!empty($data->pangkat_id)?$data->pangkat->pangkat_nama : null)."');
                                            $('#pendidikan').val('".(empty($data->pendidikan_id)?"":$data->pendidikan->pendidikan_nama)."');
                                            $('#statusperkawinan').val('".$data->statusperkawinan."');
                                            $('#alamat_pegawai').val('".$data->alamat_pegawai."');
                                            $('#KPPengangkatanpnsT_jabatan').val('".(empty($data->jabatan_id)?"":$data->jabatan->jabatan_nama)."');
                                            $('#KPPengangkatanpnsT_pangkat').val('".(!empty($data->pangkat_id)?$data->pangkat->pangkat_nama : "")."');
                                            $('#KPPengangkatanpnsT_pendidikan').val('".(empty($data->pendidikan_id)?"":$data->pendidikan->pendidikan_nama)."');
                                            
                                            $('#dialogPegawai').dialog('close');    
                                            return false;
                                            "));
                        },
                    ),
            
                'nomorindukpegawai',
                'nama_pegawai',
                'tempatlahir_pegawai',
                'tgl_lahirpegawai',
                //'jeniskelamin',
                array(
                    'header' => 'Jenis Kelamin',
                    'name' => 'jeniskelamin',
                    'filter' => CHtml::dropDownList('KPRegistrasifingerprint[jeniskelamin]', $modPegawai->jeniskelamin, LookupM::getItems('jeniskelamin'), array('empty'=>'-- Pilih --')),
                ),
                'statusperkawinan',
                array(
                    'header' => 'Jabatan',
                    'name' => 'jabatan_id',
                    'filter' => CHtml::dropDownList('KPRegistrasifingerprint[jabatan_id]', $modPegawai->jabatan_id, CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"),'jabatan_id','jabatan_nama'), array('empty'=>'-- Pilih --')),
                ), 
               // 'jabatan.jabatan_nama',
                'alamat_pegawai',
            ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>