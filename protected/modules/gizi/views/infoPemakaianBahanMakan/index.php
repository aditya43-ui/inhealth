<?php $linkHalaman = CustomFunction::getUrlByMenuID(3300); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pemakaian Bahan Makanan',
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('informasipemakaianbhnmkn-v-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pemakaian Bahan Makanan</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemakaian Bahan Makanan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasipemakaianbhnmkn-v-grid',
                    'dataProvider' => $model->search(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
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
                            'header' => 'Instalasi Nama',
                            'type' => 'raw',
                            'value' => '$data->instalasi_nama',
                        ),
                        array(
                            'header' => 'Ruangan Nama',
                            'type' => 'raw',
                            'value' => '$data->ruangan_nama',
                        ),
                        array(
                            'header' => 'Tanggal Pemakaian Bahan Makanan',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpemakaianbhnmkn)',
                        ),
                        array(
                            'name' => 'No Pemakaian Bahan Makanan',
                            'type' => 'raw',
                            'value' => '$data->no_pemakaianbhnmkn',
                        ),
                        array(
                            'header' => 'Untuk Keperluan',
                            'type' => 'raw',
                            'value' => '$data->untukkeperluan',
                        ),
                        array(
                            'header' => 'Keterangan Pemakaian',
                            'type' => 'raw',
                            'value' => '$data->ketpemakaian',
                        ),
                        array(
                            'header' => 'Lihat',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'entypo-eye\'></i> ",  Yii::app()->controller->createUrl("/gizi/infoPemakaianBahanMakan/detail",array("id"=>$data->pemakaianbhnmkn_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Pemakaian Bahan Makanan", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));', 'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => Yii::t('zii', 'Batal'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{remove}',
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='entypo-cancel'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/batalPemakaianBahanMakanan",array("id"=>$data->pemakaianbhnmkn_id))',
                                    'click' => 'function(){batalPemakaianBahanMakanan(this);return false;}',
                                    'visible' => '(($data->ruanganpemakaibhnmkn == Yii::app()->user->getState("ruangan_id"))? TRUE : FALSE)'
                                ),
                            )
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
        <!--search-form-->
    </div>
</div>
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Pemakaian Bahan Makanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));
echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
?>
<script type="text/javascript">
    function batalPemakaianBahanMakanan(obj) {
        myConfirm("Anda yakin akan membatalkan data ini untuk sementara?", "Perhatian!",
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {}, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('informasipemakaianbhnmkn-v-grid');
                            if (data.sukses > 0) {} else {
                                myAlert('Data gagal dibatalkan!');
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