<?php $linkHalaman = CustomFunction::getUrlByMenuID(1475); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pembayaran Uang Muka Pembelian</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
        $this->breadcrumbs = array(
            'Informasi Pembayaran Uang Muka Pembelian',
        );
        Yii::app()->clientScript->registerScript('search', "
				$('#pembayaran-t-search').submit(function()
				{
					$.fn.yiiGridView.update('infopembayaran-m-grid', {
						data: $(this).serialize()
					});
					return false;
				});
				$('#btn_resset').click(function()
				{
					setTimeout(function(){
						$.fn.yiiGridView.update('infopembayaran-m-grid', {
							data: $('#pembayaran-t-search').serialize()
						});
					}, 1000);
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
                <?php $this->renderPartial('_search', array('modBayar' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pembayaran Uang Muka Pembelian</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel" style="overflow: auto;">
                    <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                        'id' => 'infopembayaran-m-grid',
                        'dataProvider' => $model->searchInformasi(),
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                        'columns' => array(
                            array(
                                'header' => 'Tgl. Kas Keluar',
                                'type' => 'raw',
                                'value' => '!empty($data->tglkaskeluar)?MyFormatter::formatDateTimeForUser($data->tglkaskeluar):"-"'
                            ),
                            array(
                                'header' => 'No. Kas Keluar',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    return $data->nokaskeluar;
                                }
                            ),
                            array(
                                'header' => 'Tgl. Permintaan Uang Muka',
                                'type' => 'raw',
                                'value' => '!empty($data->tglpermintaanuangmuka)?MyFormatter::formatDateTimeForUser($data->tglpermintaanuangmuka):"-"'
                            ),
                            array(
                                'header' => 'No. Permintaan Pembelian',
                                'type' => 'raw',
                                'value' => 'empty($data->nopermintaanpembelian)?"-":$data->nopermintaanpembelian',
                            ),
                            array(
                                'header' => 'Supplier',
                                'type' => 'raw',
                                'value' => '$data->supplier_nama',
                            ),
                            array(
                                'header' => 'Total Permintaan Pembelian<br>(Rp)',
                                'type' => 'raw',
                                'value' => '(!empty($data->totalpo)?MyFormatter::formatNumberForPrint($data->totalpo, 2):"-")',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                ),
                            ),
                            array(
                                'header' => 'Jumlah Permintaan Uang Muka<br>(Rp)',
                                'type' => 'raw',
                                'value' => '(!empty($data->jmlpermintaanuangmuka)?MyFormatter::formatNumberForPrint($data->jmlpermintaanuangmuka, 2):"-")',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                ),
                            ),
                            array(
                                'header' => 'Jumlah Pembayaran<br>(Rp)',
                                'type' => 'raw',
                                'value' => '(!empty($data->jumlahuang)?MyFormatter::formatNumberForPrint($data->jumlahuang, 2):"-")',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                ),
                            ),
                            array(
                                'header' => 'Biaya Administrasi<br>(Rp)',
                                'type' => 'raw',
                                'value' => '(!empty($data->biayaadministrasi)?MyFormatter::formatNumberForPrint($data->biayaadministrasi, 2):"-")',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                ),
                            ),
                            array(
                                'header' => 'Biaya Meterai<br>(Rp)',
                                'type' => 'raw',
                                'value' => '(!empty($data->biaya_materai)?MyFormatter::formatNumberForPrint($data->biaya_materai, 2):"-")',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                ),
                            ),
                            array(
                                'header' => 'Jumlah Kas Keluar<br>(Rp)',
                                'type' => 'raw',
                                'value' => '(!empty($data->jmlkaskeluar)?MyFormatter::formatNumberForPrint($data->jmlkaskeluar, 2):"-")',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                ),
                            ),
                            array(
                                'header' => 'Jumlah Sisa Uang Muka<br>(Rp)',
                                'type' => 'raw',
                                'value' => '(!empty($data->jmlsisauangmuka)?MyFormatter::formatNumberForPrint($data->jmlsisauangmuka, 2):"-")',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                ),
                            ),
                            array(
                                'header' => 'Total Sisa Utang Permintaan Pembelian<br>(Rp)',
                                'type' => 'raw',
                                'value' => '(!empty($data->totalsisahutangpo)?MyFormatter::formatNumberForPrint($data->totalsisahutangpo, 2):"-")',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                ),
                            ),
                            array(
                                'header' => 'Status Pembayaran',
                                'type' => 'raw',
                                'htmlOptions' => array('style' => 'text-align: center;'),
                                'value' => function ($data) {
                                    if ($data->jmlsisauangmuka <= 0) {
                                        return Params::getWrStatusBayar(Params::STATUSBAYAR_LUNAS);
                                    } else {
                                        return Params::getWrStatusBayar(Params::STATUSBAYAR_BELUM_LUNAS);
                                    }
                                }
                            ),
                            array(
                                'header' => 'Rincian',
                                'type' => 'raw',
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",Yii::app()->controller->createUrl("detailInformasi",array("uangmukabeli_id"=>$data->uangmukabeli_id,"frame"=>true)) ,array("title"=>"Klik untuk Melihat Rincian Pembayaran Uang Muka Pembelian","target"=>"iframeDetail", "onclick"=>"$(\"#dialogDetail\").dialog(\"open\");", "rel"=>"tooltip"))',
                            ),
                            array(
                                'header' => 'Batal',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    return (!empty($data->pegawaibatal_id) ? "SUDAH DIBATALKAN" : CHtml::link("<i class='icon-form-silang'></i>", 'javascript:dialogBatal(' . $data->uangmukabeli_id . ')', array("id" => $data->uangmukabeli_id, "rel" => "tooltip", "title" => "Klik untuk membatalkan pembayaran Uang Muka Pembelian", "data-placement" => "left")));
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
</div>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Rincian Pembayaran Uang Muka Pembelian',
        'autoOpen' => false,
        'minWidth' => 1100,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="iframeDetail" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
// ===========================Dialog Batal Periksa=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'DialogBatal',
    'options' => array(
        'title' => 'Form Pembatalan Pembayaran Uang Muka Pembelian',
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
$this->renderPartial('_formPembatalan');
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<script type="text/javascript">
    function dialogBatal(uangmukabeli_id) {
        myConfirm("Apakah Anda akan melakukan pembatalan pembayaran dan penjurnalan uang muka pembelian?", "Perhatian!", function(r) {
            if (r) {
                $('#DialogBatal #uangmukabeli_id').val(uangmukabeli_id);
                $('#DialogBatal #keterangan_batal').val('');
                $('#DialogBatal').dialog('open');
            }
        });
    }

    function simpanPembatalan() {
        var uangmukabeli_id = $('#DialogBatal #uangmukabeli_id').val();
        var tglbatal = $('#DialogBatal #tglbatal').val();
        var pegawaibatal_id = $('#DialogBatal #pegawaibatal_id').val();
        var keterangan_batal = $('#DialogBatal #keterangan_batal').val();
        $('#DialogBatal #keterangan_batal').attr('class', '');
        if (keterangan_batal == '') {
            myAlert("Alasan Pembatalan, wajib diisi");
            $('#DialogBatal #keterangan_batal').attr('class', 'error');
            return false;
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('BatalPembayaranUangMuka'); ?>',
            data: {
                uangmukabeli_id: uangmukabeli_id,
                tglbatal: tglbatal,
                pegawaibatal_id: pegawaibatal_id,
                keterangan_batal: keterangan_batal
            }, //
            dataType: "json",
            success: function(data) {
                if (data.status == 'ok') {
                    myAlert(data.keterangan);
                    $('#DialogBatal').dialog('close');
                    $.fn.yiiGridView.update('infopembayaran-m-grid', {
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