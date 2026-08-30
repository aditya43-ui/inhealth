<?php
$this->breadcrumbs = array(
    'Informasi Pemesanan Menu Diet Pegawai',
);
?>
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('gzpesanmenudietpegawai-v-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
");
?>
<div class="panel panel-pr_imary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pemesanan Menu Diet Pegawai</b>
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
                <?php $this->renderPartial($this->path_view . '_search', array('model' => $model,'model2' => $model2)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemesanan Menu Diet Pegawai</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $artab = array(
                    array(
                        'header' => 'Tanggal Pesan',
                        //				'name'=>'tglpesanmenu',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatDateTimeForUser($data->tglpesanmenu)'
                    ),
                    array(
                        'header' => 'No. Pesan',
                        'type' => 'raw',
                        //                            'name' => 'nopesanmenu',     
                        'value' => '$data->nopesanmenu'
                    ),
                );
                if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIZI) {
                    array_push(
                        $artab,
                        array(
                            'header' => 'Instalasi / Ruangan',
                            'type' => 'raw',
                            'value' => '$data->ruangan->instalasi->instalasi_nama." / ".$data->ruangan->ruangan_nama',
                            'headerHtmlOptions' => array('style' => 'vertical-align: middle;text-align:left;')
                        )
                    );
                }
                array_push(
                    $artab,
                    array(
                        'header' => 'Nama Pemesan',
                        'type' => 'raw',
                        //                            'name' => 'jenispesanmenu', 
                        'value' => '$data->nama_pemesan'
                    ),
                    //			'nama_pemesan',
                    array(
                        'header' => 'Jenis Kelamin',
                        'type' => 'raw',
                        //                            'name' => 'jenisdiet.jenisdiet_nama',
                        'value' => '$data->jeniskelamin'
                    ),
                    array(
                        'header' => 'NIK',
                        'type' => 'raw',
                        //                            'name' => 'bahandiet.bahandiet_nama',
                        'value' => '$data->noidentitas'
                    ),
                    array(
                        'header' => 'Keterangan Pesan',
                        'type' => 'raw',
                        //                            'name' => 'bahandiet.bahandiet_nama',
                        'value' => '$data->keterangan_pesan'
                    )
                    //			'adaalergimakanan',
                    //			'',
                    //			array(
                    //				'header'=>'Rincian',
                    //				'type'=>'raw',
                    //				'value'=>'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/gizi/PesanmenudietT/detailPesanMenuDiet",array("id"=>$data->pesanmenudiet_id)),array("id"=>"$data->pesanmenudiet_id","target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk rincian pemesanan menu diet Pegawai", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));','htmlOptions'=>array('style'=>'text-align: left')
                    //			),
                );
                //                        $data =array();
                foreach (JeniswaktuM::getJenisWaktu() as $row) {
                    array_push($artab, array(
                        'header' => $row->jeniswaktu_nama,
                        'type' => 'raw',
                        'value' => '$data->getMenuDiet($data->pesanmenudiet_id, $data->pegawai_id, ' . $row->jeniswaktu_id . ', "' . Params::JENISPESANMENU_PEGAWAI . '")'
                    ));
                    //                
                }
                //            echo '<pre>';
                //            print_r($data);
                //            exit();
                //            array_push($artab, $data);
                array_push(
                    $artab,
                    array(
                        'header' => 'Etiket',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return CHtml::link("<i class='icon-form-detail'></i>", Yii::app()->createUrl('/gizi/PesanmenudietT/PrintGizi', array(
                                'pesanmenudiet_id' => $data->pesanmenudiet_id, 'caraPrint' => 'dialog'
                            )), array(
                                'target' => 'iframeDetailPenjualan',
                                'rel' => 'tooltip',
                                'title' => 'Klik untuk Print etiket',
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
                        $kirim = KirimmenudietT::model()->findByAttributes(array(
                            'pesanmenudiet_id' => $data->pesanmenudiet_id,
                        ));
                        if (empty($kirim)) {
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
                $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                    'id' => 'gzpesanmenudietpegawai-v-grid',
                    'dataProvider' => $model->searchInformasiPegawai(),
                    //	'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'replaceUrl' => 'true',
                    'mergeHeaders' => array(
                        array(
                            'name' => '<p style="margin: 0; text-align: center;">Menu Diet</p>',
                            'start' => 7, //indeks kolom 3
                            'end' => 11, //indeks kolom 4
                        ),
                    ),
                    'columns' => $artab,
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<!--<div class="white-container">
    <legend class="rim2">Informasi Pemesanan <b>Menu Diet Pegawai</b></legend>
    <div class="block-tabel">
        <h6>Tabel Pemesanan <b>Menu Diet Pegawai</b></h6>
    </div>
    <fieldset class="box search-form">
    </fieldset> search-form 
</div>-->
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
        'title' => 'Rincian Pemesanan Menu Diet Pegawai',
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
        'height' => 500,
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
<?php $this->endWidget(); ?>
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
                        $.fn.yiiGridView.update('gzpesanmenudietpegawai-v-grid');
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
                    $.fn.yiiGridView.update('gzpesanmenudietpegawai-v-grid');
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
                            $.fn.yiiGridView.update('gzpesanmenudietpegawai-v-grid');
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