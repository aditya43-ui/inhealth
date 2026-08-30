<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'id'=>'rjkelasruangan-m-search',
                 'type'=>'horizontal',
)); ?>
                                <?php // echo $form->DropDownListRow($model, 'ruangan_id', CHtml::listData($model->getRuanganItems(),'ruangan_id','ruangan_nama'),array('empty'=>'-- Pilih --',)); ?>
		<?php //echo $form->DropDownListRow($model, 'kelaspelayanan_id', CHtml::listData($model->getKelaspelayananItems(),'kelaspelayanan_id','kelaspelayanan_nama'),array('empty'=>'-- Pilih --')); ?>
		<?php echo CHtml::label('Kelas Pelayanan','',array('class'=>'control-label required')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model,'kelaspelayanan_id', array('readonly'=>true)) ?>
                <?php $this->widget('MyJuiAutoComplete', array(
                                       'name'=>'kelaspelayanan', 
                                        'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.Yii::app()->createUrl('ActionAutoComplete/Kelaspelayanan').'",
                                                   dataType: "json",
                                                   data: {
                                                       term: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                        'options'=>array(
                                                   'showAnim'=>'fold',
                                                   'minLength' => 3,
                                                   'focus'=> 'js:function( event, ui )
                                                       {
                                                        $(this).val(ui.item.label);
                                                        return false;
                                                        }',
                                                   'select'=>'js:function( event, ui ) {
                                                       $(\'#KelasruanganM_kelaspelayanan_id\').val(ui.item.value);
                                                       $(\'#kelaspelayanan\').val(ui.item.label);
                                                        return false;
                                                    }',
                                        ),
                                        'htmlOptions'=>array(
                                            'readonly'=>false,
                                            'placeholder'=>'Kelas Pelayanan',
                                            'size'=>13,
                                            'onkeypress'=>"return $(this).focusNextInputField(event);",
                                        ),
                                        'tombolDialog'=>array('idDialog'=>'dialogkelaspelayanan'),
                                )); ?>
            </div>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
<!-- ============================== Widget Dialog dialogkelaspelayanan =============================== -->
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'dialogkelaspelayanan',
        'options'=>array(
            'title'=>'Pencarian Kelas Pelayanan',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>900,
            'height'=>600,
            'resizable'=>false,
        ),
    ));
    
    $modkelaspelayanan = new KelaspelayananM;
    $modkelaspelayanan->unsetAttributes();
    if (isset($_GET['KelaspelayananM'])) {
        $modkelaspelayanan->attributes = $_GET['KelaspelayananM'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'jeniskasuspenyakit-grid',
        'dataProvider'=>$modkelaspelayanan->search(),
        'filter'=>$modkelaspelayanan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                array(
                                        "class"=>"btn-small",
                                        "id" => "selectKelasruangan",
                                        "onClick" => "\$(\"#KelasruanganM_kelaspelayanan_id\").val($data->kelaspelayanan_id);
                                                              \$(\"#kelaspelayanan\").val(\"$data->kelaspelayanan_nama\");
                                                              \$(\"#dialogkelaspelayanan\").dialog(\"close\");"
                                ))',
            ),
            'kelaspelayanan_nama',
            'kelaspelayanan_namalainnya',
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
$this->endWidget();
?>
<!-- ======================== endWidget dialogkelaspelayanan ===================================== -->