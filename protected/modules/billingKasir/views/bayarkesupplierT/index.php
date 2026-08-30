<?php
$this->breadcrumbs = array(
    'Pembayaran Ke Supplier',
);
Yii::app()->clientScript->registerScript('search', "
$('#divSearch-form form').submit(function(){
	$.fn.yiiGridView.update('bayarkesupplier-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pembayaran ke Supplier</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body" id="divSearch-form">
                <!--<div id="divSearch-form">-->
                <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'action' => Yii::app()->createUrl($this->route),
                    'method' => 'get',
                    'id' => 'bayarkesupplier-t-search',
                    'type' => 'horizontal',
                    'focus' => '#BayarkesupplierT_nofaktur'
                )); ?>
                <!--</div>-->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Tgl. Kas Keluar", 'tglterima', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d F Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($model->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'nokaskeluar', array('placeholder' => 'No. Kas Keluar', 'class' => 'span4 numberOnly')); ?>
                        <?php echo $form->textFieldRow($model, 'nofaktur', array('placeholder' => 'No. Faktur', 'class' => 'span4 numberOnly')); ?>
                        <?php echo $form->dropDownListRow($model, 'supplier_jenis', array('Farmasi' => 'Farmasi', 'Gizi' => 'Gizi', 'Umum' => 'Umum'), array('class' => 'span4 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'empty' => '-- Pilih --', 'maxlength' => 50)); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->dropDownListRow(
                            $model,
                            'supplier_id',
                            CHtml::listData(BKBayarkesupplierT::model()->getSupplierItems(), 'supplier_id', 'supplier_nama'),
                            array(
                                'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'empty' => '-- Pilih --',
                            )
                        ); ?>
                        <div class="control-group">
                            <?php echo Chtml::label('Status Bayar', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'statusBayar', array(1 => 'Sudah Lunas', 2 => 'Belum Lunas'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo Chtml::label('Status Batal', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'statusBatal', array(1 => 'Sudah Dibatalkan', 2 => 'Belum Dibatalkan'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo Chtml::label('Petugas Keuangan', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'petugaskeuangan', PegawairuanganV::getDropPegawai(Yii::app()->user->getState('ruangan_id')), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                    ); ?>
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        array(
                            'title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    ); ?>
                    <?php
                    $content = $this->renderPartial('../tips/informasi2', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pembayaran ke Supplier</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'bayarkesupplier-m-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
								($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
								: ($row+1)'
                        ),
                        array(
                            'header' => 'Tgl. Kas Keluar/<br>No. BKK',
                            'name' => 'tglterima',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return MyFormatter::formatDateTimeForUser($data->tglkaskeluar) . '/<br>' . $data->nokaskeluar;
                                //                                if (!empty($data->fakturpembelian_id)) {
                                //								return CHtml::Link('<u>'. MyFormatter::formatDateTimeForUser($data->tglkaskeluar).'/<br>'.$data->nokaskeluar.'</u>',Yii::app()->controller->createUrl($this->modul."PembayaranSupplier".$this->init."/print",array("id"=>$data->bayarkesupplier_id,"frame"=>true)),
                                //									array("class"=>"", 
                                //										  "target"=>"detailbkk",
                                //										  "onclick"=>'$("#dialogDetailBKK").dialog("open");',
                                //										  "rel"=>"tooltip",
                                //										  "title"=>"Klik untuk melihat details kas  keluar",
                                //									));
                                //                                } else if (!empty($data->terimapersediaan_id) || !empty($data->terimabahanmakan_id)) {
                                //                                    return CHtml::Link('<u>'. MyFormatter::formatDateTimeForUser($data->tglkaskeluar).'/<br>'.$data->nokaskeluar.'</u>',Yii::app()->controller->createUrl("/keuangan/PembayaranKeSupplierUmum/print",array("terimapersediaan_id"=>$data->terimapersediaan_id,"terimabahanmakan_id"=>$data->terimabahanmakan_id,"frame"=>true)),
                                //									array("class"=>"", 
                                //										  "target"=>"detailbkk",
                                //										  "onclick"=>'$("#dialogDetailBKK").dialog("open");',
                                //										  "rel"=>"tooltip",
                                //										  "title"=>"Klik untuk melihat details kas  keluar",
                                //									));
                                //                                }
                            }
                            //'value'=>'MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->tglterima)))',
                        ),
                        array(
                            'header' => 'Tgl. Faktur/<br>No Faktur',
                            'name' => 'tglterima',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data->fakturpembelian_id)) {
                                    return CHtml::Link(
                                        '<u>' . MyFormatter::formatDateTimeForUser($data->tglfaktur) . '/<br>' . $data->nofaktur . '</u>',
                                        Yii::app()->controller->createUrl($this->modul . "FakturPembelian" . $this->init . "/print", array("fakturpembelian_id" => $data->fakturpembelian_id, "frame" => true)),
                                        array(
                                            "class" => "",
                                            "target" => "iframe",
                                            "onclick" => '$("#dialogDetailsFaktur").dialog("open");',
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk melihat detail faktur pembelian",
                                        )
                                    );
                                } else if (!empty($data->terimapersediaan_id)) {
                                    return CHtml::Link(
                                        '<u>' . MyFormatter::formatDateTimeForUser($data->tglfaktur) . '/<br>' . $data->nofaktur . '</u>',
                                        Yii::app()->controller->createUrl($this->modul . "informasiFakturUmum/detailsFaktur", array("terimapersediaan_id" => $data->terimapersediaan_id, "frame" => true)),
                                        array(
                                            "class" => "",
                                            "target" => "iframe",
                                            "onclick" => '$("#dialogDetailsFaktur").dialog("open");',
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk melihat detail faktur pembelian",
                                        )
                                    );
                                } else if (!empty($data->terimabahanmakan_id)) {
                                    return CHtml::Link(
                                        '<u>' . MyFormatter::formatDateTimeForUser($data->tglfaktur) . '/<br>' . $data->nofaktur . '</u>',
                                        Yii::app()->controller->createUrl("/gizi/Terimabahanmakan/detailPenerimaan", array("id" => $data->terimabahanmakan_id, "frame" => true)),
                                        array(
                                            "class" => "",
                                            "target" => "iframe",
                                            "onclick" => '$("#dialogDetailsFaktur").dialog("open");',
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk melihat detail faktur pembelian",
                                        )
                                    );
                                }
                            }
                            //'value'=>'MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->tglterima)))',
                        ),
                        array(
                            'header' => 'Jenis Faktur',
                            'value' => function ($data) {
                                $modsup = SupplierM::model()->findByPk($data->supplier_id);
                                return $modsup->supplier_jenis;
                            }
                        ),
                        array(
                            'header' => 'Supplier',
                            'value' => '$data->supplier_nama'
                        ),
                        /*array(
							'header' => 'Uang Muka',
							'type' => 'raw',
							'value' => function($data){
								if (!empty($data->fakturpembelian->penerimaanbarang_id)){
									$uangmuka = UangmukabeliT::model()->findByAttributes(array('penerimaanbarang_id' => $data->fakturpembelian->penerimaanbarang_id));
									if (count((array)$uangmuka)>0){
										return number_format($uangmuka->jumlahuang,0,"",".");
									}
								}
							},
							'htmlOptions' => array('style' => 'text-align:right')
						),*/
                        array(
                            'header' => 'Jumlah Tagihan<br>(Rp)',
                            'type' => 'raw',
                            //'value'=>'number_format($data->totaltagihan,0,"",".")',
                            'value' => function ($data) {
                                return number_format($data->totaltagihan, 0, "", ".");
                            },
                            'htmlOptions' => array('style' => 'text-align:right')
                        ),
                        array(
                            'header' => 'Jumlah Pembayaran<br>(Rp)',
                            'type' => 'raw',
                            'value' => 'number_format($data->jmldibayarkan,0,"",".")',
                            'htmlOptions' => array('style' => 'text-align:right')
                        ),
                        array(
                            'header' => 'Sisa Tagihan<br>(Rp)',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $selisih = $data->totaltagihan - $data->jmldibayarkan;
                                return number_format($selisih <= 0 ? 0 : $selisih, 0, "", ".");;
                            },
                            'htmlOptions' => array('style' => 'text-align:right')
                        ),
                        array(
                            'header' => 'Status',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center;'),
                            'value' => function ($data) {
                                if (($data->totaltagihan - $data->jmldibayarkan) <= 0) {
                                    return Params::getWrStatusBayar(Params::STATUSBAYAR_LUNAS);
                                } else {
                                    return Params::getWrStatusBayar(Params::STATUSBAYAR_BELUM_LUNAS);
                                }
                            }
                        ),
                        array(
                            'header' => 'Petugas Keuangan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $log  = LoginpemakaiK::model()->findByPk($data->create_loginpemakai_id);
                                if (!empty($log)) {
                                    if (!empty($log->pegawai_id)) {
                                        return $log->pegawai->namaLengkap;
                                    } else {
                                        return $log->nama_pemakai;
                                    }
                                }
                            }
                        ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => function ($data) {
                                if (!empty($data->fakturpembelian_id)) {
                                    return CHtml::Link(
                                        '<i class=\'icon-form-detail\'></i>',
                                        Yii::app()->controller->createUrl($this->modul . "PembayaranSupplier" . $this->init . "/print", array("id" => $data->bayarkesupplier_id, "frame" => true)),
                                        array(
                                            "class" => "",
                                            "target" => "detailbkk",
                                            "onclick" => '$("#dialogDetailBKK").dialog("open");',
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk melihat details kas  keluar",
                                        )
                                    );
                                } else if (!empty($data->terimapersediaan_id) || !empty($data->terimabahanmakan_id)) {
                                    return CHtml::Link(
                                        '<i class=\'icon-form-detail\'></i>',
                                        Yii::app()->controller->createUrl("/keuangan/PembayaranKeSupplierUmum/print", array("terimapersediaan_id" => $data->terimapersediaan_id, "terimabahanmakan_id" => $data->terimabahanmakan_id, "frame" => true)),
                                        array(
                                            "class" => "",
                                            "target" => "detailbkk",
                                            "onclick" => '$("#dialogDetailBKK").dialog("open");',
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk melihat details kas  keluar",
                                        )
                                    );
                                }
                            }
                            //                                                'value'=>'CHtml::link("<i class=\'icon-form-detail\'></i> ",Yii::app()->controller->createUrl("FakturPembelianKU/print",array("fakturpembelian_id"=>$data->fakturpembelian_id,"frame"=>true)) ,array("title"=>"Klik untuk Melihat Rincian Faktur","target"=>"iframe", "onclick"=>"$(\"#dialogDetailsFaktur\").dialog(\"open\");", "rel"=>"tooltip"))',
                            //                                                'footer'=>'-',
                            //                                                'footerHtmlOptions'=>array('style'=>'text-align:left;color:white;'),
                        ),
                        array(
                            'header' => 'Batal bayar',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => function ($data) {
                                $batal = BatalbayarsupplierT::model()->findByAttributes(array(
                                    'bayarkesupplier_id' => $data->bayarkesupplier_id
                                ));
                                if (!empty($batal)) return "SUDAH</br>DIBATALKAN";
                                return CHtml::link("<i class='icon-form-silang'></i> ", Yii::app()->controller->createUrl("BatalBayarSupplier/index", array("idFakturPembelian" => $data->fakturpembelian_id, "tandabuktikeluar_id" => $data->tandabuktikeluar_id)), array("title" => "Klik untuk Membatalkan pembayaran ke Supplier", "rel" => "tooltip"));
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
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$action = $this->getAction()->getId();
$currentUrl =  Yii::app()->createUrl($module . '/' . $controller . '/' . $action);
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'form_hiddenFaktur',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('target' => '_new'),
    'action' => Yii::app()->createUrl($module . '/fakturPembelian/index'),
)); ?>
<?php echo CHtml::hiddenField('idPenerimaanForm', '', array('readonly' => true)); ?>
<?php echo CHtml::hiddenField('noPenerimaanForm', '', array('readonly' => true)); ?>
<?php echo CHtml::hiddenField('tglPenerimaanForm', '', array('readonly' => true)); ?>
<?php echo CHtml::hiddenField('currentUrl', $currentUrl, array('readonly' => true)); ?>
<?php $this->endWidget(); ?>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailsFaktur',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Faktur Pembelian',
        'autoOpen' => false,
        'minWidth' => 1100,
        'height' => 320,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('bayarkesupplier-m-grid', {
                                data: $('#bayarkesupplier-t-search').serialize()
                            }); }",
    ),
));
?>
<iframe src="" name="iframe" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogBatal',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Pembatalan pembayaran',
        'autoOpen' => false,
        'minWidth' => 1100,
        'height' => 320,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('bayarkesupplier-m-grid', {
                                data: $('#bayarkesupplier-t-search').serialize()
                            }); }",
    ),
));
?>
<iframe src="" name="iframeBatal" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailBKK',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Bukti Kas Keluar',
        'autoOpen' => false,
        'minWidth' => 900,
        'height' => 500,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('bayarkesupplier-m-grid', {
							data: $('#bayarkesupplier-t-search').serialize()
						}); }",
    ),
));
?>
<iframe src="" name="detailbkk" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
$js = <<< JSCRIPT
function formFaktur(idPenerimaan,noPenerimaan,tglPenerimaan)
{
    $('#idPenerimaanForm').val(idPenerimaan);
    $('#noPenerimaanForm').val(noPenerimaan);
    $('#tglPenerimaanForm').val(tglPenerimaan);
    $('#form_hiddenFaktur').submit();
}
JSCRIPT;
Yii::app()->clientScript->registerScript('javascript', $js, CClientScript::POS_HEAD); ?>
<script>
    document.getElementById('BayarkesupplierT_tgl_awalbayarkesupplier_date').setAttribute("style", "display:none;");
    document.getElementById('BayarkesupplierT_tgl_akhirbayarkesupplier_date').setAttribute("style", "display:none;");

    function cekTanggal() {
        var checklist = $('#berdasarkanpembayaran');
        var pilih = checklist.attr('checked');
        if (pilih) {
            document.getElementById('BayarkesupplierT_tgl_awalbayarkesupplier_date').setAttribute("style", "display:block;");
            document.getElementById('BayarkesupplierT_tgl_akhirbayarkesupplier_date').setAttribute("style", "display:block;");
        } else {
            document.getElementById('BayarkesupplierT_tgl_awalbayarkesupplier_date').setAttribute("style", "display:none;");
            document.getElementById('BayarkesupplierT_tgl_akhirbayarkesupplier_date').setAttribute("style", "display:none;");
        }
    }
</script>