<div id="divSearch-form">
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'rencana-t-search',
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($model, 'nopermintaan'),
    )); ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Tgl. Permintaan", 'tglpermintaanpembelian', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'nopermintaan', array('placeholder' => 'No. Permintaan', 'class' => 'angkahuruf-only')); ?>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'statuspembelian', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'statuspembelian', LookupM::getItems('statuspembelian'), array('empty' => '-- Pilih --', 'style' => 'width:130px;')); ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow(
                $model,
                'ruangan_id',
                CHtml::listData(RuanganM::model()->getRuanganByInstalasi(Yii::app()->user->getState('instalasi_id')), 'ruangan_id', 'ruangan_nama'),
                array(
                    'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'empty' => '-- Pilih --', 'style' => 'width:130px;'
                )
            ); ?>
            <?php echo $form->dropDownListRow(
                $model,
                'supplier_id',
                CHtml::listData(SupplierM::model()->SupplierItems, 'supplier_id', 'supplier_nama'),
                array(
                    'class' => 'span3 isRequired', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'empty' => '-- Pilih --'
                )
            ); ?>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit')); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . 'index', array('modul_id' => Yii::app()->session['modul_id'])),
            array(
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        );
        ?>
        <?php
        $tips = array(
            '0' => 'tanggal',
            '1' => 'ubah',
            '2' => 'terima',
            '3' => 'detail',
            '4' => 'cari',
            '5' => 'ulang2'
        );
        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>