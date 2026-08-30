<style>
    .table {
        border-collapse: collapse;
        border: 1px solid black;
        box-shadow: none;
    }
    .table td, .table th {
        border: 1px solid black !important;
    }
    
    .table tbody + tbody {
        border: 1px solid black !important;
    }
</style>

<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$data = $model->searchPiutangPenjamin();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
    $sort = false;
  $data = $model->searchPrintPenjamin();  
  $template = "{items}";
  if ($caraPrint == "EXCEL")
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
}

$prov2 = $model->searchPiutangPenjamin();
$prov2->pagination = false;

$total_tagihan = 0;
$total_asuransi = 0;
$total_pasien = 0;

foreach ($prov2->data as $item) {
    $total_tagihan += $item->totalTagihan;
    $total_asuransi += $item->totalsubsidiasuransi;
    $total_pasien += $item->totaliurbiaya;
}

?>
<?php if($_GET['filter_tab'] == 'penjamin'){ ?>
<div id="div_penjamin">
    <div>
        <?php if(!$caraPrint){ ?>
        <legend class="rim"> Tabel Rekap Penjamin </legend>
        <?php } ?>
        <?php 
            $data = $model->searchPrintPenjamin();
            $this->widget($table,array(
                'id'=>'laporanrekapiutangpenjamin-grid',
                'dataProvider'=>$data,
                'enableSorting'=>$sort,
                'template'=>$template,
                'itemsCssClass'=>'table',
                    'columns'=>array(
                        array(
                            'header' => 'No.',
                            'value' => '$row+1',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            'htmlOptions'=>array('style'=>'text-align:center;'),
                            'footer'=>'Total',
                            'footerHtmlOptions'=>array('colspan'=>9, 'style'=>'font-weight: bold;'),
                        ),  
                        array(
                            'header'=>'Asuransi',
                            'type'=>'raw',
                            'value'=>'$data->penjamin_nama',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Tgl. Pembayaran/<br>No. Pembayaran',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tglpembayaran)."/<br>".$data->nopembayaran',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Tgl. Pendaftaran/<br>No. Pendaftaran',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/<br>".$data->no_pendaftaran',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'<p style="margin: 0; text-align: center;">Unit Pelayanan</p>',
                            'type'=>'raw',
                            'value'=>function($data) use (&$pendaftaran, &$admisi) {
                                $str = $data->ruanganakhir_nama;
                                $pendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                if (!empty($pendaftaran->pasienadmisi_id)) {
                                    $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
                                    $kelas = KelaspelayananM::model()->findByPk($admisi->kelaspelayanan_id);
                                    
                                    $str .= '<br>'.$kelas->kelaspelayanan_nama;
                                } 
                                return $str;
                            },
                            //'value'=>'$data->ruanganakhir_nama',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'No. Rekam Medik',
                            'type'=>'raw',
                            'value'=>'$data->no_rekam_medik',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                           'header'=>'<p style="margin: 0; text-align: center;">Nama Pasien</p>',
                           'type'=>'raw',
                           'value'=>'$data->nama_pasien',
                           'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'<p style="margin: 0; text-align: center;">Tanggal Masuk</p>',
                            'type'=>'raw',
                             'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'<p style="margin: 0; text-align: center;">Tanggal Keluar</p>',
                            'type'=>'raw',
                            'value'=>function($data) use (&$pendaftaran, &$admisi) {
                                if (empty($pendaftaran->pasienadmisi_id)) {
                                    if ($pendaftaran->instalasi_id == Params::INSTALASI_ID_RJ) {
                                        return MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s', strtotime($data->tglpembayaran)));
                                    } else if ($pendaftaran->instalasi_id == Params::INSTALASI_ID_RD) {
                                        $pulang = PasienpulangT::model()->findByAttributes(array(
                                            'pendaftaran_id'=>$data->pendaftaran_id
                                        ));
                                        if (empty($pulang)) return "-";
                                        return $pulang->tglpasienpulang;
                                    } 
                                } else {
                                    $pulang = PasienpulangT::model()->findByAttributes(array(
                                        'pendaftaran_id'=>$data->pendaftaran_id,
                                    ), array(
                                        'condition'=>'pasienadmisi_id is not null',
                                    ));
                                    if (!empty($pulang)) 
                                        return $pulang->tglpasienpulang; 
                                    else if (!empty($admisi->rencanapulang))
                                        return MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s', strtotime($admisi->rencanapulang))); 
                                }
                                return '-';
                            },
                            //'value'=>'date("d/m/Y H:i:s", strtotime($data->tglpulang))',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'<p style="margin: 0; text-align: center;">Total Tagihan</p>',
                            'type'=>'raw',
							'name'=>'totaltagihanseluruh',
                            'value'=>function($data) {
								//$tanda = TandabuktibayarT::model()->findByPk($data->tandabuktibayar_id);
								//var_dump(count((array)$tanda));
								
								if (!empty($tanda)>0){
								//	return MyFormatter::formatNumberForPrint($data->totalTagihan+$tanda->biayaadministrasi);
								}else{
								//	return MyFormatter::formatNumberForPrint($data->totalTagihan);
								}
								
								return MyFormatter::formatNumberForPrint($data->totaltagihanseluruh);
                            },
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            'htmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                            //'footer'=>MyFormatter::formatNumberForPrint($total_tagihan),
							'footer'=>'sum(totaltagihanseluruh)',
                            'footerHtmlOptions'=>array('style'=>'text-align: right; font-weight: bold;'),
                        ),
                        array(
                            'header'=>'<p style="margin: 0; text-align: center;">Dijamin <br>Asuransi</p>',
                            'type'=>'raw',
							'name'=>'totalpenjamin',
                            'value'=>'MyFormatter::formatNumberForPrint($data->totalpenjamin)',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            'htmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                            'footer'=>'sum(totalpenjamin)',
                            'footerHtmlOptions'=>array('style'=>'text-align: right; font-weight: bold;'),

                        ),
                        array(
                            'header'=>'<p style="margin: 0; text-align: center;">Dibayar oleh Pasien</p>',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatNumberForPrint($data->totaliurbiaya)',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            'htmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                            'footer'=>MyFormatter::formatNumberForPrint($total_pasien),
                            'footerHtmlOptions'=>array('style'=>'text-align: right; font-weight: bold;'),
                        ),
                    ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            )); 
        ?>
    </div>
</div>
<?php } /*else if($_GET['filter_tab'] == 'umum'){ ?>
<div id="div_umum">
    <div style="max-width:1300px;overflow:auto;">
        <?php if(!$caraPrint){ ?>
        <legend class="rim">Tabel Rekap Piutang - Umum </legend>
        <?php } ?>
            <?php 
                $data = $model->searchPrintUmum();
                $this->widget($table,array(
                'id'=>'laporanrekapiutangumum-grid',
                'dataProvider'=>$data,
                'enableSorting'=>$sort,
                'template'=>$template,
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>array(
                        array(
                                'header' => 'No.',
                                'value' => '$row+1',
                                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),  
                        array(
                            'header'=>'Tanggal Billing',
                            'type'=>'raw',
                            'value'=>'date("d/m/Y H:i:s", strtotime($data->tglpembayaran))',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'No. RM',
                            'type'=>'raw',
                            'value'=>'$data->nama_pasien',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'No. Pendaftaran',
                            'type'=>'raw',
                            'value'=>'$data->nama_pasien',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                           'header'=>'Nama Pasien',
                           'type'=>'raw',
                           'value'=>'$data->nama_pasien',
                        ),
                        array(
                           'header'=>'Unit <br> Pelayanan',
                           'type'=>'raw',
                           'value'=>'$data->ruanganakhir_nama',
                        ),
                        array(
                            'header'=>'Tanggal Masuk',
                            'type'=>'raw',
                            'value'=>'date("d/m/Y H:i:s", strtotime($data->tgl_pendaftaran))',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                           'header'=>'Tanggal Keluar',
                           'type'=>'raw',
                            'value'=>'date("d/m/Y H:i:s", strtotime($data->tglpulang))',
                        ),
                        array(
                            'header'=>'Total Tagihan',
                            'type'=>'raw',
                            'value'=>'$data->totalbiayapelayanan',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                            'htmlOptions'=>array('style'=>'text-align:right;'),
                        ),
                        array(
                            'header'=>'Tanggungan <br> P3',
                            'type'=>'raw',
                            'value'=>'$data->totalsubsidiasuransi',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            'htmlOptions'=>array('style'=>'text-align:right;'),

                        ),
                        array(
                            'header'=>'Tanggungan <br> Pasien',
                            'type'=>'raw',
                            'value'=>'$data->totaliurbiaya-$data->totalsubsidiasuransi',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            'htmlOptions'=>array('style'=>'text-align:right;'),
                        ),
                    ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            )); 
        ?>
    </div>
</div>
<?php } */ ?>
<br>