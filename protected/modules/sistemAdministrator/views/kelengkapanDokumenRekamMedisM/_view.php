<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Instalasi</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
		<div class="view">
			<b><?php echo CHtml::encode($model->getAttributeLabel('jenisdokumen')); ?>:</b>
			<?php echo CHtml::encode($model->jenisdokumen); ?>
			<br>
		
			<b><?php echo CHtml::encode($model->getAttributeLabel('nama_dokumen')); ?>:</b>
			<?php echo CHtml::encode($model->nama_dokumen); ?>
			<br>
		
			<b><?php echo CHtml::encode($model->getAttributeLabel('urutan_dokumen')); ?>:</b>
			<?php echo CHtml::encode($model->urutan_dokumen); ?>
			<br>
		
			<b><?php echo CHtml::encode($model->getAttributeLabel('level_dokumen')); ?>:</b>
			<?php echo CHtml::encode($model->level_dokumen); ?>
			<br>
		
			<b><?php echo CHtml::encode($model->getAttributeLabel('kelengkapandokumen_aktif')); ?>:</b>
			<?php echo CHtml::encode((($model->kelengkapandokumen_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
			<br>
		
		</div>
	</div>
</div>