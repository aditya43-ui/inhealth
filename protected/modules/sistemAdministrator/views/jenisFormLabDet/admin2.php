<?php
$this->breadcrumbs = array(
    'Jenis Form Det' => array('index'),
    'Kelola',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sajenisformdetlab-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);


if (isset($_GET['JenisformdetM'])) {
    $model->attributes = $_GET['JenisformdetM'];
    $model->pemeriksaanlab_nama = $_GET['JenisformdetM']['pemeriksaanlab_nama'];
    $model->pemeriksaanlab_kode = $_GET['JenisformdetM']['pemeriksaanlab_kode'];
    $model->jenispemeriksaanlab_kelompok = $_GET['JenisformdetM']['jenispemeriksaanlab_kelompok'];
    $model->jenispemeriksaanlab_nama = $_GET['JenisformdetM']['jenispemeriksaanlab_nama'];
}

?>
<!--<legend class="rim">Pengaturan Jenis Pemeriksaan Lab</legend>-->
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Jenis Form Detail</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'sajenisformdetlab-m-grid',
                    'dataProvider' => $model->searchForm(),
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
                            'htmlOptions' => array('style' => 'text-align: right; width: 20px;'),
                        ),
                        array(
                            'header' => 'Kelompok Pemeriksaan Lab',
                            'value' => '$data->jenispemeriksaanlab_kelompok',
                            'htmlOptions' => array('style' => 'text-align: center; width: 200px;'),
                            'filter' => Chtml::activeDropDownList($model, 'jenispemeriksaanlab_kelompok', LookupM::getItemsUrutan('jenispemeriksaanlab_kelompok'), array('empty'=>'-- Pilih --', 'class' => 'custom-only')),
                        ),
                        array(
                            'header' => 'Jenis Pemeriksaan Lab',
                            'value' =>'$data->jenispemeriksaanlab_nama',
                            'htmlOptions' => array('style' => 'text-align: center; width: 200px;'),
                            'filter' => Chtml::activeTextField($model, 'jenispemeriksaanlab_nama', array('class' => 'custom-only')),
                        ),
                        array(
                            'header' => 'Kode Pemeriksaan Lab',
                            'value' => '$data->pemeriksaanlab_kode',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'filter' => Chtml::activeTextField($model, 'pemeriksaanlab_kode', array('class' => 'custom-only')),
                            
                        ),
                        array(
                            'header' => 'Nama Pemeriksaan Lab',
                            'value' => '$data->pemeriksaanlab_nama',
                            'htmlOptions' => array('style' => ''),
                            'filter' => Chtml::activeTextField($model, 'pemeriksaanlab_nama', array('class' => 'custom-only')),
                     
                        ),
                        
                        array(
                            'header' => 'Nama Jenis Form',
                            'value' => '$data->jenisform_nama',
                            'htmlOptions' => array('style' => 'text-align: center; width: 200px;'),
                            'filter' => Chtml::activeDropDownList($model, 'jenisform_id', CHtml::listData(JenisformM::model()->findAll('jenisform_aktif = true order by jenisform_nama'), 'jenisform_id', 'jenisform_nama'), array('empty'=>'-- Pilih --','class' => 'custom-only')),
                            
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord(".$data->formlab_id.")",array("id"=>"$data->formlab_id","rel"=>"tooltip","title"=>"Hapus"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                    
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
								 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
								 $("table").find("input[type=text]").each(function(){
									 cekForm(this);
								 })
							 }',
                )); ?>
            </div>
        </div>

       

<script type="text/javascript">
    function deleteRecord(id) {
            var id = id;
            var url = '<?php echo $url . "/delete"; ?>';
            myConfirm("Yakin Akan Menghapus Data ini?", "Perhatian!", function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('sajenisformdetlab-m-grid');
                            } else {
                                myAlert('Data gagal dihapus!')
                            }
                        }, "json");
                }
            });
    }
</script>