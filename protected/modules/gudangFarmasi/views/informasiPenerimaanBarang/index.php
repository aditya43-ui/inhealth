<?php $linkHalaman = CustomFunction::getUrlByMenuID(1211); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Penerimaan Obat dan Alkes Dari Supplier',
);
Yii::app()->clientScript->registerScript('search', "
$('#divSearch-form form').submit(function(){
	$.fn.yiiGridView.update('rencana-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Penerimaan Obat dan Alkes Dari Supplier</b>
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
                <?php echo $this->renderPartial('search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penerimaan Obat dan Alkes dari Supplier</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'rencana-m-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'replaceUrl' => true,
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                            ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                            : ($row+1)'
                        ),
                        array(
                            'header' => 'Tgl. Terima/<br>No Terima',
                            'name' => 'tglterima',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return MyFormatter::formatDateTimeForUser($data->tglterima) . '/<br>' . $data->noterima;
                                //                                            return CHtml::Link('<u>'. MyFormatter::formatDateTimeForUser($data->tglterima).'/<br>'.$data->noterima.'</u>',Yii::app()->controller->createUrl("PenerimaanBarang/print",array("penerimaanbarang_id"=>$data->penerimaanbarang_id,"frame"=>true)),
                                //                                                array("class"=>"", 
                                //                                                      "target"=>"rencana",
                                //                                                      "onclick"=>'$("#dialogPenerimaan").dialog("open");',
                                //                                                      "rel"=>"tooltip",
                                //                                                      "title"=>"Klik untuk melihat details Penerimaan Barang",
                                //                                                ));
                            }
                            //'value'=>'MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->tglterima)))',
                        ),
                        array(
                            'header' => 'Tgl. Faktur/<br>No Faktur',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center;'),
                            'value' => function ($data) {
                                //                                            if (empty($data->fakturpembelian_id)) {
                                //                                                return CHtml::link('<i class="icon-form-fakturbeli"></i>',$this->createUrl("fakturPembelian/index", array('penerimaanbarang_id'=>$data->penerimaanbarang_id)),
                                //                                                    array("class"=>"", 
                                //                                                        "rel"=>"tooltip",
                                //                                                        "title"=>"Klik untuk melakukan Faktur Pembelian",
                                //                                                    ));
                                //                                            }
                                //                                            
                                $faktur = FakturpembelianT::model()->findByPk($data->fakturpembelian_id);
                                return (isset($faktur) ? CHtml::Link(
                                    '<u>' . MyFormatter::formatDateTimeForUser($faktur->tglfaktur) . '/<br>' . $faktur->nofaktur . '</u>',
                                    Yii::app()->controller->createUrl("fakturPembelian/print", array("fakturpembelian_id" => $data->fakturpembelian_id, "frame" => true)),
                                    array(
                                        "class" => "",
                                        "target" => "faktur",
                                        "onclick" => '$("#dialogFaktur").dialog("open");',
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk melihat details Faktur Penerimaan Barang",
                                    )
                                ) : "Faktur Belum Ada");
                            },
                        ),
                        array(
                            'name' => 'supplier_id',
                            'type' => 'raw',
                            'value' => '$data->supplier_nama',
                        ),
                        array(
                            'header' => 'Total Harga Netto (Rp)',
                            'type' => 'raw',
                            'value' => 'number_format($data->harganettotal,2,",",".")',
                            'htmlOptions' => array('style' => (Params::cekHiddenHargaGudangFarmasi() == false) ? 'text-align:center' : 'text-align:right')
                        ),
                        array(
                            'header' => 'Total Keringanan (Rp)',
                            'type' => 'raw',
                            'value' => 'number_format($data->totaljmldiscount,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Total PPN (Rp)',
                            'type' => 'raw',
                            'value' => 'number_format($data->totalpajakppn,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Total Harga Bruto (Rp)',
                            'type' => 'raw',
                            'value' => 'number_format($data->totalharga,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Pegawai Penerima',
                            'value' => function ($data) {
                                $pen = GFPenerimaanBarangT::model()->findByPk($data->penerimaanbarang_id);
                                return $pen->pegawai->namaLengkap;
                            }
                        ),
                        array(
                            'name' => 'pegawaimengetahui_id',
                            'type' => 'raw',
                            'value' => '$data->PegawaimengetahuiLengkap',
                        ),
                        array(
                            'name' => 'statuspenerimaan',
                            'type' => 'raw',
                            'value' => '$data->statuspenerimaan',
                        ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => 'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("PenerimaanBarang/print",array("penerimaanbarang_id"=>$data->penerimaanbarang_id,"frame"=>true)),
										array("class"=>"", 
											  "target"=>"rencana",
											  "onclick"=>"$(\"#dialogPenerimaan\").dialog(\"open\");",
											  "rel"=>"tooltip",
											  "title"=>"Klik untuk melihat Rincian Penerimaan Barang",
										))',
                        ),
                        array(
                            'header' => 'Status Bayar',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $modFaktur = FakturpembelianT::model()->findByAttributes(array('penerimaanbarang_id' => $data->penerimaanbarang_id));
                                $html = Params::getWrStatusBayar(Params::STATUSBAYAR_BELUM_LUNAS);
                                if (!empty($modFaktur)) {
                                    $bayarSupplier = BayarkesupplierT::model()->findAllByAttributes(array('fakturpembelian_id' => $modFaktur->fakturpembelian_id));
                                    if (!empty($bayarSupplier)) {
                                        $totalSisaTagihan = 0;
                                        foreach ($bayarSupplier as $byr) {
                                            $totalSisaTagihan += $byr->totalsisatagihan;
                                        }
                                        if ($totalSisaTagihan == 0) {
                                            $html = Params::getWrStatusBayar(Params::STATUSBAYAR_LUNAS);
                                        }
                                    }
                                }
                                return $html;
                            }
                        ),
                        array(
                            'header' => 'Retur',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => function ($data) {
                                if (empty($data->fakturpembelian_id)) {
                                    return "Faktur<br>Belum Ada";
                                } else {
                                    if (empty($data->returpembelian_id)) {
                                        $cekBayar = GFFakturpembelianT::model()->findByPk($data->fakturpembelian_id);
                                        if (Params::cekUnitReturTerimaOa(Yii::app()->user->getState('unitkerja_id'), 'gudangfarmasi')) {
                                            //														if (empty($cekBayar->bayarkesupplier_id)){
                                            //															return CHtml::Link("<i class='icon-form-retur'></i>","javascript:;",array("class"=>"", 
                                            //																	"rel"=>"tooltip",
                                            //																	"title"=>"Klik untuk membuat retur pembelian",
                                            //																	"data-placement" => "left",
                                            //																	"onclick" => "myAlert('Faktur Belum Lunas')"
                                            //															  ));
                                            //														}else{
                                            return CHtml::Link("<i class='icon-form-retur'></i>", $this->createUrl("PenerimaanBarang/returPembelianOA") . '&penerimaanbarang_id=' . $data->penerimaanbarang_id, array(
                                                "class" => "",
                                                "rel" => "tooltip",
                                                "title" => "Klik untuk membuat retur pembelian",
                                                "data-placement" => "left"
                                            ));
                                            //														}																												
                                        } else {
                                            return CHtml::Link("<i class='icon-form-retur'></i>", "javascript:;", array(
                                                "class" => "",
                                                "rel" => "tooltip",
                                                "title" => "Klik untuk membuat retur pembelian",
                                                "data-placement" => "left",
                                                "onclick" => "myAlert('Hanya Unit Farmasi dan Purchasing yang bisa mengakses ini')"
                                            ));
                                        }
                                    } else {
                                        return "Sudah Diretur";
                                    }
                                }
                            },
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPenerimaan',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Penerimaan',
        'autoOpen' => false,
        'minWidth' => 900,
        'height' => 320,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="rencana" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
// ===========================Dialog Faktur=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogFaktur',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Faktur Penerimaan',
        'autoOpen' => false,
        'minWidth' => 900,
        'height' => 320,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="faktur" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
?>