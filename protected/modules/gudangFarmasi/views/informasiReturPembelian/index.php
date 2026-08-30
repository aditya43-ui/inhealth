<?php
Yii::app()->clientScript->registerScript('search', "
$('#divSearch-form form').submit(function(){
	$.fn.yiiGridView.update('retur-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Retur Pembelian</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . 'search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Retur Pembelian</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
                    <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'retur-m-grid',
                        'dataProvider' => $model->searchInformasi(),
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                        'columns' => array(
                            'returpembelian_id',
                            array(
                                'name' => 'tglretur',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", (strtotime("$data->tglretur"))))',
                            ),
                            array(
                                'name' => 'noretur',
                                'type' => 'raw',
                                'value' => '$data->noretur',
                            ),
                            array(
                                'name' => 'alasanretur',
                                'type' => 'raw',
                                'value' => '$data->alasanretur',
                            ),
                            array(
                                'name' => 'instalasi_nama',
                                'type' => 'raw',
                                'value' => '$data->instalasi_nama',
                            ),
                            array(
                                'name' => 'ruangan_nama',
                                'type' => 'raw',
                                'value' => '$data->ruangan_nama',
                            ),
                            array(
                                'name' => 'tglterima',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", (strtotime("$data->tglterima"))))',
                            ),
                            array(
                                'name' => 'tglterimafaktur',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", (strtotime("$data->tglterimafaktur"))))',
                            ),
                            array(
                                'name' => 'tglfaktur',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", (strtotime("$data->tglfaktur"))))',
                            ),
                            array(
                                'name' => 'nofaktur',
                                'type' => 'raw',
                                'value' => '$data->nofaktur',
                            ),
                            array(
                                'name' => 'tgljatuhtempo',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", (strtotime("$data->tgljatuhtempo"))))',
                            ),
                            array(
                                'name' => 'supplier_nama',
                                'type' => 'raw',
                                'value' => '$data->supplier_nama',
                            ),
                            array(
                                'header' => 'Batal',
                                'type' => 'raw',
                                'value' => 'CHtml::link("<i class=\'icon-form-silang\'></i> ", "javascript:deleteRecord($data->returpembelian_id)",array("id"=>"$data->returpembelian_id","rel"=>"tooltip","title"=>"Batalkan Retur Pembelian"));',
                                'htmlOptions' => array('style' => 'text-align: center; width:40px'),
                            ),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    )); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function deleteRecord(id) {
        myConfirm('Yakin Akan Membatalkan Retur Pembelian ini?', 'Perhatian!', function(r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id) . "/batalRetur"; ?>',
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status == 'delete') {
                            $.fn.yiiGridView.update('retur-m-grid');
                        } else {
                            myAlert('Retur Pembelian Gagal di Dibatalkan');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        });
    }
</script>