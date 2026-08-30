<div class="search-form">
    <?php
		$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
			'action' => Yii::app()->createUrl($this->route),
			'method' => 'get',
			'type' => 'horizontal',
			'id' => 'searchLaporan',
			'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
		));
    ?>
    <style>
        table{
            margin-bottom: 0;
        }
        .form-actions{
            padding:4px;
            margin-top:5px;
        }
        .nav-tabs>li>a{display:block; cursor:pointer;}
        .nav-tabs > .active a:hover{cursor:pointer;}
    </style>
        <table style="width: 100%; border: none;">
            <tr>
                <td>
                    <fieldset class="box2">
                        <legend class="rim">Berdasarkan Tanggal Kunjungan</legend>
                        <?php //echo CHtml::hiddenField('type', ''); ?>
                        <div class='control-label'>Tanggal Kunjungan</div>
                        <div class="controls">  
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_awal',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true,
								'class'=>'dtPicker2',
								'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                        </div> 
                        <?php echo CHtml::label('Sampai dengan', 'Sampai dengan', array('class' => 'control-label')) ?>
                        <div class="controls">  
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_akhir',
                                'mode' => 'date',
    //                                         'maxdate'=>'d',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true,
								'class'=>'dtPicker2',
								'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                        </div>
						
						<?php echo CHtml::label('Dokter', 'Dokter', array('class' => 'control-label')) ?>
						<div class="controls">  
						<?php 
						$this->widget('MyJuiAutoComplete', array(
							'model'=>$model,
							'attribute'=>'dokter',
							'source'=>'js: function(request, response) {
											$.ajax({
												url: "'.$this->createUrl('AutocompleteDokter').'",
												dataType: "json",
												data: {
													nama_pegawai: request.term,
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
										$("#'.CHtml::activeId($model,'dokter').'").val(ui.item.nama_pegawai);
										return false;
									}',
							),
//							'tombolDialog' => array('idDialog' => 'dialogDokter'),
							'htmlOptions'=>array('placeholder'=>'Nama Dokter',
								'onkeyup'=>"return $(this).focusNextInputField(event)",
								),
						)); 
						?>
						</div>
                    </fieldset>
                </td>
            </tr> 
        </table>

    <div class="form-actions">
        <?php
	        echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit'));
        ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
			Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
				array('class' => 'btn btn-default',
					'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    </div>
</div>
<?php
	$this->endWidget();
	$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
	$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
	$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>