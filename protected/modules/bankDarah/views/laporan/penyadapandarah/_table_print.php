<?php 
    $itemCssClass='table table-bordered table-striped table-condensed';
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
                border-spacing: 0;
                padding: 0;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
        $itemCssClass='table border';
        
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<style>
    .border th, .border td{
        border:1px solid #000 !important;
    }
    .table thead:first-child{
        border-top:1px solid #000 !important;        
    }

    thead tr{
        background:none !important;
        color:#333 !important;
    }

    .border {
        box-shadow:none !important;
        border-spacing:0px !important;
        padding:0px !important;
    }

    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none !important;
    }
    .table-bordered th + th, .table-bordered td + td, .table-bordered th + td, .table-bordered td + th {
        border-left: 1px solid #000;
        box-shadow:none !important;
    }
    .table-bordered{
        border-collapse: collapse;
    }
</style>
<div>
    <table width="100%" class="table table-bordered table-condensed" border="1px solid #000" style="border:1px solid #000 !important;text-align:center; font-weight: bold;box-shadow:none !important;
        border-spacing:0px !important;
        padding:0px !important">
        <thead>
            <tr>
                <td rowspan="3" style="text-align:center;">TGL</td>
                <td rowspan="3" style="text-align:center;">TEMPAT DONOR</td>
                <td rowspan="3" style="text-align:center;">JMLH <br>LOLOS <br> SELEKSI<br>(org) </td>
                <td colspan="19" style="text-align:center;">PENYADAPAN</td>    
                <td rowspan="3" style="text-align:center;">SUK<br>SES<br> SA<br>DAP<br>(org)</td>
            </tr>
            <tr>
                
               
                <td colspan="2" style="text-align:center;">JNS KELAMIN</td>
                <td colspan="2" style="text-align:center;">DONOR KE</td>
                <td colspan="3" style="text-align:center;">JNS DONOR</td>
                <td colspan="4" style="text-align:center;">Gol Darah</td>
                <td colspan="2" style="text-align:center;">Rhesus</td>
                <td colspan="4" style="text-align:center;">Jenis Kantong</td>
                <td colspan="2" style="text-align:center;">Gagal Sadap</td>
            </tr>
            <tr>
                <td rowspan="3" style="text-align:center;">LK</td>
                <td rowspan="3" style="text-align:center;">PR</td>
                <td rowspan="3" style="text-align:center;">1</td>
                <td rowspan="3" style="text-align:center;">>1</td>
                <td rowspan="3" style="text-align:center;">SKRL</td>
                <td rowspan="3" style="text-align:center;">PGGT</td>
                <td rowspan="3" style="text-align:center;">AUTO<br>LOGUS</td>
                <td rowspan="2" style="text-align:center;">A</td>
                <td rowspan="2" style="text-align:center;">B</td>
                <td rowspan="2" style="text-align:center;">O</td>
                <td rowspan="2" style="text-align:center;">AB</td>
                <td rowspan="2" style="text-align:center;">Pos</td>
                <td rowspan="2" style="text-align:center;">Neg</td>
                <td rowspan="2" style="text-align:center;">SG</td>
                <td rowspan="2" style="text-align:center;">DBL</td>
                <td rowspan="2" style="text-align:center;">TR</td>
                <td rowspan="2" style="text-align:center;">QD</td>
                <td rowspan="2" style="text-align:center;">Rks</td>
                <td rowspan="2" style="text-align:center;">V Kcl</td>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($modShow as $value) :
                $alasanbatal = $value->alasanbatal_penyadapan;
                $tglsekarang = 'sekarang';
                $laki = Params::JENIS_KELAMIN_LAKI_LAKI;
                $perempuan = Params::JENIS_KELAMIN_PEREMPUAN;
                $satu = 1;
                $lebihdarisatu = !1;
                $skrl = 'Sukarela';
                $pggt = 'Pengganti';
                $al = 'Autologus';
                $goldarahA = 'A';
                $goldarahB = 'B';
                $goldarahO = 'O'; $Negatif = 'Negatif';
                $goldarahAB = 'AB'; $Positif = 'Positif';
                $carikata1 = 'REAKSI DONOR';
                $carikata2 = 'Vena Kecil';
                $lolos = 'lolos';
                $SG  = 'Single';//1
                $DBL = 'Double';//2
                $TR  = 'Triple';//3
                $QR  = 'Quadruple';//4
                $os = array("Mac", "NT", "Irix", "Linux");
                
            ?>  
            <tr>
                <td colspan="24"></td>
            </tr>
            <tr>
                <td colspan="24"><?php echo MyFormatter::formatDateTimeForUser($value->waktu_pendaftaran); echo " di "; echo $value->ruangan_nama ?> </td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: center">< 18 Thn</td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$tglsekarang"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$tglsekarang"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$laki"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$laki"]['umur<18'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$perempuan"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$perempuan"]['umur<18'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$satu"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$satu"]['umur<18'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$lebihdarisatu"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$lebihdarisatu"]['umur<18'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$skrl"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$skrl"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$pggt"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$pggt"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$al"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$al"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$goldarahA"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$goldarahA"]['umur<18'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$goldarahB"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$goldarahB"]['umur<18'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$goldarahO"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$goldarahO"]['umur<18'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$goldarahAB"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$goldarahAB"]['umur<18'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$Positif"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$Positif"]['umur<18'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$Negatif"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$Negatif"]['umur<18'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$SG"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$SG"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$DBL"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$DBL"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$TR"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$TR"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$QR"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$QR"]['umur<18'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$carikata1"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$carikata1"]['umur<18'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$carikata2"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$carikata2"]['umur<18'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$lolos"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$lolos"]['umur<18'] :""; ?></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: center">18 - 24 Thn</td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$tglsekarang"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$tglsekarang"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$laki"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$laki"]['18sampai24'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$perempuan"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$perempuan"]['18sampai24'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$satu"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$satu"]['18sampai24'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$lebihdarisatu"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$lebihdarisatu"]['18sampai24'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$skrl"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$skrl"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$pggt"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$pggt"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$al"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$al"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$goldarahA"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$goldarahA"]['18sampai24'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$goldarahB"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$goldarahB"]['18sampai24'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$goldarahO"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$goldarahO"]['18sampai24'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$goldarahAB"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$goldarahAB"]['18sampai24'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$Positif"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$Positif"]['18sampai24'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$Negatif"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$Negatif"]['18sampai24'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$SG"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$SG"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$DBL"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$DBL"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$TR"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$TR"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$QR"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$QR"]['18sampai24'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$carikata1"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$carikata1"]['18sampai24'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$carikata2"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$carikata2"]['18sampai24'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$lolos"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$lolos"]['18sampai24'] :""; ?></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: center">25 - 44 Thn</td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$tglsekarang"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$tglsekarang"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$laki"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$laki"]['25sampai44'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$perempuan"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$perempuan"]['25sampai44'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$satu"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$satu"]['25sampai44'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$lebihdarisatu"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$lebihdarisatu"]['25sampai44'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$skrl"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$skrl"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$pggt"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$pggt"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$al"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$al"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$goldarahA"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$goldarahA"]['25sampai44'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$goldarahB"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$goldarahB"]['25sampai44'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$goldarahO"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$goldarahO"]['25sampai44'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$goldarahAB"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$goldarahAB"]['25sampai44'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$Positif"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$Positif"]['25sampai44'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$Negatif"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$Negatif"]['25sampai44'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$SG"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$SG"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$DBL"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$DBL"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$TR"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$TR"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$QR"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$QR"]['25sampai44'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$carikata1"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$carikata1"]['25sampai44'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$carikata2"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$carikata2"]['25sampai44'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$lolos"]['25sampai44']) ? $b["$value->waktu_pendaftaran"]['det']["$lolos"]['25sampai44'] :""; ?></td>
            </tr>
            <tr>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$tglsekarang"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$tglsekarang"]['45sampai59'] :"";?></td>
                <td style="text-align: center">45 - 59 Thn</td>
                <td></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$laki"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$laki"]['45sampai59'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$perempuan"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$perempuan"]['45sampai59'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$satu"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$satu"]['45sampai59'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$lebihdarisatu"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$lebihdarisatu"]['45sampai59'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$skrl"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$skrl"]['45sampai59'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$pggt"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$pggt"]['45sampai59'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$al"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$al"]['45sampai59'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$goldarahA"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$goldarahA"]['45sampai59'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$goldarahB"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$goldarahB"]['45sampai59'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$goldarahO"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$goldarahO"]['45sampai59'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$goldarahAB"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$goldarahAB"]['45sampai59'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$Positif"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$Positif"]['45sampai59'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$Negatif"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$Negatif"]['45sampai59'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$SG"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$SG"]['45sampai59'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$DBL"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$DBL"]['45sampai59'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$TR"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$TR"]['45sampai59'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$QR"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$QR"]['45sampai59'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$carikata1"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$carikata1"]['45sampai59'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$carikata2"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$carikata2"]['45sampai59'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$lolos"]['45sampai59']) ? $b["$value->waktu_pendaftaran"]['det']["$lolos"]['45sampai59'] :""; ?></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: center">> 61 Thn</td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$tglsekarang"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$tglsekarang"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$laki"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$laki"]['lebih61'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$perempuan"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$perempuan"]['lebih61'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$satu"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$satu"]['lebih61'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$lebihdarisatu"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$lebihdarisatu"]['lebih61'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$skrl"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$skrl"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$pggt"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$pggt"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$al"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$al"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$goldarahA"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$goldarahA"]['lebih61'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$goldarahB"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$goldarahB"]['lebih61'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$goldarahO"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$goldarahO"]['lebih61'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$goldarahAB"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$goldarahAB"]['lebih61'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$Positif"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$Positif"]['lebih61'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$Negatif"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$Negatif"]['lebih61'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$SG"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$SG"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$DBL"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$DBL"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$TR"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$TR"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$QR"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$QR"]['lebih61'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$carikata1"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$carikata1"]['lebih61'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$carikata2"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$carikata2"]['lebih61'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$lolos"]['lebih61']) ? $b["$value->waktu_pendaftaran"]['det']["$lolos"]['lebih61'] :""; ?></td>
            </tr>
            <tr>
                <td><?php echo date('d', strtotime($value->waktu_pendaftaran)); ?></td>
                <td style="text-align: center">JUMLAH</td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$tglsekarang"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$tglsekarang"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$laki"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$laki"]['jumlah'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$perempuan"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$perempuan"]['jumlah'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$satu"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$satu"]['jumlah'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$lebihdarisatu"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$lebihdarisatu"]['jumlah'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$skrl"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$skrl"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$pggt"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$pggt"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$al"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$al"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$goldarahA"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$goldarahA"]['jumlah'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$goldarahB"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$goldarahB"]['jumlah'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$goldarahO"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$goldarahO"]['jumlah'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$goldarahAB"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$goldarahAB"]['jumlah'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$Positif"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$Positif"]['jumlah'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$Negatif"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$Negatif"]['jumlah'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$SG"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$SG"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$DBL"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$DBL"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$TR"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$TR"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$QR"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$QR"]['jumlah'] :"";?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$carikata1"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$carikata1"]['jumlah'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$carikata2"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$carikata2"]['jumlah'] :""; ?></td>
                <td><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$lolos"]['jumlah']) ? $b["$value->waktu_pendaftaran"]['det']["$lolos"]['jumlah'] :""; ?></td>
            </tr>
            <?php
            endforeach;
            ?>
        </tbody>
    </table>
    
</div>
