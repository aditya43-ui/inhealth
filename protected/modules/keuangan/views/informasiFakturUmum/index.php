<?php $linkHalaman = CustomFunction::getUrlByMenuID(1414); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Faktur Pembelian Barang Non Medis</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'fakturpembelianumum-t-search',
            'type' => 'horizontal',
        )); ?>
        <?php
        $this->breadcrumbs = array(
            'Informasi Faktur Pembelian Barang Non Medis',
        );
        Yii::app()->clientScript->registerScript('search', "
					$('#fakturpembelianumum-t-search').submit(function(){
						$.fn.yiiGridView.update('fakturpembelianumum-m-grid', {
							data: $(this).serialize()
						});
						return false;
					});
					");
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="row" id="divSearch-form">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php //$modFaktur->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modFaktur->tgl_awal, 'yyyy-MM-dd H:i:s'),'long',null); 
                            ?>
                            <?php echo CHtml::label('Tgl. Faktur', 'InformasifakturumumV_tgl_awal', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                // $modFaktur->tgl_awal = MyFormatter::formatDateTimeForUser($modFaktur->tgl_awal);
                                $modFaktur->tgl_awal = date('d M Y',strtotime($modFaktur->tgl_awal));
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modFaktur,
                                    'attribute' => 'tgl_awal',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                )); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php //$modFaktur->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modFaktur->tgl_akhir, 'yyyy-MM-dd H:i:s'),'long',null); 
                            ?>
                            <?php echo CHtml::label('Sampai Dengan', 'InformasifakturumumV_tgl_akhir', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                // $modFaktur->tgl_akhir = MyFormatter::formatDateTimeForUser($modFaktur->tgl_akhir);
                                $modFaktur->tgl_akhir = date('d M Y',strtotime($modFaktur->tgl_akhir));
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modFaktur,
                                    'attribute' => 'tgl_akhir',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                )); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($modFaktur, 'nofaktur', array('placeholder' => 'No. Faktur', 'class' => 'angkahuruf-only span3')); ?>
                        <?php echo $form->dropDownListRow(
                            $modFaktur,
                            'supplier_id',
                            CHtml::listData(SupplierM::model()->findAll(array('order' => 'supplier_nama asc')), 'supplier_id', 'supplier_nama'),
                            array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",                                                                                 'empty' => '-- Pilih --',)
                        ); ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php //$modFaktur->tgl_awalJatuhTempo = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modFaktur->tgl_awalJatuhTempo, 'yyyy-MM-dd'),'medium',null); 
                            ?>
                            <label class="control-label">
                                <?php echo CHtml::checkBox('berdasarkanJatuhTempo', '', array('uncheckValue' => 0)); ?>
                                Tgl. Jatuh Tempo
                            </label>
                            <div class="controls">
                                <?php
                                $modFaktur->tgl_awalJatuhTempo = MyFormatter::formatDateTimeForUser($modFaktur->tgl_awalJatuhTempo);
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modFaktur,
                                    'attribute' => 'tgl_awalJatuhTempo',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                )); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php //$modFaktur->tgl_akhirJatuhTempo = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modFaktur->tgl_akhirJatuhTempo, 'yyyy-MM-dd'),'medium',null); 
                            ?>
                            <?php echo CHtml::label('Sampai Dengan', 'InformasifakturumumV_tgl_akhirJatuhTempo', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $modFaktur->tgl_akhirJatuhTempo = MyFormatter::formatDateTimeForUser($modFaktur->tgl_akhirJatuhTempo);
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modFaktur,
                                    'attribute' => 'tgl_akhirJatuhTempo',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                )); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Syarat Bayar', 'syaratbayar_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList(
                                    $modFaktur,
                                    'syaratbayar_id',
                                    CHtml::listData(SyaratbayarM::model()->findAll('syaratbayar_aktif = true order by syaratbayar_nama ASC'), 'syaratbayar_id', 'syaratbayar_nama'),
                                    array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',)
                                ); ?>
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
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')')); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) ?>
                    <?php
                    $content = $this->renderPartial('billingKasir.views.tips.informasi', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Faktur Pembelian Barang Non Medis</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $subtotal = 0;
                $prov = $modFaktur->search();
                $cloneProv = clone $prov;
                foreach ($cloneProv->data as $dataClone) {
                    $subtotal += $dataClone->totalhutangusaha;
                }
                $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
                    'id' => 'fakturpembelianumum-m-grid',
                    'dataProvider' => $modFaktur->search(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Tanggal Faktur',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglfaktur)',
                            'footer' => 'Total :',
                            'footerHtmlOptions' => array('colspan' => 16, 'style' => 'text-align:right;'),
                        ),
                        'nofaktur',
                        array(
                            'header' => 'Tanggal Terima',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglterima)',
                        ),
                        'nopenerimaan',
                        array(
                            'header' => 'No. Permintaan',
                            'type' => 'raw',
                            'value' => '$data->nopembelian',
                        ),
                        'supplier_nama',
                        array(
                            'header' => 'Tanggal Jatuh Tempo',
                            'name' => 'tgljatuhtempo',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgljatuhtempo)'
                        ),
                        array(
                            'header' => 'Keterangan Faktur',
                            'type' => 'raw',
                            'value' => '$data->keteranganfaktur',
                        ),
                        array(
                            'header' => 'Syarat Bayar',
                            'type' => 'raw',
                            'value' => '$data->syaratbayar_nama',
                        ),
                        array(
                            'header' => 'Umur Utang',
                            'type' => 'raw',
                            'value' => '$data->getUmurHutang($data->tgljatuhtempo, $data->tglfaktur)',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Total Harga<br>(Rp)',
                            'name' => 'totalharga',
                            'type' => 'raw',
                            'value' => 'number_format($data->totalharga,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Keringanan<br>(Rp)',
                            'name' => 'discount',
                            'type' => 'raw',
                            'value' => 'number_format($data->discount,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Total Pajak PPN<br>(Rp)',
                            'name' => 'pajakppn',
                            'type' => 'raw',
                            'value' => 'number_format($data->pajakppn,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Total Pajak PPh<br>(Rp)',
                            'name' => 'pajakpph',
                            'type' => 'raw',
                            'value' => 'number_format($data->pajakpph,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Total Keseluruhan<br>(Rp)',
                            'type' => 'raw',
                            'value' => 'number_format($data->totalkeseluruhan,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Jumlah Uang Muka<br>(Rp)',
                            'type' => 'raw',
                            'value' => 'number_format($data->jlmuangmukabeli,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Total Harga Netto<br>(Rp)',
                            'type' => 'raw',
                            'value' => 'number_format($data->totalhutangusaha,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'footer' => number_format($subtotal, 2, ",", "."),
                            'footerHtmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",Yii::app()->createUrl("keuangan/InformasiFakturUmum/detailsFaktur",array("terimapersediaan_id"=>$data->terimapersediaan_id,"frame"=>true)) ,array("title"=>"Klik untuk Melihat Rincian Faktur","target"=>"iframe", "onclick"=>"$(\"#dialogDetailsFaktur\").dialog(\"open\");", "rel"=>"tooltip"))',
                            'footer' => '-',
                            'footerHtmlOptions' => array('style' => 'text-align:left;color:white;'),
                        ),
                        array(
                            'header' => 'Manager Keuangan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $modAppr = ApprovalotorisasiM::model()->find();
                                $pegawainame = "";
                                $pegawainameid = "";
                                $peg = PegawaiM::model()->findByPk($data->pegawaimenyetujuikeuangan_id);
                                if (isset($peg)) {
                                    $pegawainameid = $peg->pegawai_id;
                                    $pegawainame = $peg->namaLengkap;
                                }
                                if (isset($modAppr)) {
                                    if ($data->asalbarang_id == Params::SUMBERDANA_ID_PT) {
                                        if (!empty($modAppr->managerkeuanganpt_id)) {
                                            $pegawainameid = $modAppr->managerkeuanganpt_id;
                                            $pegawainame = $modAppr->managerkeuanganpt->namaLengkap;
                                        }
                                    } else {
                                        if (!empty($modAppr->managerkeuangan_id)) {
                                            $pegawainameid = $modAppr->managerkeuangan_id;
                                            $pegawainame = $modAppr->managerkeuangan->namaLengkap;
                                        }
                                    }
                                }
                                $dataDialog = 'myAlert("Hanya ' . $pegawainame . ' yang bisa mengakses");';
                                if ($pegawainameid == Yii::app()->user->getState('pegawai_id')) {
                                    $dataDialog = "$('#dialogMenyetujui').dialog('open');";
                                }
                                $html = $pegawainame . (!empty($data->pegawaimenyetujuikeuangan_id) ? (!empty($data->tgl_menyetujuikeuangan) ? "<br>" . MyFormatter::formatDateTimeForUser($data->tgl_menyetujuikeuangan) : "") : CHtml::link("<icon class='icon-form-check'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Menyetujui', array("terimapersediaan_id" => $data->terimapersediaan_id, "frame" => true)), array("target" => "frameMenyetujui", "rel" => "tooltip", "title" => "Klik untuk Approve Manager Keuangan", "onclick" => $dataDialog)));
                                return $html;
                            },
                            'footer' => '-',
                            'footerHtmlOptions' => array('style' => 'text-align:left;color:white;'),
                        ),
                        array(
                            'header' => 'Ubah Faktur',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => function ($data) {
                                $modelByr = BayarkesupplierT::model()->findAllByAttributes(array('terimapersediaan_id' => $data->terimapersediaan_id));
                                return ((count((array)$modelByr) == 0) ? CHtml::link("<i class='icon-form-fakturbeli'></i> ",  Yii::app()->createUrl("keuangan/InformasiFakturUmum/ubahFaktur", array("terimapersediaan_id" => $data->terimapersediaan_id)), array("rel" => "tooltip", "title" => "Klik untuk Ubah Faktur Pembelian Umum")) : "");
                            },
                            'footer' => '-',
                            'footerHtmlOptions' => array('style' => 'text-align:left;color:white;'),
                            //                                                                        'value'=>'(empty($data->bayarkesupplier_id)?CHtml::link("<i class=\'icon-form-fakturbeli\'></i> ",  Yii::app()->createUrl("keuangan/InformasiFakturUmum/ubahFaktur",array("terimapersediaan_id"=>$data->terimapersediaan_id)),array("rel"=>"tooltip","title"=>"Klik untuk Ubah Faktur Pembelian Umum")):"")',
                        ),
                        array(
                            'header' => 'Status Pembayaran',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center;'),
                            'value' => function ($data) {
                                $bayarSupplier = BayarkesupplierT::model()->findAllByAttributes(array('terimapersediaan_id' => $data->terimapersediaan_id));
                                $totalSisaTagihan = 0;
                                $htmlStatus = '<button id="red" class="btn btn-default" name="yt1">BELUM LUNAS</button>';
                                if (isset($bayarSupplier) && count((array)$bayarSupplier) > 0) {
                                    foreach ($bayarSupplier as $byr) {
                                        $totalSisaTagihan += $byr->totalsisatagihan;
                                    }
                                    if ($totalSisaTagihan == 0) {
                                        $htmlStatus = '<button id="red" class="btn btn-primary" name="yt1">LUNAS</button>';
                                    }
                                }
                                return $htmlStatus;
                            }
                        ),
                        // 									array(
                        // 										'header'=>'Bayar ke Supplier',
                        // 										'type'=>'raw',
                        // 										'htmlOptions'=>array('style'=>'text-align:left;'),
                        //                                                                             'value'=>'(!empty($data->tgl_menyetujuikeuangan)? ((!$data->checkStatusPembayaran($data->terimapersediaan_id)) ? CHtml::link("<i class=\'icon-form-bayar\'></i> ",  Yii::app()->createUrl("keuangan/PembayaranKeSupplierUmum/index",array("terimapersediaan_id"=>$data->terimapersediaan_id)),array("rel"=>"tooltip","title"=>"Klik untuk Membayar ke Supplier")) : "Lunas"):"")',
                        // //										'value'=>'(!empty($data->tgl_menyetujuikeuangan)? ((empty($data->bayarkesupplier_id)) ? CHtml::link("<i class=\'icon-form-bayar\'></i> ",Yii::app()->createUrl("keuangan/PembayaranKeSupplierUmum/index",array("frame"=>1,"terimapersediaan_id"=>$data->terimapersediaan_id)) ,array("title"=>"Klik untuk Membayar ke Supplier","target"=>"iframeRetur", "onclick"=>"$(\"#dialogRetur\").dialog(\"open\");", "rel"=>"tooltip","data-placement"=>"left")) : "Lunas"):"")',
                        //                                                                            'footer'=>'-',
                        // 									   'footerHtmlOptions'=>array('style'=>'text-align:left;color:white;'),
                        // 									),
                        array(
                            'header' => 'Batal',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $modelByr = BayarkesupplierT::model()->findAllByAttributes(array('terimapersediaan_id' => $data->terimapersediaan_id));
                                return ((count((array)$modelByr) == 0) ? CHtml::link("<i class='icon-form-silang'></i>", 'javascript:dialogBatalFaktur(' . $data->terimapersediaan_id . ')', array("id" => $data->terimapersediaan_id, "rel" => "tooltip", "title" => "Klik untuk membatalkan Faktur Pembelian Barang Non Medis", "data-placement" => "left")) : "");
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'footer' => '-',
                            'footerHtmlOptions' => array('style' => 'text-align:left;color:white;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$action = $this->getAction()->getId();
$currentUrl =  Yii::app()->createUrl($module . '/' . $controller . '/' . $action);
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'form_hiddenFaktur',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('target' => '_new'),
    'action' => Yii::app()->createUrl($module . '/fakturPembelian/index'),
)); ?>
<?php
$jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#fakturpembelianumum-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=1100px, scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $jsx, CClientScript::POS_HEAD);
?>
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
        'title' => 'Rincian Faktur Pembelian',
        'autoOpen' => false,
        'minWidth' => 1100,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="iframe" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRetur',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Pembayaran Supplier',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
        "beforeClose" => 'js:function(){$("#divSearch-form form").submit();}',
        'close' => "js:function(){ $.fn.yiiGridView.update('fakturpembelianumum-m-grid', {
							data: $('#divSearch-form form').serialize()
						}); }",
    )
));
?>
<iframe src="" name="iframeRetur" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
?>
<!--Dialog untuk menyetujui-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMenyetujui',
    'options' => array(
        'title' => 'Approvement Pegawai Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 920,
        'height' => 500,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('fakturpembelianumum-m-grid', {
                            data: $(this).serialize()
                    }); }",
    ),
));
?>
<iframe name='frameMenyetujui' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<?php
// ===========================Dialog Batal Periksa=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'DialogBatalFaktur',
    'options' => array(
        'title' => 'Pembatalan Faktur Pembelian Barang Non Medis',
        'autoOpen' => false,
        'show' => 'blind',
        'hide' => 'explode',
        'zIndex' => 1002,
        'minWidth' => 500,
        'height' => 320,
        'resizable' => false,
        'modal' => true,
    ),
));
$this->renderPartial('_formPembatalanFaktur');
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
$js = <<< JSCRIPT
function formFaktur(idPenerimaan,noPenerimaan,tglPenerimaan)
{
    $('#idPenerimaanForm').val(idPenerimaan);
    $('#noPenerimaanForm').val(noPenerimaan);
    $('#tglPenerimaanForm').val(tglPenerimaan);
    $('#form_hiddenFaktur').submit();
}
JSCRIPT;
Yii::app()->clientScript->registerScript('javascript', $js, CClientScript::POS_HEAD);
?>
<script type="text/javascript">
    function dialogBatalFaktur(terimapersediaan_id) {
        myConfirm("Apakah Anda yakin akan membatalkan data faktur ini?", "Perhatian!", function(r) {
            if (r) {
                $('#DialogBatalFaktur #terimapersediaan_id').val(terimapersediaan_id);
                $('#DialogBatalFaktur #keterangan_batal').val('');
                $('#DialogBatalFaktur').dialog('open');
            }
        });
    }

    function ubahFakturKarenaBatal() {
        var terimapersediaan_id = $('#DialogBatalFaktur #terimapersediaan_id').val();
        var tglbatal = $('#DialogBatalFaktur #tglbatal').val();
        var pegawaibatal = $('#DialogBatalFaktur #tglbatal').val();
        var keterangan_batal = $('#DialogBatalFaktur #keterangan_batal').val();
        $('#DialogBatalFaktur #keterangan_batal').attr('class', '');
        if (keterangan_batal == '') {
            myAlert("Alasan Pembatalan Faktur Ini, wajib diisi");
            $('#DialogBatalFaktur #keterangan_batal').attr('class', 'error');
            return false;
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('BatalFaktur'); ?>',
            data: {
                terimapersediaan_id: terimapersediaan_id,
                tglbatal: tglbatal,
                pegawaibatal: pegawaibatal,
                keterangan_batal: keterangan_batal
            }, //
            dataType: "json",
            success: function(data) {
                if (data.status == 'ok') {
                    myAlert(data.keterangan);
                    $('#DialogBatalFaktur').dialog('close');
                    $.fn.yiiGridView.update('fakturpembelianumum-m-grid', {
                        data: $(this).serialize()
                    });
                } else {
                    myAlert(data.keterangan);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
</script>