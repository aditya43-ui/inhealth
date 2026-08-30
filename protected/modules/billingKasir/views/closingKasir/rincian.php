<style>
    *:not(.btn) {
        font-family: sans-serif !important;
        font-size: 12px !important;
    }

    body {
        color: black;
        width: auto !important;
    }

    thead>tr>th {
        text-align: center;
        background-color: white;
    }

    .unwrap td:not(.wrap),
    .unwrap th {
        white-space: nowrap;
    }

    .num {
        text-align: right;
    }

    .nom {
        text-align: center;
    }

    .judul {
        text-align: center;
        margin: 5px;
        font-weight: bold;
    }

    .base {
        border: 1px solid black;
    }

    .base th {
        border-bottom: 1px solid black;
        border-right: 1px solid black;
        color: black;
        font-weight: bold;
    }

    .base td {
        vertical-align: top;
        border-right: 1px solid black;
    }

    .base th,
    .base td {
        padding: 2px;
        padding-left: 5px;
        padding-right: 5px;
    }

    /* .headee {
        border-bottom: 1px solid black;
    } */

    .note {
        margin-bottom: 20px;
        font-style: italic;
    }

    .judulcontent{
        text-align: center;
        font-weight: bold;
        padding-bottom: 10px;
        font-size: 17px;
        font-family: "Arial Narrow";
    }
    .data tr td{
        text-align:left;
        font-weight: bold;
        padding-top: 10px;
        /* padding-left:300px; */
        padding-bottom: 40px;
        font-size: 17px;
        font-family: "Arial Narrow";
    }
</style>
<?php
$dok = array();
foreach ($rekap as $item){
    $dt = InformasipembayarantagihannontunaiV::model()->findAllByAttributes(['closingkasir_id' => $item->closingkasir_id]);

    if(!empty($item->tandabuktibayar_id)){
        $idx_line = "0_".$item->tandabuktibayar_id;
        $tesidxline[] = $idx_line;
    }
    if (empty($dok[$item->jenis_rekap."".$item->jnspembayar_nama])) {
        $dok[$item->jenis_rekap."".$item->jnspembayar_nama] = array(
            'nama'=>$item->jenis_rekap." ".$item->jnspembayar_nama." ".$item->namabankpembayaran,
            'content'=>array(),
        );
    }
    if (empty($dok[$item->jenis_rekap."".$item->jnspembayar_nama]['content'][$idx_line])) {
        $dok[$item->jenis_rekap."".$item->jnspembayar_nama]['content'][$idx_line] = array(
            'jenis_rekap'=>$item->jenis_rekap,
            'carabayar' => $item->jnspembayar_nama,
            'nopembayaran'=>$item->nopembayaran,
            'nopendaftaran'=>$item->no_pendaftaran,
            'nama_pasien'=>$item->nama_pasien,
            'instalasi_nama'=>$item->instalasi_nama,
            'ruangan_nama'=> $item->ruangan_nama,
            'penjamin_nama'=> $item->penjamin_nama,
            'namabank'=> $item->namabankpembayaran,
            'nokartu'=>$item->nokartu,
            'nilai'=>$item->nilai,
            'norm'=>$item->no_rekam_medik,
        );
    }
}

// keluar
$res_keluar = array();
$totalRetur = 0;
foreach ($bkk as $item) {

    $retur = ReturbayarpelayananT::model()->findByPk($item->returbayarpelayanan_id);
    
    $nopendaftaran = "-";
    $nama_pasien = "-";
    $norm = "-";
    $nopembayaran = $retur->noreturbayar;
    $nokartu = "";
    $nilai = $retur->totalbiayaretur;

    $totalRetur += $retur->totalbiayaretur;
    
    // $bkm = TandabuktibayarT::model()->findByPk($retur->tandabuktibayar_id);
    // if (!empty($bkm)) {
    //     $bayar = PembayaranpelayananT::model()->findByPk($bkm->pembayaranpelayanan_id);
    //     if (!empty($bayar)) {
    //         $nopendaftaran = $bayar->pendaftaran->no_pendaftaran;
    //         $nama_pasien = $bayar->pendaftaran->pasien->nama_pasien;
    //         $norm = $bayar->pendaftaran->pasien->no_rekam_medik;
    //     }
    // }


    // $sub = array(
    //     'nopendaftaran'=>$nopendaftaran,
    //     'nama_pasien'=>$nama_pasien,
    //     'norm'=>$norm,
    //     'nopembayaran'=>$nopembayaran,
    //     'nokartu'=>$nokartu,
    //     'nilai'=>0 - $nilai,
    //     'carabayar'=>'retur',
    // );

    // $res_keluar["1_".$item->tandabuktikeluar_id] = $sub;

}  
$grandTotRetur = 0;
foreach ($rekapRetur as $a){
    $grandTotRetur += $a->nilai;
}
// $dok['RETUR'] = array(
//     'nama'=>'RET UR PEMBAYARAN',
//     'content'=>$res_keluar,
// );
// echo '<pre>';
// var_dump($dok, $res_keluar); 
// die; 

?>
<?php
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$konfig = KonfigsystemK::model()->find(); 
$format = new MyFormatter;
// if (!isset($_GET['frame'])){
   ?>
<table style="width: 100%; border: none;">
    <thead class="data">
        <tr>
            <td>
                <?php echo $data->nama_rumahsakit;?>
                <!-- <div class="header"><?php //echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());?></div> -->
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">

                    <table width="100%" class="unwrap headee">
                    <div class="judulcontent">Closing Kasir</div>
                        <tr>
                            <td>No. Reg Kasir</td>
                            <td>: <?php echo $closing->closingkasir_no; ?></td> 
                            <td>User</td>
                            <td>: <?php
                                    $pegawai = PegawaiM::model()->findByPk($closing->pegawai_id);
                                    echo $pegawai->nama_pegawai;
                                ?>
                            </td>
                            <td>Tgl. Buka</td>
                            <td class="wrap">: <?php echo $closing->closingdari; ?></td>
                        </tr>
                        <tr>
                            <td>Kasir</td>
                            <?php $ruangan = RuanganM::model()->findByPk($closing->create_ruangan);?>
                            <td>: <?php echo $ruangan->ruangan_nama; ?></td>
                            <td>Jumlah Invoice</td>
                            <td>:<?php ?></td>
                            <td>Sampai Dengan</td>
                            <td>: <?php echo $closing->tglclosingkasir; ?></td>
                        </tr>
                        <tr>
                            <td>Shift</td>
                            <td>: <?php
                                    $shift = ShiftM::model()->findByPk($closing->shift_id);
                                    if (!empty($shift)) {
                                        echo $shift->shiftJam;
                                    } else {
                                        echo "-";
                                    }
                                    ?>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td>Periode Closing</td>
                            <td width="100%" class="wrap">: <?php //echo $closing->closingdari; ?></td>
                            <td>No. Closing Kasir</td>
                            <td>: <?php //echo $closing->closingkasir_no; ?></td>
                        </tr> -->
                        <!-- <tr>
                            <td>Sampai Dengan</td>
                            <td>: <?php //echo $closing->sampaidengan; ?></td>
                            <td>Petugas Kasir</td>
                            <td>: <?php
                                    //$pegawai = PegawaiM::model()->findByPk($closing->pegawai_id);
                                    //echo $pegawai->nama_pegawai;
                                    ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Shift</td>
                            <td>: <?php
                                    //$shift = ShiftM::model()->findByPk($closing->shift_id);
                                    //if (!empty($shift)) {
                                    //    echo $shift->shiftJam;
                                    //} else {
                                    //    echo "-";
                                    //}
                                    ?></td>
                        </tr> -->
                    </table>
                    
                    <?php
                    if (empty($closing->totalpengeluaran)) $closing->totalpengeluaran = 0;
                    $totalAdm = 0;
                    foreach($bkm as $a){
                        if(!empty($a->biayaadministrasi)){
                            $totalAdm += $a->biayaadministrasi;
                        }else{
                            $totalAdm = 0;
                        }
                        
                    }
                    // var_dump($a);die;
                    ?>
                    
                    <table width="100%" class="unwrap">
                        <tr>
                            <td>Saldo Awal</td>
                            <td>: <?php echo 'Rp' . MyFormatter::formatNumberForPrint($closing->closingsaldoawal); ?></td>
                        </tr>
                        <tr>
                            <td>Inv. Tunai</td>
                            <?php
                            $invTunai = 0; 
                            $carabayar = "TUNAI";
                            foreach($rekapTunai as $i):
                                if($i->jnspembayar_nama==$carabayar){
                                    $invTunai += $i->nilai;
                                }
                                
                            ?>
                            <?php
                            $totalRetur = 0; 
                            $carabayar = "TUNAI";
                            foreach($rekapRetur as $i):
                                if($i->jnspembayar_nama==$carabayar){
                                    $totalRetur += $i->nilai;
                                }    
                            ?>
                            <?php endforeach;?>
                            <?php endforeach;?>
                            <?php if($invTunai != null){
                                $invTunai = $invTunai - $totalRetur;
                            }else{
                                $invTunai = $invTunai;
                            }
                            ?>
                            <td>: <?php echo 'Rp' . MyFormatter::formatNumberForUser($invTunai); ?></td>
                            <td>Inv. Kt. Kredit</td>
                            <?php
                            $invKtKredit = 0; 
                            $carabayar = "CREDIT CARD";
                            foreach($rekapTunai as $i):
                                if($i->jnspembayar_nama==$carabayar){
                                    $invKtKredit += $i->nilai;
                                }
                                
                            ?>
                            <?php endforeach;?>
                            <td>: <?php echo 'Rp' . MyFormatter::formatNumberForUser($invKtKredit); ?></td>
                            <td>Inv. Kt. Debit</td>
                            <?php
                            $invKtDebit = 0; 
                            $carabayar = "DEBIT CARD";
                            foreach($rekapTunai as $i):
                                if($i->jnspembayar_nama==$carabayar){
                                    $invKtDebit += $i->nilai;
                                };
                                
                            ?>
                            <?php endforeach;?>
                            <td>: <?php echo 'Rp' . MyFormatter::formatNumberForUser($invKtDebit); ?></td> 
                            <td>Total Invoice</td>
                            <?php
                            $totalInv = $invTunai + $invKtKredit + $invKtDebit; 
                            ?>
                            <?php
                            $totalTransfer = 0; 
                            $carabayar = "TRANSFER";
                            foreach($rekap as $i):
                                if($i->jnspembayar_nama==$carabayar){
                                    $totalTransfer += $i->nilai;
                                }
                                
                            ?>
                            <?php endforeach;?>
                            <?php $totalInv = $totalInv +  $totalTransfer//endforeach;?>
                            <td>: <?php echo 'Rp' . MyFormatter::formatNumberForUser($totalInv); ?></td>
                        </tr>
                        <tr>
                            <td>DP Tunai</td>
                            <?php
                            $dpTunai = 0; 
                            $carabayar = "TUNAI";
                            foreach($rekapDP as $i):
                                if($i->jnspembayar_nama==$carabayar){
                                    $dpTunai += $i->nilai;
                                }
                                
                            ?>
                            <?php endforeach;?>
                            <td>: <?php echo 'Rp' . MyFormatter::formatNumberForUser($dpTunai); ?></td>
                            <td>DP Kt. Kredit</td>
                            <?php
                            $dpKtKredit = 0; 
                            $carabayar = "CREDIT CARD";
                            foreach($rekapDP as $i):
                                if($i->jnspembayar_nama==$carabayar){
                                    $dpKtKredit += $i->nilai;
                                }
                                
                            ?>
                            <?php endforeach;?>
                            <td>: <?php echo 'Rp' . MyFormatter::formatNumberForUser($dpKtKredit); ?></td>
                            <td>DP Kt. Debit</td>
                            <?php
                            $dpKtDebit = 0; 
                            $carabayar = "DEBIT CARD";
                            foreach($rekapDP as $i):
                                if($i->jnspembayar_nama==$carabayar){
                                    $dpKtDebit += $i->nilai;
                                }
                                
                            ?>
                            <?php endforeach;?>
                            <td>: <?php echo 'Rp' . MyFormatter::formatNumberForUser($dpKtDebit); ?></td> 
                            <td>Total DP</td>
                            <?php
                            $totalDP = $dpTunai + $dpKtKredit + $dpKtDebit; 
                            ?>
                            <?php //endforeach;?>
                            <td>: <?php echo 'Rp' . MyFormatter::formatNumberForUser($totalDP); ?></td>
                        </tr>
                        <tr>
                            <td>Total Tunai</td>
                            <?php
                                $totalTunai = $invTunai + $dpTunai;
                            ?>
                            <td>: <?php echo 'Rp' . MyFormatter::formatNumberForUser($totalTunai); ?></td>
                            <td>Total Kt. Kredit</td>
                            <?php
                                $totalCredit = $invKtKredit + $dpKtKredit;
                            ?>
                            <td>: <b><?php echo 'Rp' . MyFormatter::formatNumberForUser($totalCredit); ?><b></td>
                            <td>Total Kt. Debit</td>
                            <?php
                               $totalDebit =  $invKtDebit + $dpKtDebit;
                            ?>
                            <td>: <b><?php echo 'Rp' . MyFormatter::formatNumberForUser($totalDebit); ?><b></td> 
                            <td>Total Pendapatan</td>
                            <?php
                               $totalPendapatan =  $totalInv + $totalDP;  
                            ?>
                            <td>: <?php echo 'Rp' . MyFormatter::formatNumberForUser($totalPendapatan); ?></td>
                        </tr>
                        <tr>
                            <td>Kasbon</td>
                            <td>: -<?php //echo 'Rp' . MyFormatter::formatNumberForUser($closing->closingsaldoawal, 2); ?></td>
                            <td></td>
                            <td><?php //echo 'Rp' . MyFormatter::formatNumberForUser($closing->closingsaldoawal, 2); ?></td>
                            <td></td>
                            <td><?php //echo 'Rp' . MyFormatter::formatNumberForUser($closing->closingsaldoawal, 2); ?></td> 
                            <td>Total Jaminan</td>
                            <?php
                            $totalJaminan = 0; 
                            foreach($rekapjaminan as $i):

                                $totalJaminan += $i->nilai;
                                
                            ?>
                            <?php endforeach;?>
                            <?php
                            $totalReturPiutang = 0; 
                            $carabayar = "PIUTANG";
                            foreach($rekapRetur as $i):
                                if($i->jnspembayar_nama==$carabayar){
                                    $totalReturPiutang += $i->nilai;
                                }    
                            ?>
                            <?php endforeach;?>
                            <?php $totalJaminan = $totalJaminan - $totalReturPiutang;?>
                            <td>: <b><?php echo 'Rp' . MyFormatter::formatNumberForUser($totalJaminan); ?><b></td>
                        </tr>
                        <tr>
                            <td>Total yg disetor</td>
                            <td>: <b><?php echo 'Rp' . MyFormatter::formatNumberForUser($closing->closingsaldoawal + $invTunai + $dpTunai); ?><b></td>
                            <td></td>
                            <td><?php //echo 'Rp' . MyFormatter::formatNumberForUser($closing->closingsaldoawal, 2); ?></td>
                            <td></td>
                            <td><?php //echo 'Rp' . MyFormatter::formatNumberForUser($closing->closingsaldoawal, 2); ?></td> 
                            <td>Grand Total</td>
                            <td>: <?php echo 'Rp' . MyFormatter::formatNumberForUser($totalPendapatan + $totalJaminan); ?></td>
                        </tr>
                        <tr>
                            <td>Total Transfer</td>
                            <?php
                            $totalTransfer = 0; 
                            $carabayar = "TRANSFER";
                            foreach($rekap as $i):
                                if($i->jnspembayar_nama==$carabayar){
                                    $totalTransfer += $i->nilai;
                                }
                                
                            ?>
                            <?php endforeach;?>
                            <td>: <?php echo 'Rp' . MyFormatter::formatNumberForUser($totalTransfer); ?></td>
                        </tr>
                        <!-- <tr>
                            <td>Pembayaran E-Wallet</td>
                            <?php
                            // $totalEwall = 0;
                            // $carabayar = "E-WALLET";
                            // foreach($rekap as $i):
                            //     if($i->jnspembayar_nama==$carabayar){
                            //         $totalEwall += $i->nilai;
                            //     }
                                 
                            ?>
                            <?php //endforeach;?>
                            <td>: <?php //echo 'Rp' . MyFormatter::formatNumberForPrint($totalEwall, 2); ?></td>
                        </tr> -->
                        <!-- <tr>
                            <td>Retur</td>
                            <?php
                            //$totalRetur = 0;
                            //$carabayar = "RETUR ";
                            //foreach($rekap as $i):
                            //    if($i->jenis_rekap==$carabayar){
                            //        $totalRetur += $i->nilai;
                            //    }
                            //     
                            ?>
                            <?php //endforeach;?>
                            <td>: <?php //echo 'Rp' . MyFormatter::formatNumberForPrint($totalRetur, 2); ?></td>
                        </tr> -->
                        <!-- <tr>
                            <td>Tanggal Tutup Kasir </td>
                            <td width="100%">: <?php //echo $closing->tglclosingkasir; ?></td>
                            <td>Jumlah Closing</td>
                            <td>: <?php //echo 'Rp' . MyFormatter::formatNumberForPrint($closing->terimauangpelayanan, 2); ?></td>
                            <?php /*
                                <td>Jumlah Transaksi</td>
                                <td>: <?php echo count((array)$bkm); ?></td>
                                *  
                                */ ?>
                        </tr>
                        <tr>
                            <td>Jumlah Saldo Awal</td>
                            <td>: <?php //echo 'Rp' . MyFormatter::formatNumberForPrint($closing->closingsaldoawal, 2); ?></td>
                            <td>Jumlah Setoran</td>
                            <td>: <?php //echo 'Rp' . MyFormatter::formatNumberForPrint($closing->totalsetoran, 2); ?></td>
                        </tr>
                        <tr>
                            <td>Jumlah Penerimaan Uang Muka</td>
                            <td>: <?php //echo 'Rp' . MyFormatter::formatNumberForPrint($closing->terimauangmuka, 2); ?></td>
                            <td>Keterangan</td>
                            <td>: <?php //echo $closing->keterangan_closing; ?></td>
                        </tr>
                        <tr>
                            <td>Jumlah Piutang</td>
                            <td>: <?php //echo 'Rp' . MyFormatter::formatNumberForPrint($closing->piutang + $totalAdm, 2); ?></td>
                        </tr>
                        <tr>
                            <td>Jumlah Penerimaan Tunai</td>
                            <td>: <?php //echo 'Rp' . MyFormatter::formatNumberForPrint($closing->nilaiclosingtrans - $closing->jumlahnontunai, 2); ?></td>

                        </tr>
                        <tr>
                            <td>Jumlah Penerimaan Non Tunai</td>
                            <td>: <?php //echo 'Rp' . MyFormatter::formatNumberForPrint($closing->jumlahnontunai, 2); ?></td>

                        </tr>
                        <tr>
                            <td>Jumlah Pengeluaran Umum</td>
                            <td>: <?php //echo 'Rp' . MyFormatter::formatNumberForPrint($closing->totalpengeluaran, 2); ?></td>
                        </tr>
                        <tr>
                            <td>Jumlah Retur Obat</td>
                            <td>: <?php //echo 'Rp' . MyFormatter::formatNumberForPrint($closing->jumlahreturoa, 2); ?></td>

                        </tr>
                        <tr>
                            <td>Jumlah Retur Tindakan</td>
                            <td>: <?php //echo 'Rp' . MyFormatter::formatNumberForPrint($closing->jumlah_returtagihan, 2); ?></td>

                        </tr>
                        <tr>
                            <td>Jumlah Pemakaian Uang Muka</td>
                            <td>: <?php //echo 'Rp' . MyFormatter::formatNumberForPrint($closing->pemakaianuangmuka, 2); ?></td>
                        </tr> -->
                    </table>
                    <br>
                    <table width="100%" class="base" border="1">
                        <thead>
                            <tr>
                                <th width="3%">No.</th>
                                <th>No. Reg</th>
                                <th>Nama Pasien</th>
                                <!-- <th>REG</th> -->
                                <th>No. RM</th>
                                <th width="10%">Penjamin</th>
                                <th>No Tagihan</th>
                                <th>No Kartu</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // $cnt = 0; 
                            $grand_total = 0;
                            foreach($dok as $item) :
                                // echo '<pre>';
                                // print_r($item);die;
                                // var_dump($item);die;
                            ?>
                            <tr>
                                <th style="text-align:left" colspan="8"><?php echo $item['nama'];?></th>
                            </tr>
                            
                            <?php
                                $cnt = 0;
                                $total = 0;
                                foreach ($item['content'] as $item2) :
                                    $cnt++;
                                    $total +=$item2['nilai'];
                                    if($item['nama'] != "RETUR  TUNAI -" && $item['nama'] != "RETUR  PIUTANG -"){
                                        // return $a['jenis_rekap'];
                                        $grand_total += $item2['nilai'];
                                    }
                                   
                                   
                                ?>
                            <tr>
                                <td width="4%"><?php  echo $cnt;?></td>
                                <td><?php echo $item2['nopendaftaran'];?></td>
                                <td><?php  echo $item2['nama_pasien'];//echo !empty($rekap[$i]->nama_pasien) ? $rekap[$i]->nama_pasien : "-";?></td>
                                <td><?php echo $item2['norm'];?></td>
                                <td><?php echo $item2['penjamin_nama'];?></td>
                                <td><?php  echo $item2['nopembayaran'];//echo !empty($rekap[$i]->nopembayaran) ? $rekap[$i]->nopembayaran : "-";?></td>
                                <td><?php  echo $item2['nokartu'];//echo !empty($nontunai[$i]->nokartu) ? $nontunai[$i]->nokartu : "";?></td>
                                <td style='text-align:right;' ><?php echo "Rp" . MyFormatter::formatNumberForPrint($item2['nilai']);// echo !empty($rekap[$i]->nilai) ? "Rp" . MyFormatter::formatNumberForPrint($rekap[$i]->nilai, 2): "0.00"; ?></td>
                            </tr>
                            <?php endforeach;?>
                            <tr style="border-top:1px solid">
                                <td style="text-align:right; font-weight:bold;" colspan="7">Subtotal</td>
                                <td class="num" id='data_<?php echo $item2['carabayar'];?>'><?php echo 'Rp' . MyFormatter::formatNumberForPrint($total); ?></td>
                            </tr>

                            <?php endforeach;?>

                            <tr style="border-top:1px solid">
                                <td style="text-align:right; font-weight:bold;" colspan="7">Grand Total</td>
                                <td class="num"><?php echo 'Rp' . MyFormatter::formatNumberForPrint($grand_total - $grandTotRetur); ?></td>
                            </tr>
                        </tbody>
                        
                    </table>
                    <!-- <table width="100%" class="base">
                        
                    </table> -->
                    <?php //if (count((array)$rincian) > 0) : ?>
                        <!-- <table width="100%" class="base">
                            <thead class="unwrap">
                                <tr>
                                    <th>No. </th>
                                    <th>Nilai Uang</th>
                                    <th>Banyak Uang</th>
                                    <th>Jumlah Uang</th>
                                </tr>
                            </thead>
                            <tbody class="unwrap">
                                <?php
                                //$cnt = 0;
                                //$val = 0;
                                //foreach ($rincian as $i => $item) :
                                //    if ($item->banyakuang == 0) continue;
                                //    $cnt++;
                                //    $val += $item->jumlahuang;
                                //    
                                ?>
                                <td><?php //echo $rekap[$i]->jnspembayar_nama;?></td>
                                    <tr>
                                        
                                        <td class="nom"><?php //echo $cnt; ?></td>
                                        <td class="nom wrap" width="100%"><?php //echo 'Rp' . MyFormatter::formatNumberForPrint($item->nilaiuang); ?></td>
                                        <td class="nom"><?php //echo MyFormatter::formatNumberForPrint($item->banyakuang); ?></td>
                                        <td class="num"><?php //echo 'Rp' . MyFormatter::formatNumberForPrint($item->jumlahuang); ?></td>
                                    </tr>
                                <?php //endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr style="border-top:1px solid">
                                    <td colspan="3">Total Nilai Uang</td>
                                    <td class="num"><?php //echo 'Rp' . MyFormatter::formatNumberForPrint($val); ?></td>
                                </tr>
                            </tfoot>
                        </table> -->
                    <?php //endif; ?>

                    <!-- <div class="judul">RINCIAN PEMBAYARAN</div>
                    <table class="base">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tgl. Pembayaran</th>
                                <th>No Pembayaran</th>
                                <th>Nama Pasien</th>
                                <th>Penjamin</th>
                                <th>Piutang</th>
                                <th>Pemakaian Uang Muka</th>
                                <th>Tunai</th>
                                <th>Non-Tunai</th>
                                <th>Retur Obat</th>
                                <th>Jumlah Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody class="unwrap">
                            <?php
                            // $cnt = 0;
                            // $total = 0;
                            // $total_piutang = 0;
                            // $total_tunai = 0;
                            // $total_nontunai = 0;
                            // $total_retur = 0;
                            // $total_pakaiuangmuka = 0;



                            // $cr_retur = new CDbCriteria();
                            // $cr_retur->select = "sum(t.totaloaretur) as totaloaretur";
                            // $cr_retur->addCondition("t.tandabuktibayar_id = :id");

                            // foreach ($bkm as $item) :
                            //     $cnt++;
                            //     $bayar = PembayaranpelayananT::model()->findByPk($item->pembayaranpelayanan_id);
                            //     $bulat = $item->jmlpembulatan;
                            //     $retur = 0;
                            //     $uang_muka = 0;
                            //     $total_nontunai += $item->bank_nominal;

                            //     if (!empty($bayar)) {

                            //         //                if ($item->uangditerima == 0) {
                            //         //                    continue;
                            //         //                }

                            //         $no_bayar = $bayar->nopembayaran;
                            //         $tgl_bayar = $item->tglbuktibayar;
                            //         $total_bayar = $item->uangditerima - $item->uangkembalian;
                            //         $total_biaya = $bayar->totalbiayapelayanan;
                            //         $penjamin_bayar = $bayar->penjamin_id;
                            //         $pasien = $bayar->pasien;

                            //         $cr_retur->params = array(
                            //             ":id" => $item->tandabuktibayar_id
                            //         );

                            //         $data_retur = ReturbayarpelayananT::model()->find($cr_retur);
                            //         $retur = $data_retur->totaloaretur;

                            //         $total_retur += $retur;

                                    /*
                                $pakai = PemakaianuangmukaT::model()->findAllByAttributes(array(
                                    'pembayaranpelayanan_id'=>$bayar->pembayaranpelayanan_id,
                                ));
                                
                                foreach ($pakai as $item) {
                                    // $total_bayar -= $item->pemakaianuangmuka;
                                }
                                * 
                                */
                                // } else {
                                //     $uangmuka = BayaruangmukaT::model()->findByAttributes(array(
                                //         'tandabuktibayar_id' => $item->tandabuktibayar_id
                                //     ));

                                //     // if (empty($uangmuka)) continue;

                                //     if (!empty($uangmuka->pasienadmisi_id))
                                //         $moddat = PasienadmisiT::model()->findByPk($uangmuka->pasienadmisi_id);
                                //     else
                                //         $moddat = PendaftaranT::model()->findByPk($uangmuka->pendaftaran_id);

                                //     $tgl_bayar = $total_biaya = $uangmuka->tgluangmuka;
                                //     $total_bayar = $uangmuka->jumlahuangmuka - $item->bank_nominal; //+ $bulat;
                                //     $penjamin_bayar = $moddat->penjamin_id;
                                //     $pasien = $uangmuka->pasien;
                                // }


                                // $item->jmlpembayaran = ((empty($bayar) || !empty($item->jmlpembayaran)) ? $item->jmlpembayaran : $total_biaya);

                                // $piutang = 0;

                                //            if (!empty($bayar)) {
                                //                $piutang += $bayar->total_inacbg + $bayar->totalsubsidiasuransi;
                                //                if ($bayar->tandabuktibayar_id == $item->tandabuktibayar_id && in_array($item->carapembayaran, array(Params::CARAPEMBAYARAN_CICILAN, Params::CARAPEMBAYARAN_HUTANG))) {
                                //                    $bayar_angsuran = BayarangsuranpelayananT::model()->findByAttributes(array(
                                //                        'tandabuktibayar_id'=>$item->tandabuktibayar_id,
                                //                    ));
                                //                    if (!empty($bayar_angsuran)) {
                                //                        $piutang = $bayar_angsuran->sisaangsuran;
                                //                    }
                                //                } else {
                                //                    $piutang = (empty($bayar)) ? 0 : ($bayar->totalsubsidiasuransi + $bayar->totalsubsidirs + $bayar->total_inacbg);
                                //                }
                                //            }

                                // if (!empty($bayar)) {
                                //     $piutang += $bayar->total_inacbg + $bayar->totalsubsidiasuransi;
                                //     if ($bayar->tandabuktibayar_id == $item->tandabuktibayar_id && in_array($item->carapembayaran, array(Params::CARAPEMBAYARAN_CICILAN, Params::CARAPEMBAYARAN_HUTANG))) {
                                //         $bayar_angsuran = BayarangsuranpelayananT::model()->findByAttributes(array(
                                //             'tandabuktibayar_id' => $item->tandabuktibayar_id,
                                //         ));
                                //         if (!empty($bayar_angsuran)) {
                                //             $piutang += $bayar_angsuran->sisaangsuran;
                                //         }
                                //     }



                                //     $modUangMuka = PemakaianuangmukaT::model()->findByAttributes(array(
                                //         'pembayaranpelayanan_id' => $bayar->pembayaranpelayanan_id,
                                //     ));

                                //     if (!empty($modUangMuka)) {
                                //         $uang_muka = $modUangMuka->pemakaianuangmuka;
                                //     }
                                // } else {
                                //     $piutang = (empty($bayar)) ? 0 : ($bayar->totalsubsidiasuransi + $bayar->totalsubsidirs + $bayar->total_inacbg);
                                // }



                                // $total_piutang += $piutang;
                                // $total_tunai += $total_bayar;
                                // $total += $total_bayar + $total_piutang;
                                // $total_pakaiuangmuka += $uang_muka;
                            ?>
                                <tr>
                                    <td class="nom"><?php //echo $cnt; ?></td>
                                    <td><?php //echo MyFormatter::formatDateTimeForUser($item->tglbuktibayar, 2); ?></td>
                                    <td><?php
                                        //if (!empty($item->pembayaranpelayanan_id)) echo $item->pembayaranpelayanan->nopembayaran;
                                        //else {
                                        //    if (!empty($uangmuka) && !empty($uangmuka->nouangmuka)) echo $uangmuka->nouangmuka;
                                        //    else echo $item->nobuktibayar;
                                        //}
                                        ?></td>
                                    <td class="wrap" width="100%"><?php
                                                                    // $pasien = $item->pembayaranpelayanan->pasien;
                                                                    //if (empty($pasien)) $pasien = $item->bayaruangmuka->pasien;
                                                                    //echo $pasien->namadepan . " " . $pasien->nama_pasien;
                                                                    //?></td>
                                    <td class="wrap" nowrap><?php
                                                            //$penjamin = PenjaminpasienM::model()->findByPk($penjamin_bayar);
                                                            //if (!empty($penjamin)) echo $penjamin->penjamin_nama;
                                                            //else echo "UMUM";
                                                            // echo !empty($item->pembayaranpelayanan->pendaftaran_id)?$item->pembayaranpelayanan->pendaftaran->penjamin->penjamin_nama:"UMUM"; 

                                                            ?></td>
                                    <td class="num"><?php //echo "Rp" . MyFormatter::formatNumberForPrint($piutang, 2); ?></td>
                                    <td class="num"><?php //echo "Rp" . MyFormatter::formatNumberForPrint($uang_muka, 2); ?></td>
                                    <td class="num"><?php //echo "Rp" . MyFormatter::formatNumberForPrint($total_bayar, 2); ?></td>
                                    <td class="num"><?php //echo "Rp" . MyFormatter::formatNumberForPrint($item->bank_nominal, 2); ?></td>
                                    <td class="num"><?php //echo "Rp" . MyFormatter::formatNumberForPrint($retur, 2); ?></td>
                                    <td class="num" nowrap><?php //echo 'Rp' . MyFormatter::formatNumberForPrint($total_bayar + $item->bank_nominal + $piutang - $retur, 2, true); // meterai dan administrasi sudah termasuk dalam biaya pembayaran 
                                                            ?></td>
                                </tr>
                                <?php //endforeach; ?>
                        </tbody>
                        
                        <tfoot>
                            <tr style="border-top:1px solid">
                                <td colspan="5">Total</td>
                                <td class="num"><?php //echo 'Rp' . MyFormatter::formatNumberForPrint($total_piutang, 2); ?></td>
                                <td class="num"><?php //echo 'Rp' . MyFormatter::formatNumberForPrint($total_pakaiuangmuka, 2); ?></td>
                                <td class="num"><?php //echo 'Rp' . MyFormatter::formatNumberForPrint($total_tunai, 2); ?></td>
                                <td class="num"><?php //echo 'Rp' . MyFormatter::formatNumberForPrint($total_nontunai, 2); ?></td>
                                <td class="num"><?php //echo 'Rp' . MyFormatter::formatNumberForPrint($total_retur, 2); ?></td>
                                <td class="num"><?php //echo 'Rp' . MyFormatter::formatNumberForPrint($total_piutang + $total_nontunai + $total_tunai - $total_retur, 2, true); ?></td>
                            </tr>
                        </tfoot>
                    </table> -->
                    <div class="note">
                        <tr>
                            <td>Keterangan : <br><?php echo $closing->keterangan_closing; ?></td>
                        </tr>
                    </div>

                    <table style="page-break-inside:avoid">
                        <tr>
                            <td nowrap></td>
                            <td width="100%"></td>
                            <td nowrap><?php
                                        $format = new MyFormatter;
                                        echo Yii::app()->user->getState('kabupaten_nama') . ", " . $format->formatDateTimeForUser(date('Y-m-d'));
                                        ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:center;" nowrap>
                               
                                <br><br><br><br><br>
                            </td>
                            <td></td>
                            <td style="text-align:center;" nowrap>
                                Kasir
                                <br><br><br><br><br>
                                <?php
                                // $user = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
                                $pegawai = PegawaiM::model()->findByPk($closing->pegawai_id);
                                if (isset($pegawai->nama_pegawai)) echo $pegawai->nama_pegawai;
                                else echo "Administrator";
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
    <?php //echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>
<?php if (isset($_GET['caraPrint'])) {
    $this->layout = '//layouts/printWindows';
?>
    <script type="text/javascript">
        $this - > layout = '//layouts/printWindows';
        window.print();
    </script>
<?php  } else {
    echo "<br>";
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\',$(\'#pegawai\').val());$(this).style(\'display:none\');'));
    $idClosing = $closing->closingkasir_id;
    $urlPrint = $this->createUrl('rincian');
    $js = <<< JSCRIPT
function print(caraPrint,nama)
{
    window.open("${urlPrint}&idClosing=${idClosing}&caraPrint="+caraPrint+"&penerima="+nama,"",'location=_new, width=1100px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
} ?>