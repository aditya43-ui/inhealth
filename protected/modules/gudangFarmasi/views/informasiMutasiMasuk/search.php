<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'mutasimasuk-t-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'noterima'),
)); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="control-group">
                    <?php echo CHtml::label("Tgl. Mutasi", 'tgl_rekam', array('class' => 'control-label')) ?>
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
                <?php echo $form->textFieldRow($model, 'nomutasioa', array('placeholder' => 'No. Mutasi', 'class' => 'angkahuruf-only span4',)); ?>
                <?php echo $form->dropDownListRow(
                    $model,
                    'instalasiasalmutasi_id',
                    $instalasiAsals,
                    array(
                        'class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
                            'update' => "#" . CHtml::activeId($model, 'ruanganasalmutasi_id'),
                        )
                    )
                );
                ?>
                <?php echo $form->dropDownListRow($model, 'ruanganasalmutasi_id', $ruanganAsals, array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->dropDownListRow($model, 'statuspesan', LookupM::getItems('statuspesan'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->dropDownListRow($model, 'status_terima', array(1 => 'BELUM DITERIMA', 2 => 'SUDAH DITERIMA'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->dropDownListRow($model, 'pegawaipenerima_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array(
                    'ruangan_id' => Yii::app()->user->getState('ruangan_id')
                ), array(
                    'order' => 'nama_pegawai'
                )), 'pegawai_id', 'namaLengkap'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'class' => 'btn btn-default',
                    'title' => 'Ulang',
                    //                                      'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php
            $content = $this->renderPartial($this->path_view . 'tips/tipsInformasi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>