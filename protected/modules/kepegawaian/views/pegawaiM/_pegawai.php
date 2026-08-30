<fieldset>
    <table class="table">
        <tr>
            <!--====================== kolom ke-1 ==============================================-->
            <td>
                <?php echo $form->textFieldRow($model,'nomorindukpegawai',array('readonly'=>true,'id'=>'NIP')); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Nama Pegawai','namapegawai',array('class'=>'control-label')) ?>
                    <div class="controls">
                            <?php echo $form->hiddenField($model,'pegawai_id',array('readonly'=>true,'id'=>'pegawai_id')) ?>
                            <?php $this->widget('MyJuiAutoComplete',array(
                                        'model'=>$model, 
//                                        'name'=>'namapegawai',
                                        'attribute'=>'nama_pegawai',
                                        'value'=>$namapegawai,
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
            </td>
            <!--=========================== kolom ke 2 ======================================-->
            <td>
<!--<div class="control-group">
                    <?php //echo $form->labelEx($model, 'jabatan_id',array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php //echo $form->textFieldRow($model,'jabatan_id',array('readonly'=>true,'id'=>'jabatan')); ?>
                    </div>
                </div>-->
                <?php echo $form->textFieldRow($model,'jabatan_id',array('readonly'=>true,'id'=>'jabatan')); ?>
                <?php echo $form->textFieldRow($model,'pangkat_id',array('readonly'=>true,'id'=>'pangkat')); ?>
                <?php echo $form->textFieldRow($model,'kategoripegawai',array('readonly'=>true,'id'=>'kategoripegawai')); ?>
                <?php echo $form->textFieldRow($model,'kategoripegawaiasal',array('readonly'=>true,'id'=>'kategoripegawaiasal')); ?>
                <?php echo $form->textFieldRow($model,'kelompokpegawai_id',array('readonly'=>true,'id'=>'kelompokpegawai')); ?>
                <?php echo $form->textFieldRow($model,'pendidikan_id',array('readonly'=>true,'id'=>'pendidikan')); ?>
                <?php //echo $form->textAreaRow($model,'alamat_pegawai',array('readonly'=>true,'id'=>'alamat_pegawai')); ?>
            </td>
            <td>
                <?php 
                    if(!empty($model->photopasien)){
                        echo CHtml::image(Params::urlPasienTumbsDirectory().'kecil_'.$model->photopasien, 'Foto pasien', array('id'=>'photo_pasien','width'=>150));
                    } else {
                        echo CHtml::image(Params::urlPhotoPasienDirectory().'no_photo.jpeg', 'Foto pasien', array('id'=>'photo_pasien','width'=>150));
                    }
                ?> 
            </td>
        </tr>
    </table>
</fieldset>
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

$modPegawai = new PegawaiM;
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawai-m-grid',
	'dataProvider'=>$model->search(),
//	'filter'=>$modRencanaKebFarmasi,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                        "id" => "selectPegawai",
                                        "href"=>"",
                                        "onClick" => "
                                                      $(\"#NIP\").val(\"$data->nomorindukpegawai\");
                                                      $(\"#pegawai_id\").val(\"$data->pegawai_id\");
                                                      $(\"#'.CHtml::activeId($model, 'nama_pegawai').'\").val(\"$data->nama_pegawai\");
                                                      $(\"#tempatlahir_pegawai\").val(\"$data->tempatlahir_pegawai\");
                                                      $(\"#tgl_lahirpegawai\").val(\"$data->tgl_lahirpegawai\");
                                                      $(\"#jabatan\").val(\"".$data->jabatan->jabatan_nama."\");
                                                      $(\"#pangkat\").val(\"".$data->pangkat->pangkat_nama."\");
                                                      $(\"#kategoripegawai\").val(\"$data->kategoripegawai\");
                                                      $(\"#kategoripegawaiasal\").val(\"$data->kategoripegawaiasal\");
                                                      $(\"#kelompokpegawai\").val(\"".$data->kelompokpegawai->kelompokpegawai_nama."\");
                                                      $(\"#pendidikan\").val(\"".$data->pendidikan->pendidikan_nama."\");
                                                      $(\"#jeniskelamin\").val(\"$data->jeniskelamin\");
                                                      $(\"#statusperkawinan\").val(\"$data->statusperkawinan\");
                                                      $(\"#alamat_pegawai\").val(\"$data->alamat_pegawai\");
                                                      if(\"$data->photopegawai\" != \"\"){
                                                            $(\"#photo_pasien\").attr(\'src\',\"'.Params::urlPegawaiTumbsDirectory().'kecil_$data->photopegawai\");
                                                      } else {
                                                            $(\"#photo_pasien\").attr(\'src\',\"http://localhost/simrs/data/images/pasien/no_photo.jpeg\");
                                                      }
                                                      $(\"#dialogPegawai\").dialog(\"close\");    
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