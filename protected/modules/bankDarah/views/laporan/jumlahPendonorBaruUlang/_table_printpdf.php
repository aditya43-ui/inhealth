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
                <th rowspan="4" style="text-align:center; vertical-align: middle;"> No </th>
                <th rowspan="4" style="text-align:center; vertical-align: middle;"> Kelompok Umur </th>
                <th colspan="8" style="text-align:center; vertical-align: middle;"> Jumlah Donor Darah Menurut Golongan dan Rh Darah</th>
                <th colspan="8" style="text-align:center; vertical-align: middle;"> Jumlah Donor Darah Menurut Golongan dan Rh Darah</th>
            </tr>
            <tr>
                <th colspan="8" style="text-align:center;vertical-align: middle;"> Baru </th>
                <th colspan="8" style="text-align:center;vertical-align: middle;"> Ulang </th>
            </tr>
            <tr>
                <th colspan="2" style="text-align:center;vertical-align: middle;"> O </th>
                <th colspan="2" style="text-align:center;vertical-align: middle;"> A </th>
                <th colspan="2" style="text-align:center;vertical-align: middle;"> B </th>
                <th colspan="2" style="text-align:center;vertical-align: middle;"> AB </th>
                <th colspan="2" style="text-align:center;vertical-align: middle;"> O </th>
                <th colspan="2" style="text-align:center;vertical-align: middle;"> A </th>
                <th colspan="2" style="text-align:center;vertical-align: middle;"> B </th>
                <th colspan="2" style="text-align:center;vertical-align: middle;"> AB </th>
            </tr>
            <tr>
                <th style="text-align:center;vertical-align: middle;"> Pos </th>
                <th style="text-align:center;vertical-align: middle;"> Neg </th>
                <th style="text-align:center;vertical-align: middle;"> Pos </th>
                <th style="text-align:center;vertical-align: middle;"> Neg </th>
                <th style="text-align:center;vertical-align: middle;"> Pos </th>
                <th style="text-align:center;vertical-align: middle;"> Neg </th>
                <th style="text-align:center;vertical-align: middle;"> Pos </th>
                <th style="text-align:center;vertical-align: middle;"> Neg </th>
                <th style="text-align:center;vertical-align: middle;"> Pos </th>
                <th style="text-align:center;vertical-align: middle;"> Neg </th>
                <th style="text-align:center;vertical-align: middle;"> Pos </th>
                <th style="text-align:center;vertical-align: middle;"> Neg </th>
                <th style="text-align:center;vertical-align: middle;"> Pos </th>
                <th style="text-align:center;vertical-align: middle;"> Neg </th>
                <th style="text-align:center;vertical-align: middle;"> Pos </th>
                <th style="text-align:center;vertical-align: middle;"> Neg </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $tglsekarang = 'sekarang';
            
            //Berdasarkan Donor Ke
            $satu = 1;
            $lebihdarisatu = !1;

            //Berdasarkan Golongan Darah
            $goldarahA = 'A';
            $goldarahB = 'B';
            $goldarahO = 'O';
            $goldarahAB = 'AB';
            
            //Berdasarkan Rhesus
            $Positif = 'Positif';
            $Negatif = 'Negatif';
            ?>  
            <tr>
                <td style="text-align:center; font-weight:bold;"> 1. </td>
                <td style="text-align:left; font-weight:bold; width:110px !important;">< 18 Tahun</td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['umur<18'])  ? $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['umur<18']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['umur<18'])  ? $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['umur<18']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['umur<18'])  ? $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['umur<18']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['umur<18'])  ? $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['umur<18']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['umur<18'])  ? $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['umur<18']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['umur<18'])  ? $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['umur<18']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['umur<18']) ? $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['umur<18'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['umur<18']) ? $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['umur<18'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['umur<18'])  ? $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['umur<18']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['umur<18'])  ? $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['umur<18']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['umur<18'])  ? $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['umur<18']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['umur<18'])  ? $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['umur<18']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['umur<18'])  ? $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['umur<18']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['umur<18'])  ? $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['umur<18']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['umur<18']) ? $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['umur<18'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['umur<18']) ? $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['umur<18'] : ""; ?></td>
                
            </tr>
            <tr>
                <td style="text-align:center; font-weight:bold;"> 2. </td>
                <td style="text-align:left; font-weight:bold; width:110px !important;">18 - 24 Tahun</td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['18sampai24'])  ? $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['18sampai24'])  ? $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['18sampai24'])  ? $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['18sampai24'])  ? $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['18sampai24'])  ? $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['18sampai24'])  ? $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['18sampai24']) ? $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['18sampai24'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['18sampai24']) ? $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['18sampai24'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['18sampai24'])  ? $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['18sampai24'])  ? $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['18sampai24'])  ? $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['18sampai24'])  ? $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['18sampai24'])  ? $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['18sampai24'])  ? $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['18sampai24']) ? $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['18sampai24'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['18sampai24']) ? $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['18sampai24'] : ""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center; font-weight:bold;"> 3. </td>
                <td style="text-align:left; font-weight:bold; width:110px !important;">25 - 44 Tahun</td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['25sampai44'])  ? $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['25sampai44'])  ? $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['25sampai44'])  ? $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['25sampai44'])  ? $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['25sampai44'])  ? $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['25sampai44'])  ? $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['25sampai44']) ? $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['25sampai44'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['25sampai44']) ? $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['25sampai44'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['25sampai44'])  ? $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['25sampai44'])  ? $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['25sampai44'])  ? $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['25sampai44'])  ? $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['25sampai44'])  ? $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['25sampai44'])  ? $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['25sampai44']) ? $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['25sampai44'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['25sampai44']) ? $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['25sampai44'] : ""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center; font-weight:bold;"> 4. </td>
                <td style="text-align:left; font-weight:bold; width:110px !important;">45 - 59 Tahun</td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['45sampai59'])  ? $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['45sampai59']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['45sampai59'])  ? $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['45sampai59']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['45sampai59'])  ? $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['45sampai59']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['45sampai59'])  ? $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['45sampai59']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['45sampai59'])  ? $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['45sampai59']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['45sampai59'])  ? $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['45sampai59']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['45sampai59']) ? $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['45sampai59'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['45sampai59']) ? $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['45sampai59'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['45sampai59'])  ? $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['45sampai59']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['45sampai59'])  ? $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['45sampai59']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['45sampai59'])  ? $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['45sampai59']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['45sampai59'])  ? $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['45sampai59']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['45sampai59'])  ? $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['45sampai59']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['45sampai59'])  ? $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['45sampai59']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['45sampai59']) ? $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['45sampai59'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['45sampai59']) ? $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['45sampai59'] : ""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center; font-weight:bold;"> 5. </td>
                <td style="text-align:left; font-weight:bold; width:110px !important;"> 60 Tahun Keatas</td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['lebih61'])  ? $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['lebih61']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['lebih61'])  ? $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['lebih61']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['lebih61'])  ? $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['lebih61']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['lebih61'])  ? $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['lebih61']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['lebih61'])  ? $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['lebih61']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['lebih61'])  ? $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['lebih61']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['lebih61']) ? $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['lebih61'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['lebih61']) ? $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['lebih61'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['lebih61'])  ? $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['lebih61']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['lebih61'])  ? $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['lebih61']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['lebih61'])  ? $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['lebih61']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['lebih61'])  ? $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['lebih61']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['lebih61'])  ? $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['lebih61']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['lebih61'])  ? $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['lebih61']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['lebih61']) ? $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['lebih61'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['lebih61']) ? $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['lebih61'] : ""; ?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center; font-weight:bold;"> JUMLAH </td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['jumlah'])  ? $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['jumlah']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['jumlah'])  ? $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['jumlah']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['jumlah'])  ? $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['jumlah']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['jumlah'])  ? $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['jumlah']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['jumlah'])  ? $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['jumlah']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['jumlah'])  ? $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['jumlah']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['jumlah']) ? $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['jumlah'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['jumlah']) ? $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['jumlah'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['jumlah'])  ? $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['jumlah']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['jumlah'])  ? $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['jumlah']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['jumlah'])  ? $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['jumlah']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['jumlah'])  ? $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['jumlah']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['jumlah'])  ? $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['jumlah']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['jumlah'])  ? $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['jumlah']  : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['jumlah']) ? $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['jumlah'] : ""; ?></td>
                <td style="text-align:center;"><?php echo isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['jumlah']) ? $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['jumlah'] : ""; ?></td>
            </tr>
        </tbody>
    </table>
</div>