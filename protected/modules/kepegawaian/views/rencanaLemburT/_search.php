<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'rencana-lembur-t-search',
    'type' => 'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Rencana", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modRencanaLembur->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modRencanaLembur->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($modRencanaLembur->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($modRencanaLembur->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($modRencanaLembur, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($modRencanaLembur, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->label($modRencanaLembur, 'norencana', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modRencanaLembur, 'norencana', array(
                    'class' => 'form-control span4',
                    'placeholder' => 'No. Rencana',
                )); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->label($modRencanaLembur, 'statusrencana', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($modRencanaLembur, 'statusrencana', Params::getStatusRencanaLembur(), array(
                    'empty' => '-- Pilih --', 'class' => 'span3',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
//                $format = new myFormatter();
//                $modRencanaLembur->tgl_awal  = $format->formatDateTimeForUser($modRencanaLembur->tgl_awal);
//                $modRencanaLembur->tgl_akhir = $format->formatDateTimeForUser($modRencanaLembur->tgl_akhir);
?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('RencanaLemburT/Informasi'),
        array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')
    ); ?>
    <?php
    $content = $this->renderPartial('kepegawaian.views.tips.informasi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>