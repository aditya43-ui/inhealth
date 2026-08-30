<style>
    .row_kuning td {
        /* background-color: yellow !important; */
        background-color: #FFFDD0 !important;
    }

    .row_merah td {
        /* background-color: red !important; */
        background-color: #FCC7CF !important;
        /* color: white; */
    }
</style>

<?php $linkHalaman = CustomFunction::getUrlByMenuID(257); ?>
<?php
$this->breadcrumbs = array(
    'PasienKarcis',
);
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'caripasien-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#BKInformasibayaruangmukaV',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
Yii::app()->clientScript->registerScript('cariPasien', "
    $('#caripasien-form').submit(function(){
            $.fn.yiiGridView.update('pencarianpasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
?>
<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <strong>Order Batal Uang Muka Pasien</strong>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Tgl. Pembayaran Uang Muka", 'tgl_rekam', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->textFieldRow($model, 'nouangmuka', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                        <div class="control-group">
                            <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                        <div class="control-group">
                            <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                        <div class="control-group">
                            <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                        <div class="control-group">
                            <?php echo Chtml::label("NIK", 'no_identitas_pasien', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'no_identitas_pasien', array('class' => 'span3 custom-only', 'maxlength' => 50, 'rows' => 3)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Status", "status", array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo $form->dropDownList($model, 'status', array(3 => 'BELUM DIBAYAR', 1 => 'SUDAH DIBAYAR', 2 => 'SUDAH DIBATALKAN'), array(
                                    'class' => 'span3',
                                    'empty' => '-- Pilih --',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Instalasi", "instalasi_id", array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(BKInstalasiM::getItems(), 'instalasi_id', 'instalasi_nama'), array(
                                    'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
                                        'success' => 'function(data){$("#' . CHtml::activeId($model, "ruangan_id") . '").html(data);}',
                                    )
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Ruangan", "ruangan_id", array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                $modRuangans = BKRuanganM::getItems($model->instalasi_id);
                                echo $form->dropDownList($model, 'ruangan_id', ((count((array)$modRuangans) > 0) ? CHtml::listData($modRuangans, 'ruangan_id', 'ruangan_nama') : array()), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Petugas Kasir", "pegawai_id", array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo $form->dropDownList($model, 'pegawai_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(
                                    array('ruangan_id' => Params::RUANGAN_ID_KASIR)
                                ), 'pegawai_id', 'namaLengkap'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit')); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'reset')); ?>
                    <?php
                    $content = $this->renderPartial('billingKasir.views.daftarPasien/tips/informasi2', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <strong>Order Batal Uang Muka</strong>
                </div>
            </div>
            <div class="panel-body">
                <div class="table-responsive overflow-x">
                    <?php

                    $is_keuangan = strtolower($this->module->id) == "keuangan";


                    $col = array(
                        array(
                            'header' => 'Tgl. Pembayaran Uang Muka Pasien/<br/>No. Pembayaran<br>',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgluangmuka) . " <br> " . $data->nouangmuka ',
                        ),
                        array(
                            'header' => 'Tgl. Pendaftaran/<br/>No. Pendaftaran<br>',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran) . " <br> " . $data->no_pendaftaran ',
                        ),
                        array(
                            'header' => 'Instalasi / Ruangan',
                            'type' => 'raw',
                            'value' => 'isset($data->instalasi_nama)?$data->ruangan_nama. " / ".$data->ruangan_nama:" - "',
                        ),
                        array(
                            'header' => 'Jenis Penjamin/<br/>Penjamin',
                            'type' => 'raw',
                            'value' => '$data->carabayar_nama."/<br/>".$data->penjamin_nama',
                        ),
                        array(
                            'header' => 'No. Rekam Medik',
                            'type' => 'raw',
                            'value' => '$data->no_rekam_medik',
                        ),
                        array(
                            'name' => 'nama_pasien',
                            'type' => 'raw',
                            'value' => '$data->nama_pasien',
                        ),
                        array(
                            'header' => 'Total Uang Muka',
                            'type' => 'raw',
                            'value' => function($data) {
                                $str = "Rp. ".MyFormatter::formatNumberForPrint($data->jumlahuangmuka,2);
                                if ($data->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR) {
                                    if ($data->jumlahuangmuka >= 2000000) {
                                        $str .= '<span class="sorot_merah">&nbsp;</span>';
                                    } else {
                                        $str .= '<span class="sorot_kuning">&nbsp;</span>';
                                    }
                                }
                                return $str;
                            }, //'"Rp. ".MyFormatter::formatNumberForPrint($data->jumlahuangmuka,2)',
                            'htmlOptions' => array('style' => 'text-align: left; width:80px'),
                            'htmlOptions' => array(
                                'style' => 'text-align: right',
                            ),
                        ),
                        array(
                            'header' => 'Total Pemakaian',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return "Rp. " . MyFormatter::formatNumberForPrint($data->uangmukadipakai, 2);
                            },
                            'htmlOptions' => array('style' => 'text-align: left; width:80px'),
                            'htmlOptions' => array(
                                'style' => 'text-align: right',
                            ),
                        ),
                        array(
                            'header' => 'Sisa Uang Muka',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return "Rp. " . MyFormatter::formatNumberForPrint(($data->jumlahuangmuka - $data->uangmukadipakai), 2);
                            },
                            'htmlOptions' => array('style' => 'text-align: left; width:80px'),
                            'htmlOptions' => array(
                                'style' => 'text-align: right',
                            ),
                        ),
                        array(
                            'header' => 'Sisa Pembayaran',
                            'type' => 'raw',
                            'value' => '"Rp. ".MyFormatter::formatNumberForPrint($data->sisaPembayaran($data->jmlpembayaran,$data->jumlahuangmuka+$data->jmlpembulatan),2)',
                            'htmlOptions' => array('style' => 'text-align: left; width:80px'),
                            'htmlOptions' => array(
                                'style' => 'text-align: right',
                            ),
                        ),
                        array(
                            'header' => 'Keterangan',
                            'type' => 'raw',
                            'value' => '$data->keteranganuangmuka'
                        ),
                        array(
                            'header' => 'Petugas Kasir',
                            'type' => 'raw',
                            'value' => function ($data) use (&$bayar) {
                                $bayar = BayaruangmukaT::model()->findByPk($data->bayaruangmuka_id);
                                $login = LoginpemakaiK::model()->findByPk($bayar->create_loginpemakai_id);
                                if (empty($login->pegawai_id)) return "-";
                                $peg = PegawaiM::model()->findByPk($login->pegawai_id);
                                return $peg->namaLengkap;
                            },
                        ),
                        array(
                            'header' => 'Status Periksa',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $p = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                return CHtml::htmlButton($p->statusperiksa, array(
                                    'class' => 'btn ' . Params::statusPeriksaCol()[$p->statusperiksa],
                                    'style' => 'min-width: 200px;'
                                ));
                            },
                            'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:left;'),
                        ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link('<i class="icon-form-detail"></i>', $this->createUrl('detailUangMuka', array('id' => $data->bayaruangmuka_id)), array(
                                    'target' => 'iframeDetail',
                                    'onclick' => '$("#dialogDetail").dialog("open");',
                                    'data-toggle' => 'tooltip',
                                    'title' => 'Klik untuk melihat Rincian Pembayaran Uang Muka',
                                ));
                            }
                        )
                    );

                    if ($is_keuangan) {
                        $col[] = array(
                            'header' => 'Pengembalian',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data->pembatalanuangmuka_id)) {
                                    $batal = PembatalanuangmukaT::model()->findByPk($data->pembatalanuangmuka_id);
                                    if ($batal->is_pengembalian) {
                                        $bkk = TandabuktikeluarT::model()->findByAttributes(array(
                                            'pembatalanuangmuka_id' => $data->pembatalanuangmuka_id
                                        ));
                                        return CHtml::link('<u>' . MyFormatter::formatDateTimeForUser($bkk->tglkaskeluar) . "/<br/>" . $bkk->nokaskeluar . '</u>', $this->createUrl('print/pembatalanUangMuka', array(
                                            'idTandaBukti' => $bkk->tandabuktikeluar_id,
                                        )), array(
                                            'target' => 'iframeDetailBatal',
                                            'onclick' => '$("#dialogDetailBatal").dialog("open");',
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Klik untuk melihat detail Pembatalan Uang Muka',
                                        ));
                                    }
                                    return "<a data-toggle = 'tooltip' title = '".$batal->keterangan_batal."'> SUDAH DIBATALKAN OLEH ".$batal->login->pegawai->namaLengkap."</a>";
                                }

                                $pakai = PemakaianuangmukaT::model()->findAllByAttributes(array(
                                    'bayaruangmuka_id' => $data->bayaruangmuka_id,
                                ));

                                $sisa = $data->jumlahuangmuka - $data->pemakaianuangmuka;

                                if ($sisa > 0) {
                                    if ($data->jumlahuangmuka == $data->uangmukadipakai) {
                                        return "SUDAH DIPAKAI";
                                    }

                                    foreach ($pakai as $item) {
                                        $bayar = PembayaranpelayananT::model()->findByPk($item->pembayaranpelayanan_id);
                                        $tandabukti = TandabuktibayarT::model()->findByAttributes(array(
                                            'pembayaranpelayanan_id' => $bayar->pembayaranpelayanan_id,
                                        ), array(
                                            'condition' => 'closingkasir_id is not null',
                                        ));

                                        if (!empty($tandabukti)) {
                                            return "SUDAH DI CLOSING";
                                        }
                                    }

                                    return CHtml::Link(
                                        "<i class=\"icon-form-bayar\"></i>",
                                        '#',
                                        //Yii::app()->controller->createUrl("pembatalanUangMuka/index",array("idBayarUangMuka"=>$data->bayaruangmuka_id,"frame"=>true)),
                                        array(
                                            "onclick" => "confirmPengembalian(" . $data->bayaruangmuka_id . ");",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk mengembalikan uang muka",
                                        )
                                    );
                                }

                                return "-";
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width:40px', 'visible'=>$is_keuangan)
                        );
                    } else {
                        $col[] = array(
                            'header' => 'Order Batal Uang Muka',
                            'type' => 'raw',
                            'value' => function ($data) use (&$bayar) {

                                if (!empty($bayar->orderbataluangmuka_id)) {
                                    return "SUDAH VERIFIKASI BATAL UANG MUKA";
                                }

                                $pakai = PemakaianuangmukaT::model()->findAllByAttributes(array(
                                    'bayaruangmuka_id' => $data->bayaruangmuka_id,
                                ));
                                if ($data->pemakaianuangmuka > 0) return "SUDAH DIBAYAR";

                                $order = OrderbataluangmukaT::model()->findByAttributes(array(
                                    'bayaruangmuka_id'=>$data->bayaruangmuka_id
                                ));//
                                if (!empty($order)) {
                                    return "SUDAH ORDER BATAL UANG MUKA";
                                }


                                if (!empty($data->pembatalanuangmuka_id)) {
                                    $bkk = TandabuktikeluarT::model()->findByAttributes(array(
                                        'pembatalanuangmuka_id' => $data->pembatalanuangmuka_id
                                    ));
                                    return CHtml::link('<u>' . MyFormatter::formatDateTimeForUser($bkk->tglkaskeluar) . "/<br/>" . $bkk->nokaskeluar . '</u>', $this->createUrl('print/pembatalanUangMuka', array(
                                        'idTandaBukti' => $bkk->tandabuktikeluar_id,
                                    )), array(
                                        'target' => 'iframeDetailBatal',
                                        'onclick' => '$("#dialogDetailBatal").dialog("open");',
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Klik untuk melihat detail Pembatalan Uang Muka',
                                    ));
                                }
                                foreach ($pakai as $item) {
                                    $bayar = PembayaranpelayananT::model()->findByPk($item->pembayaranpelayanan_id);
                                    $tandabukti = TandabuktibayarT::model()->findByAttributes(array(
                                        'pembayaranpelayanan_id' => $bayar->pembayaranpelayanan_id,
                                    ), array(
                                        'condition' => 'closingkasir_id is not null',
                                    ));
                                    if (!empty($tandabukti)) {
                                        return "SUDAH DI CLOSING";
                                    }
                                }
                                return CHtml::Link(
                                    "<i class=\"icon-form-silang\"></i>",
                                    '#',
                                    //Yii::app()->controller->createUrl("pembatalanUangMuka/index",array("idBayarUangMuka"=>$data->bayaruangmuka_id,"frame"=>true)),
                                    array(
                                        "onclick" => "confirmBatal(" . $data->bayaruangmuka_id . "); return false;",
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk membatalkan uang muka",
                                    )
                                );
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width:40px')
                        );
                    }

                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'pencarianpasien-grid',
                        'dataProvider' => $model->searchInformasi(),
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                        'columns' => $col,
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); sorotTabel();}',
                    ));
                    ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogBatalUangMuka',
            'options' => array(
                'title' => 'Pembatalan Uang Muka',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 980,
                'zIndex' => 1001,
                'minHeight' => 610,
                'resizable' => true,
                'close' => "js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
								data: $(this).serialize()
							}); }",
            ),
        ));
        ?>
        <iframe src="" name="iframePembayaran" width="100%" height="550"></iframe>
        <?php
        $this->endWidget();
        ?>
        <?php
        $this->beginWidget(
            'zii.widgets.jui.CJuiDialog',
            array(
                'id' => 'dialogEditUangMuka',
                'options' => array(
                    'title' => 'Edit Uang Muka',
                    'autoOpen' => false,
                    'modal' => true,
                    'minWidth' => 980,
                    'zIndex' => 1001,
                    'minHeight' => 610,
                    'resizable' => true,
                ),
            )
        );
        ?>
        <iframe src="" name="iframeUangMuka" width="100%" height="550"></iframe>
        <?php
        $this->endWidget();
        ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogDetail',
            'options' => array(
                'title' => 'Rincian Pembayaran Uang Muka',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 980,
                'zIndex' => 1001,
                'minHeight' => 610,
                'resizable' => true,
                'close' => "js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
								data: $(this).serialize()
							}); }",
            ),
        ));
        ?>
        <iframe src="" name="iframeDetail" width="100%" height="550"></iframe>
        <?php
        $this->endWidget();
        ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogDetailBatal',
            'options' => array(
                'title' => 'Detail Pembatalan Uang Muka',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 1100,
                'zIndex' => 1001,
                'minHeight' => 610,
                'resizable' => true,
                'close' => "js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
								data: $(this).serialize()
							}); }",
            ),
        ));
        ?>
        <iframe src="" name="iframeDetailBatal" width="100%" height="550"></iframe>
        <?php
        $this->endWidget();
        ?>
    </div>
</div>
<?php //echo $this->renderPartial('_formKriteriaPencarian', array('model'=>$model,'form'=>$form),true);   
?>
<script>
    function confirmBatal(id) {

        myConfirm("Apakah anda yakin untuk order batal uang muka?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('orderBatal'); ?>', {
                    bayaruangmuka_id: id
                }, function(data) {
                    if (data.ok == 1) {
                        $.fn.yiiGridView.update("pencarianpasien-grid");
                        window.parent.myAlert(data.msg);
                    } else {
                        window.parent.myAlert(data.msg);
                    }
                }, 'json');
            }
        });

        //myConfirm("Pembatalan uang muka pasien juga akan menghapus data jurnal, apakah anda melanjutkan ?", "Peringatan", function(r) {
        //window.location.href = "<?php echo Yii::app()->controller->createUrl("pembatalanUangMuka/index") ?>&idBayarUangMuka=" + id;
        //});
    }

    function confirmPengembalian(id) {
        window.location.href = "<?php echo Yii::app()->controller->createUrl("/billingKasir/pembatalanUangMuka/pengembalian") ?>&idBayarUangMuka=" + id;
    }

    function sorotTabel() {
        $(".sorot_merah").each(function() {
            $(this).parents("tr").addClass("row_merah");
        });
        $(".sorot_kuning").each(function() {
            $(this).parents("tr").addClass("row_kuning");
        });
    }

    $(document).ready(function() {
        sorotTabel();
    });
</script>