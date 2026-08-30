<?php $linkHalaman = CustomFunction::getUrlByMenuID(3524); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pembayaran Supplier Kolektif</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Informasi Pembayaran Supplier Kolektif',
        );
        Yii::app()->clientScript->registerScript('search', "
            $('#pembayaransupplierkolektif-info-search').submit(function(){
                $.fn.yiiGridView.update('pembayaransupplierkolektif-info-grid', {
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
                <?php $this->renderPartial($this->path_view . '_search', array('model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pembayaran Supplier Kolektif</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
                    'id' => 'pembayaransupplierkolektif-info-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'type' => 'raw',
                            'value' => '$row+1',
                        ),
                        array(
                            'header' => 'Tanggal Kas Keluar / <br> No Kas Keluar',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglkaskeluar)." / <br>".$data->nokaskeluar',
                        ),
                        array(
                            'header' => 'Tanggal Pembayaran / <br> No Pembayaran',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglbayarkesupplier)." / <br>".$data->no_setorpajakpembelian',
                        ),
                        array(
                            'header' => 'Supplier',
                            'type' => 'raw',
                            'value' => '$data->supplier_nama',
                        ),
                        array(
                            'header' => 'Jenis Supplier',
                            'type' => 'raw',
                            'value' => '$data->supplier_jenis',
                        ),
                        array(
                            'header' => 'Total Tagihan',
                            'value' => '"Rp ". number_format($data->totaltagihan,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Total Yang Dibayarkan',
                            'value' => '"Rp ". number_format($data->jmldibayarkan,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Biaya Administrasi',
                            'value' => '"Rp ". number_format($data->biayaadministrasi,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Biaya Ongkos Kirim',
                            'value' => '"Rp ". number_format($data->biayaongkos_kirim,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Jumlah Kas Keluar',
                            'value' => '"Rp ". number_format($data->jmlkaskeluar,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Total Sisa Utang',
                            'value' => '"Rp ". number_format($data->totalsisatagihan,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Petugas Penyetor',
                            'type' => 'raw',
                            'value' => '$data->petugaspenyetor',
                        ),
                        array(
                            'header' => 'Status',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $html = '<button id="red" class="btn btn-primary" name="yt1">LUNAS</button>';
                                if ($data->totalsisatagihan > 0) {
                                    $html = '<button id="red" class="btn btn-default" name="yt1">BELUM LUNAS</button>';
                                }
                                return $html;
                            }
                        ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",Yii::app()->createUrl("keuangan/InformasiPembayaranSupplierKoletif/rincian",array("tandabuktikeluar_id"=>$data->tandabuktikeluar_id)) ,array("title"=>"Klik untuk Melihat Rincian Pembayaran Supplier Kolektif","target"=>"iframe", "onclick"=>"$(\"#dialogRincianPajak\").dialog(\"open\");", "rel"=>"tooltip"))',
                        ),
                        array(
                            'header' => 'Batal',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link("<i class='icon-form-silang'></i>", 'javascript:void(0)', array('onclick' => 'myAlert("Belum Berfungsi")', "id" => $data->tandabuktikeluar_id, "rel" => "tooltip", "title" => "Klik untuk membatalkan Pembayaran Supplier Kolektif", "data-placement" => "left"));
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
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
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$action = $this->getAction()->getId();
$currentUrl =  Yii::app()->createUrl($module . '/' . $controller . '/' . $action);
?>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincianPajak',
    'options' => array(
        'title' => 'Rincian Pembayaran Supplier Kolektif',
        'autoOpen' => false,
        'minWidth' => 1100,
        'minHeight' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="iframe" width="100%" height="550"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
?>