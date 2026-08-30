<div id="divSearch-form">
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'informasi-search',
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($model, 'instalasi_id'),
    )); ?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-search"></i> Pencarian Kartu Stok Barang
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label("Tgl. Transaksi", 'tgl_rekam', array('class' => 'control-label')) ?>
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
                        <?php echo $form->dropDownListRow(
                            $model,
                            'instalasi_id',
                            $instalasiAsals,
                            array(
                                'disabled' => $disabled, 'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
                                    'update' => "#" . CHtml::activeId($model, 'ruangan_id'),
                                )
                            )
                        );
                        ?>
                    </div>
                    <div class="control-group">
                        <?php echo $form->dropDownListRow($model, 'ruangan_id', $ruanganAsals, array('disabled' => $disabled, 'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                    <?php /*
                <div class="control-group">
                    <?php echo CHtml::label('Nama Transaksi','Nama Transaksi', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'transaksi',$model->getNamaTransaksiKartuStok(),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                    </div>
                </div>
                 * 
                 */ ?>
                    <div class="control-group">
                        <?php echo $form->dropDownListRow(
                            $model,
                            'jenisbarang_id',
                            CHtml::listData(JenisbarangM::model()->findAll(array(
                                'condition' => 'jenisbarang_aktif = true',
                                'order' => 'jenisbarang_nama',
                            )), "jenisbarang_id", "jenisbarang_nama"),
                            array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")
                        ); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <?php echo $form->dropDownListRow($model, 'barang_type', LookupM::getItems('barangumumtype'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->textFieldRow($model, 'barang_kode', array('class' => 'span3 custom-only', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->textFieldRow($model, 'barang_nama', array('class' => 'span3 custom-only', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->dropDownListRow($model, 'barang_satuan',  LookupM::getItems('satuanbarang'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('class' => 'btn btn-danger', 'type' => 'submit')
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        );
        ?>
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
            array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print("PRINT")')
        );
        $tips = array(
            '0' => 'simpan',
            '1' => 'ulang',
            '2' => 'print',
        );
        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        // $content = $this->renderPartial($this->path_view . '/tips/tipsInformasi', array(), true);
        // $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>