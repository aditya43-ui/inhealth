<?php echo $form->errorSummary($model); ?>
<div class="row">
    <?php
        if (isset($modMutasiRuangan)) {
            $this->renderPartial($this->path_view.'_formMutasiRuangan', array('form'=>$form,'model'=>$model, 'instalasiTujuans'=>$instalasiTujuans, 'ruanganTujuans'=>$ruanganTujuans,'modMutasiRuangan'=>$modMutasiRuangan));
        }
    ?>   
    <hr>
    <div class="col-sm-6">
        <?php echo $form->hiddenField($model, 'mutasioaruangan_id', array('readonly'=>true,'class' => 'span3 ')) ?>
        <?php //echo $form->textFieldRow($model, 'noterimamutasi', array('readonly'=>true,'class' => 'span3 ')) ?>
        <?php
        echo $form->dropDownListRow($model, 'ruanganasal_id', CHtml::listData(GFRuanganM::model()->findAll(), 'ruangan_id', 'ruangan_nama'), array('class' => 'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)",
            'empty' => '-- Pilih --',
            'disabled'=>'disabled'));
        ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglterima', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php   
                    $model->tglterima = (!empty($model->tglterima) ? date("d/m/Y H:i:s",strtotime($model->tglterima)) : null);
                    $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'tglterima',
                        'mode'=>'datetime',
                        'options'=> array(
                            'dateFormat'=>Params::DATE_FORMAT,
                            'showOn' => false,
                            'maxDate' => 'd',
                            'yearRange'=> "-150:+0",
                        ),
                        'htmlOptions'=>array('class'=>'dtPicker2 realtime','onkeyup'=>"return $(this).focusNextInputField(event)"
                        ),
                )); ?>
            </div>
        </div>
        <?php echo $form->textAreaRow($model,'keterangan_terima',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'totalharganetto',array('class'=>'span2 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'totalhargajual',array('class'=>'span2 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        
        <div class="control-group">
            <?php echo $form->labelEx($model, 'pegawaipenerima_id', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegawaipenerima_id',array('readonly'=>true)); ?>
                <?php echo $form->textField($model, 'pegawaipenerima_nama',array('readonly'=>true)); ?>
                <?php
                /*$this->widget('MyJuiAutoComplete', array(
                    'model'=>$model,
                    'attribute' => 'pegawaipenerima_nama',
                    'source' => 'js: function(request, response) {
                                       $.ajax({
                                           url: "' . $this->createUrl('AutocompletePegawaiPenerima') . '",
                                           dataType: "json",
                                           data: {
                                               term: request.term,
                                           },
                                           success: function (data) {
                                                   response(data);
                                           }
                                       })
                                    }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val( ui.item.label);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $("#'.CHtml::activeId($model, 'pegawaipenerima_id') . '").val(ui.item.pegawai_id); 
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#'.CHtml::activeId($model, 'pegawaipenerima_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawaiPenerima'),
                ));*/
                ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($model, 'pegawaimengetahui_id', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegawaimengetahui_id',array('readonly'=>true)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model'=>$model,
                    'attribute' => 'pegawaimengetahui_nama',
                    'source' => 'js: function(request, response) {
                                       $.ajax({
                                           url: "' . $this->createUrl('AutocompletePegawaiMengetahui') . '",
                                           dataType: "json",
                                           data: {
                                               term: request.term,
                                           },
                                           success: function (data) {
                                                   response(data);
                                           }
                                       })
                                    }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val( ui.item.label);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $("#'.CHtml::activeId($model, 'pegawaimengetahui_id') . '").val(ui.item.pegawai_id); 
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#'.CHtml::activeId($model, 'pegawaimengetahui_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                ));
                ?>
            </div>
    </div>
    </div>
    <div class="clear"></div>
</div>

<?php 
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMengetahui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiMengetahui = new GFPegawairuanganV('search');
$modPegawaiMengetahui->unsetAttributes();
$modPegawaiMengetahui->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['GFPegawairuanganV'])) {
    $modPegawaiMengetahui->attributes = $_GET['GFPegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengetahui-grid',
	'dataProvider'=>$modPegawaiMengetahui->search(),
	'filter'=>$modPegawaiMengetahui,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($model,'pegawaimengetahui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'pegawaimengetahui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai'),
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
                ),
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>

<?php 
//========= Dialog buat cari data Pegawai Penerima =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiPenerima',
    'options'=>array(
        'title'=>'Pencarian Pegawai Penerima',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiPenerima = new GFPegawairuanganV('search');
$modPegawaiPenerima->unsetAttributes();
$modPegawaiPenerima->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['GFPegawairuanganV'])) {
    $modPegawaiPenerima->attributes = $_GET['GFPegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaipenerima-grid',
	'dataProvider'=>$modPegawaiPenerima->search(),
	'filter'=>$modPegawaiPenerima,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                            $(\"#'.CHtml::activeId($model,'pegawaipenerima_id').'\").val(\"$data->pegawai_id\");
                                            $(\"#'.CHtml::activeId($model,'pegawaipenerima_nama').'\").val(\"$data->NamaLengkap\");
                                            $(\"#dialogPegawaiPenerima\").dialog(\"close\"); 
                                            return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'filter'=>  CHtml::activeTextField($modPegawaiPenerima, 'nomorindukpegawai'),
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiPenerima, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiPenerima, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
                ),
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiPenerima, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiPenerima, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>
