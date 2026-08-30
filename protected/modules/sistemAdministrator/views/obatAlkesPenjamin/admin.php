<?php
$this->breadcrumbs = array(
	'Obat Alkes Penjamin' => array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sabank-rek-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Pengaturan <b>Obat Alkes Penjamin</b></div>
    </div>
    <div class="panel-body">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php //echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
	<!-- <div class="cari-lanjut2 search-form" style="display:none">
		<?php
		// $this->renderPartial($this->path_view . '_search', array(
		// 	'model' => $model,
		// ));
		?>
	</div> -->
	<div class="block-tabel">
		<?php
		$this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
			'id' => 'obatalkespenjamin-m-grid',
			'dataProvider' => $model->search(),
			'filter' => $model,
			'template' => "{summary}\n{items}\n{pager}",
			'itemsCssClass' => 'table table-striped table-bordered table-condensed',
			'mergeColumns' => array('carabayar_id','penjamin_id'),
			'columns' => array(
				array(
					'header' => 'No.',
					'value' => '($this->grid->dataProvider->pagination) ?
						($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
						: ($row+1)',
					'type' => 'raw',
					'htmlOptions' => array('style' => 'text-align:right;'),
				),
				array(
					'header' => 'Jenis Penjamin',
					'name' => 'carabayar_id',
					'filter' => CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif is TRUE order by carabayar_nama ASC'), 'carabayar_id', 'carabayar_nama'),
					'value' => '$data->carabayar->carabayar_nama',
				),
				array(
					'header' => 'Penjamin',
					'name' => 'penjamin_id',
					'filter' => CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif is TRUE order by penjamin_nama ASC'), 'penjamin_id', 'penjamin_nama'),
					'value' => '$data->penjamin->penjamin_nama',
				),
				array(
					'header' => 'Jenis Obat Alkes',
					'name' => 'jenisobatalkes_id',
					'filter' => CHtml::listData(JenisobatalkesM::model()->findAll('jenisobatalkes_aktif is TRUE order by jenisobatalkes_nama ASC'), 'jenisobatalkes_id', 'jenisobatalkes_nama'),
					'value' => 'isset($data->jenisobatalkes->jenisobatalkes_nama)?$data->jenisobatalkes->jenisobatalkes_nama:"-"',
				),
				array(
					'header' => 'Margin (%)',
					'type' => 'raw',
					'filter' => false,
					'value' => 'MyFormatter::formatNumberForPrint($data->persmargin,2)',
					'htmlOptions'=>array('style'=>'text-align: right')
				),
				array(
					'header' => 'Keringanan (%)',
					'type' => 'raw',
					'filter' => false,
					'value' => 'MyFormatter::formatNumberForPrint($data->persdiskon,2)',
					'htmlOptions'=>array('style'=>'text-align: right')
				),
				array(
					'header' => 'Biaya Administrasi (Rp)',
					'type' => 'raw',
					'filter' => false,
					'value' => 'MyFormatter::formatNumberForPrint($data->biayaadministrasi,2)',
					'htmlOptions'=>array('style'=>'text-align: right')
				),
				array(
					'header' => Yii::t('zii', 'View'),
					'class' => 'bootstrap.widgets.BootButtonColumn',
					'template' => '{view}',
					'buttons' => array(
						'view' => array(),
					),
				),
				array(
					'header' => Yii::t('zii', 'Update'),
					'class' => 'bootstrap.widgets.BootButtonColumn',
					'template' => '{update}',
					'buttons' => array(
						'update' => array(
							'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
							'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/index",array("id"=>$data->obatalkespenjamin_id))',
						),
					),
				),
				array(
					'header' => Yii::t('zii', 'Delete'),
					'class' => 'bootstrap.widgets.BootButtonColumn',
					'template' => '{delete}',
					'buttons' => array(
						'delete' => array(
							'label' => "<i class='icon-delete'></i>",
							'options' => array('title' => Yii::t('mds', 'Delete')),
							'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/delete",array("id"=>"$data->obatalkespenjamin_id"))',
						),
					)
				),
			),
			'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
		));
		?>
	</div>
	<br />
	<?php
	echo CHtml::link(Yii::t('mds', '{icon} Tambah Obat Alkes Penjamin', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('index', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp&nbsp";
	echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
	echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
	echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
	$this->widget('UserTips', array('content' => ''));
	$urlPrint = $this->createUrl('print');

	$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#obatalkespenjamin-m-grid').find('input,select').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
	Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
	?>
    </div>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>
