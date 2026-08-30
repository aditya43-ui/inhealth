<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Verifikasi", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($modInfoOrderBatal->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($modInfoOrderBatal->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d F Y', strtotime($modInfoOrderBatal->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($modInfoOrderBatal->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($modInfoOrderBatal, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($modInfoOrderBatal, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($modInfoOrderBatal, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4', 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($modInfoOrderBatal, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'maxlength' => 50)); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->textFieldRow($modInfoOrderBatal, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'maxlength' => 20)); ?>
            <?php echo $form->textFieldRow($modInfoOrderBatal, 'petugasbatal_nama', array('placeholder' => 'Verifikator', 'class' => 'span4', 'maxlength' => 20)); ?>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
    ); ?>
    <?php
    $tips = array(
        '0' => 'simpan',
        '1' => 'ulang',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>