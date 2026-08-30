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
    <table width="100%" class="border" border="1px solid" id="tableLaporan" >
        <thead>
            <tr>
                <th rowspan="3" style="text-align:center; vertical-align: middle; font-size:8pt !important"> No </th>
                <th rowspan="3" style="text-align:center; vertical-align: middle;  font-size:8pt !important"> Kelompok&nbsp;Umur </th>
                <th rowspan="3" style="text-align:center; vertical-align: middle;  font-size:8pt !important"> Jumlah Total Donor (orang)</th>
                <th colspan="2" rowspan="2" style="text-align:center; vertical-align: middle;  font-size:8pt !important"> Jenis Kelamin </th>
                <th colspan="3" rowspan="2" style="text-align:center; vertical-align: middle;  font-size:8pt !important"> Jenis Donor </th>
                <th colspan="2" rowspan="2" style="text-align:center; vertical-align: middle;  font-size:8pt !important"> Jumlah Donor Cekal Permanen </th>
                <th colspan="4" style="text-align:center; vertical-align: middle;  font-size:8pt !important"> Jumlah Donor Cekal Sementara (orang)</th>
            </tr>
            <tr>
                <th colspan="2" style="text-align:center;vertical-align: middle; font-size:8pt !important"> Menunggu Konfirmasi Diagnostik (RR) </th>
                <th colspan="2" style="text-align:center;vertical-align: middle;  font-size:8pt !important"> Tidak Memenuhi Syarat Donor </th>
            </tr>
            <tr>
                <th style="text-align:center; width: 80px !important; font-size:8pt !important"> Laki-Laki </th>
                <th style="text-align:center;  font-size:8pt !important"> Perempuan </th>
                <th style="text-align:center;  font-size:8pt !important"> Sukarela  </th>
                <th style="text-align:center;  font-size:8pt !important"> Pengganti </th>
                <th style="text-align:center;  font-size:8pt !important"> Bayaran   </th>
                <th style="text-align:center;  font-size:8pt !important"> Sukarela  </th>
                <th style="text-align:center;  font-size:8pt !important"> Pengganti </th>
                <th style="text-align:center;  font-size:8pt !important"> Sukarela  </th>
                <th style="text-align:center;  font-size:8pt !important"> Pengganti </th>
                <th style="text-align:center;  font-size:8pt !important"> Sukarela  </th>
                <th style="text-align:center;  font-size:8pt !important"> Pengganti </th>
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
                <td style="text-align:center; font-weight:bold;  font-size:8pt !important"> 1. </td>
                <td style="text-align:left; font-weight:bold;  width:210px !important; font-size:8pt !important">< 18 Tahun</td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']['jumlahnya']['umur<18']) ? $b['det']['jumlahnya']['umur<18'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$laki"]['umur<18']) ? $b['det']["$laki"]['umur<18'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$perempuan"]['umur<18']) ? $b['det']["$perempuan"]['umur<18'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$skrl"]['umur<18']) ? $b['det']["$skrl"]['umur<18'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$pggt"]['umur<18']) ? $b['det']["$pggt"]['umur<18'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$al"]['umur<18']) ? $b['det']["$al"]['umur<18'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['umur<18']) ? $b['det']["jumlahnya"]['umur<18'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['umur<18']) ? $b['det']["jumlahnya"]['umur<18'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['umur<18']) ? $b['det']["jumlahnya"]['umur<18'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['umur<18']) ? $b['det']["jumlahnya"]['umur<18'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['umur<18']) ? $b['det']["jumlahnya"]['umur<18'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['umur<18']) ? $b['det']["jumlahnya"]['umur<18'] :"";     ?></td>
            </tr>
            <tr>
                <td style="text-align:center; font-weight:bold;  font-size:8pt !important"> 2. </td>
                <td style="text-align:left; font-weight:bold;  width:210px !important; font-size:8pt !important">18 - 24 Tahun</td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']['jumlahnya']['18sampai24']) ? $b['det']['jumlahnya']['18sampai24'] : "-"; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$laki"]['18sampai24']) ? $b['det']["$laki"]['18sampai24'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$perempuan"]['18sampai24']) ? $b['det']["$perempuan"]['18sampai24'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$skrl"]['18sampai24']) ? $b['det']["$skrl"]['18sampai24'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$pggt"]['18sampai24']) ? $b['det']["$pggt"]['18sampai24'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$al"]['18sampai24']) ? $b['det']["$al"]['18sampai24'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['18sampai24']) ? $b['det']["jumlahnya"]['18sampai24'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['18sampai24']) ? $b['det']["jumlahnya"]['18sampai24'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['18sampai24']) ? $b['det']["jumlahnya"]['18sampai24'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['18sampai24']) ? $b['det']["jumlahnya"]['18sampai24'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['18sampai24']) ? $b['det']["jumlahnya"]['18sampai24'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['18sampai24']) ? $b['det']["jumlahnya"]['18sampai24'] :"";     ?></td>
            </tr>
            <tr>
                <td style="text-align:center; font-weight:bold;  font-size:8pt !important"> 3. </td>
                <td style="text-align:left; font-weight:bold;  width:210px !important; font-size:8pt !important">25 - 44 Tahun</td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']['jumlahnya']['25sampai44']) ? $b['det']['jumlahnya']['25sampai44'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$laki"]['25sampai44']) ? $b['det']["$laki"]['25sampai44'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$perempuan"]['25sampai44']) ? $b['det']["$perempuan"]['25sampai44'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$skrl"]['25sampai44']) ? $b['det']["$skrl"]['25sampai44'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$pggt"]['25sampai44']) ? $b['det']["$pggt"]['25sampai44'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$al"]['25sampai44']) ? $b['det']["$al"]['25sampai44'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['25sampai44']) ? $b['det']["jumlahnya"]['25sampai44'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['25sampai44']) ? $b['det']["jumlahnya"]['25sampai44'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['25sampai44']) ? $b['det']["jumlahnya"]['25sampai44'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['25sampai44']) ? $b['det']["jumlahnya"]['25sampai44'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['25sampai44']) ? $b['det']["jumlahnya"]['25sampai44'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['25sampai44']) ? $b['det']["jumlahnya"]['25sampai44'] :"";     ?></td>
            </tr>
            <tr>
                <td style="text-align:center; font-weight:bold;  font-size:8pt !important"> 4. </td>
                <td style="text-align:left; font-weight:bold;  width:210px !important; font-size:8pt !important">45 - 59 Tahun</td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']['jumlahnya']['45sampai59']) ? $b['det']['jumlahnya']['45sampai59'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$laki"]['45sampai59']) ? $b['det']["$laki"]['45sampai59'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$perempuan"]['45sampai59']) ? $b['det']["$perempuan"]['45sampai59'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$skrl"]['45sampai59']) ? $b['det']["$skrl"]['45sampai59'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$pggt"]['45sampai59']) ? $b['det']["$pggt"]['45sampai59'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$al"]['45sampai59']) ? $b['det']["$al"]['45sampai59'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['45sampai59']) ? $b['det']["jumlahnya"]['45sampai59'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['45sampai59']) ? $b['det']["jumlahnya"]['45sampai59'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['45sampai59']) ? $b['det']["jumlahnya"]['45sampai59'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['45sampai59']) ? $b['det']["jumlahnya"]['45sampai59'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['45sampai59']) ? $b['det']["jumlahnya"]['45sampai59'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['45sampai59']) ? $b['det']["jumlahnya"]['45sampai59'] :"";     ?></td>
            </tr>
            <tr>
                <td style="text-align:center; font-weight:bold;  font-size:8pt !important"> 5. </td>
                <td style="text-align:left; font-weight:bold;  width:210px !important; font-size:8pt !important"> 60&nbsp;Tahun&nbsp;Keatas</td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']['jumlahnya']['lebih61']) ? $b['det']['jumlahnya']['lebih61'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$laki"]['lebih61']) ? $b['det']["$laki"]['lebih61'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$perempuan"]['lebih61']) ? $b['det']["$perempuan"]['lebih61'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$skrl"]['lebih61']) ? $b['det']["$skrl"]['lebih61'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$pggt"]['lebih61']) ? $b['det']["$pggt"]['lebih61'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php echo isset($b['det']["$al"]['lebih61']) ? $b['det']["$al"]['lebih61'] : ""; ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['lebih61']) ? $b['det']["jumlahnya"]['lebih61'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['lebih61']) ? $b['det']["jumlahnya"]['lebih61'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['lebih61']) ? $b['det']["jumlahnya"]['lebih61'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['lebih61']) ? $b['det']["jumlahnya"]['lebih61'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['lebih61']) ? $b['det']["jumlahnya"]['lebih61'] :"";     ?></td>
                <td style="text-align:center;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['lebih61']) ? $b['det']["jumlahnya"]['lebih61'] :"";     ?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center; font-weight:bold;  font-size:8pt !important"> JUMLAH </td>
                <td style="text-align:center; font-weight:bold;  font-size:8pt !important"><?php echo isset($b['det']['jumlahnya']['jumlah']) ? $b['det']['jumlahnya']['jumlah'] : ""; ?></td>
                <td style="text-align:center; font-weight:bold;  font-size:8pt !important"><?php echo isset($b['det']["$laki"]['jumlah']) ? $b['det']["$laki"]['jumlah'] : ""; ?></td>
                <td style="text-align:center; font-weight:bold;  font-size:8pt !important"><?php echo isset($b['det']["$perempuan"]['jumlah']) ? $b['det']["$perempuan"]['jumlah'] : ""; ?></td>
                <td style="text-align:center; font-weight:bold;  font-size:8pt !important"><?php echo isset($b['det']["$skrl"]['jumlah']) ? $b['det']["$skrl"]['jumlah'] : ""; ?></td>
                <td style="text-align:center; font-weight:bold;  font-size:8pt !important"><?php echo isset($b['det']["$pggt"]['jumlah']) ? $b['det']["$pggt"]['jumlah'] : ""; ?></td>
                <td style="text-align:center; font-weight:bold;  font-size:8pt !important"><?php echo isset($b['det']["$al"]['jumlah']) ? $b['det']["$al"]['jumlah'] : ""; ?></td>
                <td style="text-align:center; font-weight:bold;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['jumlah']) ? $b['det']["jumlahnya"]['jumlah'] :"";     ?></td>
                <td style="text-align:center; font-weight:bold;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['jumlah']) ? $b['det']["jumlahnya"]['jumlah'] :"";     ?></td>
                <td style="text-align:center; font-weight:bold;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['jumlah']) ? $b['det']["jumlahnya"]['jumlah'] :"";     ?></td>
                <td style="text-align:center; font-weight:bold;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['jumlah']) ? $b['det']["jumlahnya"]['jumlah'] :"";     ?></td>
                <td style="text-align:center; font-weight:bold;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['jumlah']) ? $b['det']["jumlahnya"]['jumlah'] :"";     ?></td>
                <td style="text-align:center; font-weight:bold;  font-size:8pt !important"><?php // echo isset($b['det']["jumlahnya"]['jumlah']) ? $b['det']["jumlahnya"]['jumlah'] :"";     ?></td>
            </tr>
        </tbody>
    </table>
</div>