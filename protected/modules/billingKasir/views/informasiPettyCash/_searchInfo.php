<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'kpinfohukumanpoinpeg-v-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'nama_pegawai'),
)); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Pengajuan", 'tglpresensi', array('class' => 'control-label')) ?>
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
        <?php echo $form->textFieldRow($model, 'pengajuanpetty_no', array('placeholder' => 'No. Pengajuan', 'class' => 'angkahuruf-only span4')) ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'pembuat_nama', array('placeholder' => 'Yang Mengajukan', 'class' => 'hurufs-only span4')) ?>
        <?php
        //		$r = RuanganM::model()->getRuanganByModul(Params::MODUL_ID_KEUANGAN);
        //		if ($r){			
        ?>
        <!--			<div class="control-group">
				<?php // echo CHtml::label('Ruangan', '', array('class' => 'control-label')) 
                ?>
				<div class="controls">
					<?php // echo $form->dropDownList($model,'ruangan_id', CHtml::listData(RuanganM::model()->findAll("ruangan_aktif = TRUE ORDER BY ruangan_nama ASC"), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class'=>'col-sm-8')) 
                    ?>
				</div>
			</div>-->
        <?php
        //		}
        ?>
        <?php // echo $form->dropDownListRow($model,'pengajuanpetty_status', LookupM::getItems('status_pettycash'), array('empty' => '-- Pilih --', 'class'=>'col-sm-12')) 
        ?>
        <?php // echo $form->dropDownListRow($model,'pengajuanpetty_kategori', LookupM::getItems('kategori_pettycash'), array('empty' => '-- Pilih --', 'class'=>'col-sm-12')) 
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
        $this->createUrl('Informasi'),
        array('title' => 'Ulang', 'class' => 'btn btn-default')
    ); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'disabled' => false, 'type' => 'button', 'onclick' => 'printInfo(\'EXCEL\')')); ?>
    <?php
    $tips = array(
        '0' => 'simpan',
        '1' => 'ulang',
        '2' => 'masterEXCEL',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>