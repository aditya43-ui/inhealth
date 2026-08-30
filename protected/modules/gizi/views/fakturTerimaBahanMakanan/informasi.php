<?php
//komen buat ngepull
$this->breadcrumbs = array(
    'Informasi Faktur Penerimaan Bahan Makanan',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Faktur Pembelian Bahan Makanan</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
		});
		$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('gzterimabahanmakan-grid', {
						data: $(this).serialize()
				});
				return false;
		});
		");
        ?>
        <?php $this->renderPartial($this->path_view . '_search', array('model' => $model,)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Faktur Pembelian Bahan Makanan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                    'id' => 'gzterimabahanmakan-grid',
                    'dataProvider' => $model->searchInformasiFaktur(),
                    //	'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
                    'columns' => array(
                        array(
                            'header' => 'No. Faktur',
                            'value' => '$data->nofaktur',
                            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                        ),
                        array(
                            'header' => 'Tanggal Faktur',
                            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglfaktur)',
                        ),
                        array(
                            'header' => 'Tanggal Terima',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglterimabahan)',
                        ),
                        array(
                            'header' => 'No. Penerimaan',
                            'type' => 'raw',
                            'value' => '$data->nopenerimaanbahan',
                        ),
                        array(
                            'name' => 'pengajuanbahanmkn.nopengajuan',
                            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                        ),
                        array(
                            'header' => 'Tanggal Jatuh Tempo',
                            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                            'value' => '$data->tgljatuhtempo',
                        ),
                        array(
                            'header' => 'Umur Utang',
                            'type' => 'raw',
                            'value' => '$data->getUmurHutang($data->tgljatuhtempo, $data->tglfaktur)',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Jenis PPh',
                            'type' => 'raw',
                            'value' => '(isset($data->pajak)?$data->pajak->pajak_nama:"")',
                            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                        ),
                        array(
                            'header' => 'Syarat Bayar',
                            'type' => 'raw',
                            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                            'value' => '(!empty($data->syaratbayar_id)? $data->syaratbayar->syaratbayar_nama:"")',
                        ),
                        array(
                            'header' => 'Keterangan Faktur',
                            'type' => 'raw',
                            'value' => '$data->keteranganfaktur',
                            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                        ),
                        array(
                            'header' => 'Total Harga<br>(Rp)',
                            'name' => 'totalharganetto',
                            'value' => 'number_format($data->totalharganetto,2,",",".")',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            ),
                            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                        ),
                        array(
                            'header' => 'Total Keringanan<br>(Rp)',
                            'name' => 'totaldiscount',
                            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                            'value' => 'number_format($data->totaldiscount,2,",",".")',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            ),
                        ),
                        array(
                            'header' => 'Total PPN<br>(Rp)',
                            'value' => 'number_format($data->pajakppn,2,",",".")',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            )
                        ),
                        array(
                            'header' => 'Total PPh<br>(Rp)',
                            'value' => 'number_format($data->pajakpph,2,",",".")',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            )
                        ),
                        array(
                            'header' => 'Total Keseluruhan<br>(Rp)',
                            'type' => 'raw',
                            'value' => 'number_format($data->totalkeseluruhan,2,",",".")',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            ),
                            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                        ),
                        array(
                            'header' => 'Jumlah Uang Muka<br>(Rp)',
                            'type' => 'raw',
                            'value' => 'number_format($data->jmluangmukabeli,2,",",".")',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            ),
                            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                        ),
                        array(
                            'header' => 'Total Harga Netto<br>(Rp)',
                            'type' => 'raw',
                            'value' => 'number_format($data->totalhutangusaha,2,",",".")',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            ),
                            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                        ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/gizi/fakturTerimaBahanMakanan/detailPenerimaan",array("id"=>$data->terimabahanmakan_id,"frame"=>true)),array("id"=>"$data->terimabahanmakan_id","target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Rincian Faktur Pembelian Bahan Makanan", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')", "data-placement"=>"left"));',
                            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
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
                                    if ($data->sumberdanabhn == "PT. SHB") {
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
                                //                                                $dataDialog = 'myAlert("Hanya '.$pegawainame.' yang bisa mengakses");';
                                //                                                if($pegawainameid==Yii::app()->user->getState('pegawai_id')){
                                $dataDialog = "window.parent.$('#dialogMenyetujui').dialog('open');";
                                //                                                }
                                $html = $pegawainame . (!empty($data->pegawaimenyetujuikeuangan_id) ? (!empty($data->tgl_menyetujuikeuangan) ? "<br>" . MyFormatter::formatDateTimeForUser($data->tgl_menyetujuikeuangan) : "") : CHtml::link("<icon class='icon-form-check'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Menyetujui', array("terimabahanmakan_id" => $data->terimabahanmakan_id, "frame" => true)), array("target" => "frameMenyetujui", "rel" => "tooltip", "title" => "Klik untuk Approve Manager Keuangan", "onclick" => $dataDialog)));
                                return $html;
                            },
                        ),
                        array(
                            'header' => 'Ubah Faktur',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => function ($data) {
                                $bayar = BayarkesupplierT::model()->findAllByAttributes(array(
                                    'terimabahanmakan_id' => $data->terimabahanmakan_id
                                ));
                                return ((count((array)$bayar) == 0) ? CHtml::link("<i class='icon-form-fakturbeli'></i> ",  Yii::app()->createUrl("keuangan/FakturTerimaBahanMakananKU/ubahFaktur", array("terimabahanmakan_id" => $data->terimabahanmakan_id)), array("rel" => "tooltip", "title" => "Klik untuk Ubah Faktur Pembelian Bahan Makanan")) : "");
                            },
                        ),
                        array(
                            'header' => 'Status Pembayaran',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center;'),
                            'value' => function ($data) {
                                $bayarSupplier = BayarkesupplierT::model()->findAllByAttributes(array('terimabahanmakan_id' => $data->terimabahanmakan_id));
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
                        //             array(
                        //                 'header'=>'Bayar ke Supplier',
                        //                 'type'=>'raw',
                        //                 'value'=>function($data) {
                        //                     $bayar = BayarkesupplierT::model()->findAllByAttributes(array(
                        //                         'terimabahanmakan_id'=>$data->terimabahanmakan_id
                        //                     ));
                        //
                        //                     $cek = false;
                        //                     if (count((array)$bayar)) {
                        //                         $jml = 0;
                        //                         foreach ($bayar as $detByr){
                        //                             $jml += $detByr->jmldibayarkan;
                        //                         }
                        //
                        //                         if($data->totalkeseluruhan == $jml){
                        //                             $cek = true;
                        //                         }
                        //
                        //                     }
                        //                     if($cek){
                        //                         return "SUDAH<br>DIBAYAR";
                        //                     }else{
                        //                         return (!empty($data->tgl_menyetujuikeuangan)? CHtml::link("<i class='icon-form-bayar'></i> ",  Yii::app()->createUrl("keuangan/PembayaranKeSupplierUmum/index",array("terimabahanmakan_id"=>$data->terimabahanmakan_id)),array("rel"=>"tooltip","title"=>"Klik untuk Membayar ke Supplier")) : "");
                        //                     }
                        //                 },
                        // 'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                        // 'htmlOptions'=>array('style'=>'text-align: center;'),
                        //             ),
                        array(
                            'header' => 'Batal',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $bayar = BayarkesupplierT::model()->findAllByAttributes(array(
                                    'terimabahanmakan_id' => $data->terimabahanmakan_id
                                ));
                                return ((count((array)$bayar) == 0) ? CHtml::link("<i class='icon-form-silang'></i>", 'javascript:dialogBatalFaktur(' . $data->terimabahanmakan_id . ')', array("id" => $data->terimabahanmakan_id, "rel" => "tooltip", "title" => "Klik untuk membatalkan Faktur Pembelian Bahan Makanan", "data-placement" => "left")) : "");
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
$js = <<< JSCRIPT
function openDialog(id){
    $('#dialogDetail').dialog('open');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('head', $js, CClientScript::POS_HEAD);
?>
<?php
//========= Dialog untuk Melihat detail Pengajuan Bahan Makanan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Rincian Faktur Pembelian Bahan Makanan',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 1100,
        'height' => 500,
        'resizable' => false,
    ),
));
echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
?>
<?php
//========= Dialog untuk Melihat detail Pengajuan Bahan Makanan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogBayarSupplier',
    'options' => array(
        'title' => 'Bayar ke Supplier',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('gzterimabahanmakan-grid', {
                            data: $('#gzpengajuanbahanmkn-search').serialize()
                        }); }",
    ),
));
echo '<iframe src="" name="frameBayarSupplier" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
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
        'close' => "js:function(){ $.fn.yiiGridView.update('gzterimabahanmakan-grid', {
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
        'title' => 'Pembatalan Faktur Pembelian Bahan Makanan',
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
$this->renderPartial($this->path_view . '_formPembatalanFaktur');
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<script type="text/javascript">
    function dialogBatalFaktur(terimabahanmakan_id) {
        myConfirm("Apakah Anda yakin akan membatalkan data faktur ini?", "Perhatian!", function(r) {
            if (r) {
                $('#DialogBatalFaktur #terimabahanmakan_id').val(terimabahanmakan_id);
                $('#DialogBatalFaktur #keterangan_batal').val('');
                $('#DialogBatalFaktur').dialog('open');
            }
        });
    }

    function ubahFakturKarenaBatal() {
        var terimabahanmakan_id = $('#DialogBatalFaktur #terimabahanmakan_id').val();
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
                terimabahanmakan_id: terimabahanmakan_id,
                tglbatal: tglbatal,
                pegawaibatal: pegawaibatal,
                keterangan_batal: keterangan_batal
            }, //
            dataType: "json",
            success: function(data) {
                if (data.status == 'ok') {
                    myAlert(data.keterangan);
                    $('#DialogBatalFaktur').dialog('close');
                    $.fn.yiiGridView.update('gzterimabahanmakan-grid', {
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