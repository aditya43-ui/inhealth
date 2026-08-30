<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'search-form',
        ));
?>
<div class="col-sm-6">   
    <div class="control-group">
        <?php //echo CHtml::label('Tanggal Daftar', '', array('class' => 'control-label')) ?> 
        <div class="controls">
            <?php  
                // $this->widget('MyDateTimePicker', array(
                //     'model' => $model,
                //     'attribute' => 'tglantrian',
                //     'mode' => 'date',
                //     'options' => array(
                //         'dateFormat' => Params::DATE_FORMAT,                       
                //     ),
                //     'htmlOptions' => array(
                //         'readonly' => true,
                //         'class' => 'span3 tgl_jadwal',
                //         'placeholder' => 'Silakan pilih tanggal',
                //         'onkeypress' => "return $(this).focusNextInputField(event)"
                //     ),
                // ));
            ?>
        </div>
    </div> 
    <div class="control-group">
        <?php echo CHtml::label('Barcode', '', array('class' => 'control-label')) ?> 
        <div class="controls">
            <?php echo $form->textField($model, 'barcode', array('placeholder' => 'Ketik Nomor Barcode', 'class' => 'span4',  'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>           
    <div class="control-group">
        <?php echo CHtml::label('No Antrian', '', array('class' => 'control-label')) ?> 
        <div class="controls">
            <?php echo $form->textField($model, 'noantrian', array('placeholder' => 'Ketik Nomor Antrian', 'class' => 'span4',  'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>  
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Poliklinik', '', array('class' => 'control-label')) ?> 
        <div class="controls">
            <?php echo $form->dropDownList($model, 'ruangan_id', RuanganM::arrRuanganId(Params::INSTALASI_ID_RJ), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    
    <div class="control-group">
        <?php echo CHtml::label('Status', '', array('class' => 'control-label')) ?> 
        <div class="controls">
            <?php echo $form->dropDownList($model, 'status_barcode', [
                'Belum Barcode' => 'Belum Barcode',
                'Sudah Barcode' => 'Sudah Barcode',
                'Terlambat' => 'Terlambat',
            ],array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
</div>
<div class="actions clear">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan')); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    ?>  
</div>
<?php $this->endWidget(); ?>
