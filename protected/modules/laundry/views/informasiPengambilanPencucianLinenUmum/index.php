<?php
$this->breadcrumbs = array(
    'Informasi Penerimaan Linen',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('informasipengambilancucilinenumum-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pengambilan Pencucian Linen Umum</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pengambilan Pencucian Linen Umum</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasipengambilancucilinenumum-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'replaceUrl' => true,
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
							($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
							: ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:right; width:30px;'),
                        ),
                        array(
                            'header' => 'Tanggal Penerimaan',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpenerimaan)',
                        ),
                        array(
                            'header' => 'Tanggal Pengambilan',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpengambilan)',
                        ),
                        array(
                            'header' => 'No. Penerimaan',
                            'value' => '$data->nopenerimaan',
                        ),
                        array(
                            'header' => 'No. Pengambilan',
                            'value' => '$data->nopengambilan',
                        ),
                        array(
                            'header' => 'Nama Pengirim',
                            'value' => '$data->namapengirim',
                        ),
                        array(
                            'header' => 'Nama Pengambil',
                            'value' => '$data->namapengambil',
                        ),
                        array(
                            'header' => 'Berat',
                            'value'  => function($data){
                                return 'Rp.'.number_format($data->berat,2,',','.');
                            },
                        ),
                        array(
                            'name' => 'Harga',
                            'type' => 'raw',
                            'value'  => function($data){
                                return 'Rp.'.number_format($data->harga,2,',','.');
                            },
                            'htmlOptions' => array('style' => 'text-align: right; width: 60px;'),
                        ),
                        array(
                            'header' => 'Lihat Detail',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-lihat\'></i> ",  Yii::app()->controller->createUrl("/laundry/InformasiPengambilanPencucianLinenUmum/detail",array("ambilpencucianlinenumum_id"=>$data->ambilpencucianlinenumum_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Penerimaan Linen", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => Yii::t('zii', 'Batal'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{remove}',
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='icon-form-silang'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/batalPenerimaan",array("ambilpencucianlinenumum_id"=>$data->ambilpencucianlinenumum_id, "terimapencucianlinenumum_id"=>$data->terimapencucianlinenumum_id))',
                                    'click' => 'function(){batalPenerimaan(this);return false;}',
                                    //								'visible'=>'(($data->ruangan_id == Yii::app()->user->getState("ruangan_id"))? TRUE : FALSE)'
                                ),
                            ),
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->renderPartial($this->path_view . '_search', array(
                    'model' => $model, 'format' => $format
                ));
                ?>
            </div>
        </div>

    </div>
</div>

<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Penerimaan Linen',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => true,
    ),
));

echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';

$this->endWidget();
?>

<script type="text/javascript">
    function batalPenerimaan(obj) {
        myConfirm("Anda yakin akan membatalkan data ini?", "Perhatian!",
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {}, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('informasipengambilancucilinenumum-grid');
                            if (data.sukses > 0) {} else {
                                myAlert('Data Berhasil Dibatalkan');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            myAlert('Data gagal dibatalkan!');
                            console.log(errorThrown);
                        }
                    });
                }
            }
        );
        return false;
    }
</script>