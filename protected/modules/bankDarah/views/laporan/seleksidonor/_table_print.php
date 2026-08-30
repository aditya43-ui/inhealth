<?php 
    $itemCssClass = 'table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchTable();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
         if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewPDF';
            
        }
  
        echo "
        <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing:0px;
                padding:0px;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
        $itemCssClass = 'table border';
        
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<style>
    .border th, .border td{
        border:1px solid #000 !important;
    }

    .border thead tr{
        background:none !important;
        color:#333 !important;
    }

    .border {
        box-shadow:none !important;
        border-spacing:0px !important;
        padding:0px !important;
    }
</style>
<div>
    <table id="tableLaporan" width="100%" class="border" border="1px solid !important" style="text-align:center;">
        <thead>
            <tr>
                <td rowspan="5" style="text-align:center;">TGL</td>
                <td rowspan="5" style="text-align:center;">TEMPAT DONOR</td>
                <td rowspan="5" style="text-align:center;">JMLH <br>KUNJ <br>(org)</td>
                <td colspan="2" rowspan="2" style="text-align:center;">JNS KELAMIN</td>
                <td colspan="2" rowspan="2" style="text-align:center;">DONOR KE</td>
                <td colspan="3" rowspan="2" style="text-align:center;">JNS DONOR</td>
                <td colspan="13" style="text-align:center;">BATAL</td>
                <td rowspan="5" style="text-align:center;">JMLH <br>LOLOS <br>SELEKSI <br>(org)</td>
            </tr>
            <tr>
                <td colspan="10" style="text-align:center;">PENYEBAB</td>
                <td rowspan="4" style="text-align:center;">L</td>
                <td rowspan="4" style="text-align:center;">P</td>
                <td rowspan="4" style="text-align:center;">JMLH<br>BATAL<br>(org)</td>
            </tr>
            <tr>
                <td rowspan="3" style="text-align:center;">LK</td>
                <td rowspan="3" style="text-align:center;">PR</td>
                <td rowspan="3" style="text-align:center;" >1</td>
                <td rowspan="3" style="text-align:center;" >>1</td>
                <td rowspan="3" style="text-align:center;">Skrl</td>
                <td rowspan="3" style="text-align:center;">Pggt</td>
                <td rowspan="3" style="text-align:center;">Auto<br>logus</td>
                <td rowspan="2" style="text-align:center;">Hb</td>
                <td rowspan="2" style="text-align:center;">BB</td>
                <td colspan="5" style="text-align:center;">MEDIS LAIN</td>
                <td rowspan="3" style="text-align:center;">PERIL<br>AKU<br>BERE<br>SIKO</td>
                <td rowspan="3" style="text-align:center;">RIWAY<br>AT<br>BEPER<br>GIAN</td>
                <td style="text-align:center;">LAIN2</td>
            </tr>
            <tr>
                <td style="text-align:center;">Hb</td>
                <td colspan="2" style="text-align:center;">TEK DARAH</td>
                <td style="text-align:center;">BB</td>
                <td rowspan="2" style="text-align:center;">Vaksin</td>
                <td rowspan="2" style="text-align:center;">Ggl sadap</td>
            </tr>
            <tr>
                <td style="text-align:center;"><</td>
                <td style="text-align:center;"><</td>
                <td style="text-align:center;">>17</td>
                <td style="text-align:center;"><</td>
                <td style="text-align:center;">></td>
                <td style="text-align:center;">>></td>
            </tr>
        </thead>
        <tbody>
            <?php 
//            var_dump(!empty($modShow2)); 
            foreach ($modShow as $value){
                $cari = LapseleksidonordarahV::model()->findAllByAttributes(array('waktu_pendaftaran' => $value->waktu_pendaftaran));
                $laki = Params::JENIS_KELAMIN_LAKI_LAKI;
                $perempuan = Params::JENIS_KELAMIN_PEREMPUAN;
                $HBrendah  = 'hbrendah';
                $BBrendah  = 'bbrendah'; 
                $medishb17 = 'medishb17'; 
                $tdrendah  = 'tdrendah'; 
                $tktinggi  = 'tkrendah'; $skrl = 'Sukarela'; $pggt = 'Pengganti';  $al = 'Autologus';
                $bblebih   = 'bblebih';
                $medisvaksin = 'medisvaksin'; $perilakuberesiko = 'perilakuberesiko'; $riwayat = 'riwayat'; $lain2 = 'lain2';
                $batallaki = 'batallaki';
                $batalperempuan = 'batalperempuan';
                $isbatal = 'batal';
                $lolos = 'lolos';
                $satu = 1;
                $lebihdarisatu = !1;
                $tglsekarang = 'sekarang';
                $cekruangan = RuanganM::model()->findByPk($value->ruangan_rekruitmen_id);
            ?>
            <tr>
                <td colspan="24"></td>
            </tr>
            <tr>
                <td colspan="24"><?php echo MyFormatter::formatDateTimeForUser($value->waktu_pendaftaran); echo " di "; echo !empty($cekruangan) ? $cekruangan->ruangan_nama : '-'; ?> </td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: center">< 18 Thn</td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tglsekarang"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tglsekarang"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$laki"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$laki"]['umur<18'] :""; ?> </td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$perempuan"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$perempuan"]['umur<18'] :""; ?> </td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$satu"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$satu"]['umur<18'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lebihdarisatu"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lebihdarisatu"]['umur<18'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$skrl"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$skrl"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$pggt"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$pggt"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$al"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$al"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$HBrendah"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$HBrendah"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$BBrendah"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$BBrendah"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$medishb17"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$medishb17"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tdrendah"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tdrendah"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tktinggi"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tktinggi"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$bblebih"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$bblebih"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$medisvaksin"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$medisvaksin"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$perilakuberesiko"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$perilakuberesiko"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$riwayat"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$riwayat"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lain2"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lain2"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$batallaki"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$batallaki"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$batalperempuan"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$batalperempuan"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$isbatal"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$isbatal"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lolos"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lolos"]['umur<18'] :""; ?></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: center">18 - 24 Thn</td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tglsekarang"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tglsekarang"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$laki"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$laki"]['18sampai24'] :""; ?> </td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$perempuan"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$perempuan"]['18sampai24'] :""; ?> </td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$satu"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$satu"]['18sampai24'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lebihdarisatu"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lebihdarisatu"]['18sampai24'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$skrl"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$skrl"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$pggt"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$pggt"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$al"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$al"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$HBrendah"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$HBrendah"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$BBrendah"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$BBrendah"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$medishb17"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$medishb17"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tdrendah"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tdrendah"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tktinggi"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tktinggi"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$bblebih"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$bblebih"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$medisvaksin"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$medisvaksin"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$perilakuberesiko"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$perilakuberesiko"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$riwayat"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$riwayat"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lain2"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lain2"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$batallaki"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$batallaki"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$batalperempuan"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$batalperempuan"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$isbatal"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$isbatal"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lolos"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lolos"]['18sampai24'] :""; ?></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: center">25 - 44 Thn</td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tglsekarang"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tglsekarang"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$laki"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$laki"]['25sampai44'] :""; ?> </td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$perempuan"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$perempuan"]['25sampai44'] :""; ?> </td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$satu"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$satu"]['25sampai44'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lebihdarisatu"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lebihdarisatu"]['25sampai44'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$skrl"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$skrl"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$pggt"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$pggt"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$al"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$al"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$HBrendah"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$HBrendah"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$BBrendah"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$BBrendah"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$medishb17"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$medishb17"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tdrendah"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tdrendah"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tktinggi"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tktinggi"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$bblebih"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$bblebih"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$medisvaksin"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$medisvaksin"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$perilakuberesiko"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$perilakuberesiko"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$riwayat"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$riwayat"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lain2"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lain2"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$batallaki"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$batallaki"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$batalperempuan"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$batalperempuan"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$isbatal"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$isbatal"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lolos"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lolos"]['25sampai44'] :""; ?></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: center">45 - 59 Thn</td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tglsekarang"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tglsekarang"]['45sampai59'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$laki"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$laki"]['45sampai59'] :""; ?> </td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$perempuan"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$perempuan"]['45sampai59'] :""; ?> </td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$satu"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$satu"]['45sampai59'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lebihdarisatu"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lebihdarisatu"]['45sampai59'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$skrl"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$skrl"]['45sampai59'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$pggt"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$pggt"]['45sampai59'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$al"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$al"]['45sampai59'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$HBrendah"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$HBrendah"]['45sampai59'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$BBrendah"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$BBrendah"]['45sampai59'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$medishb17"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$medishb17"]['45sampai59'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tdrendah"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tdrendah"]['45sampai59'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tktinggi"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tktinggi"]['45sampai59'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$bblebih"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$bblebih"]['45sampai59'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$medisvaksin"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$medisvaksin"]['45sampai59'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$perilakuberesiko"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$perilakuberesiko"]['45sampai59'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$riwayat"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$riwayat"]['45sampai59'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lain2"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lain2"]['45sampai59'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$batallaki"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$batallaki"]['45sampai59'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$batalperempuan"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$batalperempuan"]['45sampai59'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$isbatal"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$isbatal"]['45sampai59'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lolos"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lolos"]['45sampai59'] :""; ?></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: center">> 61 Thn</td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tglsekarang"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tglsekarang"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$laki"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$laki"]['lebih61'] :""; ?> </td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$perempuan"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$perempuan"]['lebih61'] :""; ?> </td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$satu"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$satu"]['lebih61'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lebihdarisatu"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lebihdarisatu"]['lebih61'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$skrl"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$skrl"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$pggt"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$pggt"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$al"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$al"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$HBrendah"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$HBrendah"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$BBrendah"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$BBrendah"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$medishb17"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$medishb17"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tdrendah"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tdrendah"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tktinggi"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tktinggi"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$bblebih"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$bblebih"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$medisvaksin"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$medisvaksin"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$perilakuberesiko"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$perilakuberesiko"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$riwayat"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$riwayat"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lain2"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lain2"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$batallaki"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$batallaki"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$batalperempuan"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$batalperempuan"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$isbatal"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$isbatal"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lolos"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lolos"]['lebih61'] :""; ?></td>
            </tr>
            <tr>
                <td><?php echo date('d', strtotime($value->waktu_pendaftaran)); ?></td>
                <td style="text-align: center">JUMLAH</td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tglsekarang"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tglsekarang"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$laki"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$laki"]['jumlah'] :""; ?> </td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$perempuan"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$perempuan"]['jumlah'] :""; ?> </td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$satu"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$satu"]['jumlah'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lebihdarisatu"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lebihdarisatu"]['jumlah'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$skrl"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$skrl"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$pggt"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$pggt"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$al"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$al"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$HBrendah"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$HBrendah"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$BBrendah"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$BBrendah"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$medishb17"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$medishb17"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tdrendah"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tdrendah"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tktinggi"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$tktinggi"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$bblebih"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$bblebih"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$medisvaksin"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$medisvaksin"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$perilakuberesiko"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$perilakuberesiko"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$riwayat"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$riwayat"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lain2"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lain2"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$batallaki"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$batallaki"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$batalperempuan"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$batalperempuan"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$isbatal"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$isbatal"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lolos"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$value->ruangan_rekruitmen_id"]['ruangan']["$lolos"]['jumlah'] :""; ?></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>