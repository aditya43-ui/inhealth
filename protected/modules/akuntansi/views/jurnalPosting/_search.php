<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
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
    <fieldset class="">
        <div class="row">			
            <div class="col-sm-6">
                <?php echo CHtml::hiddenField('type', ''); ?>
                <div class='control-group'>
                    <?php echo CHtml::label('Tgl. Bukti Jurnal','Tanggal Bukti Jurnal', array('class'=>'control-label')) ?>
                    <div class="controls">  
                        <?php
                            $model->tgl_awal = isset($model->tgl_awal) ? MyFormatter::formatDateTimeForUser($model->tgl_awal) : date('d M Y');
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_awal',
                                'mode' => 'date',
                                //                                          'maxDate'=>'d',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true,'class'=>'span3',
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            $model->tgl_awal = isset($model->tgl_awal) ? MyFormatter::formatDateTimeForDb($model->tgl_awal) : date('d M Y');
                            ?>
                    </div>
                </div>
                <div class='control-group'>
                    <?php echo CHtml::label('Sampai Dengan','Sampai Dengan', array('class'=>'control-label')) ?>
                    <div class="controls">  
                        <?php
                            $model->tgl_akhir = isset($model->tgl_akhir) ? MyFormatter::formatDateTimeForUser($model->tgl_akhir) : date('d M Y');
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_akhir',
                                'mode' => 'date',
                                //                                         'maxdate'=>'d',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true,'class'=>'span3',
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                                ));
                            $model->tgl_akhir = isset($model->tgl_akhir) ? MyFormatter::formatDateTimeForDb($model->tgl_akhir) : date('d M Y');
                            ?>
                    </div>
                </div>
				<?php echo $form->textFieldRow($model,'nobuktijurnal',array('class'=>'span3 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false));?>
                <?php echo $form->textFieldRow($model,'kodejurnal',array('class'=>'span2 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>9,'readonly'=>false));?>
            </div>
            <div class="col-sm-6">
                
				<div class="control-group">
					<?php echo CHtml::label("Nama Akun",'nama_akun',array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($model,'rekening_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'readonly'=>false));?>
					</div>
				</div>
				<?php echo $form->textAreaRow($model,'urianjurnal',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'readonly'=>false));?>
				<?php /*
                <div class="control-group">
                    <?php echo  CHtml::label('Unit Kerja','',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'unitkerja_id',CHtml::listData(AKUnitkerjaM::model()->findAll(),'unitkerja_id','namaunitkerja'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'empty'=>'-- Pilih --'));?>
                    </div>
                </div>	
				 * 
				 */ ?>		
            </div>			
        </div>
        <div class="form-actions">
            <?php
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), 
                array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));?>
        </div>
    </fieldset>

	<?php //$this->widget('UserTips', array('type' => 'create')); ?>    
	<?php $this->endWidget(); ?>
</div>    