<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'realisasi-lembur-t-search',
    'type' => 'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Realisasi Lembur", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modRealisasiLembur->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modRealisasiLembur->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($modRealisasiLembur->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($modRealisasiLembur->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($modRealisasiLembur, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($modRealisasiLembur, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->label($modRealisasiLembur, 'norealisasi', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modRealisasiLembur, 'norealisasi', array('placeholder' => 'No. Realisasi', 'class' => 'span4 form-control')); ?>
            </div>
        </div>
    </div>
</div>
<?php
//                $format = new myFormatter();
//                $modRealisasiLembur->tgl_awal  = $format->formatDateTimeForUser($modRealisasiLembur->tgl_awal);
//                $modRealisasiLembur->tgl_akhir = $format->formatDateTimeForUser($modRealisasiLembur->tgl_akhir);
?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('RealisasiLemburT/Informasi'),
        array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')
    ); ?>
    <?php
    $content = $this->renderPartial('kepegawaian.views.tips/informasi_realisasiLembur', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>