<?php $linkHalaman = CustomFunction::getUrlByMenuID(383); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pengiriman Menu Diet Pasien',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pengiriman Menu Diet Pasien</b>
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
                $.fn.yiiGridView.update('gzkirimmenudiet-t-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");
        ?>
        <?php $this->renderPartial('_search', array('model' => $model,)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pengiriman Menu Diet Pasien</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'gzkirimmenudiet-t-grid',
                    'dataProvider' => $model->searchInformasi(),
                    //    'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Tanggal Kirim Menu',
                            'type' => 'raw',
                            'value' => 'isset($data->tglkirimmenu) ? MyFormatter::formatDateTimeForUser($data->tglkirimmenu) : ""',
                        ),
                        array(
                            'header' => 'No. Kirim Menu',
                            'type' => 'raw',
                            'value' => 'isset($data->nokirimmenu) ? $data->nokirimmenu : ""',
                        ),
                        array(
                            'header' => 'No. Pesan Menu',
                            'type' => 'raw',
                            'value' => '!empty($data->pesanmenudiet_id)?$data->pesanmenudiet->nopesanmenu:"-"',
                        ),
                        array(
                            'header' => 'Jenis Pesan',
                            'type' => 'raw',
                            'value' => 'isset($data->jenispesanmenu) ? $data->jenispesanmenu : ""',
                        ),
                        array(
                            'header' => 'Jenis Menu Diet',
                            'type' => 'raw',
                            'value' => '(isset($data->jenisdiet_id)?$data->jenisdiet->jenisdiet_nama:"")',
                        ),
                        array(
                            'header' => 'Pasien (Instalasi/Ruangan, Kelas)',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if ($data->jenispesanmenu  == "Pasien") {
                                    $kirim = KirimmenupasienT::model()->findAllByAttributes(array(
                                        'kirimmenudiet_id' => $data->kirimmenudiet_id,
                                    ));
                                    $str = "";
                                    if (count((array)$kirim) > 0) {
                                        $str .= "<ul>";
                                        $pasien = array();
                                        foreach ($kirim as $item) {
                                            $modPasien = PasienM::model()->findByPk($item->pasien_id);
                                            $modPendaftaran = PendaftaranT::model()->findByPk($item->pendaftaran_id);
                                            $key = $item->pendaftaran_id . "_" . $item->pasienadmisi_id;
                                            if (empty($pasien[$key])) {
                                                $pasien[$key] = array('nama' => $modPasien->nama_pasien, 'ruangan' => $item->ruangan->instalasi->instalasi_nama . "/" . $item->ruangan->ruangan_nama, 'kelas' => '');
                                            }
                                            if (!empty($item->pasienadmisi_id)) {
                                                $masuk = MasukkamarT::model()->findByAttributes(array(
                                                    'pasienadmisi_id' => $item->pasienadmisi_id,
                                                    'kamarruangan_id' => $item->kamarruangan_id
                                                ));
                                                if (!empty($masuk)) {
                                                    $pasien[$key]['kelas'] = $masuk->kelaspelayanan->kelaspelayanan_nama;
                                                }
                                            } else {
                                                $pasien[$key]['kelas'] = $modPendaftaran->kelaspelayanan->kelaspelayanan_nama;
                                            }
                                        }
                                        foreach ($pasien as $item) {
                                            $str .= "<li>" . $item['nama'];
                                            if (!empty($item['ruangan']) || !empty($item['kelas'])) {
                                                $str .= " (";
                                                if (!empty($item['ruangan'])) {
                                                    $str .= $item['ruangan'];
                                                }
                                                if (!empty($item['kelas'])) {
                                                    $str .= ", " . $item['kelas'];
                                                }
                                                $str .= ")";
                                            }
                                            $str .= '</li>';
                                        }
                                        $str .= "</ul>";
                                    }
                                    return $str;
                                } else if ($data->jenispesanmenu  == "Pendamping") {
                                    $pesan = PesanmenudietT::model()->findByPk($data->pesanmenudiet_id);
                                    if (!empty($pesan->pendaftaran)) {
                                        $str = "<ul>";
                                        $str .= "<li>" . $pesan->pendaftaran->pasien->nama_pasien . " (";
                                        $str .= $pesan->ruangan->instalasi->instalasi_nama . "/" . $pesan->ruangan->ruangan_nama;
                                        if (!empty($pesan->pendaftaran->pasienadmisi_id)) {
                                            $masuk = MasukkamarT::model()->findByAttributes(array(
                                                'pasienadmisi_id' => $pesan->pendaftaran->pasienadmisi_id,
                                                'ruangan_id' => $pesan->ruangan_id,
                                            ));
                                            if (!empty($masuk)) {
                                                $str .= ", " . $masuk->kelaspelayanan->kelaspelayanan_nama;
                                            }
                                        } else {
                                            $str .= ", " . $pesan->pendaftaran->kelaspelayanan->kelaspelayanan_nama;
                                        }
                                        $str .= ")</li>";
                                        $str .= "</ul>";
                                        return $str;
                                    }
                                }
                                return "";
                            },
                        ),
                        /*
							array(
								'header'=>'Instalasi / Ruangan',
								'type'=>'raw',
													'value'=> function ($data){
                                                        //$kirim = KirimmenupasienT::model()->findAllBy
														return isset($data->kirimmenupasien->kirimmenupasien_id) ? $data->kirimmenupasien->ruangan->instalasi->instalasi_nama." / ".$data->kirimmenupasien->ruangan->ruangan_nama : isset($data->kirimmenupegawai->kirimmenupegawai_id) ? $data->kirimmenupegawai->ruangan->instalasi->instalasi_nama." / ".$data->kirimmenupegawai->ruangan->ruangan_nama : "";
													},
								'headerHtmlOptions'=>array('style'=>'vertical-align: middle;text-align:center;')
							),
							/*array(
								'header'=>'Nama Bahan Diet',
								'type'=>'raw',
								'value'=>'!empty($data->bahandiet_id)?$data->bahandiet->bahandiet_nama: "-"',
								'headerHtmlOptions'=>array('style'=>'vertical-align: middle;text-align:center;')
							),*/
                        array(
                            'header' => 'Ket. <br> Kirim',
                            'type' => 'raw',
                            'value' => '$data->keterangan_kirim',
                        ),
                        array(
                            'header' => 'Pegawai Pengirim',
                            'value' => '$data->pengirim->pegawai->namaLengkap'
                        ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/gizi/KirimmenudietT/detailKirimMenuDiet",array("id"=>$data->kirimmenudiet_id,"frame"=>TRUE)),array("id"=>"$data->kirimmenudiet_id","target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk rincian pengiriman menu diet", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'headerHtmlOptions' => array('style' => 'vertical-align: middle;text-align:center; width:40px')
                        ),
                        array(
                            'header' => 'Ubah Menu Diet',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-ubah\'></i> ",  Yii::app()->controller->createUrl("/gizi/InformasiMenuDiet/indexKirim",array("idKirimmenudiet"=>$data->kirimmenudiet_id)),array("idKirimmenudiet"=>"$data->kirimmenudiet_id","target"=>"frameUbahMenu","rel"=>"tooltip","title"=>"Klik untuk Retur  / Ubah Menu Diet", "onclick"=>"window.parent.$(\'#dialogUbahMenu\').dialog(\'open\')"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Batal <br> Kirim',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=icon-form-silang></i>","javascript:batalKirim(\'$data->kirimmenudiet_id\')",array("idKirimDiet"=>$data->kirimmenudiet_id,"href"=>"#","rel"=>"tooltip","title"=>"Klik untuk Batal Pesan Menu Diet",))',
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
        'title' => 'Detail Pemesanan Menu Diet',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 750,
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
    'id' => 'dialogUbahMenu',
    'options' => array(
        'title' => 'Retur / Ubah Menu Diet',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 1200,
        'height' => 500,
        'resizable' => false,
    ),
));
echo '<iframe src="" name="frameUbahMenu" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
?>
<?php
// Dialog untuk Batal Kirim Menu Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogBatalKirim',
    'options' => array(
        'title' => 'Batal Kirim Menu Diet',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'minHeight' => 200,
        'resizable' => false,
    ),
));
echo '<div class="divForForm"></div>';
$this->endWidget();
//========= Dialog untuk Batal Kirim Menu Diet =============================
?>
<script>
    function batalKirim(idKirimDiet) {
        var idKirimDiet = idKirimDiet;
        //    var answer = confirm('Yakin Akan Membatalkan Pengiriman Diet?');
        //    if (answer){
        $.post('<?php echo $this->createUrl('batalKirimMenuDiet'); ?>', {
            idKirimDiet: idKirimDiet
        }, function(data) {
            if (data.status == 'create_form') {
                setTimeout("$('#dialogBatalKirim').dialog('open') ", 1000);
                $('#dialogBatalKirim div.divForForm').html(data.div);
                $('#dialogBatalKirim div.divForForm form #idKirimDiet').val(data.idKirim);
                $('#dialogBatalKirim div.divForForm form').submit(konfirmBatal);
            } else {
                $('#dialogBatalKirim div.divForForm').html(data.div);
                $.fn.yiiGridView.update('gzkirimmenudiet-t-grid');
                setTimeout("$('#dialogBatalKirim').dialog('close') ", 1000);
            }
        }, 'json');
        //    }
    }

    function konfirmBatal() {
        <?php
        echo CHtml::ajax(array(
            'url' => $this->createUrl('batalKirimMenuDiet'),
            'data' => "js:$(this).serialize()",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogBatalKirim div.divForForm').html(data.div);
                    $('#dialogBatalKirim div.divForForm form').submit(konfirmBatal);
                }
                else
                {
                    $('#dialogBatalKirim div.divForForm').html(data.div);
                    $.fn.yiiGridView.update('gzkirimmenudiet-t-grid');
                    setTimeout(\"$('#dialogBatalKirim').dialog('close') \",3000);
                }
            } ",
        ))
        ?>;
        return false;
    }
</script>