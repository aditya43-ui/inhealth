<div class="panel_jenispembayaran panel_jenispembayaran_digital">
    <!-- <div class="control-group">
        <?php //echo CHtml::activeLabel($modJenis, 'profilrs_id', array('class'=>'control-label', 'label'=>'Klinik')); ?>
        <div class="controls">
            <?php // echo CHtml::activeHiddenField($modJenis, '[detail]['.$i.']profilrs_id', array('class'=>'span3 profilrs_id')); ?>
            <?php // echo CHtml::textField('nama_klinik', Yii::app()->user->getState('nama_rumahsakit'), array('class'=>'span3', 'readonly'=>true)); ?>
        </div>
    </div> -->
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'nostruk', array('class'=>'control-label', 'label'=>'No. Transaksi', 'required' => true)); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modJenis, '[detail]['.$i.']nostruk', array('class'=>'span3 nostruk required')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'noreferensi', array('class'=>'control-label', 'label'=>'No. Referensi', 'required' => true)); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modJenis, '[detail]['.$i.']noreferensi', array('class'=>'span3 noreferensi')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'tgltransaksi', array('class'=>'control-label', 'label'=>'Waktu Transaksi')); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model'=>$modJenis,
                'attribute'=>'[detail]['.$i.']tgltransaksi',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array('readonly' => true,
                    'onkeyup' => "return $(this).focusNextInputField(event)", 'class'=>'tgltransaksi2'),
            ));
            ?>
        </div>
    </div>
    <div class="control-group" hidden>
        <?php echo CHtml::activeLabel($modJenis, 'tgljatuhtempo', array('class'=>'control-label', 'label'=>'Tanggal Jatuh Tempo <span class="required">*</span>')); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model'=>$modJenis,
                'attribute'=>'[detail]['.$i.']tgljatuhtempo',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    // 'maxDate' => 'd',
                ),
                'htmlOptions' => array('readonly' => true,
                    'onkeyup' => "return $(this).focusNextInputField(event)", 'class'=>'tgljatuhtempo2'),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Kode Akun', '', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('bayar_kodeakun', '', array('readonly'=>false, 'class'=>'span3 bayar_kodeakun', 'readonly'=>true)); ?>
        </div>
    </div>
</div>
