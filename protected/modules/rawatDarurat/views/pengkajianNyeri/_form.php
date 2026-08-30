<?php 
    $hide = '';
    if(isset($_GET['lihat'])) {
        $hide = 'hide';
    }
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Riwayat Pengkajian Nyeri Pasien</div>
    </div>
    <div class="panel-body">
        <?php
        if($hide == 'hide') {
            echo $this->renderPartial($this->path_view.'_lihatRiwayat', array(
                'model'=>$model,
            ), true);    
        } else {
            echo $this->renderPartial($this->path_view.'_riwayat', array(
                'model'=>$model,
            ), true); 
        }
        ?>
    </div>
</div>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pengkajiannyeri-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
    <?php echo $form->hiddenField($model,'pendaftaran_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->hiddenField($model,'ruangan_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>

    
    <div class="panel panel-success <?= $hide ?>">
        <div class="panel-heading">
            <div class="panel-title">Tambah Pengkajian Nyeri</div>
        </div>
        <div class="panel-body">
            <div class="control-group ">
                <?php echo $form->labelEx($model,'waktupengkajian', array('class'=>'control-label required', 'label'=>'Waktu Pengkajian')) ?>
                <div class="controls">
                    <?php
                        $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'waktupengkajian',
                        'mode'=>'datetime',
                        'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate' => 'd',
                        ),
                        'htmlOptions'=>array('readonly'=>true,'class'=>'span3','style'=>'width:150px;'),
                    )); ?>
                </div>
            </div>
			<?php echo $form->dropDownListRow($model,'petugaspengkaji_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array(
                'ruangan_id'=>Yii::app()->user->getState('ruangan_id')
            ), array(
                'order'=>'nama_pegawai'
            )), 'pegawai_id', 'namaLengkap'),array('empty'=>'-- Pilih --', 'class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			
            <div class="control-group">
                <?php echo $form->labelEx($model,'sistemskoring', array('class'=>'control-label')) ?>
                <div class="controls">
                <?php echo $form->radioButtonList($model,'sistemskoring', array(
                        "wbs" => "Wong Baker Faces Pain Scale",
                        "flaccs" => "Skala FLACCS",
                        "nrs" => "Numerical Rating Scale (NRS)",
                        "vas" => "Visual Analog Scale (VAS)",
                        "bps_tanpaventilator" => "Behavioural Pain Scale Tanpa Ventilator",
                        "bps_ventilator" => "Behavioural Pain Scale Ventilator",
                        "nips" => "Neonatal Infant Pain Score",
                    ), array('onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, "class"=>'sistemskoring')); ?>
                </div>
            </div>
            
            
            
            <?php 
            echo $this->renderPartial($this->path_view.'skoring/_skalaNyeri', array(
                'model'=>$model,
            ), true); 
            
            echo $this->renderPartial($this->path_view.'skoring/_flaccs', array(
                'model'=>$model, 'form'=>$form,
            ), true); 
            
            echo $this->renderPartial($this->path_view.'skoring/_nrs', array(
                'model'=>$model, 'form'=>$form,
            ), true); 
            
            echo $this->renderPartial($this->path_view.'skoring/_vas', array(
                'model'=>$model, 'form'=>$form,
            ), true); 
            
            echo $this->renderPartial($this->path_view.'skoring/_bps_tanpaventilator', array(
                'model'=>$model, 'form'=>$form,
            ), true); 
            
            echo $this->renderPartial($this->path_view.'skoring/_bps_ventilator', array(
                'model'=>$model, 'form'=>$form,
            ), true); 
            
            echo $this->renderPartial($this->path_view.'skoring/_nips', array(
                'model'=>$model, 'form'=>$form,
            ), true); 
            ?>
            
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Tips & Deskripsi Nyeri</div>
                </div>
                <div class="panel-body">
                    <div class="row-fluid">
                        <div class="col-sm-6">
                            <?php echo $form->radioButtonListRow($model,'tipenyeri',array('Akut'=>'Akut', 'Kronis'=>'Kronis'), array('uncheckValue'=>null, 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                            <?php echo $form->textFieldRow($model,'deskripsinyeri_lokasinyeri',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>255)); ?>
                            
                            <div class="control-group">		
                                <?php echo $form->labelEx($model, 'deskripsinyeri_onset', array('class'=>'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model,'deskripsinyeri_onset',array('class'=>'span2', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                                    <?php echo $form->dropDownList($model,'deskripsinyeri_onsetsatuan', LookupM::getItemsUrutan('satuanonset_nyeri'), array('empty'=>'-- Pilih --', 'class'=>'span2', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                                </div>
                            </div>
                            
                            <?php echo $form->textFieldRow($model,'deskripsinyeri_pencetus',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>255)); ?>
                            <?php // echo $form->textAreaRow($model,'deskripsinyeri_kualitasnyeri',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                            <div class="control-group">		
                                <?php echo $form->labelEx($model, 'deskripsinyeri_kualitasnyeri', array('class'=>'control-label')); ?>
                                <div class="controls ceklis_panel">
                                    <?php echo $form->checkBoxList($model, 'deskripsinyeri_kualitasnyeri', LookupM::getItemsUrutan('kualitasnyeri'), array(
                                        'uncheckValue'=>null, 'class'=>'ceklis_box',
                                    )); ?>
                                    <?php echo $form->textField($model,'deskripsinyeri_kualitasnyerilainnya',array('class'=>'span3 ceklis_input', 'data-nilai'=>'Lainnya', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="ceklis_panel">
                                <?php echo $form->radioButtonListRow($model,'deskripsinyeri_menjalar', array('Tidak'=>'Tidak', 'Ya'=>'Ya'), array('class'=>'ceklis_box', 'uncheckValue'=>null, 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                                <?php echo $form->textFieldRow($model,'deskripsinyeri_lokasipenjalaran',array('class'=>'span3 ceklis_input', 'data-nilai'=>'Ya', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>255)); ?>
                                
                            </div>
                            <?php echo $form->radioButtonListRow($model,'deskripsinyeri_tingkatan', array('Tidak Nyeri'=>'Tidak Nyeri','Ringan'=>'Ringan', 'Sedang'=>'Sedang', 'Berat'=>'Berat'), array('uncheckValue'=>null, 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                            <div class="control-group">		
                                <?php echo $form->labelEx($model, 'deskripsinyeri_frekuensinyeri', array('class'=>'control-label')); ?>
                                <div class="controls ceklis_panel">
                                    <?php echo $form->checkBoxList($model, 'deskripsinyeri_frekuensinyeri', LookupM::getItemsUrutan('frekuensinyeri'), array(
                                        'uncheckValue'=>null, 'class'=>'ceklis_box',
                                    )); ?>
                                    <?php echo $form->textField($model,'deskripsinyeri_frekuensinyerilainnya',array('class'=>'span3 ceklis_input', 'onkeyup'=>"return $(this).focusNextInputField(event);", 
                                        'data-nilai'=>'Lainnya')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Tatalaksana Nyeri</div>
                </div>
                <div class="panel-body">
                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'tatalaksananyeri', 'toolbar'=>'mini','height'=>'200px')) ?>
                </div>
            </div>
        </div>
        
    </div>
    
    
    
	<div class="row-fluid">

		<div class = "span4">
			<?php // echo $form->textFieldRow($model,'skalanyeri',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php // echo $form->textFieldRow($model,'keterangan_skalanyeri',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
		</div>
	</div>
	<div class="row-fluid">
	<div class="form-actions <?= $hide ?>">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		
		<?php // echo CHtml::link(Yii::t('mds','{icon} Pengaturan PengkajiannyeriT',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php // $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
<?php $this->endWidget(); ?>

<script>
    
    
    function printPengkajian(pasien_id, caraPrint) {
        window.open('<?php echo $this->createUrl('print'); ?>&pasien_id='+pasien_id+'&caraPrint='+caraPrint+"&"+$("#searchRiwayat :input").serialize(),'printwin','left=100,top=100,width=793,height=1122,scrollbars=yes');
    }
    
    function cekCeklisForm() {
        $(".ceklis_panel").each(function() {
            var ceklis = false;
            var nilai = $(this).find(".ceklis_input").data('nilai');
            $(this).find(".ceklis_box:checked").each(function() {
                if ($(this).val() == nilai) {
                    ceklis = true;
                }
            });
            
            if (ceklis) {
                $(this).find(".ceklis_input").attr("readonly", false);
            } else {
                $(this).find(".ceklis_input").attr("readonly", true).val("");
                
            }
        });
    }
    
    function cekPilihSkoring() {
        var nilai = $(".sistemskoring:checked").val();
        
        $(".form_skoring").hide().find(":input").attr("disabled", true);
        $(".form_" + nilai).show().find(":input").attr("disabled", false);
    }
    
    $(document).ready(function(data) {
        $(".sistemskoring").change(cekPilihSkoring);
        $(".ceklis_panel .ceklis_box").on("click", cekCeklisForm);
        
        cekPilihSkoring();
        cekCeklisForm();
    });
    
</script>
