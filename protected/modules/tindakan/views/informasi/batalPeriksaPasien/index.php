<?php
Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('#search').submit(function(){
		$.fn.yiiGridView.update('daftarpasien-v-grid', {
			data: $(this).serialize()
		});
		return false;
	});
");
$this->breadcrumbs = array(
    'Informasi Pasien Batal Periksa'
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pasien Batal Periksa</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('rawatJalan.views.informasi.batalPeriksaPasien._search', array('model' => $model, 'format' => $format)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Batal Periksa</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="">
                    <?php $this->renderPartial('rawatJalan.views.informasi.batalPeriksaPasien._table', array('model' => $model)); ?>
                </div>
            </div>
        </div>
    </div>
</div>