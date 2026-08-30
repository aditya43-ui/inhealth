<?php
$this->breadcrumbs = array(
    'Informasi Pemesanan Menu Diet Pendamping',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pemesanan Menu Diet Pendamping</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view_tamu . '_search', array('model' => $model,)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemesanan Menu Diet Pendamping</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                Yii::app()->clientScript->registerScript('search', "
                $('.search-button').click(function(){
                        $('.search-form').toggle();
                        return false;
                });
                $('.search-forms form').submit(function(){
                        $.fn.yiiGridView.update('gzpesanmenudietPendamping-v-grid', {
                                data: $(this).serialize()
                        });
                        return false;
                });
                ");
                ?>
                <div class="block-tabel">
                    <?php
                    $artab = array(
                        array(
                            'header' => 'Tanggal Pesan',
                            'name' => 'tglpesanmenu',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpesanmenu)'
                        ),
                        array(
                            'header' => 'No. Pesan',
                            'name' => 'nopesanmenu',
                        ),
                    );
                    if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIZI) {
                        array_push($artab, array(
                            'header' => 'Instalasi / Ruangan',
                            'type' => 'raw',
                            'value' => '$data->ruangan->instalasi->instalasi_nama." / ".$data->ruangan->ruangan_nama',
                            'headerHtmlOptions' => array('style' => 'vertical-align: middle;text-align:left;')
                        ));
                    }
                    array_push(
                        $artab,
                        array(
                            'header' => 'Jenis Pesanan',
                            'name' => 'jenispesanmenu',
                        ),
                        //                    'nama_pemesan',
                        array(
                            'header' => 'Nama Pasien',
                            //                                    'name' => 'jenisdiet.jenisdiet_nama',
                            'value' => '(!empty($data->pendaftaran_id)?(!empty($data->pendaftaran->pasien_id)?$data->pendaftaran->pasien->nama_pasien:""):"")',
                        ),
                        array(
                            'header' => 'Jenis Diet',
                            'name' => 'jenisdiet.jenisdiet_nama',
                        ),
                        /*
                                array(
                                    'header' => 'Bahan Diet',
                                    'name' => 'bahandiet.bahandiet_nama',
                                ),
                                        /*
                    array(
                        'header'=>'Pasien',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $det = PesanmenupegawaiT::model()->findAllByAttributes(array(
                                'pesanmenudiet_id'=>$data->pesanmenudiet_id,
                            ));
                            $pasien_list = array();
                            foreach ($det as $item) {
                                if (!empty($item->pegawai_id) && empty($pasien_list[$item->pegawai_id])) {
                                    $p = PegawaiM::model()->findByPk($item->pegawai_id);
                                    $pasien_list[$item->pegawai_id] = $p;
                                }
                            }
                            if (count((array)$pasien_list) == 0) {
                                return "-";
                            }
                            $str = '<ul>';
                            foreach ($pasien_list as $item) {
                                $str .= '<li>'.$item->namaLengkap.'</li>';
                            }
                            $str .= '</ul>';
                            return $str;
                        }
                    ),
                                         * 
                                         */
                        //'adaalergimakanan',
                        //'keterangan_pesan',
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/gizi/PesanmenudietT/detailPesanMenuDiet",array("id"=>$data->pesanmenudiet_id)),array("id"=>"$data->pesanmenudiet_id","target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk rincian pemesanan menu diet Pendamping", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));', 'htmlOptions' => array('style' => 'text-align: left')
                        ),
                        array(
                            'header' => 'Etiket',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link("<i class='icon-form-detail'></i>", Yii::app()->createUrl('/gizi/PesanmenudietT/PrintGizi', array(
                                    'pesanmenudiet_id' => $data->pesanmenudiet_id, 'caraPrint' => 'dialog'
                                )), array(
                                    'target' => 'iframeDetailPenjualan',
                                    'rel' => 'tooltip',
                                    'title' => 'Klik untuk print etiket',
                                    'onclick' => '$("#dialogDetailPenjualan").dialog("open")'
                                ));
                            }
                        )
                    );
                    if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIZI) {
                        array_push($artab, array(
                            'header' => 'Kirim Menu Diet',
                            'type' => 'raw',
                            //'value'=>'(($data->jenispesanmenu == "'.Params::JENISPESANMENU_PASIEN.'") ? CHtml::link(\'<i class="icon-form-kmenudiet"></i>\', Yii::app()->controller->createUrl("/gizi/KirimmenudietT/index",array("idPesan"=>$data->pesanmenudiet_id)),array("rel"=>"tooltip","title"=>"Klik untuk Melanjutkan ke Pengiriman")) : CHtml::link(\'<i class="icon-form-kmenudiet"></i>\', Yii::app()->controller->createUrl("/gizi/KirimmenudietT/indexPegawai",array("idPesan"=>$data->pesanmenudiet_id)),array("rel"=>"tooltip","title"=>"Klik untuk Melanjutkan ke Pengiriman")))','htmlOptions'=>array('style'=>'text-align: left')
                            'value' => function ($data) {
                                if (empty($data->kirimmenudiet_id)) {
                                    //                                    if ($data->jenispesanmenu == Params::JENISPESANMENU_PASIEN){
                                    //                                        echo CHtml::link("<i class='icon-form-kmenudiet'></i>", Yii::app()->controller->createUrl("/gizi/KirimmenudietT/index",array("idPesan"=>$data->pesanmenudiet_id)),array("rel"=>"tooltip","title"=>"Klik untuk Melanjutkan ke Pengiriman"));
                                    //                                    }else{
                                    echo CHtml::link("<i class='icon-form-kmenudiet'></i>", Yii::app()->controller->createUrl("/gizi/KirimmenudietT/indexPegawai", array("idPesan" => $data->pesanmenudiet_id, "jenisPesanMenu" => $data->jenispesanmenu)), array("rel" => "tooltip", "title" => "Klik untuk Melanjutkan ke Pengiriman"));
                                    //                                    }                                    
                                } else {
                                    if ($data->status_terima == TRUE) {
                                        echo "Sudah Dikirim";
                                    } else {
                                        echo "Sedang Dikirim";
                                    }
                                }
                            }
                        ));
                    }
                    array_push($artab, array(
                        'header' => 'Batal <br> Pesan',
                        'type' => 'raw',
                        //'value'=>'CHtml::link("<i class=icon-form-silang></i>","#",array("idPesanDiet"=>$data->pesanmenudiet_id,"href"=>"#","rel"=>"tooltip","title"=>"Klik untuk Batal Pesan Menu Diet","onclick"=>"batalPesan(\'$data->pesanmenudiet_id\'); return false;"))',
                        'value' => function ($data) {
                            if (empty($data->kirimmenudiet_id)) {
                                echo CHtml::link("<i class=icon-form-silang></i>", "#", array("idPesanDiet" => $data->pesanmenudiet_id, "href" => "#", "rel" => "tooltip", "title" => "Klik untuk Batal Pesan Menu Diet", "onclick" => "batalPesan('" . $data->pesanmenudiet_id . "'); return false;"));
                            } else {
                                echo "Sudah Diproses";
                            }
                        }
                    ));
                    array_push($artab, array(
                        'header' => 'Status Terima',
                        'type' => 'raw',
                        'value' => function ($data) {
                            if (empty($data->kirimmenudiet_id)) {
                                echo "Pemesanan Belum Diproses";
                            } else {
                                if ($data->status_terima == TRUE) {
                                    echo "Sudah Diterima";
                                } else {
                                    if ($data->ruangan_id == Yii::app()->user->getState('ruangan_id')) {
                                        echo Chtml::link("<button class='btn btn-danger'><i class='entypo-check'></i> Konfirmasi</button>", '#', array("onclick" => "terimaKonfirmasi('" . $data->pesanmenudiet_id . "')"));
                                    } else {
                                        echo "Belum Diterima";
                                    }
                                }
                            }
                        }
                    ));
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'gzpesanmenudietPendamping-v-grid',
                        'dataProvider' => $model->searchInformasiPendamping(),
                        //	'filter'=>$model,
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-striped table-condensed',
                        'columns' => $artab,
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    )); ?>
                </div>
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
        'title' => 'Rincian Pemesanan Menu Diet Pendamping',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => true,
    ),
));
echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
?>
<?php
// Dialog untuk Batal Pesan Menu Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogBatalPesan',
    'options' => array(
        'title' => 'Batal Pesan Menu Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));
echo '<div class="divForForm"></div>';
$this->endWidget();
//========= Dialog untuk Batal Pesan Menu Diet =============================
?>
<?php
// Dialog buat Detail Penjualan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailPenjualan',
    'options' => array(
        'title' => 'Print Etiket',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="iframeDetailPenjualan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget(); ?>
<script>
    function batalPesan(idPesanDiet) {
        var idPesanDiet = idPesanDiet;
        //var answer = myConfirm('Yakin Akan Membatalkan Pemesanan Diet?');
        myConfirm('Apakah Anda yakin ingin membatalkan pemesanan menu diet?', 'Perhatian!', function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('batalMenuDiet'); ?>', {
                    idPesanDiet: idPesanDiet
                }, function(data) {
                    if (data.status == 'create_form') {
                        setTimeout("$('#dialogBatalPesan').dialog('open') ", 1000);
                        $('#dialogBatalPesan div.divForForm').html(data.div);
                        $('#dialogBatalPesan div.divForForm form #idPesanDiet').val(data.idPesan);
                        $('#dialogBatalPesan div.divForForm form').submit(konfirmBatal);
                    } else {
                        $('#dialogBatalPesan div.divForForm').html(data.div);
                        $.fn.yiiGridView.update('gzpesanmenudietPendamping-v-grid');
                        setTimeout("$('#dialogBatalPesan').dialog('close') ", 1000);
                    }
                }, 'json');
            }
        });
    }

    function konfirmBatal() {
        <?php
        echo CHtml::ajax(array(
            'url' => $this->createUrl('batalMenuDiet'),
            'data' => "js:$(this).serialize()",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogBatalPesan div.divForForm').html(data.div);
                    $('#dialogBatalPesan div.divForForm form').submit(konfirmBatal);
                }
                else
                {
                    $('#dialogBatalPesan div.divForForm').html(data.div);
                    $.fn.yiiGridView.update('gzpesanmenudietPendamping-v-grid');
                    setTimeout(\"$('#dialogBatalPesan').dialog('close') \",3000);
                }
            } ",
        ))
        ?>;
        return false;
    }

    function terimaKonfirmasi(idPesan) {
        var url = '<?php echo $this->createUrl("terimaKonfirmasi"); ?>';
        myConfirm('Apakah Anda yakin ingin mengubah status menjadi <b>Sudah Diterima</b>?', 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        idPesan: idPesan
                    },
                    function(data) {
                        if (data.status == 'sukses') {
                            $.fn.yiiGridView.update('gzpesanmenudietPendamping-v-grid');
                        } else if (data.status == 'gagal') {
                            myAlert('Data gagal diubah menjadi status diterima');
                        } else {
                            myAlert(data.pesan);
                        }
                    }, "json");
            }
        });
    }
</script>