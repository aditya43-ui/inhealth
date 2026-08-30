
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->label($closing, 'tglclosingkasir', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php 
                echo $form->hiddenField($closing, 'closingkasir_id');
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$closing,
                                'attribute'=>'tglclosingkasir',
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('autocompleteclosing').'",
                                                   dataType: "json",
                                                   data: {
                                                       no_pendaftaran: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                'tombolDialog'=>array('idDialog'=>'dialogClosing'),
                                'htmlOptions'=>array('rel'=>'tooltip','title'=>'Klik icon untuk mencari data closing kasir.',
                                'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3', 
                                'readonly'=>true,
                                    ),
                            )); 
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($closing, 'closingdari', array('readonly'=>true, 'class'=>'span3')); ?>
        <?php echo $form->textFieldRow($closing, 'sampaidengan', array('readonly'=>true, 'class'=>'span3')); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Pegawai Closing', '', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($closing, 'pegawai_id', array('readonly'=>true, 'class'=>'span3')); ?>
            </div>
        </div>
    </div>


<?php 
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogClosing',
    'options'=>array(
        'title'=>'Pencarian Data Closing Kasir',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>1100,
        'height'=>550,
        'resizable'=>false,
    ),
));

$modClosing = new BKClosingkasirT();
$format = new MyFormatter();
$modClosing->unsetAttributes();
if(isset($_GET['BKClosingkasirT'])){
    $modClosing->attributes = $_GET['BKClosingkasirT'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'informasiclosingkasir-m-grid',
    'dataProvider'=>$modClosing->searchSetoran(),
    'filter'=>$modClosing,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-condensed',
    'columns'=>array(
                array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectClosing",
                                        "onClick" => "
										loadDataClosing(".$data->closingkasir_id."); 
										$(\"#dialogClosing\").dialog(\"close\");
										return false;"))',
                ),
                array(
                    'name'=>'tglclosingkasir',
                    'header'=>'Tanggal Closing Kasir',
                    'type'=>'raw',
//                        'value'=>'$data->tglclosingkasir."/<br>".$data->getBuktibayar(\'tglbuktibayar\')',
                    'value'=>'$data->tglclosingkasir',
                    'filter'=>false,
                ),
                array(
                    'name'=>'shift_id',
                    'value'=>function($data) {
						$s = ShiftM::model()->findByPk($data->shift_id);
						return $s->shift_nama;
					},
                    'type'=>'raw',
                    'filter'=>CHtml::activeDropDownList($modClosing, 'shift_id',
                            CHtml::listData(ShiftM::model()->findAll('shift_aktif = true order by shift_nama'), 'shift_id', 'shift_nama'),
                            array('empty'=>'-- Pilih --')),
                ),
                array(
                    'name'=>'closingdari',
                    'header'=>'Periode Closing',
                    'type'=>'raw',
                    'value'=>'$data->closingdari." sd.<br> ".$data->sampaidengan',
                    'filter'=>false,
                ), /*
                array(
                    'name'=>'closingsaldoawal',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatUang($data->closingsaldoawal)',
                    'htmlOptions'=>array('style'=>'text-align: right'),
                    'filter'=>false,
                ), /*
                array(
                    'name'=>'terimauangmuka',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatUang($data->terimauangmuka)',
                    'htmlOptions'=>array('style'=>'text-align: right'),
                    'filter'=>false,
                ),
                array(
                    'name'=>'terimauangpelayanan',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatUang($data->terimauangpelayanan)',
                    'htmlOptions'=>array('style'=>'text-align: right'),
                    'filter'=>false,
                ),
                array(
                    'name'=>'nilaiclosingtrans',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatUang($data->nilaiclosingtrans)',
                    'htmlOptions'=>array('style'=>'text-align: right'),
                    'filter'=>false,
                ), */
                array(
                    'name'=>'pegawai_id',
                    'type'=>'raw',
                    'value'=>function($data) {
						$p = PegawaiM::model()->findByPk($data->pegawai_id);
						return $p->nama_pegawai;
					},
                    'filter'=>CHtml::activeDropDownList($modClosing, 'pegawai_id', 
                            CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array(
                            'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
                            )),'pegawai_id', 'nama_pegawai'),
                            array('empty'=>'-- Pilih --')),
                ),

    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
$this->endWidget();
////======= end pendaftaran dialog =============
?>

