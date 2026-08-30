<?php $linkHalaman = CustomFunction::getUrlByMenuID(962); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Penjualan Obat untuk Dokter',
);
?>
<!--div class="white-container"-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Penjualan Obat untuk Dokter</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial('_search', array('modInfoPenjualan' => $modInfoPenjualan), true); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penjualan Obat untuk Dokter</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
                    <?php
                    $this->widget('bootstrap.widgets.BootAlert');
                    Yii::app()->clientScript->registerScript('cariPasien', "
                                $('#searchInformasi').submit(function(){
                                    $('#informasipenjualandokter-grid').addClass('animation-loading');
                                    $.fn.yiiGridView.update('informasipenjualandokter-grid', {
                                        data: $(this).serialize()
                                    });
                                    return false;
                                });
                                ");
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'informasipenjualandokter-grid',
                        'dataProvider' => $modInfoPenjualan->searchInfoJualDokter(),
                        //        'filter'=>$modInfo,
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                        'columns' => array(
                            array(
                                'header' => 'Tanggal Penjualan/<br>Tanggal Resep',
                                'type' => 'raw',
                                'value' => '$data->tglpenjualan." / ".$data->tglresep',
                            ),
                            array(
                                'header' => 'No. Resep',
                                'type' => 'raw',
                                'value' => '$data->noresep',
                            ),
                            array(
                                'header' => 'Jenis Penjualan',
                                'type' => 'raw',
                                'value' => '$data->jenispenjualan',
                            ),
                            array(
                                'header' => 'Nama Dokter',
                                'type' => 'raw',
                                'value' => '$data->getNamaPegawai($data->pasienpegawai_id)',
                            ),
                            array(
                                'header' => 'Nama Dokter Resep',
                                'type' => 'raw',
                                'value' => 'isset($data->NamaDokter) ? $data->NamaDokter : "-"',
                            ),
                            array(
                                'header' => 'Umur/<br>Jenis Kelamin',
                                'type' => 'raw',
                                'value' => '"$data->umur"."<br>"."$data->jeniskelamin"',
                            ),
                            array(
                                'header' => 'Status Obat',
                                'type' => 'raw',
                                'value' => '$data->getStatusObat($data->statusobat,$data->penjualanresep_id)',
                                'htmlOptions' => array('style' => 'text-align:center;')
                            ),
                            array(
                                'header' => 'Etiket',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    $racikan = ObatalkespasienT::model()->findByAttributes(array(
                                        'penjualanresep_id' => $data->penjualanresep_id,
                                        'racikan_id' => Params::RACIKAN_ID_RACIKAN,
                                    ));
                                    $nonRacikan = ObatalkespasienT::model()->findByAttributes(array(
                                        'penjualanresep_id' => $data->penjualanresep_id,
                                        'racikan_id' => Params::RACIKAN_ID_NONRACIKAN,
                                    ));
                                    $str = array();
                                    if (!empty($racikan)) {
                                        $str[] = CHtml::link('<i class="icon-form-print"></i><br>Racikan', Yii::app()->createUrl('/farmasiApotek/penjualanDariReseptur/printEtiket', array(
                                            'penjualanresep_id' => $data->penjualanresep_id, 
                                            'racikan' => Params::RACIKAN_ID_RACIKAN
                                        )), array(
                                            'target' => 'frameEtiket',
                                            'onclick' => "$('#dialogEtiket').dialog('open');"
                                        ));
                                    }
                                    if (!empty($nonRacikan)) {
                                        $str[] = CHtml::link('<i class="icon-form-print"></i><br>Non Racikan', Yii::app()->createUrl('/farmasiApotek/penjualanDariReseptur/printEtiket', array(
                                            'penjualanresep_id' => $data->penjualanresep_id, 
                                            'racikan' => Params::RACIKAN_ID_NONRACIKAN
                                        )), array(
                                            'target' => 'frameEtiket',
                                            'onclick' => "$('#dialogEtiket').dialog('open');"
                                        ));
                                    }
                                    return implode("<br>", $str);
                                },
                                'htmlOptions' => array('style' => 'text-align: center; width:60px')
                            ),
                            array(
                                'name' => 'Penyerahan Obat',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    $oa = ObatalkespasienT::model()->findByAttributes(array(
                                        'penjualanresep_id' => $data->penjualanresep_id,
                                    ), array(
                                        'condition' => 'oasudahbayar_id is null',
                                    ));
                                    if (!empty($oa)) {
                                        return 'BELUM LUNAS';
                                    } else if (!empty($data->tglpenyerahan)) {
                                        return "Penyerahan Obat Tgl " . $data->tglpenyerahan;
                                    } else {
                                        return CHtml::Link(
                                            "<i class=\"icon-form-verifikasi\"></i>",
                                            Yii::app()->controller->createUrl("InformasiResepPasien/ambilObat", array("penjualanresep_id" => $data->penjualanresep_id, "frame" => 1, "popup" => "true")),
                                            array(
                                                "class" => "",
                                                "target" => "iframeAmbilObat",
                                                "onclick" => "$(\"#dialogAmbilObat\").dialog(\"open\");",
                                                "rel" => "tooltip",
                                                "title" => "Klik untuk Penyerahan Obat",
                                            )
                                        );
                                    }
                                },
                                'htmlOptions' => array('style' => 'text-align: center; width:60px')
                            ),
                            array(
                                'header' => 'Ubah',
                                'type' => 'raw',
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                'value' => '(!empty($data->nomorResepSudahBayar) ? "<p style=\"margin: 0; text-align: center;\">-</p>" : 
                                            CHtml::Link("<i class=\"icon-form-ubah\"></i>",Yii::app()->controller->createUrl(("InformasiPenjualanKaryawan/ubahPenjualanResep"),array("penjualanresep_id"=>$data->penjualanresep_id,"dokter"=>1)),
                                                array("class"=>"", 
                                                    "rel"=>"tooltip",
                                                    "title"=>"Klik untuk lihat ubah penjualan",
                                                )
                                            ))',
                            ),
                            array(
                                'header' => 'Detail Penjualan',
                                'type' => 'raw',
                                'value' => 'CHtml::Link("<i class=\"icon-form-rincianjual\"></i>",Yii::app()->controller->createUrl("PenjualanDokter/print",array("penjualanresep_id"=>$data->penjualanresep_id,"frame"=>true)),
                                            array("class"=>"", 
                                                "target"=>"iframePenjualanResep",
                                                "onclick"=>"$(\"#dialogDetailPenjualan\").dialog(\"open\");",
                                                "rel"=>"tooltip",
                                                "title"=>"Klik untuk lihat detail penjualan",
                                            ))',
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            ),
                            array(
                                'header' => 'Batal / Retur Penjualan',
                                'type' => 'raw',
                                'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                                'value' => '(!empty($data->returresep_id)) ?  
                                            "Sudah Diretur" : 
                                            ((!empty($data->nomorResepSudahBayar)) ? 
                                            "Sudah Melakukan Retur"
                                                : 
                                            (CHtml::Link("<i class=\"icon-form-silang\"></i>","javascript:void(0);",
                                            array("class"=>"", 
                                                "onclick"=>"cekHakBatal(".$data->penjualanresep_id.");return false;",
                                                "rel"=>"tooltip",
                                                "title"=>"Klik untuk Batal Penjualan Resep",
                                            )).
                                            CHtml::Link("<i class=\"icon-form-retur\"></i>",Yii::app()->controller->createUrl("informasiPenjualanResep/returPenjualan",array("penjualanresep_id"=>$data->penjualanresep_id)),
                                            array("class"=>"", 
                                                "target"=>"iframeReturPenjualan",
                                                "onclick"=>"$(\"#dialogReturPenjualan\").dialog(\"open\");",
                                                "rel"=>"tooltip",
                                                "title"=>"Klik untuk Retur Penjualan",
                                            ))))',
                            ),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/div-->
<?php
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogEtiket',
    'options' => array(
        'title' => 'Etiket',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe name='frameEtiket' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<?php
// Dialog untuk ambil Obat =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAmbilObat',
    'options' => array(
        'title' => 'Penyerahan Obat Pasien',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1100,
        'height' => 550,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('informasipenjualandokter-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe src="" name="iframeAmbilObat" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end ambil Obat =============================
?>
<?php
// Dialog buat lihat penjualan resep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailPenjualan',
    'options' => array(
        'title' => 'Detail Penjualan Resep',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 980,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframePenjualanResep" style="width: 100%; height: 90%;"></iframe>
<?php
$this->endWidget();
//========= end lihat penjualan resep dialog =============================
?>
<?php
// Dialog buat lihat Retur Penjualan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogReturPenjualan',
    'options' => array(
        'title' => 'Retur Penjualan',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => true,
        'before'
    ),
));
?>
<iframe src="" name="iframeReturPenjualan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end lihat Retur Penjualan Dialog =============================
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'logindialog',
    'options' => array(
        'title' => 'Login',
        'autoOpen' => false,
        'modal' => true,
        'width' => 400,
        'height' => 190,
        'resizable' => true,
    ),
)); ?>
<?php echo CHtml::beginForm('', 'POST', array('class' => 'form-horizontal', 'id' => 'loginform')); ?>
<div class="control-group">
    <?php echo CHtml::label('Nama Pemakai', 'username', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('username', '', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo CHtml::hiddenField('penjualanresep_id', '', array()); ?>
        <?php echo CHtml::hiddenField('untukaction', '', array()); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Kata Kunci', 'password', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::passwordField('password', '', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Login', array('{icon}' => '<i class="icon-lock icon-white"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'submitLogin();return false;', 'onkeypress' => 'submitLogin();return false;')
    ); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')), '#', array('class' => 'btn btn-default', 'onclick' => "$('#logindialog').dialog('close');return false", 'disabled' => false)); ?>
</div>
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctionsIndex'); ?>
<script type="text/javascript">
    function printEtiket(penjualanresep_id, racikan) {
        window.open('<?php echo $this->createUrl('penjualanDariReseptur/printEtiket'); ?>&racikan=' + (racikan ? 1 : 0) + '&penjualanresep_id=' + penjualanresep_id + '&caraPrint=PRINT', 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    function setStatusObat(obj, status, penjualanresep_id) {
        if (status == 'BELUM') {
            window.parent.myConfirm('Apakah obat akan dipersiapkan?', 'Perhatian!', function(r) {
                if (r) {
                    $.post('<?php echo $this->createUrl('ubahStatusObat'); ?>', {
                        status: status,
                        penjualanresep_id: penjualanresep_id
                    }, function(data) {
                        if (data.pesan == 'ok') {
                            $.fn.yiiGridView.update('informasipenjualandokter-grid');
                        }
                    }, 'json');
                }
            });
        } else {
            window.parent.myConfirm('Apakah obat sudah dipersiapkan?', 'Perhatian!', function(r) {
                if (r) {
                    $.post('<?php echo $this->createUrl('ubahStatusObat'); ?>', {
                        status: status,
                        penjualanresep_id: penjualanresep_id
                    }, function(data) {
                        if (data.pesan == 'ok') {
                            $.fn.yiiGridView.update('informasipenjualandokter-grid');
                        }
                    }, 'json');
                }
            });
        }
        return false;
    }
</script>