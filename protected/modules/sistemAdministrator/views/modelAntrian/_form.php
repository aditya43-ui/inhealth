<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'saloket-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);','enctype'=>'multipart/form-data'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">

		<div class = "col-sm-6">
			<?php echo $form->textFieldRow($model,'modelantrian_kode',array('class'=>'span1', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>5)); ?>
                        <?php echo $form->textFieldRow($model,'modelantrian_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        <?php echo $form->textFieldRow($model,'modelantrian_singkatan',array('class'=>'span2', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
			<?php echo $form->textFieldRow($model,'modelantrian_formatnomor',array('class'=>'span2 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($model,'modelantrian_maksantrian',array('class'=>'span2 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->dropDownListRow($model,'lokasi_karcisantrian_id', CHtml::listData(LokasiKarcisantrianM::model()->findAll(" lokasi_karcisantrian_aktif = TRUE ORDER BY lokasi_karcisantrian_nama ASC "), 'lokasi_karcisantrian_id', 'lokasi_karcisantrian_nama'),array('empty'=>'-- Pilih --')); ?>
                        <?php echo $form->textFieldRow($model,'modelantrian_labeltombol',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                     <div class="control-group">
                        <label class="control-label">Gambar Tombol</label>
                        <div class="controls">
                            <?php                                                                                  
                                echo CHtml::link("Browse",'javascript:;',array('onclick'=>'fileLoad(this);','class'=>'btn btn-primary')).'&nbsp;'.CHtml::link("<u></u>",'javascript:;',array('onclick'=>'fileLoad(this);','class'=>'labelbrowse'));
                                echo CHtml::activeHiddenField($model, 'modelantrian_temp',array('readonly' => true));
                                echo '<br/>'.CHtml::link("<u>".$model->modelantrian_temp.'</u>','javascript:;',array('rel'=>'','data-original-title'=>'Klik untuk mengunduh file', 'style'=>'color:blue;'));//$this->createUrl('UnduhDok',array('dokumenpendukungpengadaan_id'=>$modDok->dokumenpendukungpengadaan_id))
                                echo '<div class="hide">';
                                echo CHtml::activeFileField($model,'modelantrian_gambartombol',array( 'onchange'=>'cekFile(this);','accept'=>'image/*', 'class'=>'fileimage'));
                                echo '</div>';                                
                            ?>
                        </div>
                    </div>
                        <div class="control-group">
                            <?php echo CHtml::label("","",array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->checkBox($model,'modelantrian_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?> <label> Aktif</label>
                            </div>
                        </div>
                    </div>
			
                        
		<div class = "col-sm-6">
                        <?php echo $form->textAreaRow($model,'modelantrian_layanan',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textAreaRow($model,'modelantrian_deskripsi',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			
                        <div class="control-group">
                            <label class="control-label">Jam Buka</label>
                            <div class="controls">
                                <?php
                                    $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'modelantrian_buka',
                                        'mode'=>'time',
                                        'options'=> array(
                                            'showOn' => false,                                                                                                                                    
                                        ),
                                            'htmlOptions'=>array(
                                                'readonly'=>true,
                                                'class'=>'span3 dtPicker2','onkeyup'=>"return $(this).focusNextInputField(event)"
                                        ),
                                    ));
                                ?>
                            </div>
                        </div>
                    
                        <div class="control-group">
                            <label class="control-label">Jam Tutup</label>
                            <div class="controls">
                                <?php
                                    $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'modelantrian_tutup',
                                        'mode'=>'time',
                                        'options'=> array(
                                            'showOn' => false,                                                                                                                                    
                                        ),
                                            'htmlOptions'=>array(
                                                'readonly'=>true,
                                                'class'=>'span3 dtPicker2','onkeyup'=>"return $(this).focusNextInputField(event)"
                                        ),
                                    ));
                                ?>
                            </div>
                        </div>
		</div>

	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Loket',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php 
                $content = $this->renderPartial($this->path_tips.'tipsaddedit3a',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));                 
                ?>
		</div>
	</div>
<?php $this->endWidget(); ?>
<script>
    function cekFile(obj){       
        
        var cek = $(obj).val();        
        
        if (cek != ''){
            var type = $(obj).get(0).files[0]['type'];
            var tipeFile = type.split('/');                          
            var ext = '.'+$(obj).val().split('.').pop().toLowerCase();           
            var fileExt = $(obj).attr('accept').split(',');        
                                                
                                                                                                
            if($.inArray(ext, fileExt) == -1 && $.inArray(tipeFile[0]+'/*', fileExt) == -1) {
                myAlert('Tipe file yang diupload tidak diizinkan !',"Perhatian!");
                $(obj).val("");                 
                return false;
            }

            var sizee = $(obj).get(0).files[0].size; //file size in bytes
            sizee = sizee / 1024; //file size in Kb
            sizee = sizee / 1024; //file size in Mb

            if (sizee > 5) {
                myAlert("Ukuran file tidak boleh lebih dari 5mb","perhatian !");
                $(obj).val("");                 
                $(obj).parents(".controls").find('.labelbrowse').html('');                
                return false;
            }else{
                $(obj).parents(".controls").find('.labelbrowse').html("<u>"+$(obj).get(0).files[0]['name']+"</u>");
            }
        }       
    }
    
    function fileLoad(obj){
        $(obj).parents(".controls").find('.fileimage').trigger('click');
    }
</script>