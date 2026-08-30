
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
                <?php 
                if(isset($model->pegpemohon_id)) {
                    $modPegawai = PegawaiM::model()->findByPk($model->pegpemohon_id);
                    if(isset($modPegawai)) {
                    $nama_pegawai = isset($modPegawai->nama_pegawai) ? $modPegawai->nama_pegawai : " ";
                    $nip = isset($modPegawai->nomorindukpegawai) ? $modPegawai->nomorindukpegawai : " ";
                    $jabatan = isset($modPegawai->jabatan->jabatan_nama) ? $modPegawai->jabatan->jabatan_nama : " ";
                    $unitkerja = isset($modPegawai->unitkerja->namaunitkerja) ? $modPegawai->unitkerja->namaunitkerja : " ";
                    }
                }
                ?>    
                <div class="controls">
                            <?php echo $form->hiddenField($model,'pegpemohon_id',array('readonly'=>true,'id'=>'pegawai_id')) ?>
                            <?php echo CHtml::textField($nama_pegawai,$nama_pegawai, array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true)); ?>

                    </div>
                </div>
            <div class="control-group">
                <?php echo CHtml::label('NIP','',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::textField($nip,$nip, array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true)); ?>

                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Jabatan','',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::textField($jabatan,$jabatan,array('readonly'=>true)); ?>
                </div>
            </div>
             <div class="control-group">
                <?php echo CHtml::label('Unit Kerja','',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::textField($unitkerja,$unitkerja,array('readonly'=>true)); ?>
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





