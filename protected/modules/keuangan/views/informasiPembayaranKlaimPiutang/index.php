<?php $linkHalaman = CustomFunction::getUrlByMenuID(941); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pembayaran Klaim Piutang Penjamin</b>
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
            'Informasi Pembayaran Klaim Piutang Penjamin',
        );
        Yii::app()->clientScript->registerScript('search', "
   $('#divSearch-form form').submit(function(){
            $('#aspembklaimpiutang-t-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('aspembklaimpiutang-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body" id="divSearch-form">
                <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pembayaran Klaim Piutang Penjamin</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'aspembklaimpiutang-t-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                            'htmlOptions' => array('style' => 'text-align:center;')
                        ),
                        array(
                            'header' => 'Tgl. Pembayaran/<br>No. Pembayaran',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return MyFormatter::formatDateTimeForUser($data->tglpembayaranklaim) . '/<br>' . $data->nopembayaranklaim;
                            }
                        ),
                        array(
                            'header' => 'Tgl. Pengajuan/<br>No. Pengajuan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return MyFormatter::formatDateTimeForUser($data->tglpengajuanklaimanklaim) . '/<br>' . $data->nopengajuanklaimanklaim;
                            }
                        ),
                        array(
                            'header' => 'Pembayaran Ke-',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return $data->bayarke;
                            },
                            'htmlOptions' => array('style' => 'text-align:center;')
                        ),
                        array(
                            'header' => 'Jenis Penjamin/<br> Penjamin',
                            'type' => 'raw',
                            'value' => '$data->carabayar_nama ."/<br>".$data->penjamin_nama',
                        ),
                        array(
                            'header' => 'Total Piutang<br>(Rp)',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return MyFormatter::formatNumberForPrint($data->totalpiutang, 2);
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Total Telah Bayar<br>(Rp)',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return MyFormatter::formatNumberForPrint($data->telahbayar, 2);
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Total Pembayaran<br>(Rp)',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return MyFormatter::formatNumberForPrint($data->totalbayar, 2);
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Biaya Administrasi<br>(Rp)',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return MyFormatter::formatNumberForPrint($data->biaya_administrasi, 2);
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Total Penerimaan<br>(Rp)',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return MyFormatter::formatNumberForPrint($data->totalpenerimaan, 2);
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Total Sisa Piutang<br>(Rp)',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return MyFormatter::formatNumberForPrint($data->totalsisapiutang, 2);
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Petugas Penerima',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $log = LoginpemakaiK::model()->findByPk($data->create_loginpemakai_id);
                                if (empty($log)) return "-";
                                if (empty($log->pegawai_id)) return $log->nama_pemakai;
                                $peg = PegawaiM::model()->findByPk($log->pegawai_id);
                                return $peg->nama_pegawai;
                            }
                        ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => function ($data) {
                                return CHtml::Link(
                                    '<i class="icon-form-detail"></i>',
                                    Yii::app()->controller->createUrl("detail", array("id" => $data->pembayarklaim_id, "frame" => true)),
                                    array(
                                        "class" => "",
                                        "target" => "detailPembayaran",
                                        "onclick" => '$("#dialogDetail").dialog("open");',
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk melihat detail Pembayaran Klaim Piutang",
                                    )
                                );
                            }
                        ),
                        array(
                            'header' => 'Status Pembayaran',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if ($data->totalsisapiutang == 0) {
                                    return Params::getWrStatusBayar(Params::STATUSBAYAR_LUNAS);
                                } else {
                                    return Params::getWrStatusBayar(Params::STATUSBAYAR_BELUM_LUNAS);
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align:center;')
                        ),
                        array(
                            'header' => 'Hapus Piutang Tak Tertagih',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $html = CHtml::Link("<i class='glyphicon glyphicon-minus' style='font-size: 14pt'></i>", 'javascript:void(0);');
                                if ($data->totalsisapiutang <> 0 && ($data->bayarke == $data->getCheckBayarMax($data->pengajuanklaimpiutang_id, $data->bayarke))) {
                                    $html = CHtml::link(
                                        '<i class="fa fa-clipboard" style="font-size: 14pt"></i>',
                                        "javascript:void(0);",
                                        array(
                                            // "target"=>"",
                                            "onclick" => "penghapusanPiutang(" . $data->pembayarklaim_id . "," . $data->pengajuanklaimpiutang_id . ");",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk Penghapusan Piutang Tak Tertagih"
                                            // "submit"=>array('delete', 'id'=>$data->pengajuanklaimpiutang_id),
                                            // 'confirm' => 'Are you sure?', 'csrf'=>true
                                        )
                                    );
                                    // $html =  CHtml::Link("<i class=\"fa fa-clipboard\" style='font-size: 14pt'></i>",'#',array('submit'=>array('penghapusanPiutang&pembayarklaim_id='.$data->pembayarklaim_id.'&pengajuanklaimpiutang_id='.$data->pengajuanklaimpiutang_id),'confirm' => 'Apakah Anda akan melakukan transaksi penghapusan piutang tak tertagih?', 'csrf'=>true,"class"=>"", "rel"=>"tooltip","title"=>"Klik untuk Penghapusan Piutang Tak Tertagih"));
                                } else if ($data->totalsisapiutang == 0 && ($data->bayarke == $data->getCheckBayarMax($data->pengajuanklaimpiutang_id, $data->bayarke))) {
                                    $html = "Di hapus oleh " . MyFormatter::formatDateTimeForDb($data->tglpenghapusanpiutang) . ' - ' . $data->pegawaipenghapusan_nama;
                                }
                                return $html;
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Batal',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-silang\"></i>",Yii::app()->controller->createUrl("batalPembayaran",array("id"=>$data->pembayarklaim_id,"frame"=>true)),
                                     array("class"=>"",
                                           "target"=>"batalPembayaran",
                                           "onclick"=>"deleteRecord($data->pembayarklaim_id);",
                                           "rel"=>"tooltip",
                                           "title"=>"Klik untuk membatalkan Pembayaran Klaim Piutang",
                           ))',
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
// ===========================Dialog Detail=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Rincian Pembayaran Klaim Piutang Penjamin',
        'autoOpen' => false,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
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
        'title' => 'Pembatalan Pembayaran Gaji',
        'autoOpen' => false,
        'width' => 550,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="batalPembayaran" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Pembatalan================================
?>
<script>
    function penghapusanPiutang(pembayarklaim_id, pengajuanklaimpiutang_id) {
        myConfirm("Apakah Anda akan melakukan transaksi penghapusan piutang tak tertagih?", 'Perhatian!', function(r) {
            if (r) {
                window.location.href = '<?php echo Yii::app()->controller->createUrl("penghapusanPiutang"); ?>&pembayarklaim_id=' + pembayarklaim_id + '&pengajuanklaimpiutang_id=' + pengajuanklaimpiutang_id;
            }
        });
    }

    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo Yii::app()->controller->createUrl("batalPembayaran"); ?>';
        myConfirm("Yakin Akan Menghapus Data ini?", 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('aspembklaimpiutang-t-grid');
                        } else {
                            myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }
</script>