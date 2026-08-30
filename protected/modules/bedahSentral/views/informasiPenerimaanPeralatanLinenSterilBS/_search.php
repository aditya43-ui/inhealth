<!--<legend class="rim"><i class="entypo-search"></i> Pencarian</legend>-->
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'penerimaanperalatanlinen-info-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'terimaperlinensteril_no'),
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Tgl. Pengiriman', 'kirimperlinensteril_tgl', array('class' => 'control-label')) ?>
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
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'kirimperlinensteril_no', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'kirimperlinensteril_no', array('placeholder' => 'No. Pengiriman', 'class' => 'span3', 'maxlength' => 20, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <!--		
		<div class="control-group">
			<?php // echo CHtml::label('Instalasi', 'instalasi_id', array('class'=>'control-label')) 
            ?>
			<div class="controls">
				<?php // echo $form->dropDownList($model,'instalasi_id', CHtml::listData(BSInstalasiM::getInstalasiItems(),'instalasi_id','instalasi_nama'), 
                //						array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                //								'ajax'=>array('type'=>'POST',
                //											'url'=>$this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($model))),
                //											'update'=>"#".CHtml::activeId($model, 'ruangan_id'),
                //								)));
                ?>
			</div>
		</div>
            <div class="control-group">
			<?php // echo CHtml::label('Ruangan', 'ruangan_id', array('class'=>'control-label')) 
            ?>
			<div class="controls">
				<?php // echo $form->dropDownList($model,'ruangan_id',CHtml::listData(BSRuanganM::getRuanganByInstalasi($model->instalasi_id),'ruangan_id','ruangan_nama'),array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'empty'=>'-- Pilih --')); 
                ?>           
			</div>
		</div>	-->
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
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips.informasi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>