<!--<legend class="rim"><i class="entypo-search"></i> Pencarian</legend>-->
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'inspeksi-info-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'terimaperlinensteril_no'),
)); ?>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Inspeksi', 'tgl_', array('class' => 'control-label')) ?>
        <div class="controls">
            <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                <i class="entypo-calendar"></i>
                <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
            </div>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($model, 'no_pembersihan', array('class' => 'control-label', 'label' => 'No. Pembersihan')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'no_pembersihan', array('placeholder' => 'No. Pembersihan', 'class' => 'span3', 'maxlength' => 20, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::activeLabel($model, 'barang_nama', array('class' => 'control-label', 'label' => 'Nama Peralatan')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'barang_nama', array('placeholder' => 'Nama Peralatan', 'class' => 'span3', 'maxlength' => 20, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($model, 'tindaklanjut', array('class' => 'control-label', 'label' => 'Tindak Lanjut')); ?>
        <div class="controls">
            <?php echo $form->dropDownList(
                $model,
                'tindaklanjut',
                array('Cuci Ulang' => 'Cuci Ulang', 'Pemolesan' => 'Pemolesan', 'Pemusnahan' => 'Pemusnahan', 'Perbaiki Alat' => 'Perbaiki Alat', 'Lainnya' => 'Lainnya'),
                array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 20, 'onkeypress' => "return $(this).focusNextInputField(event)")
            ); ?>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/index'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    //$content = $this->renderPartial($this->path_view.'tips.informasi',array(),true);
    //$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>
<?php $this->endWidget(); ?>