<?php
$this->breadcrumbs = [
    'Sapemeriksaanlabmapping Ms' => ['index'],
    'Manage',
];

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('sapemeriksaanlabmapping-m-grid', {
			data: $(this).serialize()
		});
		return false;
	});
	");

$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Pemeriksaan Alat Laboratorium</b>
        </div>
    </div>

    <div class="panel-body">
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', ['{icon}' => '<i class="icon-accordion icon-white"></i>']), '#', ['class' => 'search-button btn']); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial($this->path_view . '_search', [
                'model' => $model,
            ]); ?>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan Alat Laboratorium</b>
                </div>
            </div>

            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', [
                    'id' => 'sapemeriksaanlabmapping-m-grid',
                    'dataProvider' => $model->searchTabel(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => [
                        [
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
							($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
							: ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => ['style' => 'text-align:right;'],
                        ],
                        [
                            'header' => 'Nama Pemeriksaan',
                            'name' => 'pemeriksaanlabalat_nama',
                            'value' => '!empty($data->pemeriksaanlabalat->pemeriksaanlabalat_nama)?$data->pemeriksaanlabalat->pemeriksaanlabalat_nama:""',
                            'filter' => CHtml::activeTextField($model, 'pemeriksaanlabalat_nama'),
                        ],
                        [
                            'header' => 'Kode Pemeriksaan',
                            'name' => 'pemeriksaanlabalat_kode',
                            'value' => '!empty($data->pemeriksaanlabalat->pemeriksaanlabalat_kode)?$data->pemeriksaanlabalat->pemeriksaanlabalat_kode:""',
                            'filter' => CHtml::activeTextField($model, 'pemeriksaanlabalat_kode'),
                        ],

                        [
                            'header' => 'Kelompok Detail',
                            'name' => 'kelompokdet',
                            'value' => '!empty($data->nilairujukan->kelompokdet)?$data->nilairujukan->kelompokdet:""',
                            'filter' => CHtml::activeTextField($model, 'kelompokdet'),
                        ],
                        [
                            'header' => 'Pemeriksaan Detail',
                            'name' => 'namapemeriksaandet',
                            'value' => '!empty($data->nilairujukan->namapemeriksaandet)?$data->nilairujukan->namapemeriksaandet:""',
                            'filter' => CHtml::activeTextField($model, 'namapemeriksaandet'),
                        ],
                        [
                            'header' => 'Jenis Kelamin',
                            'name' => 'nilairujukan_jeniskelamin',
                            'value' => '!empty($data->nilairujukan->nilairujukan_jeniskelamin)?$data->nilairujukan->nilairujukan_jeniskelamin:""',
                            'filter' => LookupM::getItems('jeniskelamin'),
                        ],
                        [
                            'header' => 'Nilai Rujukan',
                            'name' => 'nilairujukan_nama',
                            'value' => '!empty($data->nilairujukan->nilairujukan_nama)?$data->nilairujukan->nilairujukan_nama:""',
                            'filter' => CHtml::activeTextField($model, 'nilairujukan_nama'),
                        ],
                        [
                            'header' => 'Nilai Minimum',
                            'name' => 'nilairujukan_min',
                            'value' => '!empty($data->nilairujukan->nilairujukan_min)?$data->nilairujukan->nilairujukan_min:""',
                            'filter' => CHtml::activeTextField($model, 'nilairujukan_min'),
                        ],
                        [
                            'header' => 'Nilai Maksimum',
                            'name' => 'nilairujukan_max',
                            'value' => '!empty($data->nilairujukan->nilairujukan_max)?$data->nilairujukan->nilairujukan_max:""',
                            'filter' => CHtml::activeTextField($model, 'nilairujukan_max'),
                        ],
                        [
                            'header' => 'Satuan',
                            'name' => 'satuan',
                            'value' => '!empty($data->nilairujukan->nilairujukan_satuan)?$data->nilairujukan->nilairujukan_satuan:""',
                            'filter' => CHtml::activeTextField($model, 'nilairujukan_satuan'),
                        ],
                        [
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;',),
                            'template' => '{delete}',
                            'buttons' => [
                                'delete' => [
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                ],
                            ],
                        ],
                    ],
                    'afterAjaxUpdate' => 'function(id, data){
						jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
						$("table").find("input[type=text]").each(function(){
							cekForm(this);
						})
						$("table").find("select").each(function(){
							cekForm(this);
						})
					}',
                ]); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Tambah Pemeriksaan Alat Lab.', ['{icon}' => '<i class="icon-plus icon-white"></i>']), $this->createUrl('create', ['modul_id' => Yii::app()->session['modul_id']]), ['class' => 'btn btn-danger', 'title' => 'Tambah pemeriksaan alat laboratorium']) . '&nbsp&nbsp';
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', ['{icon}' => '<i class="entypo-print"></i>']), ['class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')']) . '&nbsp&nbsp';
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', ['{icon}' => '<i class="entypo-book"></i>']), ['class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')']) . '&nbsp&nbsp';
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', ['{icon}' => '<i class="entypo-doc-text"></i>']), ['class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')']) . '&nbsp&nbsp';
            $content = $this->renderPartial('sistemAdministrator.views.tips.master', [], true);
            $this->widget('UserTips', ['type' => 'transaksi', 'content' => $content]);

            //mengambil Controller yang sedang dipakai
            $controller = Yii::app()->controller->id;
            //mengambil Module yang sedang dipakai
            $module = Yii::app()->controller->module->id;
            $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
function cekForm(obj)
{
    $("#sapemeriksaanlabmapping-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sapemeriksaanlabmapping-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
                            $.fn.yiiGridView.update('sapemeriksaanlabmapping-m-grid');
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