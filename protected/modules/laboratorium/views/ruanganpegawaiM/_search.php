<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'id'=>'rjkelasruangan-m-search',
                 'type'=>'horizontal',
)); ?>
                                <?php // echo $form->DropDownListRow($model, 'ruangan_id', CHtml::listData($model->getRuanganItems(),'ruangan_id','ruangan_nama'),array('empty'=>'-- Pilih --',)); ?>
		<?php //echo $form->DropDownListRow($model, 'pegawai_id', CHtml::listData($model->getPegawaiItems(),'pegawai_id','nama_pegawai'),array('empty'=>'-- Pilih --')); ?>
		<?php echo CHtml::label('Nama Pegawai','',array('class'=>'control-label required')); ?>
            <div class="controls">
			    <?php echo $form->hiddenField($model,'pegawai_id', array('readonly'=>true)) ?>
			    <?php $this->widget('MyJuiAutoComplete', array(
			                           'name'=>'pegawai', 
			                            'source'=>'js: function(request, response) {
			                                   $.ajax({
			                                       url: "'.Yii::app()->createUrl('ActionAutoComplete/Pegawai').'",
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
			                                       'minLength' => 2,
			                                       'focus'=> 'js:function( event, ui )
			                                           {
			                                            $(this).val(ui.item.label);
			                                            return false;
			                                            }',
			                                       'select'=>'js:function( event, ui ) {
			                                           $(\'#RuanganpegawaiM_pegawai_id\').val(ui.item.value);
			                                           $(\'#pegawai\').val(ui.item.label);
			                                           return false;
			                                        }',
			                            ),
			                            'htmlOptions'=>array(
			                                'readonly'=>false,
			                                'placeholder'=>'Nama Pegawai',
			                                'size'=>13,
			                            ),
			                            'tombolDialog'=>array('idDialog'=>'dialogpegawai'),
			    	)); ?>
            </div>
                                <?php // echo $form->textFieldRow($model, 'nama_pegawai',array('class'=>'span3')) ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'dialogpegawai',
        'options'=>array(
            'title'=>'Pencarian Data Pegawai',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>900,
            'height'=>600,
            'resizable'=>false,
        ),
    ));
    
    $modPegawai = new PegawaiM;
    $modPegawai->unsetAttributes();
    if (isset($_GET['PegawaiM'])) {
        $modPegawai->attributes = $_GET['PegawaiM'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'pegawai-grid',
        'dataProvider'=>$modPegawai->search(),
        'filter'=>$modPegawai,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                array(
                                        "class"=>"btn-small",
                                        "id" => "selectPegawai",
                                        "onClick" => "\$(\"#RuanganpegawaiM_pegawai_id\").val($data->pegawai_id);
                                                              \$(\"#pegawai\").val(\"$data->nama_pegawai\");
                                                              \$(\"#dialogpegawai\").dialog(\"close\");"
                                ))',
            ),
            'nomorindukpegawai',
            'nama_pegawai',
            array(
                'header'=>'No. Kartu PNS',
                'value'=>'$data->no_kartupegawainegerisipil',
            ),
        	// array(
         //                'header'=>'Aktif',
         //                'class'=>'CCheckBoxColumn',     
         //                'selectableRows'=>0,
         //                'id'=>'rows',
         //                'checked'=>'$data->pegawai_aktif',
         //        ), 
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
$this->endWidget();
?>