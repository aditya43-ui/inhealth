<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'laporan-search',
    'type' => 'horizontal',
)); ?>

<?php /*
	
		<div class="control-group">
		<?php echo CHtml::label("Periode Laporan",'invoicetagihan_tgl', array('class' => 'control-label')) ?>
					<div class="controls">
						<div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
							<i class="entypo-calendar"></i>
							<span ><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
							<?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
							<?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
						</div>
					</div>
		</div>
		 * 
		 */ ?>

<div class='control-group bulan'>
    <?php echo CHtml::label('Bulan', 'dari_tanggal', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php $model->bln_awal = MyFormatter::formatMonthForUser($model->bln_awal); ?>
        <?php
        $this->widget('MyMonthPicker', array(
            'model' => $model,
            'attribute' => 'bln_awal',
            'options' => array(
                'dateFormat' => Params::MONTH_FORMAT,
            ),
            'htmlOptions' => array(
                'readonly' => true,
                'class' => "span2",
                'onkeypress' => "return $(this).focusNextInputField(event)"
            ),
        ));
        ?>
        <?php $model->bln_awal = MyFormatter::formatMonthForDb($model->bln_awal); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->route),
        array('title' => 'Ulang', 'class' => 'btn btn-default')
    ); ?>
    <?php
    //                $content = $this->renderPartial('../tips/informasi',array(),true);
    //                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>