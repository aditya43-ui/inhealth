<?php $linkHalaman = CustomFunction::getUrlByMenuID(2746); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pembayaran Gaji Pegawai',
);
Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('#kupembgajipeg-t-search').submit(function(){
		$.fn.yiiGridView.update('kupembgajipeg-t-grid', {
			data: $(this).serialize()
		});
		return false;
	});
	");
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pembayaran Gaji Pegawai</b>
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
                    <i class="entypo-credit-card"></i> Tabel <b>Pembayaran Gaji Pegawai</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'kupembgajipeg-t-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                        ),
                        array(
                            'name' => 'periodegaji',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return MyFormatter::formatMonthForUser(date('Y-m', strtotime($data->periodegaji)));
                                //return $data->tglpenggajian;
                                //return date('M Y', strtotime($data->tglpenggajian));
                            },
                        ),
                        array(
                            'header' => 'No. Pengeluaran',
                            'name' => 'nopengeluaran',
                            'value' => '$data->nopengeluaran',
                        ),
                        array(
                            'name' => 'nokaskeluar',
                            'value' => '$data->nokaskeluar',
                        ),
                        array(
                            'header' => 'Jumlah Pembayaran Gaji (Rp)',
                            'name' => 'totalterima',
                            'value' => 'MyFormatter::formatNumberForPrint($data->totalharga)',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Detail',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->createUrl("penggajian/InformasiPembayaranGaji/detail",array("id"=>$data->pengeluaranumum_id,"frame"=>true)),
											array("class"=>"", 
												"target"=>"detailPembayaran",
												"onclick"=>"$(\"#dialogDetail\").dialog(\"open\");",
												"rel"=>"tooltip",
												"title"=>"Klik untuk melihat detail Pembayaran Gaji",
										))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Batal',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-silang\"></i>",Yii::app()->controller->createUrl("InformasiPembayaranGajiKU/batalPembayaran",array("id"=>$data->pengeluaranumum_id,"frame"=>true)),
											array("class"=>"", 
												"target"=>"batalPembayaran",
												"onclick"=>"$(\"#dialogPembatalan\").dialog(\"open\");",
												"rel"=>"tooltip",
												"title"=>"Klik untuk membatalkan Pembayaran Gaji",
											))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
        <!--fieldset class="box"-->
        <!--</fieldset>-->
    </div>
</div>
<?php
// ===========================Dialog Detail=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Pembayaran Gaji',
        'autoOpen' => false,
        'width' => 900,
        'height' => 400,
        'zIndex' => 1002,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('kupembgajipeg-t-grid', {
            data: $(this).serialize()
        }); }",
    ),
));
?>
<iframe src="" name="detailPembayaran" width="100%" height="98%" style="overflow:auto; border: none;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Detail================================
?>
<?php
// ===========================Dialog Pembatalan=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPembatalan',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Pembatalan Pembayaran Gaji',
        'autoOpen' => false,
        'width' => 550,
        'zIndex' => 1002,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('kupembgajipeg-t-grid', {
            data: $(this).serialize()
        }); }",
    ),
));
?>
<iframe src="" name="batalPembayaran" width="100%" height="300" style="overflow:auto; border: none;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Pembatalan================================
?>