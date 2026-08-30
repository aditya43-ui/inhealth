<fieldset>
    <table class="table">
        <tr>
            <!--====================== kolom ke-1 ==============================================-->
            <td>
                <?php echo $form->textFieldRow($model,'nofingerprint',array('id'=>'nofingerprint', 'onkeypress'=>"if (event.keyCode == 13){setNofinger(this);}return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
                <?php echo $form->textFieldRow($model,'nomorindukpegawai',array('id'=>'NIP', 'onkeypress'=>"if (event.keyCode == 13){setNip(this);}return $(this).focusNextInputField(event)", 'class'=>'span3', )); ?>
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
                                                $("#nofingerprint").val( ui.item.nofingerprint);
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
            </td>
            <!--=========================== kolom ke 2 ======================================-->
            <td>
                
                <?php echo $form->textFieldRow($model,'jabatan_id',array('readonly'=>true,'id'=>'jabatan')); ?>
                <?php echo $form->textFieldRow($model,'pangkat_id',array('readonly'=>true,'id'=>'pangkat')); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model,'notelp_pegawai',array('readonly'=>true,'class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'notelp_pegawai',array('readonly'=>true,'id'=>'notelp', 'class'=>'span2')); ?>
                        <?php echo $form->textField($model,'nomobile_pegawai',array('readonly'=>true,'id'=>'nomobile', 'class'=>'span1', 'style'=>'width:70px;')); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model,'agama',array('readonly'=>true,'id'=>'agama')); ?>
                <?php echo $form->textAreaRow($model,'alamat_pegawai',array('readonly'=>true,'id'=>'alamat_pegawai')); ?>
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

$modPegawai = new KPRegistrasifingerprint();
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawai-m-grid',
	'dataProvider'=>$modPegawai->search(),
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
                                                      $(\"#jeniskelamin\").val(\"$data->jeniskelamin\");
                                                      $(\"#jabatan\").val(\"".$data->jabatan->jabatan_nama."\");
                                                      $(\"#pangkat\").val(\"".$data->pangkat->pangkat_nama."\");
                                                      $(\"#nofingerprint\").val(\"$data->nofingerprint\");
                                                      $(\"#norek\").val(\"$data->no_rekening\");
                                                      $(\"#banknorek\").val(\"$data->bank_no_rekening\");
                                                      $(\"#npwp\").val(\"$data->npwp\");
                                                      $(\"#notelp\").val(\"$data->notelp_pegawai\");
                                                      $(\"#nomobile\").val(\"$data->nomobile_pegawai\");
                                                      $(\"#agama\").val(\"$data->agama\");
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

<?php 
$urlNip = Yii::app()->createUrl('actionAjax/getPegawaiFromNoFinger');
Yii::app()->clientScript->registerScript('onhead2','
    function setNofinger(obj){
        var value = $(obj).val();
        $.post("'.$urlNip.'",{nofinger:value},function(hasil){
            $("#pegawai_id").val(hasil.pegawai_id);
            $("#NIP").val(hasil.nomorindukpegawai);
            $("#tempatlahir_pegawai").val(hasil.tempatlahir_pegawai);
            $("#tgl_lahirpegawai").val(hasil.tgl_lahirpegawai);
            $("#namapegawai").val(hasil.nama_pegawai);
            $("#'.CHtml::activeId($model, 'jabatan').'").val(hasil.jabatan_nama);
            $("#'.CHtml::activeId($model, 'nama_pegawai').'").val(hasil.nama_pegawai);
            $("#jeniskelamin").val(hasil.jeniskelamin);
            $("#statusperkawinan").val(hasil.statusperkawinan);
            $("#jabatan").val(hasil.jabatan_nama);
            $("#pangkat").val(hasil.pangkat_nama);
            $("#alamat_pegawai").val(hasil.alamat_pegawai);
            if(hasil.photopegawai != null){
                $("#photo_pasien").attr(\'src\',\''.Params::urlPegawaiTumbsDirectory().'kecil_\'+hasil.photopegawai);
            } else {
                $("#photo_pasien").attr(\'src\',\'http://localhost/simrs/data/images/pasien/no_photo.jpeg\');
            }
        }, "json");
    }
',  CClientScript::POS_HEAD); ?>

<?php 
$urlNIP = Yii::app()->createUrl('actionAjax/getPegawaiFromNip');
Yii::app()->clientScript->registerScript('nip','
    function setNip(obj){
        var value = $(obj).val();
        $.post("'.$urlNIP.'",{nip:value},function(hasil){
            $("#pegawai_id").val(hasil.pegawai_id);
            $("#nofingerprint").val(hasil.nofingerprint);
            $("#tempatlahir_pegawai").val(hasil.tempatlahir_pegawai);
            $("#tgl_lahirpegawai").val(hasil.tgl_lahirpegawai);
            $("#namapegawai").val(hasil.nama_pegawai);
            $("#'.CHtml::activeId($model, 'jabatan').'").val(hasil.jabatan_nama);
            $("#'.CHtml::activeId($model, 'nama_pegawai').'").val(hasil.nama_pegawai);
            $("#'.CHtml::activeId($model, 'nofingerprint').'").val(hasil.nofingerprint);
            $("#jeniskelamin").val(hasil.jeniskelamin);
            $("#statusperkawinan").val(hasil.statusperkawinan);
            $("#jabatan").val(hasil.jabatan_nama);
            $("#pangkat").val(hasil.pangkat_nama);
            $("#alamat_pegawai").val(hasil.alamat_pegawai);
            if(hasil.photopegawai != null){
                $("#photo_pasien").attr(\'src\',\''.Params::urlPegawaiTumbsDirectory().'kecil_\'+hasil.photopegawai);
            } else {
                $("#photo_pasien").attr(\'src\',\'http://localhost/simrs/data/images/pasien/no_photo.jpeg\');
            }
        }, "json");
    }
',  CClientScript::POS_HEAD); ?>