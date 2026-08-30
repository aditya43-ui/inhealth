<div class="col-sm-6">
    <?php echo $form->textFieldRow($modPegawai,'nomorindukpegawai',array('readonly'=>true,'id'=>'NIP','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        <div class="control-group">
            <?php echo CHtml::label('Nama Pegawai','namapegawai',array('class'=>'control-label')) ?>
            <div class="controls">
                    <?php echo $form->hiddenField($modPegawai,'pegawai_id',array('readonly'=>true,'id'=>'pegawai_id','onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
                    <?php $this->widget('MyJuiAutoComplete',array(
                        'model'=>$modPegawai, 
                        'attribute'=>'nama_pegawai',
                        'sourceUrl'=> $this->createUrl('AutocompletePegawai'),
                        'options'=>array(
                           'showAnim'=>'fold',
                           'minLength' => 3,
                           'focus'=> 'js:function( event, ui ) {
                                $("#pegawai_id").val( ui.item.value );
                                $("#namapegawai").val( ui.item.nama_pegawai );
                                return false;
                            }',
                           'select'=>'js:function( event, ui ) {
                                setPegawai( ui.item.pegawai_id);
                                totalbobot();
                                totalscore();
                                return false;
                            }',
                        ),
                        'htmlOptions'=>array('placeholder' => 'Nama Pegawai', 'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3'),
                        'tombolDialog'=>array('idDialog'=>'dialogPegawai','idTombol'=>'tombolPasienDialog'),
                    )); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($modPegawai,'tempatlahir_pegawai',array('readonly'=>true,'id'=>'tempatlahir_pegawai','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($modPegawai, 'tgl_lahirpegawai',array('readonly'=>true,'id'=>'tgl_lahirpegawai','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($modPegawai, 'jeniskelamin',array('readonly'=>true,'id'=>'jeniskelamin','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($modPegawai,'statusperkawinan',array('readonly'=>true,'id'=>'statusperkawinan','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php //echo $form->labelEx($model, 'jabatan_id',array('class'=>'control-label')) ?>
        <div class="controls">
            <?php //echo $form->textFieldRow($model,'jabatan_id',array('readonly'=>true,'id'=>'jabatan')); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($modPegawai,'jabatan_id',array('readonly'=>true,'id'=>'jabatan','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->textFieldRow($modPegawai,'pangkat_id',array('readonly'=>true,'id'=>'pangkat','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->textFieldRow($modPegawai,'pendidikan_id',array('readonly'=>true,'id'=>'pendidikan','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->textFieldRow($modPegawai,'gajipokok',array('readonly'=>true,'id'=>'gajipokok','onkeyup'=>"return $(this).focusNextInputField(event)", 'style'=>'text-align: right;')); ?>
    <?php echo $form->textFieldRow($modPegawai,'kategoripegawai',array('readonly'=>true,'id'=>'kategoripegawai','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->textFieldRow($modPegawai,'kategoripegawaiasal',array('readonly'=>true,'id'=>'kategoripegawaiasal','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->textFieldRow($modPegawai,'kelompokpegawai_id',array('readonly'=>true,'id'=>'kelompokpegawai','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php // echo $form->textFieldRow($modPegawai,'pendidikan_id',array('readonly'=>true,'id'=>'pendidikan')); ?>
    <?php //echo $form->textAreaRow($model,'alamat_pegawai',array('readonly'=>true,'id'=>'alamat_pegawai')); ?>
</div>
<div class="col-sm-4">
    <div style="text-align: center;">
        <?php 
        $url_photopegawai = (!empty($modPegawai->photopegawai) ? Params::urlPegawaiTumbsDirectory()."kecil_".$modPegawai->photopegawai : Params::urlPegawaiDirectory()."no_photo.jpeg");
        ?>
        <img id="photo-preview" src="<?php echo $url_photopegawai?>"width="128px"/> 
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

$modPegawai = new REPegawaiM('searchDialog');
$modPegawai->unsetAttributes();
if(isset($_GET['REPegawaiM'])) {
    $modPegawai->attributes = $_GET['REPegawaiM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawai-m-grid',
	'dataProvider'=>$modPegawai->searchDialog(),
        'filter'=>$modPegawai,
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
                            setPegawai($data->pegawai_id);
                            $(\"#dialogPegawai\").dialog(\"close\");    
                            return false;
                    "))',
            ),
            'nomorindukpegawai',
            'nama_pegawai',
            'tempatlahir_pegawai',
            array(
                'name'=>'tgl_lahirpegawai',
                'filter'=>false,
            ),
            array(
                'name'=>'jeniskelamin',
                'filter'=>CHtml::activeDropDownList($modPegawai, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('empty'=>'-- Pilih --')),
            ),
            array(
                'name'=>'statusperkawinan',
                'filter'=>CHtml::activeDropDownList($modPegawai, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('empty'=>'-- Pilih --')),
            ),
            array(
                'header'=>'Jabatan',
                'type'=>'raw',
                'value'=>'isset($data->jabatan_id) ? $data->jabatan->jabatan_nama : ""',
                'filter'=>CHtml::activeDropDownList($modPegawai, 'jabatan_id', 
                        CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama'), 
                        array('empty'=>'-- Pilih --')),
            ),
            'alamat_pegawai',
        ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>