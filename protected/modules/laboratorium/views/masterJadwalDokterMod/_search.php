<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'tanggal-jaga',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'method' => 'GET',
        'action' => $this->createUrl('index'),
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    ));
?>
<div class="control-group">
    <label for="" class="control-label">Bulan</label>
    <div class="controls">
        <?php 
        $this->widget('MyMonthPicker', array(
            'name' => 'tanggaljaga',
            'value' => $bulanPilih,
            'options' => array(
                'dateFormat' => Params::MONTH_FORMAT,
                'yearRange' => "-100y:+0y",
            ),
            'htmlOptions' => array(
                'readonly' => true,
                'class' => "span2",
                'onkeypress' => "return $(this).focusNextInputField(event)",
                'onchange' => 'getTanggalPeriode(); setKomponenGaji(null);',
            ),
        ));
        ?>
    </div>
</div>
<div class="form-action">
<?php echo CHtml::htmlButton(
    Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
    array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'title' => 'Cari')
); ?>
</div>
<?php $this->endWidget(); ?>