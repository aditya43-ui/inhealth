<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'review-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
));
?>
<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash("success", "Data berhasil disimpan!");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Review Evaluasi</div>
    </div>
    <div class="panel-body">
        <br>
        <div class="panel panel-dark">
            <span class="group-title">
                Tulis Review
            </span>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="control-group">
                            <?php echo $form->hiddenField($model, 'pegawai_nama', array(
                                'class' => 'form-control autogrow',
                                'readonly' => true,
                                'style' => 'style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 80px;"',
                                'placeholder' => 'Nama Pegawai'
                            )); ?>

                        </div>
                        <div class="form-control" readonly>
                            <div style="float:left;">
                                <?php
                                echo $model->pegawai_nama; ?>
                            </div>
                            <div style="float:right;">
                                <?php
                                echo $model->reviewevaluasi_tanggal; ?>
                            </div>

                        </div>
                        <br>
                        <?php echo $form->hiddenField($model, 'reviewevaluasi_tanggal', array(
                            'class' => 'form-control autogrow',
                            'readonly' => true,
                            'value' => $model->reviewevaluasi_tanggal,
                            'style' => 'style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 80px;"',
                            'placeholder' => 'Tanggal Review'
                        )); ?>
                        <div class="control-group">
                            <?php echo $form->textArea($model, 'reviewevaluasi_isi', array(
                                'class' => 'form-control autogrow',
                                'style' => 'style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 80px;"',
                                'placeholder' => 'Isi Review'
                            )); ?>
                        </div>
                    </div>
                </div>

                <?php
                echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => (isset($_GET['sukses'])) ? true : false));
                ?>
            </div>
        </div>
        <br>
        <div class="panel panel-dark">
            <span class="group-title">
                Review
            </span>
            <div class="panel-body">
                <ul class="comments">
                    <?php
                    if (!empty($modReview)) {
                        foreach ($modReview as $review) {
                            $modPegawai = PegawaiM::model()->findByPk($review->pegawai_id);
                    ?>
                            <li>
                                <div class="user-comment-thumb">
                                    <img src="assets/images/thumb-2.png" alt="" class="img-circle" width="30">
                                </div>
                                <div class="user-comment-content">
                                    <a href="#" class="user-comment-name">
                                        <?php echo $modPegawai->nama_pegawai; ?>
                                    </a>
                                    <br>
                                    <?php echo $review->reviewevaluasi_isi; ?>
                                    <div class="user-comment-meta">
                                        <a href="#" class="comment-date"><?php echo MyFormatter::formatDateTimeForUser($review->reviewevaluasi_tanggal); ?></a>
                                    </div>
                                </div>
                            </li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>

    </div>
    <?php $this->endWidget(); ?>