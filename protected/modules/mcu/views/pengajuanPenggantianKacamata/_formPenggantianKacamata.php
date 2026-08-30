<div class="row">
<div class="col-sm-6">
	<div class="control-group">
        <?php echo $form->labelEx($model, 'no_pengajuan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php  echo $form->textField($model,'no_pengajuan',array('class'=>'span3','readonly'=>false)) ;?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'tglpengajuan_km', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php   
                $model->tglpengajuan_km = (!empty($model->tglpengajuan_km) ? date("d/m/Y H:i:s",strtotime($model->tglpengajuan_km)) : null);
                $this->widget('MyDateTimePicker',array(
                    'model'=>$model,
                    'attribute'=>'tglpengajuan_km',
                    'mode'=>'datetime',
                    'options'=> array(
//                                            'dateFormat'=>Params::DATE_FORMAT,
                        'showOn' => false,
                        'maxDate' => 'd',
                        'yearRange'=> "-150:+0",
                    ),
                    'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                    ),
            )); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("Supervisor", 'supervisor_nama', array('class'=>'control-label'))?>
        <div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'name'=>'cari_supervisor_nama',
                                'value'=>$model->supervisor_nama,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteSupervisor').'",
                                                   dataType: "json",
                                                   data: {
                                                       supervisor_nama: request.term,
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
                                            return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogSupervisor'),
                                'htmlOptions'=>array('placeholder'=>'Nama Supervisor','rel'=>'tooltip','title'=>'Ketik Nama Supervisor',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                    'onblur'=>"if($(this).val()=='')",
                                    'class'=>'numbers-only'),
                            )); 
            ?>
            <?php echo $form->error($model,'supervisor_nama'); ?>                        
            <?php echo $form->hiddenField($model,'supervisior_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
        </div>
    </div>
	<div class="control-group">
        <?php echo CHtml::label("Mengetahui", 'mengetahui_nama', array('class'=>'control-label'))?>
        <div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'name'=>'cari_mengetahui_nama',
                                'value'=>$model->supervisor_nama,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteMengetahui').'",
                                                   dataType: "json",
                                                   data: {
                                                       mengetahui_nama: request.term,
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
                                            return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogMengetahui'),
                                'htmlOptions'=>array('placeholder'=>'Nama Pegawai Mengetahui','rel'=>'tooltip','title'=>'Ketik Nama Pegawai Mengetahui',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                    'onblur'=>"if($(this).val()=='')",
                                    'class'=>'numbers-only'),
                            )); 
            ?>
            <?php echo $form->error($model,'mengetahui_nama'); ?>                        
            <?php echo $form->hiddenField($model,'mengetahui_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
        </div>
    </div>
</div>
</div>

<?php
//========= Dialog untuk cari data Supervisor=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogSupervisor',
    'options' => array(
        'title' => 'Daftar Supervisor',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'resizable' => false,
    ),
));

$modSupervisor = new MCPegawaiV('searchDialog');
$modSupervisor->unsetAttributes();
if(isset($_GET['MCPegawaiV'])){
    $modSupervisor->attributes = $_GET['MCPegawaiV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'supervisor-m-grid',
    'dataProvider'=>$modSupervisor->searchDialog(),
    'filter'=>$modSupervisor,
    'template'=>"{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBahan",
                                    "onClick" => "
                                    $(\"#'.CHtml::activeId($model,'supervisior_id').'\").val($data->pegawai_id);
                                    $(\"#cari_supervisor_nama\").val(\'$data->NamaLengkap\');
                                    $(\'#dialogSupervisor\').dialog(\'close\');
                                    return false;"))',
        ),
        'nama_pegawai',
        'nomorindukpegawai',
        'alamat_pegawai',
        'agama',
        array(
            'name'=>'jeniskelamin',
//            'filter'=>  LookupM::getItems('jeniskelamin'),
            'filter'=> CHtml::dropDownList('MCPegawaiV[jeniskelamin]',$modSupervisor->jeniskelamin,LookupM::getItems('jeniskelamin'), array('empty'=>'-- Pilih --')),
            'value'=>'$data->jeniskelamin',
        ),
        
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
?>
<?php $this->endWidget(); ?>

<?php
//========= Dialog untuk cari data Pegawai Mengetahui=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogMengetahui',
    'options' => array(
        'title' => 'Daftar Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'resizable' => false,
    ),
));

$modPegMengetahui = new MCPegawaiV('search');
$modPegMengetahui->unsetAttributes();
if(isset($_GET['MCPegawaiV'])){
    $modPegMengetahui->attributes = $_GET['MCPegawaiV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'mengetahui-m-grid',
    'dataProvider'=>$modPegMengetahui->searchDialog(),
    'filter'=>$modPegMengetahui,
    'template'=>"{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBahan",
                                    "onClick" => "
                                    var parent = $(\"#dialogMengetahui\").attr(\"parentclick\");
                                    $(\"#'.CHtml::activeId($model,'mengetahui_id').'\").val($data->pegawai_id);
                                    $(\"#cari_mengetahui_nama\").val(\'$data->NamaLengkap\');
                                    $(\'#dialogMengetahui\').dialog(\'close\');
                                    return false;"))',
        ),
        'nama_pegawai',
        'nomorindukpegawai',
        'alamat_pegawai',
        'agama',
        array(
            'name'=>'jeniskelamin',
//            'filter'=>  LookupM::getItems('jeniskelamin'),
            'filter'=> CHtml::dropDownList('MCPegawaiV[jeniskelamin]',$modPegMengetahui->jeniskelamin,LookupM::getItems('jeniskelamin'), array('empty'=>'-- Pilih --')),
            'value'=>'$data->jeniskelamin',
        ),
        
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
?>
<?php $this->endWidget(); ?>