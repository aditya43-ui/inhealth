<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'pencarianobat-form',
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($modObat, 'obatalkes_kode'),
    ));
    ?>
    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->dropDownListRow($modObat, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->findAll('jenisobatalkes_aktif = true  ORDER BY jenisobatalkes_nama ASC'), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($modObat, 'obatalkes_kode', array('placeholder' => 'Kode Obat Alkes', 'class' => 'span3', 'maxlength' => 50, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($modObat, 'obatalkes_nama', array('placeholder' => 'Nama Obat Alkes', 'class' => 'span3', 'maxlength' => 200, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->dropDownListRow($modObat, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->dropDownListRow($modObat, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->dropDownListRow($modObat, 'rakobat_id', CHtml::listData(RakobatM::model()->findAll("rakobat_aktif = true and ruangan_id = ".Yii::app()->user->getState('ruangan_id')." ORDER BY rakobat_nama ASC"), 'rakobat_id', 'rakobat_nama'), array('empty' => '-- Pilih --', 'class' => 'span3','onkeyup' => "return $(this).focusNextInputField(event);")); ?>
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