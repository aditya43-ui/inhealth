<div class="search-form">
    <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
            array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'get',
                'type' => 'horizontal',
                'id' => 'search-jurnal-umum',
                'htmlOptions' => array(
                    'enctype' => 'multipart/form-data',
                    'onKeyPress' => 'return disableKeyPress(event)'
                ),
            )
        );
        $this->widget('application.extensions.moneymask.MMask', array(
            'element' => '.numbersOnly',
            'config' => array(
                'defaultZero' => true,
                'allowZero' => true,
                'decimal' => '.',
                'thousands' => '',
                'precision' => 0
            )
        ));
        $this->widget('application.extensions.moneymask.MMask',array(
            'element'=>'.currency',
            'currency'=>'PHP',
            'config'=>array(
                'symbol'=>'Rp',
                'defaultZero'=>true,
                'allowZero'=>true,
                'decimal'=>',',
                'thousands'=>'.',
                'precision'=>0,
            )
        ));
    ?>
    <fieldset class="box">
        <legend class="rim">Pencarian</legend>
			<div class="row">
				<div class="col-sm-4">
					<div class="control-group">
						<label for="AKJurnaldetailT_tgl_akhir" class="control-label">Tanggal Jurnal</label>
						<div class="controls">
							<?php
								$model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal);
								$this->widget('MyDateTimePicker',
									array(
										'model' => $model,
										'attribute' => 'tgl_awal',
										'mode' => 'date',
										'options' => array(
											'dateFormat' => Params::DATE_FORMAT,
											'maxdate'=>'d'
										),
										'htmlOptions' => array(
											'readonly' => true,
											'class'=>'dtPicker2-5',
											'onkeypress' => "return $(this).focusNextInputField(event)"
										),
									)
								);
							?>
						</div>
					</div>
					<div class="control-group">
						<label for="AKJurnaldetailT_tgl_akhir" class="control-label">Sampai Dengan</label>
						<div class="controls">
							<?php
								$model->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir);
								$this->widget('MyDateTimePicker',
									array(
										'model' => $model,
										'attribute' => 'tgl_akhir',
										'mode' => 'date',
										'options' => array(
											'dateFormat' => Params::DATE_FORMAT,
											'maxdate'=>'d'
										),
										'htmlOptions' => array(
											'readonly' => true,
											'class'=>'dtPicker2-5',
											'onkeypress' => "return $(this).focusNextInputField(event)"
										),
									)
								);
							?>
						</div>
					</div>
					<div class="control-group">
						<label for="AKJurnaldetailT_kodejurnal" class="control-label">Kode Jurnal</label>
						<div class="controls">
							<?php
								echo $form->textField(
									$model,'kodejurnal',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)
								);
							?>
						</div>
					</div>
				</div>
				<div class="col-sm-4">    
					<div class="control-group">
						<label for="AKJurnaldetailT_is_posting" class="control-label">Posting</label>
						<div class="controls">
							<?php
								echo $form->dropDownList($model, 'is_posting',
									array("1"=>"Ya","0"=>"Tidak"),
									array(
										'class'=>'span3',
										'inline'=>true,
										'empty'=>'-- Pilih --',
										'onkeypress'=>"return $(this).focusNextInputField(event)"
									)
								);
							?>
						</div>
					</div>
					<div class="control-group">
						<label for="AKJurnaldetailT_jenisjurnal_id" class="control-label">Jenis Jurnal</label>
						<div class="controls">
							<?php
								echo $form->dropDownList($model,'jenisjurnal_id',
									JenisjurnalM::items(),
									array(
										'empty'=>'-- Pilih --',
										'onkeypress'=>"return $(this).focusNextInputField(event)",
										'class'=>'span3'
									)
								);
							?>
						</div>
					</div>
					<div class="control-group">
						<label for="AKJurnaldetailT_nobuktijurnal" class="control-label">No. Bukti Jurnal</label>
						<div class="controls">
							<?php
								echo $form->textField(
									$model,'nobuktijurnal',array('class'=>'span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)
								);
							?>
						</div>
					</div>
				</div>
				<div class="col-sm-4">                  
					<div class="control-group">
						<label for="AKJurnaldetailT_noreferensi" class="control-label">No. Referensi</label>
						<div class="controls">
							<?php
								echo $form->textField(
									$model,'noreferensi',array('class'=>'span3 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)
								);
							?>
						</div>
					</div>
				</div>
			</div>
    </fieldset>
    <div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
        $this->createUrl($this->id.'/index'), 
        array('class' => 'btn btn-default',
              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    </div>
</div>    
<?php
    $this->endWidget();
?>