
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="panel panel-primary panel-success">
    <div class="panel-heading">
        <div class="panel-title">											
            <i class="entypo-user"></i> Data Pemohon 																	
        </div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group">
                    <?php echo CHtml::label('Pegawai','namapegawai',array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php
                        $pegpemohon_nama ='';
                           if(isset($model->pegpemohon_id)) {
                               $modPegawai = PegawaiM::model()->findByPk($model->pegpemohon_id);
                               $pegpemohon_nama = isset($modPegawai->nama_pegawai) ? $modPegawai->nama_pegawai : " ";
                               $nip = isset($modPegawai->nomorindukpegawai) ? $modPegawai->nomorindukpegawai : " ";
                               $modJabatan = JabatanM::model()->findByPk($modPegawai->jabatan_id);
                               $jabatan_nama = isset($modJabatan->jabatan_nama) ? $modJabatan->jabatan_nama : " ";
                               $modUnitKerja = UnitkerjaM::model()->findByPk($modPegawai->unitkerja_id);
                               $namaunitkerja = isset($modUnitKerja->namaunitkerja) ? $modUnitKerja->namaunitkerja : " ";
                           }
                        
                        ?>
                            <?php echo $form->hiddenField($model,'pegpemohon_id',array('readonly'=>true,'id'=>'pegawai_id')) ?>
                            <?php echo CHtml::textField('pegpemohon_nama',$pegpemohon_nama,array('readonly'=>true,'id'=>'pegawai_id')) ?>
 
                            <?php /* $this->widget('MyJuiAutoComplete',array(
//                                        'name'=>'namapegawai',
//                                        'sourceUrl'=> Yii::app()->createUrl('ActionAutoComplete/Pegawairiwayat'),
//                                        'options'=>array(
//                                           'showAnim'=>'fold',
//                                           'minLength' => 3,
//                                           'focus'=> 'js:function( event, ui ) {
//                                                $("#pegawai_id").val( ui.item.value );
//                                                $("#namapegawai").val( ui.item.nama_pegawai );
//                                                return false;
//                                            }',
//                                           'select'=>'js:function( event, ui ) {
//                                                $("#pegawai_id").val( ui.item.value );
//                                                $("#NIP").val( ui.item.nomorindukpegawai);                                   
//                                                return false;
//                                            }',
//
//                                        ),
//                                        'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 '),
//                                        'tombolDialog'=>array('idDialog'=>'dialogPegawai','idTombol'=>'tombolPasienDialog'),
//                            )); */ ?>
                    </div>
                </div>
            <div class="control-group">
                <?php echo CHtml::label('NIP','',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::textField('NIP',$nip,array('readonly'=>true)); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Jabatan','',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::textField('jabatan',$jabatan_nama,array('readonly'=>true)); ?>
                </div>
            </div>
             <div class="control-group">
                <?php echo CHtml::label('Unit Kerja','',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::textField('unitkerja',$namaunitkerja,array('readonly'=>true)); ?>
                </div>
            </div>
        </div>
    </div>
</div>

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

$modPegawai = new PegawaiM();
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawai-m-grid',
	'dataProvider'=>$modPegawai->search(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                        "id" => "selectPasien",
                                        "href"=>"",
                                        "onClick" => "
                                                      $(\"#pegawai_id\").val(\"$data->pegawai_id\");
                                                      $(\"#namapegawai\").val(\"$data->nama_pegawai\");
                                                      $(\"#NIP\").val(\"$data->nomorindukpegawai\");
                                                      $(\"#jabatan\").val(\"".$data->jabatan->jabatan_nama."\");
                                                      $(\"#unitkerja\").val(\"".$data->unitkerja_id."\");
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





