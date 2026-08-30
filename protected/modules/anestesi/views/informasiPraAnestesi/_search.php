
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'caripasien-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'no_rekam_medik'),
    'htmlOptions' => array(),
        ));
?>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::label('Tanggal Pra Anestesi', 'tglanastesi', array('class' => 'control-label')) ?>
            <div class="controls">
               <div class="daterange daterange-inline input-inline" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Ketik Nama Pasien', 'style' => 'width:199px;', 'maxlength' => 20)); ?>
        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'Ketik No. Rekam Medik', 'style' => 'width:199px;', 'maxlength' =>  8, 'class'=>'numbers-only')); ?>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit'));
    ?>
    <?php
    if (!isset($_GET['frame'])) {
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'));
    }
    ?>
    <?php
    $content = $this->renderPartial($this->path_tips . 'informasi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>