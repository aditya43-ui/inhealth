<?php $linkHalaman = CustomFunction::getUrlByMenuID(3533); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Penerimaan Pembayaran Piutang Bank dan Pembayaran Digital</b>
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
            'Informasi Penerimaan Pembayaran Piutang Bank dan Pembayaran Digital',
        );
        Yii::app()->clientScript->registerScript('search', "
            $('#penerimaanpembayaran-info-search').submit(function(){
                    $.fn.yiiGridView.update('penerimaanpembayaran-info-grid', {
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
                    <i class="entypo-credit-card"></i> Tabel <b>Penerimaan Pembayaran Piutang Bank dan Pembayaran Digital</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
                    'id' => 'penerimaanpembayaran-info-grid',
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
                            'header' => 'Tgl. Pembayaran Piutang / <br> No Pembayaran Piutang',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpembayaran)." / <br>".$data->nopembayaran',
                        ),
                        array(
                            'header' => 'Tgl. Kas Masuk / <br> No Kas Masuk',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglbuktibayar)." / <br>".$data->nobuktibayar',
                        ),
                        array(
                            'header' => 'Jenis Pembayaran',
                            'type' => 'raw',
                            'value' => '$data->jnspembayar_nama',
                        ),
                        array(
                            'header' => 'Bank',
                            'type' => 'raw',
                            'value' => '(!empty($data->namabank)? $data->namabank:"-")',
                        ),
                        array(
                            'header' => 'Total Piutang<br>(Rp)',
                            'value' => 'number_format($data->jmlpiutang,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Total yang Dibayarkan<br>(Rp)',
                            'value' => 'number_format($data->jmlbayar,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Total Biaya Administrasi Bank<br>(Rp)',
                            'value' => 'number_format($data->biayaadministrasi,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Total Biaya Meterai<br>(Rp)',
                            'value' => 'number_format($data->biaya_materai,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Total Penerimaan<br>(Rp)',
                            'value' => 'number_format($data->jmlpenerimaan,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Total Sisa Piutang<br>(Rp)',
                            'value' => 'number_format($data->jmlsisapiutang,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Petugas',
                            'type' => 'raw',
                            'value' => '$data->petugaspenyetor',
                        ),
                        array(
                            'header' => 'Status',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $html = '<button id="red" class="btn btn-primary" name="yt1">LUNAS</button>';
                                if ($data->jmlsisapiutang > 0) {
                                    $html = '<button id="red" class="btn btn-default" name="yt1">BELUM LUNAS</button>';
                                }
                                return $html;
                            }
                        ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",Yii::app()->createUrl("keuangan/InformasiPenerimaanPembayaran/rincian",array("tandabuktibayar_id"=>$data->tandabuktibayar_id,"pembpiutangbank_id"=>$data->pembpiutangbank_id)) ,array("title"=>"Klik untuk Melihat Rincian Penerimaan Pembayaran Piutang Bank dan Pembayaran Digital","target"=>"iframe", "onclick"=>"$(\"#dialogRincianPajak\").dialog(\"open\");", "rel"=>"tooltip"))',
                        ),
                        array(
                            'header' => 'Batal',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return (!empty($data->pegawaibatal_id) ? "SUDAH DIBATALKAN" : CHtml::link("<i class='icon-form-silang'></i>", 'javascript:dialogBatalPajak(' . $data->pembpiutangbank_id . ',' . $data->tandabuktibayar_id . ')', array("id" => $data->pembpiutangbankdetail_id, "rel" => "tooltip", "title" => "Klik untuk membatalkan Penerimaan Pembayaran Piutang Bank dan Pembayaran Digital", "data-placement" => "left")));
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
        'title' => 'Rincian Penerimaan Pembayaran Piutang Bank dan Pembayaran Digital',
        'autoOpen' => false,
        'minWidth' => 1100,
        'minHeight' => 100,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="iframe" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
?>
<?php
// ===========================Dialog Batal Periksa=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'DialogBatalSetoran',
    'options' => array(
        'title' => 'Form Pembatalan Penerimaan Pembayaran Piutang Bank dan Pembayaran Digital',
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
$this->renderPartial('_formPembatalanSetoran');
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<script type="text/javascript">
    function dialogBatalPajak(pembpiutangbank_id, tandabuktibayar_id) {
        $('#DialogBatalSetoran #pembpiutangbank_id').val(pembpiutangbank_id);
        $('#DialogBatalSetoran #tandabuktibayar_id').val(tandabuktibayar_id);
        $('#DialogBatalSetoran #keterangan_batal').val('');
        $('#DialogBatalSetoran').dialog('open');
    }

    function ubahFakturKarenaBatal() {
        var pembpiutangbank_id = $('#DialogBatalSetoran #pembpiutangbank_id').val();
        var pembpiutangbankdetail_id = $('#DialogBatalSetoran #tandabuktibayar_id').val();
        var tglbatal = $('#DialogBatalSetoran #tglbatal').val();
        var pegawaibatal_id = $('#DialogBatalSetoran #pegawaibatal_id').val();
        var keterangan_batal = $('#DialogBatalSetoran #keterangan_batal').val();
        $('#DialogBatalSetoran #keterangan_batal').attr('class', '');
        if (keterangan_batal == '') {
            myAlert("Alasan Pembatalan Setoran Ini, wajib diisi");
            $('#DialogBatalSetoran #keterangan_batal').attr('class', 'error');
            return false;
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('BatalSetoranPajak'); ?>',
            data: {
                pembpiutangbank_id: pembpiutangbank_id,
                tandabuktibayar_id: tandabuktibayar_id,
                tglbatal: tglbatal,
                keterangan_batal: keterangan_batal,
                pegawaibatal_id: pegawaibatal_id
            }, //
            dataType: "json",
            success: function(data) {
                if (data.status == 'ok') {
                    myAlert(data.keterangan);
                    $('#DialogBatalSetoran').dialog('close');
                    $.fn.yiiGridView.update('penerimaanpembayaran-info-grid', {
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