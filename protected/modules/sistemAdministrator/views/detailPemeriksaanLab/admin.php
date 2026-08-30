<?php
$this->breadcrumbs = array(
    'Sapemeriksaanlabdet Ms' => array('index'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sapemeriksaanlabdet-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Detail Pemeriksaan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            )); ?>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Detail Pemeriksaan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'sapemeriksaanlabdet-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
										($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
										: ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Nama Pemeriksaan',
                            'type' => 'raw',
                            'name' => 'pemeriksaanlab_nama',
                            'value' => '$data->pemeriksaanlab->pemeriksaanlab_nama',
                            'filter' =>  CHtml::activeTextField($model, 'pemeriksaanlab_nama'),
                        ),
                        array(
                            'header' => 'Kelompok Detail',
                            'type' => 'raw',
                            'name' => 'kelompokdet',
                            'value' => '$data->getNamaPemeriksaanDet($data->pemeriksaanlabdet_id)',
                            'filter' =>  CHtml::activeTextField($model, 'kelompokdet'),
                        ),
                        array(
                            'header' => 'Nama Pemeriksaan Detail',
                            'type' => 'raw',
                            'name' => 'namapemeriksaandet',
                            'value' => '$data->getKelompokDet($data->pemeriksaanlabdet_id)',
                            'filter' =>  CHtml::activeTextField($model, 'namapemeriksaandet'),
                        ),
                        array(
                            'type' => 'raw',
                            'name' => 'nilairujukan_jeniskelamin',
                            'value' => '$data->nilairujukan->nilairujukan_jeniskelamin',
                            'filter' => CHtml::dropDownList('SAPemeriksaanlabdetM[nilairujukan_jeniskelamin]', $model->nilairujukan_jeniskelamin, LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --')),
                        ),
                        array(
                            'header' => 'Kelompok Umur',
                            'type' => 'raw',
                            'value' => '$data->nilairujukan->kelkumurhasillab->kelkumurhasillabnama',
                            'filter' => CHtml::dropDownList(
                                'SAPemeriksaanlabdetM[kelkumurhasillab_id]',
                                $model->kelkumurhasillab_id,
                                CHtml::listData(KelkumurhasillabM::model()->findAll('kelkumurhasillab_aktif order by kelkumurhasillab_urutan'), 'kelkumurhasillab_id', 'kelkumurhasillabnama'),
                                array('empty' => '-- Pilih --')
                            ),
                        ),
                        array(
                            'type' => 'raw',
                            'name' => 'nilairujukan_nama',
                            'value' => '$data->NilaiRujukan',
                            'filter' =>  CHtml::activeTextField($model, 'nilairujukan_nama', array('class' => 'numbers-only')),
                        ),
                        array(
                            'name' => 'nilairujukan_min',
                            'type' => 'raw',
                            'value' => '$data->nilairujukan->nilairujukan_min',
                            'filter' =>  CHtml::activeTextField($model, 'nilairujukan_min', array('class' => 'numbers-only')),
                        ),
                        array(
                            'name' => 'nilairujukan_max',
                            'type' => 'raw',
                            'value' => '$data->nilairujukan->nilairujukan_max',
                            'filter' =>  CHtml::activeTextField($model, 'nilairujukan_max', array('class' => 'numbers-only')),
                        ),
                        array(
                            'name' => 'nilairujukan_satuan',
                            'type' => 'raw',
                            'value' => '$data->nilairujukan->nilairujukan_satuan',
                            'filter' => CHtml::dropDownList('SAPemeriksaanlabdetM[nilairujukan_satuan]', $model->nilairujukan_satuan, LookupM::getItems('satuanhasillab'), array('empty' => '-- Pilih --')), //,
                        ),
                        'pemeriksaanlabdet_nourut',
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/index",array("id"=>$data->pemeriksaanlab_id))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{delete}',
                            'buttons' => array(
                                'delete' => array(),
                            )
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){'
                        . 'jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
                        . '$(".numbers-only").keyup(function() {
								setNumbersOnly(this);
							});'
                        . '}',
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Tambah Detail Pemeriksaan', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('index', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger', 'title' => 'Tambah detail pemeriksaan'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_view . 'tips/tipsAdmin', array(), true);
            $this->widget('UserTips', array('content' => $content));
            $urlPrint = $this->createUrl('print');

            $js = <<< JSCRIPT
					function print(caraPrint){
						window.open("${urlPrint}/"+$('#sapemeriksaanlabdet-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
					}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function nonActive(obj) {
        myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!",
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {}, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('sapemeriksaanlabdet-m-grid');
                            if (data.sukses > 0) {} else {
                                myAlert('Data gagal dinonaktifkan!');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            myAlert('Data gagal dinonaktifkan!');
                            console.log(errorThrown);
                        }
                    });
                }
            }
        );
        return false;
    }
</script>