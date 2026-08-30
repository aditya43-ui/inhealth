<?php
$this->breadcrumbs = array(
    'Informasi Pembayaran Pesangon Pegawai',
);
Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('#gjpembpesangonpeg-t-search').submit(function(){
		$.fn.yiiGridView.update('gjpembpesangonpeg-t-grid', {
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
            <i class="entypo-info-circled"></i> Informasi <b>Pembayaran Pesangon Pegawai</b>
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
                    <i class="entypo-credit-card"></i> Tabel <b>Pembayaran Pesangon Pegawai</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'gjpembpesangonpeg-t-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                        ),
                        array(
                            'header' => 'Periode Gaji',
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
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            ),
                        ),
                        array(
                            'header' => 'Detail',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->createUrl("penggajian/InformasiPembayaranPesangon/detail",array("id"=>$data->pengeluaranumum_id,"frame"=>true)),
											array("class"=>"", 
												"target"=>"detailPembayaran",
												"onclick"=>"$(\"#dialogDetail\").dialog(\"open\");",
												"rel"=>"tooltip",
												"title"=>"Klik untuk melihat detail Pembayaran Pesangon Pegawai",
										))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Batal',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-silang\"></i>",Yii::app()->createUrl("penggajian/InformasiPembayaranPesangon/batalPembayaran",array("id"=>$data->pengeluaranumum_id,"frame"=>true)),
											array("class"=>"", 
												"target"=>"batalPembayaran",
												"onclick"=>"$(\"#dialogPembatalan\").dialog(\"open\");",
												"rel"=>"tooltip",
												"title"=>"Klik untuk membatalkan Pembayaran Pesangon Pegawai",
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
        'title' => 'Detail Pembayaran Pesangon Pegawai',
        'autoOpen' => false,
        'width' => 900,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('gjpembpesangonpeg-t-grid', {
            data: $(this).serialize()
        }); }",
    ),
));
?>
<iframe src="" name="detailPembayaran" style="width: 100%; height: 98%;"></iframe>
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
        'title' => 'Pembatalan Pembayaran Pesangon Pegawai',
        'autoOpen' => false,
        'width' => 550,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('gjpembpesangonpeg-t-grid', {
            data: $(this).serialize()
        }); }",
    ),
));
?>
<iframe src="" name="batalPembayaran" width="100%" height="300"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Pembatalan================================
?>