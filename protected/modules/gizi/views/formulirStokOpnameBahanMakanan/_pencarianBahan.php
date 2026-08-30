<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'pencarianbahanmakanan-form',
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($modObat, 'namabahanmakanan'),
    ));
    ?>
    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->dropDownListRow($modObat, 'jenisbahanmakanan',  LookupM::getItemsUrutan("jenisbahanmakanan"), array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'empty' => '-- Pilih --')); ?>
            <?php //echo $form->textFieldRow($modObat, 'obatalkes_kode', array('placeholder'=>'Kode Obat Alkes','class' => 'span4', 'maxlength' => 50,'onkeyup' => "return $(this).focusNextInputField(event);")); 
            ?>
            <?php echo $form->textFieldRow($modObat, 'namabahanmakanan', array('placeholder' => 'Nama Bahan Makanan', 'class' => 'span4', 'maxlength' => 200, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Golongan Bahan Makanan', 'golbahanmakanan_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modObat, 'golbahanmakanan_id', CHtml::listData(GolbahanmakananM::model()->findAll('golbahanmakanan_aktif = true order by golbahanmakanan_nama'), 'golbahanmakanan_id', 'golbahanmakanan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <?php // echo $form->dropDownListRow($modObat, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50,'onkeyup' => "return $(this).focusNextInputField(event);")); 
            ?>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
        ); ?>
        <?php // echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class' => 'btn btn-default', 'type'=>'reset')); 
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>