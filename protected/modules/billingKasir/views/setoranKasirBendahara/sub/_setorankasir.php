
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($setoran, 'tglsetorankasir', array('readonly' => 'true','class'=>'span3 realtime')); ?>
        <?php echo $form->textFieldRow($setoran, 'nosetorankasir', array('readonly' => 'true','class'=>'span3')); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($setoran, 'pegawai_id', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($setoran, 'pegawai_id',array('readonly'=>true)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model'=>$setoran,
                    'attribute' => 'pegawai_nama',
                    'source' => 'js: function(request, response) {
                                       $.ajax({
                                           url: "' . $this->createUrl('AutocompletePegawaiSetoran') . '",
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
                            $("#'.CHtml::activeId($setoran, 'pegawai_id') . '").val(ui.item.pegawai_id); 
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        
                        
                        'onblur' => 'if(this.value === "") $("#'.CHtml::activeId($setoran, 'pegawai_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                ));
                ?>
            </div>
        </div>
    </div>

<?php 
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawai',
    'options'=>array(
        'title'=>'Pencarian Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawai = new PegawairuanganV();
$modPegawai->unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');

if(isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengetahui-grid',
	'dataProvider'=>$modPegawai->search(),
	'filter'=>$modPegawai,
        //'template'=>"{items}\n{pager}",
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
                                                  $(\"#'.CHtml::activeId($setoran,'pegawai_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($setoran,'pegawai_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawai\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'filter'=>  CHtml::activeTextField($modPegawai, 'nomorindukpegawai'),
                    'value'=>'$data->nomorindukpegawai',
                ), /*
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ), */
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawai, 'nama_pegawai'),
                    'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
                ), /*
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ), */
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawai, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>