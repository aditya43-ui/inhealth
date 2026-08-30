<?php
$this->breadcrumbs = array(
    'Pembayaran Tagihan Non Tunai' => array('/billingKasir/informasiPembayaranTagihanNonTunai/index'),
    'index',
);
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
Yii::app()->clientScript->registerScript('cariPasien', "
    $('#caripasien-form').submit(function(){
            $.fn.yiiGridView.update('pencarianpasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
?>
<?php 
    $totaldebit= 0;
    $totalkredit = 0;
    $datatabel = $model->searchInformasi();
    foreach($datatabel->data as $item){
        if($item->jnspembayar_nama == 'DEBIT CARD'){
            $totaldebit += $item->jumlahpembayaran;
        }else if($item->jnspembayar_nama == 'CREDIT CARD'){
            $totalkredit += $item->jumlahpembayaran;
        }
    }
    //var_dump("totalkreid".$totalkredit.$totaldebit)
    
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Informasi <b>Pembayaran Tagihan Non Tunai</b>
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
                <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pembayaran Tagihan Non Tunai</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
                    'id' => 'pencarianpasien-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'extraRowColumns'=> array('jnspembayar_nama'),
                    'replaceUrl' => True,
                    'columns' => array(
                        array(
                            'header' => 'Tanggal Pembayaran/<br>No. Pembayaran',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpembayaran)."/<br>".$data->nopembayaran',
                            'footerHtmlOptions' => array(
                                'colspan' => 17,
                                'style' => 'text-align:right;font-style:italic;'
                            ),
                            'footer' => 'Total Debit',
                        ),
                        array(
                            'header' => 'Tanggal Pendaftaran/<br>No. Pendaftaran',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/<br>".$data->no_pendaftaran',
                            'footerHtmlOptions' => array(
                                'colspan' => 4,
                                'style' => 'text-align:right;font-style:italic;'
                            ),
                            'footer' => MyFormatter::formatNumberForPrint($totaldebit) .'<input type="hidden" id="totalkredit" value="' . $totalkredit . '">' .
                            '<input type="hidden" id="totaldebit" value="' . $totaldebit . '">' 
                        ),
                        array(
                            'header' => 'No. Rekam Medik',
                            'type' => 'raw',
                            'value' => '$data->no_rekam_medik',
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'type' => 'raw',
                            'value' => '$data->nama_pasien',
                        ),
                        array(
                            'header' => 'Instalasi/<br>Ruangan',
                            'type' => 'raw',
                            'value' => '$data->instalasi_nama."/<br>".$data->ruangan_nama',
                        ),
                        array(
                            'header' => 'Jenis Penjamin/<br>Penjamin',
                            'type' => 'raw',
                            'value' => '$data->carabayar_nama."/<br>".$data->penjamin_nama',
                        ),
                        array(
                            'header' => 'Kelas Pelayanan',
                            'type' => 'raw',
                            'value' => '$data->kelaspelayanan_nama',
                        ),
                        array(
                            'header' => 'Kelas Tanggungan',
                            'type' => 'raw',
                            'value' => '$data->kelastanggungan_nama',
                        ),
                        array(
                            'header' => 'Jenis Pembayaran',
                            'type' => 'raw',
                            'value' => '$data->jnspembayar_nama',
                        ),
                        array(
                            'header' => 'Bank',
                            'type' => 'raw',
                            'value' => '(!empty($data->namabankpembayaran)?$data->namabankpembayaran:"-")',
                        ),
                        array(
                            'header' => 'No. Bukti Transfer/<br>Transaksi',
                            'type' => 'raw',
                            'value' => '$data->nostruk',
                        ),
                        array(
                            'header' => 'Waktu Transaksi',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgltransaksi)',
                        ),
                        array(
                            'header' => 'Tanggal Jatuh Tempo',
                            'type' => 'raw',
                            'value' => '(!empty($data->tgljatuhtempo)? MyFormatter::formatDateTimeForUser($data->tgljatuhtempo): "-")',
                        ),
                        array(
                            'header' => 'Jumlah Pembulatan <br>(Rp)',
                            'type' => 'raw',
                            'value' => 'number_format($data->jmlpembulatan,0,"",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Total Tagihan <br>(Rp)',
                            'type' => 'raw',
                            'value' => 'number_format($data->totaliurbiaya,0,"",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Jumlah Pembayaran Non Tunai <br>(Rp)',
                            'name'=> 'jumlahpembayaran',
                            'type' => 'raw',
                            'value' => 'number_format($data->jumlahpembayaran,0,"",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            
                        ),
                        array(
                            'header' => 'Rincian Tagihan',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-rincianrs\"></i>",Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianSudahBayar2",array("pembayaranpelayanan_id"=>$data->pembayaranpelayanan_id, "frame"=>true)),
													array("class"=>"",
														  "target"=>"iframeRincianTagihan",
														  "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
														  "rel"=>"tooltip",
														  "title"=>"Klik untuk melihat Rincian Tagihan",
													))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Rincian Farmasi',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-rtfarmasi\"></i>",Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianSudahBayarFarmasi",array("pembayaranpelayanan_id"=>$data->pembayaranpelayanan_id, "frame"=>true)),
													array("class"=>"",
														  "target"=>"iframeRincianTagihan",
														  "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
														  "rel"=>"tooltip",
														  "title"=>"Klik untuk melihat Rincian Farmasi",
													))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Grup Rincian',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-rincianbayar\"></i>",Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianSudahBayar",array("pembayaranpelayanan_id"=>$data->pembayaranpelayanan_id, "frame"=>true)),
													array("class"=>"",
														  "target"=>"iframeRincianTagihan",
														  "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
														  "rel"=>"tooltip",
														  "title"=>"Klik untuk melihat Grup Rincian",
													))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Petugas Kasir',
                            'type' => 'raw',
                            'value' => '$data->petugasadministrasi_gelardepan ." ".$data->petugasadministrasi_nama ." ". $data->petugasadministrasi_gelarbelakang',
                        ),
                        array(
                            'header' => 'Status Closing',
                            'type' => 'raw',
                            'value' => '(!empty($data->closingkasir_id)?"Sudah":"Belum")',
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});hitungtotal();}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincianTagihan',
    'options' => array(
        'title' => 'Rincian Tagihan',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1024,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeRincianTagihan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>

<script>
    function hitungtotal(){
        var totalkredit = $("#totalkredit").val();
        var totaldebit = $("#totaldebit").val();

        $('#pencarianpasien-grid tbody tr:last').after('<tr><td colspan="17" style="text-align:right;font-style:italic;">Total Kredit</td><td colspan="4" style="text-align:right;font-style:italic;">' + totalkredit +'</td></tr>');
    }
</script>