<?php $linkHalaman = CustomFunction::getUrlByMenuID(2141); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pengajuan Klaim Piutang Penjamin</b>
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
            'Informasi Pengajuan Klaim Piutang Penjamin',
        );
        Yii::app()->clientScript->registerScript('search', "
    $('#divSearch-form form').submit(function(){
            $('#kupembklaimpiutang-t-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('kupembklaimpiutang-t-grid', {
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
                    <i class="entypo-credit-card"></i> Tabel <b>Pengajuan Klaim Piutang Penjamin</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'kupembklaimpiutang-t-grid',
                    'dataProvider' => $model->searchInformasiPengajuan(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                        ),
                        array(
                            'header' => 'Tgl. Pengajuan Klaim/<br>No. Pengajuan Klaim',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return MyFormatter::formatDateTimeForUser($data->tglpengajuanklaimanklaim) . " / <br>" . $data->nopengajuanklaimanklaim;
                            }
                        ),
                        array(
                            'header' => 'Tgl. Jatuh Tempo',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgljatuhtempo)',
                        ),
                        array(
                            'header' => 'Jenis Penjamin/<br>Penjamin',
                            'type' => 'raw',
                            'value' => '$data->carabayar_nama ." / <br>".$data->penjamin_nama',
                        ),
                        array(
                            'header' => 'Total Tagihan (Rp)',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return MyFormatter::formatNumberForPrint($data->totaltagihan, 2);
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Total Keringanan (Rp)',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return MyFormatter::formatNumberForPrint($data->totaldiskon, 2);
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Total Piutang (Rp)',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return MyFormatter::formatNumberForPrint($data->totalpiutang, 2);
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Total Pengajuan (Rp)',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return MyFormatter::formatNumberForPrint($data->totalbayar, 2);
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Total Telah Bayar<br>(Rp)',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return MyFormatter::formatNumberForPrint($data->jumlahpembayar, 2);
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
                            'header' => 'Lunas (%)',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $jmlbayar = ($data->jumlahpembayar + $data->jmlpiutangtaktertagih);
                                $sisapembayaran = ($data->totalbayar - $jmlbayar);
                                if ($sisapembayaran == 0) return number_format(100, 2, ',', '');
                                return number_format(($jmlbayar / $data->totalbayar) * 100, 2, ',', '');
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Operator',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return $data->petugasoperator_nama;
                            }
                        ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => function ($data) {
                                return CHtml::Link(
                                    '<i class="icon-form-detail"></i>',
                                    Yii::app()->controller->createUrl("detail", array("id" => $data->pengajuanklaimpiutang_id, "frame" => true)),
                                    array(
                                        "class" => "",
                                        "target" => "detailPembayaran",
                                        "onclick" => '$("#dialogDetail").dialog("open");',
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk melihat Rincian Pengajuan Klaim Piutang Penjamin",
                                    )
                                );;
                            }
                        ),
                        array(
                            'header' => 'Status Pembayaran',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center;'),
                            'value' => function ($data) {
                                $jmlbayar = ($data->jumlahpembayar + $data->jmlpiutangtaktertagih);
                                $sisapembayaran = ($data->totalbayar - $jmlbayar);
                                if ($sisapembayaran == 0) {
                                    return Params::getWrStatusBayar(Params::STATUSBAYAR_LUNAS);
                                } else {
                                    return Params::getWrStatusBayar(Params::STATUSBAYAR_BELUM_LUNAS);
                                }
                            }
                        ),
                        array(
                            'header' => 'Pembayaran Klaim',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center;'),
                            'value' => function ($data) {
                                $jmlbayar = ($data->jumlahpembayar + $data->jmlpiutangtaktertagih);
                                $persen = number_format(($jmlbayar / $data->totalbayar) * 100, 2, ',', '');
                                if ((($data->totalbayar - $jmlbayar) > 0) && $persen < 100) {
                                    return CHtml::Link(
                                        "<i class=\"icon-form-bayar\"></i>",
                                        Yii::app()->controller->createUrl("PembayaranKlaimPiutang" . $this->singkatan . "/index", array("pengajuanklaim_id" => $data->pengajuanklaimpiutang_id)),
                                        array(
                                            "class" => "",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk melakukan pembayaran Klaim Piutang",
                                        )
                                    );
                                } else {
                                    $det = PengajuanklaimdetailT::model()->findAllByAttributes(array(
                                        'pengajuanklaimpiutang_id' => $data->pengajuanklaimpiutang_id,
                                    ));
                                    $id_detail = array();
                                    foreach ($det as $item) {
                                        $id_detail[] = $item->pengajuanklaimdetail_id;
                                    }
                                    $cri = new CDbCriteria();
                                    $cri->select = ' bayar.tglpembayaranklaim, bayar.nopembayaranklaim, t.pembayarklaim_id ';
                                    $cri->join = " JOIN pembayarklaim_t bayar ON bayar.pembayarklaim_id = t.pembayarklaim_id ";
                                    $cri->addInCondition(" t.pengajuanklaimdetail_id ", $id_detail);
                                    $cri->addCondition(" pembklaimdetal_id IS NOT NULL ");
                                    $cri->order = " bayar.nopembayaranklaim DESC ";
                                    $cri->group = 'bayar.tglpembayaranklaim, bayar.nopembayaranklaim, t.pembayarklaim_id';
                                    $bayar = PembklaimdetalT::model()->findAll($cri);
                                    if (count((array)$bayar) != 0) {
                                        $str = "";
                                        foreach ($bayar as $item) {
                                            $str .= MyFormatter::formatDateTimeForUser($item->tglpembayaranklaim) . "/<br>" . $item->nopembayaranklaim;
                                            $str .= '<br>';
                                        }
                                        return CHtml::Link(
                                            '<u>' . $str . '</u>',
                                            Yii::app()->controller->createUrl("detailBayar", array("id" => $data->pengajuanklaimpiutang_id, "frame" => true)),
                                            array(
                                                "class" => "",
                                                "target" => "detailPembayaran",
                                                "onclick" => '$("#dialogDetail").dialog("open");',
                                                "rel" => "tooltip",
                                                "title" => "Klik untuk melihat detail Pembayaran Klaim Piutang",
                                            )
                                        );
                                    } else {
                                        return '';
                                    }
                                    //
                                }
                            },
                        ),
                        array(
                            'header' => 'Batal',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center;'),
                            'value' => function ($data) {
                                $jmlbayar = ($data->jumlahpembayar + $data->jmlpiutangtaktertagih);
                                if (($data->totalbayar - $jmlbayar) <= 0) return "SUDAH DILAKUKAN PEMBAYARAN";
                                $cek = PengajuanklaimpiutangT::model()->findByPk($data->pengajuanklaimpiutang_id);
                                if (empty($cek->pembayarklaim_id)) {
                                    return CHtml::Link(
                                        "<i class=\"icon-form-silang\"></i>",
                                        Yii::app()->controller->createUrl("batalPembayaran", array("id" => $data->pengajuanklaimpiutang_id, "frame" => true)),
                                        array(
                                            "class" => "",
                                            "target" => "batalPembayaran",
                                            "onclick" => "deleteRecord($data->pengajuanklaimpiutang_id);",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk membatalkan Pengajuan Klaim Piutang",
                                        )
                                    );
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
// ===========================Dialog Detail=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Rincian Pengajuan Klaim Piutang Penjamin',
        'autoOpen' => false,
        'width' => 1000,
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
<?php
// ===========================Dialog Detail=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailBayar',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Pembayaran Klaim Piutang',
        'autoOpen' => false,
        'width' => 900,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detailPembayaran" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Detail================================
?>
<script>
    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo Yii::app()->controller->createUrl("InformasiPengajuanKlaimPiutang/batalPembayaran"); ?>';
        myConfirm("Apakah Anda akan melakukan pembatalan pengajuan klaim piutang", 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('kupembklaimpiutang-t-grid');
                        } else {
                            myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }
</script>