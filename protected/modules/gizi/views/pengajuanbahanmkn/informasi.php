<?php $linkHalaman = CustomFunction::getUrlByMenuID(350); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Permintaan Pembelian Bahan Makanan',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Permintaan Pembelian Bahan Makanan</b>
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
        $('#gzpengajuanbahanmkn-search').submit(function(){
            $.fn.yiiGridView.update('gzpengajuanbahanmkn-grid', {
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
                    <i class="entypo-credit-card"></i> Tabel <b>Permintaan Pembelian Bahan Makanan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'gzpengajuanbahanmkn-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
                    'columns' => array(
                        'tglpengajuanbahan',
                        'nopengajuan',
                        array(
                            'header' => 'Sumber Dana Bahan',
                            'value' => '(!empty($data->sumberdana_id)? $data->sumberdana->sumberdana_nama:"")'
                        ),
                        array(
                            'header' => 'Tanggal Minta Dikirim',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglmintadikirim)'
                        ),
                        array(
                            'header' => 'Tgl. Permintaan Uang Muka Pembelian',
                            'value' => '(!empty($data->tglpermintaanuangmuka)? MyFormatter::formatDateTimeForUser($data->tglpermintaanuangmuka) : "-")'
                        ),
                        array(
                            'header' => 'Jumlah Permintaan Uang Muka Pembelian <br>(Rp)',
                            'value' => '(!empty($data->jmlpermintaanuangmuka)? MyFormatter::formatNumberForPrint($data->jmlpermintaanuangmuka,2) : "-")'
                        ),
                        array(
                            'header' => 'Jenis PPh',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return (isset($data->pajak) ? $data->pajak->pajak_nama : "-");
                            },
                        ),
                        array(
                            'header' => 'Keterangan Permintaan',
                            'value' => '$data->keterangan_bahan',
                        ),
                        array(
                            'header' => 'Total Harga',
                            'value' => '(Params::cekHiddenHargaGizi()==true) ? number_format($data->totalharganetto,2,",","."):"Hidden"',
                            'htmlOptions' => array('style' => 'text-align:right')
                        ),
                        array(
                            'header' => 'Pegawai Pemesan',
                            'value' => 'GZPegawaiM::getNamaPegawai($data->idpegawai_mengajukan)',
                        ),
                        array(
                            'header' => 'Manajer Umum',
                            'type' => 'raw',
                            'value' => '(isset($data->idpegawai_mengetahui)? GZPegawaiM::getNamaPegawai($data->idpegawai_mengetahui) : "-").
                                                                        (isset($data->tgl_mengetahui) ? "<br>".MyFormatter::formatDateTimeForUser($data->tgl_mengetahui) : 
                                                                        (empty($data->tgl_mengetahui) ? CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ApproveMengetahui", array("pengajuanbahanmkn_id"=>$data->pengajuanbahanmkn_id,"frame"=>true)), array("target"=>"frameApproveMengetahui","rel"=>"tooltip", "title"=>"Klik untuk approve dari Manajer Umum", "onclick"=>"$(\'#dialogApproveMengetahui\').dialog(\'open\');")) : "")
                                                                        )',
                        ),
                        array(
                            'header' => 'Manager Keuangan',
                            'type' => 'raw',
                            'value' => '(isset($data->idpegawai_mengetahui2) ? GZPegawaiM::getNamaPegawai($data->idpegawai_mengetahui2) : "-").
                                                                        (isset($data->tgl_mengetahui2) ? "<br>".MyFormatter::formatDateTimeForUser($data->tgl_mengetahui2) : 
                                                                        ((empty($data->tgl_mengetahui2) && !empty($data->tgl_mengetahui)) ? CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ApproveMengetahui2", array("pengajuanbahanmkn_id"=>$data->pengajuanbahanmkn_id,"frame"=>true)), array("target"=>"frameApproveMengetahui","rel"=>"tooltip", "title"=>"Klik untuk approve dari Manager Keuangan", "onclick"=>"$(\'#dialogApproveMengetahui\').dialog(\'open\');")) : "")
                                                                        )',
                        ),
                        array(
                            'header' => 'Direktur',
                            'type' => 'raw',
                            'value' => '(isset($data->idpegawai_menyetujui) ? GZPegawaiM::getNamaPegawai($data->idpegawai_menyetujui) : "-").
                                                                        (isset($data->tgl_menyetujui) ? "<br>".MyFormatter::formatDateTimeForUser($data->tgl_menyetujui) : 
                                                                        ((empty($data->tgl_menyetujui) && !empty($data->tgl_mengetahui2)) ? CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ApproveMenyetujui", array("pengajuanbahanmkn_id"=>$data->pengajuanbahanmkn_id,"frame"=>true)), array("target"=>"frameApproveMenyetujui","rel"=>"tooltip", "title"=>"Klik untuk approve dari Direktur", "onclick"=>"$(\'#dialogApproveMenyetujui\').dialog(\'open\');")) : "")
                                                                        )',
                        ),
                        array(
                            'header' => 'Status Persetujuan',
                            'type' => 'raw',
                            'value' => '($data->status_persetujuan==FALSE)?"BELUM DISETUJUI"."<br>".(!isset($data->tgl_mengetahui) ? "& BELUM DIKETAHUI": "" ):"SUDAH DISETUJUI"',
                            'htmlOptions' => array('style' => 'text-align:center')
                        ),
                        array(
                            'header' => 'Ubah Permintaan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $link_update = (!empty($data->tglmenyetujui)) ?
                                    '<a rel="tooltip" title="Tidak dapat diubah karena sudah disetujui oleh Direktur"><icon class="icon-form-ubah" style="opacity: 0.3"></icon></a> '
                                    : ((!empty($data->tgl_mengetahui2)) ?
                                        '<a rel="tooltip" title="Tidak dapat diubah karena sudah diketahui oleh Manager Keuangan"><icon class="icon-form-ubah" style="opacity: 0.3"></icon></a> '
                                        : ((($data->idpegawai_mengajukan == Yii::app()->user->getState('pegawai_id')) || ($data->idpegawai_mengetahui == Yii::app()->user->getState('pegawai_id'))) ?
                                            CHtml::link('<icon class=\'icon-form-ubah\'></icon> ', Yii::app()->controller->createUrl('index', array("id" => $data->pengajuanbahanmkn_id, "ubah" => true)), array("target" => "BLANK", "rel" => "tooltip", "title" => "Klik untuk mengubah Permintaan")) :
                                            "<a rel='tooltip' title='Tidak dapat diubah karena hanya bisa diakses oleh " . (GZPegawaiM::getNamaPegawai($data->idpegawai_mengajukan) . " atau " . GZPegawaiM::getNamaPegawai($data->idpegawai_mengetahui)) . " '><icon class='icon-form-ubah' style='opacity: 0.3'></icon></a>"));
                                return $link_update;
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Terima Bahan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data->terimabahanmakan_id)) {
                                    return "Telah Diterima";
                                } else {
                                    if (empty($data->tgl_menyetujui) || empty($data->tgl_mengetahui) || empty($data->tgl_mengetahui2)) {
                                        return "Belum Disetujui";
                                    }
                                    $modUangMukaBeli = UangmukabeliT::model()->findByAttributes(array('pengajuanbahanmkn_id' => $data->pengajuanbahanmkn_id));
                                    $checkuangmuka = true;
                                    if (!empty($data->jmlpermintaanuangmuka)) {
                                        if (!isset($modUangMukaBeli)) {
                                            $checkuangmuka = false;
                                        }
                                    }
                                    if ($checkuangmuka) {
                                        return ((Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_GIZI) ? CHtml::link("<i class='icon-form-terimabahan'></i> ", "javascript:persetujuan($data->pengajuanbahanmkn_id, '$data->nopengajuan', '')", array("rel" => "tooltip", "title" => "Klik untuk Melanjutkan ke Penerimaan", 'data-placement' => 'left')) : "Belum Diterima");
                                    } else {
                                        return "Permintaan ini belum dilakukan pembayaran uang muka";
                                    }
                                }
                            }
                        ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/gizi/Pengajuanbahanmkn/detailPengajuan",array("id"=>$data->pengajuanbahanmkn_id,"frame"=>TRUE)),array("id"=>"$data->pengajuanbahanmkn_id","target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk melihat Rincian Permintaan Pembelian Bahan Makanan", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',
                        ),
                        array(
                            'header' => 'Batal',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => function ($data) {
                                if (!empty($data->terimabahanmakan_id)) {
                                    return "Telah Diterima";
                                } else {
                                    if (!empty($data->tgl_mengetahui) && !empty($data->tgl_mengetahui2) && !empty($data->tgl_menyetujui)) {
                                        return "";
                                    } else {
                                        //                                        if(($data->idpegawai_mengajukan == Yii::app()->user->getState('pegawai_id')) || ($data->idpegawai_mengetahui == Yii::app()->user->getState('pegawai_id')) || ($data->idpegawai_mengetahui2 == Yii::app()->user->getState('pegawai_id')) || ($data->idpegawai_menyetujui == Yii::app()->user->getState('pegawai_id'))){
                                        return CHtml::link("<i class='icon-form-silang'></i>", 'javascript:dialogBatalPermintaan(' . $data->pengajuanbahanmkn_id . ')', array("id" => $data->pengajuanbahanmkn_id, "rel" => "tooltip", "title" => "Klik untuk membatalkan permintaan bahan makanan", "data-placement" => "left"));
                                        //                                        }else{
                                        //                                            return "<a rel='tooltip' title='Tidak dapat diubah karena hanya bisa diakses oleh ".(GZPegawaiM::getNamaPegawai($data->idpegawai_mengajukan) . " atau ". GZPegawaiM::getNamaPegawai($data->idpegawai_mengetahui) . " atau ". GZPegawaiM::getNamaPegawai($data->idpegawai_mengetahui2) . " atau ". GZPegawaiM::getNamaPegawai($data->idpegawai_menyetujui))." '><icon class='icon-form-silang' style='opacity: 0.3'></icon></a>";
                                        //                                        }
                                    }
                                }
                            },
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
        <!--search-form-->
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
        'title' => 'Rincian Permintaan Pembelian Bahan Makanan',
        'autoOpen' => false,
        'minWidth' => 900,
        'height' => 320,
        'resizable' => false,
        'modal' => true,
    ),
));
?>
<iframe src="" name="frameDetail" style="width: 100%; height: 98%; border: none;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
$controller = Yii::app()->controller->id;
$module = Yii::app()->controller->module->id;
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
?>
<script>
    function resizeIframe(obj) {
        obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
    }

    function persetujuan(id, no, cek) {
        var url = '<?php echo $url . "/persetujuan"; ?>';
        if (cek == "cek") {
            myConfirm('Anda Akan Melakukan Persetujuan untuk Permintaan Pembelian Bahan Makanan No Permintaan <b>' + no + '</b>?', 'Perhatian', function(r) {
                if (r) {
                    $.post(url, {
                            id: id,
                            no: no,
                            cek: cek
                        },
                        function(data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('gzpengajuanbahanmkn-grid');
                                myAlert('No Permintaan <b>' + data.nopengajuan + '</b> Sukses <b>DISETUJUI</b>')
                            } else {
                                myAlert('Data Gagal <b>DISETUJUI</b>')
                            }
                        }, "json");
                }
            });
        } else {
            // alert(url);
            //myConfirm('Apakah Anda yaki','Perhatian',function(r){
            //  if (r){
            $.post(url, {
                    id: id,
                    no: no,
                    cek: cek
                },
                function(data) {
                    if (data.status == 'cek_form') {
                        myAlert('<b>(' + data.no + ')</b> Permintaan Pembelian Bahan Makanan Belum Disetujui', 'Perhatian')
                    } else {
                        //alert(data.url);
                        window.location.href = data.url;
                    }
                }, "json");
            // }
            //  });
        }
    }

    function dialogBatalPermintaan(pengajuanbahanmkn_id) {
        $('#DialogBatalPermintaan #pengajuanbahanmkn_id').val(pengajuanbahanmkn_id);
        $('#DialogBatalPermintaan').dialog('open');
    }

    function ubahPeriksaKarenaBatal() {
        var pengajuanbahanmkn_id = $('#DialogBatalPermintaan #pengajuanbahanmkn_id').val();
        var pegawaipembatalan = $('#DialogBatalPermintaan #pegawaipembatalan').val();
        var tglbatal = $('#DialogBatalPermintaan #tglbatal').val();
        var keterangan_batal = $('#DialogBatalPermintaan #keterangan_batal').val();
        $('#DialogBatalperiksa #keterangan_batal').attr('class', '');
        if (keterangan_batal == '') {
            myAlert("Alasan Pembatalan Permintaan Pembelian, wajib diisi");
            $('#DialogBatalPermintaan #keterangan_batal').attr('class', 'error');
            return false;
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('BatalPermintaanPembelian'); ?>',
            data: {
                pengajuanbahanmkn_id: pengajuanbahanmkn_id,
                tglbatal: tglbatal,
                keterangan_batal: keterangan_batal,
                pegawaipembatalan: pegawaipembatalan
            }, //
            dataType: "json",
            success: function(data) {
                if (data.status == 'ok') {
                    if (data.pesan == 'exist') {
                        myAlert(data.keterangan);
                    } else {
                        myAlert('Pembatalan Pemintaan Pembelian Berhasil !!!');
                        $.fn.yiiGridView.update('gzpengajuanbahanmkn-grid', {
                            data: $(this).serialize()
                        });
                        $('#DialogBatalPermintaan #keterangan_batal').val('');
                        $('#DialogBatalPermintaan').dialog('close');
                    }
                } else {
                    if (data.status == 'exist') {
                        myAlert('Permintaan Tidak Bisa dibatalkan');
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
</script>
<?php
// ===========================Dialog Batal Periksa=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'DialogBatalPermintaan',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Pembatalan Permintaan Pembelian',
        'autoOpen' => false,
        'show' => 'blind',
        'hide' => 'explode',
        'zIndex' => 1002,
        'minWidth' => 500,
        'height' => 260,
        'resizable' => false,
        'modal' => true,
    ),
));
$this->renderPartial($this->path_view . '_formBatalPermintaanDialog');
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Batal Periksa================================
?>
<!--Dialog untuk mengetahui-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogApproveMengetahui',
    'options' => array(
        'title' => 'Approvement Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('gzpengajuanbahanmkn-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe name='frameApproveMengetahui' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<!--Dialog untuk mengetahui-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogApproveMenyetujui',
    'options' => array(
        'title' => 'Approvement Pegawai Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('gzpengajuanbahanmkn-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe name='frameApproveMenyetujui' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>