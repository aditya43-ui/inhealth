<?php
$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->search();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    if ($caraPrint == 'PDF') {
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
} else {
    $data = $model->search();
    $template = "{summary}\n{items}\n{pager}";
}
?>
<style>
    tr:last-child > td:first-child{
        border-bottom-left-radius: 0px !important;
        border-bottom-right-radius: 0px !important;
    }
</style>
<div>
    <table width="100%" class="table table-bordered table-condensed" border="1px" id="tableLaporan" >
        <thead>
            <tr>
                <th rowspan="3" style="text-align:center; vertical-align: middle"> No </th>
                <th rowspan="3" style="text-align:center; vertical-align: middle"> Kelompok Umur </th>
                <th rowspan="3" style="text-align:center; vertical-align: middle"> Jumlah Total Donor (orang)</th>
                <th colspan="2" rowspan="2" style="text-align:center; vertical-align: middle"> Jenis Kelamin </th>
                <th colspan="3" rowspan="2" style="text-align:center; vertical-align: middle"> Jenis Donor </th>
                <th colspan="2" rowspan="2" style="text-align:center; vertical-align: middle"> Jumlah Donor Cekal Permanen </th>
                <th colspan="4" style="text-align:center; vertical-align: middle"> Jumlah Donor Cekal Sementara (orang)</th>
            </tr>
            <tr>
                <th colspan="2" style="text-align:center;vertical-align: middle"> Menunggu Konfirmasi Diagnostik (RR) </th>
                <th colspan="2" style="text-align:center;vertical-align: middle"> Tidak Memenuhi Syarat Donor </th>
            </tr>
            <tr>
                <th style="text-align:center; width: 80px !important"> Laki-Laki </th>
                <th style="text-align:center;"> Perempuan </th>
                <th style="text-align:center;"> Sukarela  </th>
                <th style="text-align:center;"> Pengganti </th>
                <th style="text-align:center;"> Bayaran   </th>
                <th style="text-align:center;"> Sukarela  </th>
                <th style="text-align:center;"> Pengganti </th>
                <th style="text-align:center;"> Sukarela  </th>
                <th style="text-align:center;"> Pengganti </th>
                <th style="text-align:center;"> Sukarela  </th>
                <th style="text-align:center;"> Pengganti </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $tglsekarang = 'sekarang';
            $laki = Params::JENIS_KELAMIN_LAKI_LAKI;
            $perempuan = Params::JENIS_KELAMIN_PEREMPUAN;
            $skrl = 'Sukarela';
            $pggt = 'Pengganti';
            $al = 'Autologus';
            ?>  
            <tr>
                <td style="text-align:center; font-weight:bold;"> 1. </td>
                <td style="text-align:left; font-weight:bold;  width:110px !important">< 18 Tahun</td>
                <td style="text-align:center;"><?php echo isset($b['det']['jumlahnya']['umur<18']) ? $b['det']['jumlahnya']['umur<18'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$laki"]['umur<18']) ? $b['det']["$laki"]['umur<18'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$perempuan"]['umur<18']) ? $b['det']["$perempuan"]['umur<18'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$skrl"]['umur<18']) ? $b['det']["$skrl"]['umur<18'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$pggt"]['umur<18']) ? $b['det']["$pggt"]['umur<18'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$al"]['umur<18']) ? $b['det']["$al"]['umur<18'] : ""; ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['umur<18']) ? $b['det']["jumlahnya"]['umur<18'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['umur<18']) ? $b['det']["jumlahnya"]['umur<18'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['umur<18']) ? $b['det']["jumlahnya"]['umur<18'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['umur<18']) ? $b['det']["jumlahnya"]['umur<18'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['umur<18']) ? $b['det']["jumlahnya"]['umur<18'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['umur<18']) ? $b['det']["jumlahnya"]['umur<18'] :"";   ?></td>
            </tr>
            <tr>
                <td style="text-align:center; font-weight:bold;"> 2. </td>
                <td style="text-align:left; font-weight:bold;  width:110px !important">18 - 24 Tahun</td>
                <td style="text-align:center;"><?php echo isset($b['det']['jumlahnya']['18sampai24']) ? $b['det']['jumlahnya']['18sampai24'] : "-"; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$laki"]['18sampai24']) ? $b['det']["$laki"]['18sampai24'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$perempuan"]['18sampai24']) ? $b['det']["$perempuan"]['18sampai24'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$skrl"]['18sampai24']) ? $b['det']["$skrl"]['18sampai24'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$pggt"]['18sampai24']) ? $b['det']["$pggt"]['18sampai24'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$al"]['18sampai24']) ? $b['det']["$al"]['18sampai24'] : ""; ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['18sampai24']) ? $b['det']["jumlahnya"]['18sampai24'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['18sampai24']) ? $b['det']["jumlahnya"]['18sampai24'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['18sampai24']) ? $b['det']["jumlahnya"]['18sampai24'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['18sampai24']) ? $b['det']["jumlahnya"]['18sampai24'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['18sampai24']) ? $b['det']["jumlahnya"]['18sampai24'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['18sampai24']) ? $b['det']["jumlahnya"]['18sampai24'] :"";   ?></td>
            </tr>
            <tr>
                <td style="text-align:center; font-weight:bold;"> 3. </td>
                <td style="text-align:left; font-weight:bold;  width:110px !important">25 - 44 Tahun</td>
                <td style="text-align:center;"><?php echo isset($b['det']['jumlahnya']['25sampai44']) ? $b['det']['jumlahnya']['25sampai44'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$laki"]['25sampai44']) ? $b['det']["$laki"]['25sampai44'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$perempuan"]['25sampai44']) ? $b['det']["$perempuan"]['25sampai44'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$skrl"]['25sampai44']) ? $b['det']["$skrl"]['25sampai44'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$pggt"]['25sampai44']) ? $b['det']["$pggt"]['25sampai44'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$al"]['25sampai44']) ? $b['det']["$al"]['25sampai44'] : ""; ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['25sampai44']) ? $b['det']["jumlahnya"]['25sampai44'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['25sampai44']) ? $b['det']["jumlahnya"]['25sampai44'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['25sampai44']) ? $b['det']["jumlahnya"]['25sampai44'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['25sampai44']) ? $b['det']["jumlahnya"]['25sampai44'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['25sampai44']) ? $b['det']["jumlahnya"]['25sampai44'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['25sampai44']) ? $b['det']["jumlahnya"]['25sampai44'] :"";   ?></td>
            </tr>
            <tr>
                <td style="text-align:center; font-weight:bold;"> 4. </td>
                <td style="text-align:left; font-weight:bold;  width:110px !important">45 - 59 Tahun</td>
                <td style="text-align:center;"><?php echo isset($b['det']['jumlahnya']['45sampai59']) ? $b['det']['jumlahnya']['45sampai59'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$laki"]['45sampai59']) ? $b['det']["$laki"]['45sampai59'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$perempuan"]['45sampai59']) ? $b['det']["$perempuan"]['45sampai59'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$skrl"]['45sampai59']) ? $b['det']["$skrl"]['45sampai59'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$pggt"]['45sampai59']) ? $b['det']["$pggt"]['45sampai59'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$al"]['45sampai59']) ? $b['det']["$al"]['45sampai59'] : ""; ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['45sampai59']) ? $b['det']["jumlahnya"]['45sampai59'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['45sampai59']) ? $b['det']["jumlahnya"]['45sampai59'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['45sampai59']) ? $b['det']["jumlahnya"]['45sampai59'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['45sampai59']) ? $b['det']["jumlahnya"]['45sampai59'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['45sampai59']) ? $b['det']["jumlahnya"]['45sampai59'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['45sampai59']) ? $b['det']["jumlahnya"]['45sampai59'] :"";   ?></td>
            </tr>
            <tr>
                <td style="text-align:center; font-weight:bold;"> 5. </td>
                <td style="text-align:left; font-weight:bold;  width:110px !important"> 60 Tahun Keatas</td>
                <td style="text-align:center;"><?php echo isset($b['det']['jumlahnya']['lebih61']) ? $b['det']['jumlahnya']['lebih61'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$laki"]['lebih61']) ? $b['det']["$laki"]['lebih61'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$perempuan"]['lebih61']) ? $b['det']["$perempuan"]['lebih61'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$skrl"]['lebih61']) ? $b['det']["$skrl"]['lebih61'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$pggt"]['lebih61']) ? $b['det']["$pggt"]['lebih61'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b['det']["$al"]['lebih61']) ? $b['det']["$al"]['lebih61'] : ""; ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['lebih61']) ? $b['det']["jumlahnya"]['lebih61'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['lebih61']) ? $b['det']["jumlahnya"]['lebih61'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['lebih61']) ? $b['det']["jumlahnya"]['lebih61'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['lebih61']) ? $b['det']["jumlahnya"]['lebih61'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['lebih61']) ? $b['det']["jumlahnya"]['lebih61'] :"";   ?></td>
                <td style="text-align:center;"><?php // echo isset($b['det']["jumlahnya"]['lebih61']) ? $b['det']["jumlahnya"]['lebih61'] :"";   ?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center; font-weight:bold;"> JUMLAH </td>
                <td style="text-align:center; font-weight:bold;"><?php echo isset($b['det']['jumlahnya']['jumlah']) ? $b['det']['jumlahnya']['jumlah'] : ""; ?></td>
                <td style="text-align:center; font-weight:bold;"><?php echo isset($b['det']["$laki"]['jumlah']) ? $b['det']["$laki"]['jumlah'] : ""; ?></td>
                <td style="text-align:center; font-weight:bold;"><?php echo isset($b['det']["$perempuan"]['jumlah']) ? $b['det']["$perempuan"]['jumlah'] : ""; ?></td>
                <td style="text-align:center; font-weight:bold;"><?php echo isset($b['det']["$skrl"]['jumlah']) ? $b['det']["$skrl"]['jumlah'] : ""; ?></td>
                <td style="text-align:center; font-weight:bold;"><?php echo isset($b['det']["$pggt"]['jumlah']) ? $b['det']["$pggt"]['jumlah'] : ""; ?></td>
                <td style="text-align:center; font-weight:bold;"><?php echo isset($b['det']["$al"]['jumlah']) ? $b['det']["$al"]['jumlah'] : ""; ?></td>
                <td style="text-align:center; font-weight:bold;"><?php // echo isset($b['det']["jumlahnya"]['jumlah']) ? $b['det']["jumlahnya"]['jumlah'] :"";   ?></td>
                <td style="text-align:center; font-weight:bold;"><?php // echo isset($b['det']["jumlahnya"]['jumlah']) ? $b['det']["jumlahnya"]['jumlah'] :"";   ?></td>
                <td style="text-align:center; font-weight:bold;"><?php // echo isset($b['det']["jumlahnya"]['jumlah']) ? $b['det']["jumlahnya"]['jumlah'] :"";   ?></td>
                <td style="text-align:center; font-weight:bold;"><?php // echo isset($b['det']["jumlahnya"]['jumlah']) ? $b['det']["jumlahnya"]['jumlah'] :"";   ?></td>
                <td style="text-align:center; font-weight:bold;"><?php // echo isset($b['det']["jumlahnya"]['jumlah']) ? $b['det']["jumlahnya"]['jumlah'] :"";   ?></td>
                <td style="text-align:center; font-weight:bold;"><?php // echo isset($b['det']["jumlahnya"]['jumlah']) ? $b['det']["jumlahnya"]['jumlah'] :"";   ?></td>
            </tr>
        </tbody>
    </table>
</div>
