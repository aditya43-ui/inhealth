<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Setoran Utang PPh 21 Pegawai</b>
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
            'Informasi Setoran Utang PPh 21 Pegawai',
        );
        Yii::app()->clientScript->registerScript('search', "
            $('#setoranhutangpajak-info-search').submit(function(){
                $.fn.yiiGridView.update('setoranhutangpajak-info-grid', {
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
                    <i class="entypo-credit-card"></i> Tabel <b>Setoran Utang PPh 21 Pegawai</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
                    'id' => 'setoranhutangpajak-info-grid',
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
                            'header' => 'Tanggal Penyetoran / <br> No Penyetoran',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglsetoranpajak)." / <br>".$data->no_setorpajakpembelian',
                        ),
                        array(
                            'header' => 'Jenis Pajak',
                            'type' => 'raw',
                            'value' => '"PPh 21"',
                        ),
                        array(
                            'header' => 'Total Utang<br>(Rp)',
                            'value' => 'number_format($data->totalhutang,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Jumlah Setoran<br>(Rp)',
                            'value' => 'number_format($data->jmlpembayaran,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Biaya Meterai<br>(Rp)',
                            'value' => 'number_format($data->biaya_materai,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Jumlah Kas Keluar<br>(Rp)',
                            'value' => 'number_format($data->jmlkaskeluar,2,",",".")',
                            'htmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Total Sisa Utang<br>(Rp)',
                            'value' => 'number_format($data->totalsisahutang,2,",",".")',
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
                                if ($data->totalsisahutang > 0) {
                                    $html = '<button id="red" class="btn btn-default" name="yt1">BELUM LUNAS</button>';
                                }
                                return $html;
                            }
                        ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",Yii::app()->createUrl("keuangan/InformasiSetoranHutangPajak/rincian",array("tandabuktikeluar_id"=>$data->tandabuktikeluar_id)) ,array("title"=>"Klik untuk Melihat Rincian Setoran Utang PPh 21 Pegawai","target"=>"iframe", "onclick"=>"$(\"#dialogRincianPajak\").dialog(\"open\");", "rel"=>"tooltip"))',
                        ),
                        array(
                            'header' => 'Batal',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return (!empty($data->batalpegawai_id) ? "SUDAH DIBATALKAN" : CHtml::link("<i class='icon-form-silang'></i>", 'javascript:dialogBatalPajak(' . $data->tandabuktikeluar_id . ')', array("id" => $data->tandabuktikeluar_id, "rel" => "tooltip", "title" => "Klik untuk membatalkan Setoran Utang PPh 21 Pegawai", "data-placement" => "left")));
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
        'title' => 'Rincian Utang PPh 21 Pegawai',
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
        'title' => 'Form Pembatalan Setoran Utang PPh 21 Pegawai',
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
    function dialogBatalPajak(tandabuktikeluar_id) {
        $('#DialogBatalSetoran #tandabuktikeluar_id').val(tandabuktikeluar_id);
        $('#DialogBatalSetoran #keterangan_batal').val('');
        $('#DialogBatalSetoran').dialog('open');
    }

    function ubahFakturKarenaBatal() {
        var tandabuktikeluar_id = $('#DialogBatalSetoran #tandabuktikeluar_id').val();
        var tglbatal = $('#DialogBatalSetoran #tglbatal').val();
        var pegawaibatal_id = $('#DialogBatalSetoran #pegawaibatal_id').val();
        var pegawaibatal = $('#DialogBatalSetoran #tglbatal').val();
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
                tandabuktikeluar_id: tandabuktikeluar_id,
                tglbatal: tglbatal,
                pegawaibatal: pegawaibatal,
                keterangan_batal: keterangan_batal,
                pegawaibatal_id: pegawaibatal_id
            }, //
            dataType: "json",
            success: function(data) {
                if (data.status == 'ok') {
                    myAlert(data.keterangan);
                    $('#DialogBatalSetoran').dialog('close');
                    $.fn.yiiGridView.update('setoranhutangpajak-info-grid', {
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