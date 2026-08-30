<?php $linkHalaman = CustomFunction::getUrlByMenuID(2538); ?>
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
	$.fn.yiiGridView.update('informasipenerimaanlinen-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Penerimaan Linen</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
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
                <?php $this->renderPartial($this->path_view . '_search', array('modPenerimaanlinen' => $modPenerimaanlinen, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penerimaan Linen</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasipenerimaanlinen-grid',
                    'dataProvider' => $modPenerimaanlinen->searchInformasi(),
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
                            'header' => 'No. Penerimaan',
                            'type' => 'raw',
                            'value' => '$data->nopenerimaanlinen',
                        ),
                        array(
                            'header' => 'Tanggal Penerimaan',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpenerimaanlinen)',
                        ),
                        array(
                            'name' => 'Instalasi',
                            'type' => 'raw',
                            'value' => '$data->ruangan->instalasi->instalasi_nama',
                        ),
                        array(
                            'name' => 'Ruangan',
                            'type' => 'raw',
                            'value' => '$data->ruangan->ruangan_nama',
                        ),
                        array(
                            'name' => 'keterangan_pengiriman',
                            'type' => 'raw',
                            'value' => '$data->keterangan_penerimaanlinen',
                        ),
                        //				RND-8968
                        //				array(
                        //					'header'=>'Proses',
                        //					'type'=>'raw',
                        //					'value'=>'CHtml::link("<button class=\'btn btn-success\'><i class=\'entypo-check\'></i> Proses</button>",  Yii::app()->controller->createUrl("/laundry/PenerimaanLinenT/index",array("id"=>$data->pengperawatanlinen_id)),array("rel"=>"tooltip","title"=>"Klik untuk Penerimaan Linen","disabled"=>true));',    'htmlOptions'=>array('style'=>'text-align: center; width:100px')
                        //				),
                        //                        array(
                        //                            'name' => 'Nama Linen',
                        //                            'type' => 'raw',
                        //                            'value' => '$data->namalinen',
                        //                        ),
                        array(
                            'name' => 'Perawatan Linen',
                            'type' => 'raw',
                            'value' => '($data->jenisperawatanlinen == "' . Params::JENISPERAWATAN_PERAWATAN . '")?($data->checkperawatanLinen($data->penerimaanlinen_id)==1)?"Sudah Dirawat":CHtml::Link("<i class=\'icon-rawatlinen\'></i>",Yii::app()->controller->createUrl("/laundry/PerawatanLinen/Index",array("penerimaanlinen_id"=>$data->penerimaanlinen_id)),array("class"=>"", "rel"=>"tooltip","title"=>"Klik Melakukan Ke Perawatan Linen")):""',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'name' => 'Pencucian Linen',
                            'type' => 'raw',
                            'value' => '($data->jenisperawatanlinen == "' . Params::JENISPERAWATAN_PENCUCIAN . '")? ($data->checkpencucianLinen($data->penerimaanlinen_id)==1)?"Sudah Dicuci":CHtml::Link("<i class=\'icon-cucilinen\'></i>",Yii::app()->controller->createUrl("/laundry/PencucianLinen/Index",array("penerimaanlinen_id"=>$data->penerimaanlinen_id)),array("class"=>"", "rel"=>"tooltip","title"=>"Klik Melakukan Ke Pencucian Linen")):""',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Lihat Detail',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-lihat\'></i> ",  Yii::app()->controller->createUrl("/laundry/informasiPenerimaanLinen/detail",array("penerimaanlinen_id"=>$data->penerimaanlinen_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Penerimaan Linen", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',
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
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/batalPenerimaan",array("id"=>$data->penerimaanlinen_id))',
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
                            $.fn.yiiGridView.update('informasipenerimaanlinen-grid');
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