<div id="divSearch-form">
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'rencana-t-search',
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($model, 'noterima'),
    )); ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Tgl. Penerimaan", 'tglterima', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'noterima', array('placeholder' => 'No. Penerimaan', 'class' => 'angkahuruf-only all-caps span4')); ?>
            <?php echo $form->textFieldRow($model, 'nofaktur', array('placeholder' => 'No. Faktur', 'class' => 'custom-only all-caps span4')); ?>
            <?php /*echo $form->dropDownListRow($model,'gudangpenerima_id',CHtml::listData(RuanganM::model()->getRuanganByInstalasi(Yii::app()->user->getState('instalasi_id')), 'ruangan_id', 'ruangan_nama'),
				array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event)",
				'empty'=>'-- Pilih --','style'=>'width:130px;'));*/ ?>
            <?php echo $form->dropDownListRow(
                $model,
                'supplier_id',
                CHtml::listData(SupplierM::model()->getSupplierFarmasiItems(), 'supplier_id', 'supplier_nama'),
                array(
                    'class' => 'span4 isRequired span4', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'empty' => '-- Pilih --',
                )
            ); ?>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Petugas Penerima", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'pegawaipenerima_id', PegawairuanganV::getDropPegawai(Yii::app()->user->getState('ruangan_id')), array('empty' => '-- Pilih --', 'class' => 'span4',)) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'statuspenerimaan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'statuspenerimaan', LookupM::getItems('statuspenerimaan'), array('empty' => '-- Pilih --', 'class' => 'span4',)); ?>
                </div>
            </div>
            <?php /*
			<div class="control-group">
				<?php echo Chtml::label('Pegawai Mengetahui','pegawaimengetahui_id', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($model,'pegawaimengetahui_id', CHtml::listData(PegawairuanganV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id = ".Yii::app()->user->getState('ruangan_id')." ORDER BY nama_pegawai ASC"), 'pegawai_id', 'namaLengkap'),array('empty'=>'-- Pilih --','style'=>'width:130px;')); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo Chtml::label('Pegawai Menyetujui','pegawaimenyetujui_id', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($model,'pegawaimenyetujui_id', CHtml::listData(PegawairuanganV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id = ".Yii::app()->user->getState('ruangan_id')." ORDER BY nama_pegawai ASC"), 'pegawai_id', 'namaLengkap'),array('empty'=>'-- Pilih --','style'=>'width:130px;')); ?>
				</div>
			</div>
*/ ?>
            <div class="control-group">
                <?php echo Chtml::label('Status Faktur', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'statusFaktur', array(1 => 'Ada', 2 => 'Tidak'), array('empty' => '-- Pilih --', 'class' => 'span4',)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo Chtml::label('Status Bayar', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'statusBayar', array(1 => 'Sudah Lunas', 2 => 'Belum Lunas'), array('empty' => '-- Pilih --', 'class' => 'span4',)); ?>
                </div>
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
            array(
                'title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        ); ?>
        <?php
        $content = $this->renderPartial('../tips/informasi_gudangfarmasi', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>