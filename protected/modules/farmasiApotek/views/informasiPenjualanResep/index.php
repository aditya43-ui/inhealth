<!--div class="white-container"-->
<?php
$this->breadcrumbs = array(
    'Informasi Penjualan Resep & Bebas',
);
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'search',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($modInfoPenjualan, 'no_rekam_medik'),
    'method' => 'get',
    'htmlOptions' => array(),
));
?>
<style>
    .numbersOnly {
        text-align: left;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Penjualan Resep Bebas</b>
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
                <div class="row">
                    <fieldset class="box">
                        <div class="col-sm-6">
                            <div class="control-group">
                                <?php echo CHtml::label("Tgl. Penjualan", 'tgl_rekam', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($modInfoPenjualan->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($modInfoPenjualan->tgl_akhir)) ?>">
                                        <i class="entypo-calendar"></i>
                                        <span><?php echo date('d F Y', strtotime($modInfoPenjualan->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($modInfoPenjualan->tgl_akhir)) ?></span>
                                        <?php echo $form->hiddenField($modInfoPenjualan, 'tgl_awal', array('class' => 'start')) ?>
                                        <?php echo $form->hiddenField($modInfoPenjualan, 'tgl_akhir', array('class' => 'end')) ?>
                                    </div>
                                </div>
                            </div>
                            <?php echo $form->textFieldRow($modInfoPenjualan, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            <?php echo $form->textFieldRow($modInfoPenjualan, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            <?php
                            $carabayar = CarabayarM::model()->findAll(array(
                                'condition' => 'carabayar_aktif = true',
                                'order' => 'carabayar_nourut',
                            ));
                            foreach ($carabayar as $idx => $item) {
                                $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                                    'carabayar_id' => $item->carabayar_id,
                                    'penjamin_aktif' => true,
                                ));
                                if (empty($penjamins)) unset($carabayar[$idx]);
                            }
                            $penjamin = PenjaminpasienM::model()->findAll(array(
                                'condition' => 'penjamin_aktif = true',
                                'order' => 'penjamin_nama',
                            ));
                            echo $form->dropDownListRow($modInfoPenjualan, 'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                                'empty' => '-- Pilih --',
                                'class' => 'span4',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($modInfoPenjualan))),
                                    'success' => 'function(data){$("#' . CHtml::activeId($modInfoPenjualan, "penjamin_id") . '").html(data); }',
                                ),
                            ));
                            echo $form->dropDownListRow($modInfoPenjualan, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span4'));
                            ?>
                        </div>
                        <div class="col-sm-6">
                            <div class="control-group">
                                <?php echo CHtml::label('Jenis Penjualan', 'jenispenjualan', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList($modInfoPenjualan, 'jenispenjualan', $modInfoPenjualan->listJenisPenjualanBebas(), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
                                    <?php //echo $form->textField($modInfoPenjualan,'jenispenjualan',array('class'=>'span4','onkeypress'=>"return $(this).focusNextInputField(event)")); 
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label('No. Resep', 'no_resep', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($modInfoPenjualan, 'noresep', array('placeholder' => 'No. Resep', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>
                            <?php echo $form->dropDownListRow($modInfoPenjualan, 'statusperiksa', Params::statusPeriksa(), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
                            <?php
                            $pegawai = CHtml::listData(DokterV::model()->findAllByAttributes(array(
                                'instalasi_id' => array(2, 3, 4),
                            ), array(
                                'order' => 'nama_pegawai asc',
                            )), 'pegawai_id', 'namaLengkap');
                            echo $form->dropDownListRow($modInfoPenjualan, 'pegawai_id', $pegawai, array(
                                'empty' => '-- Pilih --',
                                'class' => 'span4',
                            ));
                            ?>
                            <?php echo $form->dropDownListRow($modInfoPenjualan, 'ruanganasal_nama', CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                                'instalasi_id' => array(2, 3, 4),
                                'ruangan_aktif' => true,
                            ), array(
                                'order' => 'instalasi_id, ruangan_nama asc'
                            )), 'ruangan_nama', 'ruangan_nama'), array('class' => 'span4', 'empty' => '-- Pilih --'));
                            ?>
                        </div>
                    </fieldset>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                    ); ?>
                    <?php
                    echo CHtml::link(
                        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        $this->createUrl($this->id . '/index'),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-default',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    );
                    ?>
                    <?php
                    $content = $this->renderPartial('../tips/informasi_pencarian', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penjualan Resep Bebas</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('bootstrap.widgets.BootAlert');
                Yii::app()->clientScript->registerScript('cariPasien', "
                            $('#search').submit(function(){
                                $('#informasipenjualanresep-grid').addClass('animation-loading');
                                $.fn.yiiGridView.update('informasipenjualanresep-grid', {
                                    data: $(this).serialize()
                                });
                                return false;
                            });
                            ");
                ?>
                <div class="block-tabel">
                    <?php
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'informasipenjualanresep-grid',
                        'dataProvider' => $modInfoPenjualan->searchInfoJualResep(),
                        //        'filter'=>$modInfo,
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                        'replaceUrl' => true,
                        'columns' => array(
                            array(
                                'name' => 'noantrian',
                                'header' => 'No. Antrian/<br>Panggil Antrian',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    if (empty($data->noantrian)) {
                                        return "Tanpa Antrian";
                                    }
                                    $antrian = AntrianfarmasiT::model()->findByPk($data->antrianfarmasi_id);
                                    $modelLoket = ModelantrianM::model()->findByPk(array(
                                        $antrian->modelantrian_id
                                    ));
                                    $str = $data->racikanantrian_singkatan . "-" . $data->noantrian . '<br/>';
                                    if (!empty($modelLoket)) {
                                        $str = $modelLoket->modelantrian_kode . $str;
                                    }
                                    if ($data->panggilantrian && $antrian->jumlah_panggil == 3) {
                                        return $str . "Sudah Dipanggil";
                                    }
                                    return CHtml::htmlButton(Yii::t("mds", "{icon}", array("{icon}" => '<i class="icon-volume-up icon-white"></i>')), array(
                                        "class" => "btn btn-primary",
                                        "onclick" => 'panggilAntrian("' . $data->penjualanresep_id . '","' . $data->antrianfarmasi_id . '")', "rel" => "tooltip", "title" => "Klik untuk memanggil pasien ini"
                                    ));
                                }
                            ),
                            array(
                                'header' => 'Tanggal Penjualan/<br/>No Resep',
                                'type' => 'raw',
                                'value' => '$data->tglpenjualan."/<br/>".$data->noresep',
                            ), /*
                                        array(
                                            'header'=>'No. Resep',
                                            'type'=>'raw',
                                            'value'=>'$data->noresep',
                                        ), */
                            array(
                                'header' => 'Jenis Penjualan',
                                'type' => 'raw',
                                'value' => '$data->jenispenjualan',
                            ),
                            array(
                                'header' => 'No. Rekam Medik',
                                'type' => 'raw',
                                'value' => '$data->no_rekam_medik',
                            ),
                            array(
                                'name' => 'nama_pasien',
                                'value' => '$data->namadepan.$data->nama_pasien',
                            ),
                            array(
                                'header' => 'Jenis Kelamin /<br/>Umur',
                                'type' => 'raw',
                                'value' => '"$data->jeniskelamin"."<br/>"."$data->umur"',
                            ),
                            array(
                                'header' => 'Jenis Kasus Penyakit',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    $p = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                    return !empty($p) ? (!empty($p->jeniskasuspenyakit_id) ? $p->jeniskasuspenyakit->jeniskasuspenyakit_nama : "-") : "-";
                                    //return (!empty($p)?$p->jeniskasuspenyakit->jeniskasuspenyakit_nama:"-");
                                }
                            ),
                            array(
                                'header' => 'Jenis Penjamin/<br/>Penjamin',
                                'type' => 'raw',
                                'value' => '$data->carabayar_nama."/<br/>".$data->penjamin_nama',
                            ),
                            /*
                                        array(
                                            'header'=>'Alamat',
                                            'type'=>'raw',
                                            'value'=>'$data->alamat_pasien',
                                        ), */
                            array(
                                'header' => 'Dokter/<br/>Ruangan',
                                'type' => 'raw',
                                'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama."/<br>".$data->ruanganasal_nama',
                            ),
                            array(
                                'header' => 'Status Periksa',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    $pd = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                    return !empty($pd) ? $pd->statusperiksa : "-";
                                },
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
                                        $str[] = CHtml::link('<i class="icon-form-print"></i><br/>Racikan', '#', array(
                                            'onclick' => 'printEtiket(' . $data->penjualanresep_id . ', true); return false;'
                                        ));
                                    }
                                    if (!empty($nonRacikan)) {
                                        $str[] = CHtml::link('<i class="icon-form-print"></i><br/>Non Racikan', '#', array(
                                            'onclick' => 'printEtiket(' . $data->penjualanresep_id . ', false); return false;'
                                        ));
                                    }
                                    $str[] .= "<br/>".CHtml::Link('<i class="icon-form-ubah"></i>',Yii::app()->createUrl("/farmasiApotek/informasiPenjualanResep/ubahPenjualanResep", array(
                                        "idPenjualan"=>$data->penjualanresep_id,
                                    )),
                                    array(
                                        "title"=>"Klik untuk Ubah Penjualan",
                                        "data-placement"=>"left"
                                    ));
                                    return implode("<br/>", $str);
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
                                        if ($data->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR) {
                                            return 'BELUM LUNAS';
                                        }else if (in_array($data->carabayar_id, array(Params::CARABAYAR_ID_BPJS, Params::CARABAYAR_ID_BPJS_TENAGAKERJA))) {
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
                                        }else{
                                            return 'BELUM VERIFIKASI';
                                        }
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
                            // array(
                            //     'header' => 'Ubah',
                            //     'type' => 'raw',
                            //     'htmlOptions' => array('style' => 'text-align: left;'),
                            //     'value' => '(!empty($data->NomorResepSudahBayar) ? "Pasien Sudah Bayar" : CHtml::Link("<i class=\"icon-form-ubah\"></i>",Yii::app()->controller->createUrl((($data->jenispenjualan == Params::JENISPENJUALAN_RESEP) ? "InformasiPenjualanResep/ubahPenjualanResep" : (($data->jenispenjualan == Params::JENISPENJUALAN_RESEP) ? "InformasiPenjualanResep/ubahPenjualanResep" : "InformasiPenjualanResep/ubahPenjualanResep" )),array("idPenjualan"=>$data->penjualanresep_id)),
                            //                     array("class"=>"", 
                            //                         "rel"=>"tooltip",
                            //                         "title"=>"Klik untuk lihat ubah penjualan",
                            //                     )))',
                            // ),
                            array(
                                'header' => 'Detail Penjualan',
                                'type' => 'raw',
                                'value' => '
                                            ($data->jenispenjualan != Params::JENISPENJUALAN_RESEP) ?
                                                CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("penjualanBebas/Print",array("penjualanresep_id"=>$data->penjualanresep_id)),
                                                    array("class"=>"", 
                                                          "target"=>"iframePenjualanResep",
                                                          "onclick"=>"$(\"#urlId\").val($data->penjualanresep_id);$(\"#urlPrintDetail\").val(\"' . Yii::app()->controller->createUrl("penjualanBebas/Print") . '\");$(\"#dialogDetailPenjualan\").dialog(\"open\");",
                                                          "rel"=>"tooltip",
                                                          "title"=>"Klik untuk lihat detail penjualan",
                                                    )) : 
                                                CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("penjualanResepRS/print",array("penjualanresep_id"=>$data->penjualanresep_id)),
                                                    array("class"=>"",
                                                          "target"=>"iframePenjualanResep",
                                                          "onclick"=>"$(\"#urlId\").val($data->penjualanresep_id);$(\"#urlPrintDetail\").val(\"' . Yii::app()->controller->createUrl("penjualanResepRS/print") . '\");$(\"#dialogDetailPenjualan\").dialog(\"open\");",
                                                          "rel"=>"tooltip",
                                                          "title"=>"Klik untuk lihat detail penjualan",
                                                    ))    
                                            ',
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            ),
                            array(
                                'header' => 'Batal / Retur Penjualan',
                                'type' => 'raw',
                                'value' => '(!empty($data->returresep_id)) ? "Sudah Diretur"."<br>".CHtml::Link("<i class=\"icon-form-print\"></i>","#",
                                                array("class"=>"", 
                                                    "onclick"=>"printRetur(".$data->returresep_id.",".$data->penjualanresep_id.",\"PRINT\");return false;",
                                                    "rel"=>"tooltip",
                                                    "title"=>"Klik untuk mencetak Retur Penjualan",
                                                )) : 
                                                (!empty($data->nomorResepSudahBayar) ? 
                                                "Sudah Lunas": 
                                                CHtml::Link("<i class=\"icon-form-silang\"></i>","javascript:void(0);",
                                                    array("class"=>"", 
                                                        "onclick"=>"cekHakBatal(".$data->penjualanresep_id.");return false;",
                                                        "rel"=>"tooltip",
                                                        "title"=>"Klik untuk Batal Penjualan Resep",
                                                    ))."&nbsp;&nbsp;".CHtml::Link("<i class=\"icon-form-retur\"></i>",Yii::app()->controller->createUrl("informasiPenjualanResep/returPenjualan",array("penjualanresep_id"=>$data->penjualanresep_id)),
                                                    array("class"=>"", 
                                                        "target"=>"iframeReturPenjualan",
                                                        "onclick"=>"$(\"#dialogReturPenjualan\").dialog(\"open\");",
                                                        "rel"=>"tooltip",
                                                        "title"=>"Klik untuk Retur Penjualan",
                                                    )
                                                )
                                            )',
                                'htmlOptions' => array('style' => 'text-align: center; width:80px'),
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
<?php $this->endWidget(); ?>
<?php
// Dialog buat lihat penjualan resep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailPenjualan',
    'options' => array(
        'title' => 'Detail Penjualan Resep',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="iframePenjualanResep" style="width: 100%; height: 98%;"></iframe>
<?php
echo CHtml::hiddenField('urlId', '', array());
echo CHtml::hiddenField('urlPrintDetail', '', array());
echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'printDetail(\'PRINT\')'));
$this->endWidget();
//========= end lihat penjualan resep dialog =============================
?>
<script type="text/javascript">
    function printEtiket(penjualanresep_id, racikan) {
        window.open('<?php echo $this->createUrl('penjualanDariReseptur/printEtiket'); ?>&racikan=' + (racikan ? 1 : 0) + '&penjualanresep_id=' + penjualanresep_id + '&caraPrint=PRINT', 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    function printDetail(caraPrint) {
        url = $("#urlPrintDetail").val();
        id = $("#urlId").val();
        window.open(url + "&penjualanresep_id=" + id + "&caraPrint=" + caraPrint, "", 'location=_new, width=900px');
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
                            window.location.reload()
                            // $.fn.yiiGridView.update('informasipenjualanresep-grid');
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
                            window.location.reload()
                            // $.fn.yiiGridView.update('informasipenjualanresep-grid');
                        }
                    }, 'json');
                }
            });
        }
        return false;
    }
</script>
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
        'close' => "js:function(){ $.fn.yiiGridView.update('informasipenjualanresep-grid', {
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
// Dialog buat lihat Retur Penjualan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogReturPenjualan',
    'options' => array(
        'title' => 'Retur Penjualan',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('informasipenjualanresep-grid', {
                        data: $('#search').serialize()
                    }); }",
        'before'
    ),
));
?>
<iframe src="" name="iframeReturPenjualan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end lihat Retur Penjualan Dialog =============================
?>
<script type="text/javascript">
    function printRetur(returresep_id, penjualanresep_id, caraPrint) {
        window.open("<?php echo Yii::app()->createAbsoluteUrl($this->module->id . '/informasiPenjualanResep/PrintStrukRetur') ?>&returresep_id=" + returresep_id + "&penjualanresep_id=" + penjualanresep_id + "&caraPrint=" + caraPrint, "", 'location=_new, width=900px');
    }
</script>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'logindialog',
    'options' => array(
        'title' => 'Login',
        'autoOpen' => false,
        'modal' => true,
        'width' => 400,
        'height' => 190,
        'resizable' => false,
    ),
)); ?>
<?php echo CHtml::beginForm('', 'POST', array('class' => 'form-horizontal', 'id' => 'loginform')); ?>
<div class="control-group ">
    <?php echo CHtml::label('Nama Pemakai', 'username', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('username', '', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo CHtml::hiddenField('penjualanresep_id', '', array()); ?>
        <?php echo CHtml::hiddenField('untukaction', '', array()); ?>
    </div>
</div>
<div class="control-group ">
    <?php echo CHtml::label('Kata Kunci', 'password', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::passwordField('password', '', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Login', array('{icon}' => '<i class="icon-lock icon-white"></i>')),
        array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'submitLogin();return false;', 'onkeypress' => 'submitLogin();return false;')
    ); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')), '#', array('class' => 'btn btn-danger', 'onclick' => "$('#logindialog').dialog('close');return false", 'disabled' => false)); ?>
</div>
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctionsIndex'); ?>
<!--/div-->