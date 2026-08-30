<!--<div class="row-fluid">-->
<div class="span6">
    <div class="control-group ">
        <?php echo CHtml::label('No. Kartu Peserta', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('kartu_peserta', '', array('class' => 'span3', 'placeholder' => 'Ketikan kata kunci')); ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo CHtml::label('Tanggal Pelayanan/SEP', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'name' => 'tgl_pelayanan',
                'mode' => 'date',
                'options' => array(
                    'showOn' => false,
                    'maxDate' => 'd',
                    'yearRange' => "-150:+0",
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array(
                    'placeholder' => '00/00/0000', 'class' => 'span3 dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
            <?php echo CHtml::htmlButton(
                '<i class="entypo-search"></i>',
                array(
                    'onclick' => 'cariDataSuplesi();return false;',
                    'class' => 'btn btn-primary btn-katakunci',
                    'onkeypress' => "cariDataSuplesi();return false;",
                    'rel' => "tooltip",
                    'title' => "Klik untuk mencari data Suplesi Jasa Raharja",
                )
            ); ?>
        </div>
    </div>
</div>