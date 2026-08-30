<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'dokumenpengadaan-m-search',
    'type' => 'horizontal',
        ));
?>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label"> Jenis Transaksi </label>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'dokumenpengadaan_jenistransaksi', LookupM::getItems("jenistransaksipengadaan"), array('disabled' => false, 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --'));
                ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"> Nama </label>
            <div class="controls">
                <?php echo $form->textField($model, 'dokumenpengadaan_nama', array('class' => 'span3', 'maxlength' => 100)); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"> Nama Lain </label>
            <div class="controls">
                <?php echo $form->textField($model, 'dokumenpengadaan_namalain', array('class' => 'span3', 'maxlength' => 100)); ?>
            </div>
        </div>	
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'jenispengadaan_id', Chtml::listData(JenispengadaanM::model()->findAllByAttributes(array('jenispengadaan_aktif' => true)), 'jenispengadaan_id', 'jenispengadaan_nama'), array('disabled' => false, 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --'));
        ?>
        <?php echo $form->dropDownListRow($model, 'metodepengadaan_id', Chtml::listData(MetodepengadaanM::model()->findAllByAttributes(array('metodepengadaan_aktif' => true)), 'metodepengadaan_id', 'metodepengadaan_nama'), array('disabled' => false, 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --'));
        ?>
        <?php echo $form->textAreaRow($model, 'dokumenpengadaan_deskripsi', array('rows' => 6, 'cols' => 50, 'class' => 'span3')); ?>

        <?php echo $form->checkBoxRow($model, 'dokumenpengadaan_aktif', array('checked' => 'checked')); ?>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('admin'), array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl('admin') . '";}); return false;')) . "&nbsp;";
        ?>
    </div>
</div>    

<?php $this->endWidget(); ?>
