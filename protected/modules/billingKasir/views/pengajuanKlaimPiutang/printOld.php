<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judulKuitansi.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan'=>$judulKuitansi));      
}
?>
<style>
    body {
        color: black;
    }
    
    .control-label{
        float:left; 
        text-align: right; 
        width:120px;
        color:black;
        padding-right:10px;
    }
    table{
        font-size:11px;
    }

    td .tengah{
       text-align: center;  
    }
    
    .colon {
        padding-right: 5px;
        padding-left: 5px;
    }
      .border th, .border td{
        border:1px solid #000 !important;
    }
    .table thead:first-child{
        border-top:1px solid #000 !important;        
    }
    
    thead th{
        background:none;
        color:#333;
        text-align: center !important;
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>

<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td>No. Pengajuan Klaim</td>
                    <td class="colon">: </td>
                    <td width="100%"><?php echo CHtml::encode(($modPengajuanKlaim->nopengajuanklaimanklaim)); ?> </td>
                    

                    <td nowrap>Jenis Penjamin / Penjamin</td>
                    <td class="colon">: </td>
                    <td nowrap> <?php echo CHtml::encode(($modPengajuanKlaim->carabayar->carabayar_nama ."/".$modPengajuanKlaim->penjamin->penjamin_nama)); ?> </td>
                </tr>
                
                <tr>
                    <td nowrap>Tgl. Pengajuan Klaim</td>
                    <td class="colon">: </td>
                    <td><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPengajuanKlaim->tglpengajuanklaimanklaim)); ?> </td>
                    

                    <td>Tgl. Jatuh Tempo</td>
                    <td class="colon">: </td>
                    <td nowrap> <?php echo CHtml::encode(MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($modPengajuanKlaim->tgljatuhtempo)))); ?> </td>
                </tr>
                
                <tr>
                    <td>Total Piutang</td>
                    <td class="colon">: </td>
                    <td><?php echo CHtml::encode(number_format($modPengajuanKlaim->totalpiutang,0,"",".")); ?> </td>
                    
					<?php /*
                    <td>Total Sisa Piutang</td>
                    <td class="colon">: </td>
                    <td nowrap> <?php echo CHtml::encode(number_format($modPengajuanKlaim->totalsisapiutang,0,"",".")); ?> </td>
					 * 
					 */ ?>
                </tr>               
            </table>            
        </td>
    </tr>
    <tr>
        <td>
            <div align="center" style="border-bottom: 1px solid #000000;padding: 10px;margin-bottom: 15px;">
                <?php // echo strtoupper($judulKuitansi);?>
            </div>
            <?php
                $totalbiayaadminfarmasi = 0;
                $row = array();
            ?>
            <table width="100%" style='box-shadow:none;margin-left:auto; margin-right:auto;' class='table border'>
                <thead>
                    <tr>
                        <th rowspan="2">Nama Pasien</th>
                        <th rowspan="2">Tgl. Lahir</th>
                        <th rowspan="2">RJ</th>
                        <th rowspan="2">RI</th>
                        <th rowspan="2">Nomor Kartu/Polis</th>
                        <th rowspan="2">Nomor Peserta</th>
                        <th colspan="2">Tanggal</th>
                        <th rowspan="2">Jumlah Tagihan</th>
                        <th rowspan="2">Keringanan</th>
                        <th rowspan="2">Piutang</th>
                        <th rowspan="2">Pengajuan</th>
                        <th rowspan="2">Sisa Tagihan</th>
                    </tr>
                    <tr>
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Keluar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_piutang = 0;
                    $total_bayar = 0;
                    $total_telah_bayar = 0;
                    $total_sisa_piutang = 0; 
                    $total_tagihan = 0;
                    $total_diskon = 0;
                    
                    foreach ($modPengajuanKlaimDetail as $i => $pengajuan) {
                        $tagihan = $pengajuan->jmltagihan;
                        
                        
                        // $total_tagihan = $pengajuan->jmltagihan;
                        $total_diskon += $pengajuan->jmldiskon;
                        
                        if ($tagihan == 0) {
                            $bkm = TandabuktibayarT::model()->findByPk($pengajuan->tandabuktibayar_id);
                            $pp = PembayaranpelayananT::model()->findByPk($bkm->pembayaranpelayanan_id);
                            
                            $tagihan = $pp->totalsubsidiasuransi;
                            
                        }
                        
                        $total_tagihan += $tagihan;
                    ?>
                    <tr>
                        <td>
                            <?php 
                            $pendaftaran = $pengajuan->pendaftaran;
                            $pasien = $pengajuan->pendaftaran->pasien;
                            $asuransi = AsuransipasienM::model()->findByPk($pendaftaran->asuransipasien_id);
                            
                            $pembayaran = PembayaranpelayananT::model()->findByPk($pengajuan->pembayaranpelayanan_id);
                            
                            
                            
                            $tgl = '-';
                            if (!empty($pembayaran)) {
                                $tgl = $pembayaran->tglpembayaran;
                            }
                            
                            if (!empty($pendaftaran->pasienadmisi_id)) {
                                $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
                                if (!empty($admisi->rencanapulang)) {
                                    $tgl = $admisi->rencanapulang;
                                }
                            }
                            
                            echo $pasien->namadepan.$pasien->nama_pasien; 
                            ?>
                        </td>
                        <td><?php echo MyFormatter::formatDateTimeForUser($pasien->tanggal_lahir); ?></td>
                        <td style="text-align: center;">
                            <?php
                            if (empty($pendaftaran->pasienadmisi_id)) {
                                echo '<i class="entypo-check"></i>';
                            }
                            ?>
                        </td>
                        <td style="text-align: center;">
                            <?php
                            if (!empty($pendaftaran->pasienadmisi_id)) {
                                echo '<i class="entypo-check"></i>';
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if (!empty($asuransi)) echo $asuransi->nokartuasuransi;
                            ?>
                        </td>
                        <td>
                            <?php
                            if (!empty($asuransi)) echo $asuransi->nopeserta;
                            ?>
                        </td>
                        <td><?php echo MyFormatter::formatDateTimeForUser($pendaftaran->tgl_pendaftaran); ?></td>
                        <td>
                            <?php echo empty($tgl) ? '-' : MyFormatter::formatDateTimeForUser($tgl); ?>
                        </td>
                        <td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($tagihan); ?></td>
                        <td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($pengajuan->persendiskon, 2); ?></td>
                        <td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($tagihan - $pengajuan->jmldiskon); ?></td>
						<td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($pengajuan->jumlahbayar); ?></td>
						<td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($pengajuan->jmlsisapiutang); ?></td>
                    </tr>
                    <?php 
                    
                        $total_piutang = $total_piutang + ($tagihan - $pengajuan->jmldiskon);
                        $total_bayar = $total_bayar + $pengajuan->jumlahbayar;
                        $total_telah_bayar = $total_telah_bayar + $pengajuan->jmltelahbayar;
                        $total_sisa_piutang = $total_sisa_piutang + $pengajuan->jmlsisapiutang;
                    
                    } ?>
                </body>
                </tbody>
                 <tfoot>
                    <tr>
                        <td colspan="12"><div class='pull-right'><b>Total Tagihan</b></div></td>
                        <td style="text-align:right;"><b><?php echo number_format($total_tagihan,0,',','.'); ?></b></td>
                    </tr>
                    <tr>
                        <td colspan="12"><div class='pull-right'><b>Total Keringanan</b></div></td>
                        <td style="text-align:right;"><b><?php echo number_format($total_diskon,0,',','.'); ?></b></td>
                    </tr>
                    <tr>
                        <td colspan="12"><div class='pull-right'><b>Total Piutang</b></div></td>
                        <td style="text-align:right;"><b><?php echo number_format($total_piutang,0,',','.'); ?></b></td>
                    </tr>
                    <tr>
                        <td colspan="12"><div class='pull-right'><b>Total Pengajuan</b></div></td>
                        <td style="text-align:right;"><b><?php echo number_format($total_bayar,0,',','.'); ?></b></td>
                    </tr>
                    <tr>
                        <td colspan="12"><div class='pull-right'><b>Total Sisa Piutang</b></div></td>
                        <td style="text-align:right;"><b><?php echo number_format((isset($total_sisa_piutang)?$total_sisa_piutang:0),0,',','.');?></b></td>
                    </tr>     
					<?php /*
                    <tr>
                        <td colspan="7"><div class='pull-right'><b>Total Telah Bayar</b></div></td>
                        <td style="text-align:right;"><b><?php echo number_format($total_telah_bayar,0,',','.'); ?></b></td>
                    </tr>
					 * 
					 */ ?>               
                </tfoot>
           
        </td>
    </tr>