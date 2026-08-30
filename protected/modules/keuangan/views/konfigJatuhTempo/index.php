<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
$this->breadcrumbs = array(
    'Master Jatuh Tempo',
);

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sakonfigsystem-k-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
    'focus' => '#',
));
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-layer-group"></i> Konfigurasi <b>Jatuh Tempo</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php echo $form->errorSummary($model); ?>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'Termin Jatuh Tempo Klaim', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'jatuhtempoklaim', array('class' => 'span1 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => 'Termin Jatuh Tempo Klaim')); ?> Hari.
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'Termin Jatuh Tempo Tagihan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'jatuhtempotagihan', array('class' => 'span1 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => 'Termin Jatuh Tempo Tagihan')); ?> Hari.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                    ); ?>
                    <?php
                    echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        $this->createUrl($this->id . '/index'),
                        array(
                            'class' => 'btn btn-default',
                            'onclick' => 'return refreshForm(this);'
                        )
                    );
                    ?>
                    <?php
                    //            echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Konfigurasi Sistem', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
                    $content = $this->renderPartial('tips/tipsaddedit', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>