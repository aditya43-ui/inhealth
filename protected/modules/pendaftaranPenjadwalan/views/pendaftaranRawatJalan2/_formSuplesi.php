<!--<div class="control-group form-inline">
    <?php // echo CHtml::label("Laka Lantas", 'Lantas', array('class'=>'control-label'))?>
    <div class="controls">
            <?php 
//            echo $form->radioButtonList($model,'is_lakalantas',array("1"=>"YA&nbsp;&nbsp;","0"=>"TIDAK"), array('onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'setLakaLantas(this)'));
            ?>
    </div>
</div>-->
<?php echo CHtml::activeHiddenField($model, 'lakalantas',array('value'=>'0'));?>
<div class="control-group">
    <?php echo CHtml::label("Penjamin <span class='required'>*</span>", 'Penjamin', array('class'=>'control-label'))?>
    <div class="controls">
    <?php echo $form->dropDownList($model,'penjamin_lakalantas', array('1'=>'Jasa Raharja PT','2'=>'BPJS Ketenagakerjaan','3'=>'TASPEN','4'=>'ASABRI PT'), array('empty'=>'-- Pilih --','class'=>'span3 required', 'onkeyup'=>"return $(this).focusNextInputField(event)",
        )); ?>
    </div>		
</div>
<div class="control-group form-inline">
    <?php echo CHtml::label("Suplesi Jasa Raharja", 'suplesi', array('class'=>'control-label'))?>
    <div class="controls">
            <?php 
            echo $form->radioButtonList($model,'suplesi_jasaraharja',array("1"=>"YA&nbsp;&nbsp;","0"=>"TIDAK"), array('onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'cekSuplesi(this);'));
            ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label("No. Suplesi <span class='required cari_suplesi'> * </span>", 'No. Suplesi', array('class'=>'control-label'))?>
    <div class="controls">
        <?php echo $form->textField($model,'no_suplesi',array('placeholder'=>'No SEP Suplesi','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'disabled'=>'disabled')); ?>
        <?php echo CHtml::link("<i class='entypo-search'></i>",'javascript:void(0)',array("rel"=>"tooltip","title"=>"klik untuk cari no suplesi","onclick"=>"$('#dialogSuplesi').dialog('open');return true;",'class'=>'cari_suplesi'));?>
    </div>
</div>
<div class="control-group">
    <label class="control-label">
        Tanggal Kejadian <span class='required'>*</span>
  </label>
    <div class="controls">
        <?php   
            $this->widget('MyDateTimePicker',array(
                'model'=>$model,
                'attribute'=>'tanggal_kejadian',
                'mode'=>'date',
                'options'=> array(
                    'dateFormat'=>Params::DATE_FORMAT,
                    'showOn' => false,
                    'maxDate' => 'd',
                ),
                'htmlOptions'=>array('class'=>'dtPicker2 datetimemask span3 required','onkeyup'=>"return $(this).focusNextInputField(event)",),
        )); ?>

        <?php echo $form->error($model, 'tanggal_kejadian'); ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label">
        Lokasi Kejadian
        <span class="required"> *</span>
  </label>
    <div class="controls">
        <?php echo $form->dropDownList($model,'propinsi_lakalantas_id', array(), array('empty'=>'-- Pilih Provinsi --','class'=>'span3 required', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'setKabupaten(this)')); ?><br>
        <?php echo $form->dropDownList($model,'kabupaten_lakalantas_id', array(), array('empty'=>'-- Pilih Kabupaten --','class'=>'span3 required', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'setKecamatan(this)')); ?><br>
        <?php echo $form->dropDownList($model,'kecamatan_lakalantas_id', array(), array('empty'=>'-- Pilih Kecamatan --','class'=>'span3 required', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'setKecamatanValue(this)')); ?>
        <?php echo $form->hiddenField($model,'propinsi_lakalantas_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model,'kabupaten_lakalantas_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model,'kecamatan_lakalantas_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label("Keterangan Kejadian <span class='required'>*</span>", 'Keterangan Kejadian', array('class'=>'control-label'))?>
    <div class="controls">
            <?php echo $form->textArea($model,'keterangan_kejadian', array('class'=>'span3 required','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    </div>
</div>