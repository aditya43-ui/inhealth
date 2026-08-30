<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Data Resep</div>
    </div>
    <div class="panel-body">
        <?php
			echo $form->hiddenField($modPenjualan,'penjualanresep_id',array('readonly'=>true));
		?>
        <div class="control-group ">
            <?php echo $form->labelEx($modPenjualan,'tglresep', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php   
				$this->widget('MyDateTimePicker',array(
					'model'=>$modPenjualan,
					'attribute'=>'tglresep',
					'mode'=>'datetime',
					'options'=> array(
						'dateFormat'=>Params::DATE_FORMAT,
						'maxDate' => 'd',
						'yearRange'=> "-60:+0",
					),
					'htmlOptions'=>array('readonly'=>true,'class'=>'span3','style'=>'float:left; width:170px;','onkeypress'=>"return $(this).focusNextInputField(event)"
				),
			)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modPenjualan,'noresep', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPenjualan,'noresep',array('readonly'=>true, 'style'=>'width:170px;')); ?><br>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Dokter Resep<span class="required">*</span>',' Dokter_Resep', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::activeHiddenField($modPenjualan,'pegawai_id'); ?>
                <?php echo CHtml::hiddenField('reseptur_id'); ?>
                <div style="float:left;">
                    <?php
							$modReseptur->dokter = !empty($modPenjualan->pegawai)?$modPenjualan->pegawai->nama_pegawai:null;
							$this->widget('MyJuiAutoComplete',array(
								'model'=>$modReseptur,
								'attribute'=>'dokter',
								'sourceUrl'=>  $this->createUrl('ListDokter'),
								'options'=>array(
									'showAnim'=>'fold',
									'minLength'=>2,
									'select'=>'js:function( event, ui ) {
											$("#'.CHtml::activeId($modPenjualan,'pegawai_id').'").val(ui.item.pegawai_id);
												}',
								),
								'tombolDialog'=>array('idDialog'=>'dialogDokter'),
								'htmlOptions'=>array("rel"=>"tooltip","title"=>"Pencarian Data Dokter",'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2','style'=>'float:left;')
							));
						?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Jenis Resep','Jenis Resep', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php
				echo CHtml::dropDownList('jenisresep','',
					array(0=>'Non Racikan',1=>'Racikan'),
					array('key'=>'jenisresep', 'class'=>'span3','onchange'=>'formjenisresep(this.value); setDropDownRke();')
				);
				?><br>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($modPenjualan,'tglpenjualan', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php   
				$this->widget('MyDateTimePicker',array(
					'model'=>$modPenjualan,
					'attribute'=>'tglpenjualan',
					'mode'=>'datetime',
					'options'=> array(
						'dateFormat'=>Params::DATE_FORMAT,
						'maxDate' => 'd',
						'yearRange'=> "-60:+0",
					),
					'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'style'=>'width:128px;', 'onkeypress'=>"return $(this).focusNextInputField(event)"
					),
				)
			); ?>
            </div>
        </div>
        <?php //echo $form->textFieldRow($modPenjualan,'jenispenjualan',array('readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        <div class='control-group'>
            <?php echo $form->labelEx($modPenjualan,'isresepperawatan', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($modPenjualan,'isresepperawatan', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($modPenjualan,'lamapelayanan', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPenjualan,'lamapelayanan',array('class'=>'span2 inputFormTabel lebar3 integer2','readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                Detik
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($modPenjualan,'keterangan', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($modPenjualan,'keterangan',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
    </div>
</div>
<!--	<div class="control-group ">
	   <label class="control-label" for="iter">Iter</label>
	   <div class="controls">
		   <?php // echo CHtml::textField('iter', '0', array('readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span1  numbers-only')) ?>
	   </div>
   </div>-->

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'dialogDokter',
    'options'=>array(
        'title'=>'Pencarian Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'resizable'=>false,
    ),
));
if(!isset($_GET['sukses'])){ //RND-5894
	$modDokter = new DokterV('search');
	$modDokter->unsetAttributes();
	if(isset($_GET['DokterV'])){
		$modDokter->attributes = $_GET['DokterV'];
	}
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'pegawaiYangMengajukan-m-grid',
		'dataProvider'=>$modDokter->searchDokterResep(),
		'filter'=>$modDokter,
		//'template'=>"{items}\n{pager}",
	    'template'=>"{summary}\n{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Pegawai","class"=>"btn_small",
					"id"=>"selectPegawai",
					"onClick"=>"$(\"#'.CHtml::activeId($modPenjualan,'pegawai_id').'\").val(\"$data->pegawai_id\");
								$(\"#'.CHtml::activeId($modReseptur,'dokter').'\").val(\"$data->NamaLengkap\");
								$(\"#dialogDokter\").dialog(\"close\");
								return false;"
					))'
			),

			array(
                            'name'=>'nama_pegawai',
			  'header'=>'Nama Dokter Resep',
			  'type'=>'raw',
			  'value'=>'$data->NamaLengkap',
                          'filter'=>Chtml::activeTextField($modDokter, 'nama_pegawai'),
			),
			'jeniskelamin',
			'nomorindukpegawai',
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	));
} 
$this->endWidget();
?>