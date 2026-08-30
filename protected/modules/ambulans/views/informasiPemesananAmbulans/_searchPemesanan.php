<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="search-form">
            <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'get',
                'id' => 'pesanambulans-t-search',
                'type' => 'horizontal',
                'focus' => '#' . CHtml::activeId($model, 'pesanambulans_t'),
            )); ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="control-group">
                        <?php echo CHtml::label('Tgl. Pemesanan', 'tglPemakaian', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                                <i class="entypo-calendar"></i>
                                <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                                <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <?php echo $form->textFieldRow($model, 'pesanambulans_no', array('placeholder' => 'No. Pemesanan', 'class' => 'span4', 'maxlength' => 20)); ?>
                    <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($model, 'pasien_norekammedis', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4', 'maxlength' => 10)); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo $form->textFieldRow($model, 'pasien_nama', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($model, 'pemesan_nama', array('placeholder' => 'Nama Pemesan', 'class' => 'span4', 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($model, 'ruangan_nama', array('placeholder' => 'Ruangan', 'class' => 'span4')); ?>
                </div>
            </div>
            <div class="form-actions">
                <?php echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                    array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                ); ?>
                <?php echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                    array(
                        'class' => 'btn btn-default',
                        'title' => 'Ulang',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                    )
                ); ?>
                <?php
                $content = $this->renderPartial('../tips/informasi_pemakaian', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>