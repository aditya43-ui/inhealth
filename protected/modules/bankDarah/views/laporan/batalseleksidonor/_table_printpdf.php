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
                <th rowspan="3" style="text-align:center; vertical-align: middle"> NO </th>
                <th rowspan="3" style="text-align:center; vertical-align: middle"> ALASAN BATAL </th>
                <th colspan="10" style="text-align:center; vertical-align: middle"> BARU</th>
                <th colspan="10" style="text-align:center; vertical-align: middle"> ULANG</th>
            </tr>
            <tr>
                <th colspan="2" style="text-align:center;vertical-align: middle"> 17 Th </th>
                <th colspan="2" style="text-align:center;vertical-align: middle"> 18-24 Th </th>
                <th colspan="2" style="text-align:center;vertical-align: middle"> 25-44 Th </th>
                <th colspan="2" style="text-align:center;vertical-align: middle"> 45-64 Th </th>
                <th colspan="2" style="text-align:center;vertical-align: middle"> > 65 Th </th>
                <th colspan="2" style="text-align:center;vertical-align: middle"> 17 Th </th>
                <th colspan="2" style="text-align:center;vertical-align: middle"> 18-24 Th </th>
                <th colspan="2" style="text-align:center;vertical-align: middle"> 25-44 Th </th>
                <th colspan="2" style="text-align:center;vertical-align: middle"> 45-64 Th </th>
                <th colspan="2" style="text-align:center;vertical-align: middle"> > 65 Th </th>
            </tr>
            <tr>
                <th style="text-align:center;vertical-align: middle"> LK </th>
                <th style="text-align:center;vertical-align: middle"> PR </th>
                <th style="text-align:center;vertical-align: middle"> LK </th>
                <th style="text-align:center;vertical-align: middle"> PR </th>
                <th style="text-align:center;vertical-align: middle"> LK </th>
                <th style="text-align:center;vertical-align: middle"> PR </th>
                <th style="text-align:center;vertical-align: middle"> LK </th>
                <th style="text-align:center;vertical-align: middle"> PR </th>
                <th style="text-align:center;vertical-align: middle"> LK </th>
                <th style="text-align:center;vertical-align: middle"> PR </th>
                <th style="text-align:center;vertical-align: middle"> LK </th>
                <th style="text-align:center;vertical-align: middle"> PR </th>
                <th style="text-align:center;vertical-align: middle"> LK </th>
                <th style="text-align:center;vertical-align: middle"> PR </th>
                <th style="text-align:center;vertical-align: middle"> LK </th>
                <th style="text-align:center;vertical-align: middle"> PR </th>
                <th style="text-align:center;vertical-align: middle"> LK </th>
                <th style="text-align:center;vertical-align: middle"> PR </th>
                <th style="text-align:center;vertical-align: middle"> LK </th>
                <th style="text-align:center;vertical-align: middle"> PR </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $tglsekarang = 'sekarang';
            
            //Berdasarkan Donor Ke
            $baru = 0;
            $lama = 1;

            //Berdasarkan bb_rendah
            $bb_rendah = 'bb_rendah';
            $usia_kurang = 'usia_kurang';
            $hb_rendah = 'hb_rendah';
            $medis_tk_tinggi = 'medis_tk_tinggi';
            $medis_td_rendah = 'medis_td_rendah';
            $minum_obat = 'minum_obat';
            $medis_pasca_op = 'medis_pasca_op';
            $medis_hb_17 = 'medis_hb_17';
            $medis_vaksin = 'medis_vaksin';
            $perilakuberesiko_homo = 'perilakuberesiko_homo';
            $perilakuberesiko_tatto = 'perilakuberesiko_tatto';
            $perilakuberesiko_freesx = 'perilakuberesiko_freesx';
            $perilakuberesiko_penasun = 'perilakuberesiko_penasun';
            $perilakuberesiko_napi = 'perilakuberesiko_napi';
            $riwbepergian_endemik = 'riwbepergian_endemik';
            $riwbepergian_hiv = 'riwbepergian_hiv';
            $riwbepergian_sapigila = 'riwbepergian_sapigila';
            $lain_lain_tdkkembali = 'lain_lain_tdkkembali';
            $lain_lain_donortua = 'lain_lain_donortua';
            
            //Jenis Kelamin
            $laki = strtolower(Params::JENIS_KELAMIN_LAKI_LAKI);
            $perempuan = strtolower(Params::JENIS_KELAMIN_PEREMPUAN);
            ?>  
            <tr>
                <td style="text-align:center; "> 1. </td>
                <td style="text-align:left;   width:110px !important">BB < 45 Kg</td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['umur17'])          ? $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['umur17'])     ? $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['18sampai24'])      ? $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['18sampai24']) ? $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['25sampai44'])      ? $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['25sampai44']) ? $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['45sampai64'])      ? $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['45sampai64']) ? $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['lebih65'])         ? $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['lebih65'])    ? $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['lebih65']     : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['umur17'])          ? $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['umur17'])     ? $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['18sampai24'])      ? $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['18sampai24']) ? $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['25sampai44'])      ? $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['25sampai44']) ? $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['45sampai64'])      ? $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['45sampai64']) ? $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['lebih65'])         ? $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['lebih65'])    ? $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['lebih65']     : ""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center; "> 2. </td>
                <td style="text-align:left;   width:110px !important">USIA < 17 Thn</td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['umur17'])          ? $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['umur17'])     ? $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['18sampai24'])      ? $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['18sampai24']) ? $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['25sampai44'])      ? $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['25sampai44']) ? $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['45sampai64'])      ? $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['45sampai64']) ? $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['lebih65'])         ? $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['lebih65'])    ? $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['lebih65']     : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['umur17'])          ? $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['umur17'])     ? $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['18sampai24'])      ? $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['18sampai24']) ? $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['25sampai44'])      ? $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['25sampai44']) ? $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['45sampai64'])      ? $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['45sampai64']) ? $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['lebih65'])         ? $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['lebih65'])    ? $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['lebih65']     : ""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center; "> 3. </td>
                <td style="text-align:left;   width:110px !important">Hb < 12,5 gr%</td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['umur17'])          ? $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['umur17'])     ? $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['18sampai24'])      ? $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['18sampai24']) ? $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['25sampai44'])      ? $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['25sampai44']) ? $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['45sampai64'])      ? $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['45sampai64']) ? $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['lebih65'])         ? $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['lebih65'])    ? $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['lebih65']     : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['umur17'])          ? $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['umur17'])     ? $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['18sampai24'])      ? $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['18sampai24']) ? $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['25sampai44'])      ? $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['25sampai44']) ? $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['45sampai64'])      ? $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['45sampai64']) ? $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['lebih65'])         ? $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['lebih65'])    ? $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['lebih65']     : ""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center; "> 4. </td>
                <td style="text-align:left;   width:110px !important">MEDIS LAIN : </td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
            </tr>
            <tr>
                <td style="text-align:center; "> </td>
                <td style="text-align:left;   width:110px !important">a. Hypertensi </td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['umur17'])          ? $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['umur17'])     ? $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['18sampai24'])      ? $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['18sampai24']) ? $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['25sampai44'])      ? $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['25sampai44']) ? $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['45sampai64'])      ? $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['45sampai64']) ? $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['lebih65'])         ? $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['lebih65'])    ? $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['lebih65']     : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['umur17'])          ? $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['umur17'])     ? $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['18sampai24'])      ? $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['18sampai24']) ? $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['25sampai44'])      ? $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['25sampai44']) ? $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['45sampai64'])      ? $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['45sampai64']) ? $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['lebih65'])         ? $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['lebih65'])    ? $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['lebih65']     : ""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center; "> </td>
                <td style="text-align:left;   width:110px !important">b. Hypotensi </td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['umur17'])          ? $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['umur17'])     ? $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['18sampai24'])      ? $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['18sampai24']) ? $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['25sampai44'])      ? $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['25sampai44']) ? $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['45sampai64'])      ? $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['45sampai64']) ? $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['lebih65'])         ? $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['lebih65'])    ? $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['lebih65']     : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['umur17'])          ? $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['umur17'])     ? $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['18sampai24'])      ? $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['18sampai24']) ? $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['25sampai44'])      ? $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['25sampai44']) ? $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['45sampai64'])      ? $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['45sampai64']) ? $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['lebih65'])         ? $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['lebih65'])    ? $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['lebih65']     : ""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center; "> </td>
                <td style="text-align:left;   width:110px !important">c. Minum Obat </td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['umur17'])          ? $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['umur17'])     ? $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['18sampai24'])      ? $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['18sampai24']) ? $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['25sampai44'])      ? $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['25sampai44']) ? $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['45sampai64'])      ? $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['45sampai64']) ? $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['lebih65'])         ? $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['lebih65'])    ? $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['lebih65']     : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['umur17'])          ? $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['umur17'])     ? $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['18sampai24'])      ? $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['18sampai24']) ? $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['25sampai44'])      ? $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['25sampai44']) ? $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['45sampai64'])      ? $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['45sampai64']) ? $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['lebih65'])         ? $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['lebih65'])    ? $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['lebih65']     : ""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center; "> </td>
                <td style="text-align:left;   width:110px !important">d. Pasca Op </td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['umur17'])          ? $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['umur17'])     ? $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['18sampai24'])      ? $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['18sampai24']) ? $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['25sampai44'])      ? $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['25sampai44']) ? $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['45sampai64'])      ? $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['45sampai64']) ? $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['lebih65'])         ? $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['lebih65'])    ? $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['lebih65']     : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['umur17'])          ? $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['umur17'])     ? $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['18sampai24'])      ? $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['18sampai24']) ? $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['25sampai44'])      ? $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['25sampai44']) ? $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['45sampai64'])      ? $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['45sampai64']) ? $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['lebih65'])         ? $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['lebih65'])    ? $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['lebih65']     : ""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center; "> </td>
                <td style="text-align:left;   width:110px !important">e. Hb > 17,0 gr% </td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['umur17'])          ? $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['umur17'])     ? $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['18sampai24'])      ? $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['18sampai24']) ? $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['25sampai44'])      ? $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['25sampai44']) ? $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['45sampai64'])      ? $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['45sampai64']) ? $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['lebih65'])         ? $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['lebih65'])    ? $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['lebih65']     : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['umur17'])          ? $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['umur17'])     ? $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['18sampai24'])      ? $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['18sampai24']) ? $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['25sampai44'])      ? $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['25sampai44']) ? $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['45sampai64'])      ? $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['45sampai64']) ? $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['lebih65'])         ? $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['lebih65'])    ? $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['lebih65']     : ""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center; "> </td>
                <td style="text-align:left;   width:110px !important">f. Sakit/vaksin/haid/busui </td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['umur17'])          ? $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['umur17'])     ? $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['18sampai24'])      ? $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['18sampai24']) ? $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['25sampai44'])      ? $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['25sampai44']) ? $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['45sampai64'])      ? $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['45sampai64']) ? $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['lebih65'])         ? $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['lebih65'])    ? $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['lebih65']     : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['umur17'])          ? $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['umur17'])     ? $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['18sampai24'])      ? $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['18sampai24']) ? $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['25sampai44'])      ? $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['25sampai44']) ? $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['45sampai64'])      ? $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['45sampai64']) ? $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['lebih65'])         ? $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['lebih65'])    ? $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['lebih65']     : ""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center; "> 5. </td>
                <td style="text-align:left;   width:110px !important">PERILAKU BERESIKO : </td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
            </tr>
            <tr>
                <td style="text-align:center; "> </td>
                <td style="text-align:left;   width:110px !important">a. Homo </td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['umur17'])          ? $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['umur17'])     ? $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['18sampai24'])      ? $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['18sampai24']) ? $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['25sampai44'])      ? $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['25sampai44']) ? $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['45sampai64'])      ? $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['45sampai64']) ? $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['lebih65'])         ? $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['lebih65'])    ? $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['lebih65']     : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['umur17'])          ? $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['umur17'])     ? $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['18sampai24'])      ? $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['18sampai24']) ? $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['25sampai44'])      ? $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['25sampai44']) ? $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['45sampai64'])      ? $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['45sampai64']) ? $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['lebih65'])         ? $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['lebih65'])    ? $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['lebih65']     : ""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center; "> </td>
                <td style="text-align:left;   width:110px !important">b. Tatto </td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['umur17'])          ? $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['umur17'])     ? $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['18sampai24'])      ? $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['18sampai24']) ? $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['25sampai44'])      ? $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['25sampai44']) ? $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['45sampai64'])      ? $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['45sampai64']) ? $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['lebih65'])         ? $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['lebih65'])    ? $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['lebih65']     : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['umur17'])          ? $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['umur17'])     ? $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['18sampai24'])      ? $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['18sampai24']) ? $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['25sampai44'])      ? $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['25sampai44']) ? $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['45sampai64'])      ? $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['45sampai64']) ? $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['lebih65'])         ? $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['lebih65'])    ? $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['lebih65']     : ""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center; "> </td>
                <td style="text-align:left;   width:110px !important">c. Free Sx </td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['umur17'])          ? $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['umur17'])     ? $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['18sampai24'])      ? $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['18sampai24']) ? $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['25sampai44'])      ? $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['25sampai44']) ? $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['45sampai64'])      ? $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['45sampai64']) ? $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['lebih65'])         ? $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['lebih65'])    ? $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['lebih65']     : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['umur17'])          ? $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['umur17'])     ? $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['18sampai24'])      ? $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['18sampai24']) ? $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['25sampai44'])      ? $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['25sampai44']) ? $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['45sampai64'])      ? $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['45sampai64']) ? $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['lebih65'])         ? $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['lebih65'])    ? $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['lebih65']     : ""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center; "> </td>
                <td style="text-align:left;   width:110px !important">d. Penasun </td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['umur17'])          ? $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['umur17'])     ? $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['18sampai24'])      ? $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['18sampai24']) ? $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['25sampai44'])      ? $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['25sampai44']) ? $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['45sampai64'])      ? $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['45sampai64']) ? $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['lebih65'])         ? $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['lebih65'])    ? $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['lebih65']     : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['umur17'])          ? $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['umur17'])     ? $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['18sampai24'])      ? $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['18sampai24']) ? $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['25sampai44'])      ? $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['25sampai44']) ? $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['45sampai64'])      ? $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['45sampai64']) ? $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['lebih65'])         ? $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['lebih65'])    ? $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['lebih65']     : ""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center; "> </td>
                <td style="text-align:left;   width:110px !important">e. Napi </td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['umur17'])          ? $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['umur17'])     ? $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['18sampai24'])      ? $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['18sampai24']) ? $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['25sampai44'])      ? $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['25sampai44']) ? $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['45sampai64'])      ? $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['45sampai64']) ? $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['lebih65'])         ? $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['lebih65'])    ? $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['lebih65']     : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['umur17'])          ? $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['umur17'])     ? $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['18sampai24'])      ? $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['18sampai24']) ? $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['25sampai44'])      ? $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['25sampai44']) ? $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['45sampai64'])      ? $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['45sampai64']) ? $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['lebih65'])         ? $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['lebih65'])    ? $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['lebih65']     : ""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center; "> 6. </td>
                <td style="text-align:left;   width:110px !important">RIWAYAT BEPERGIAN : </td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
            </tr>
            <tr>
                <td style="text-align:center; "> </td>
                <td style="text-align:left;   width:110px !important">a. Daerah Endemik </td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['umur17'])          ? $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['umur17'])     ? $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['18sampai24'])      ? $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['18sampai24']) ? $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['25sampai44'])      ? $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['25sampai44']) ? $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['45sampai64'])      ? $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['45sampai64']) ? $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['lebih65'])         ? $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['lebih65'])    ? $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['lebih65']     : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['umur17'])          ? $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['umur17'])     ? $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['18sampai24'])      ? $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['18sampai24']) ? $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['25sampai44'])      ? $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['25sampai44']) ? $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['45sampai64'])      ? $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['45sampai64']) ? $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['lebih65'])         ? $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['lebih65'])    ? $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['lebih65']     : ""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center; "> </td>
                <td style="text-align:left;   width:110px !important">b. Negara dg Kasus HIV </td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['umur17'])          ? $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['umur17'])     ? $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['18sampai24'])      ? $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['18sampai24']) ? $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['25sampai44'])      ? $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['25sampai44']) ? $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['45sampai64'])      ? $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['45sampai64']) ? $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['lebih65'])         ? $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['lebih65'])    ? $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['lebih65']     : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['umur17'])          ? $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['umur17'])     ? $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['18sampai24'])      ? $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['18sampai24']) ? $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['25sampai44'])      ? $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['25sampai44']) ? $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['45sampai64'])      ? $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['45sampai64']) ? $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['lebih65'])         ? $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['lebih65'])    ? $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['lebih65']     : ""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center; "> </td>
                <td style="text-align:left;   width:110px !important">c. Negara dg Kasus Sapi Gila </td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['umur17'])          ? $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['umur17'])     ? $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['18sampai24'])      ? $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['18sampai24']) ? $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['25sampai44'])      ? $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['25sampai44']) ? $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['45sampai64'])      ? $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['45sampai64']) ? $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['lebih65'])         ? $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['lebih65'])    ? $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['lebih65']     : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['umur17'])          ? $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['umur17'])     ? $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['18sampai24'])      ? $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['18sampai24']) ? $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['25sampai44'])      ? $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['25sampai44']) ? $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['45sampai64'])      ? $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['45sampai64']) ? $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['lebih65'])         ? $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['lebih65'])    ? $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['lebih65']     : ""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center; "> 7. </td>
                <td style="text-align:left;   width:110px !important">LAIN-LAIN : </td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
                <td style="text-align:center; "></td>
            </tr>
            <tr>
                <td style="text-align:center; "> </td>
                <td style="text-align:left;   width:110px !important">a. Tidak Kembali </td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['umur17'])          ? $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['umur17'])     ? $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['18sampai24'])      ? $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['18sampai24']) ? $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['25sampai44'])      ? $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['25sampai44']) ? $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['45sampai64'])      ? $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['45sampai64']) ? $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['lebih65'])         ? $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['lebih65'])    ? $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['lebih65']     : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['umur17'])          ? $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['umur17'])     ? $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['18sampai24'])      ? $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['18sampai24']) ? $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['25sampai44'])      ? $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['25sampai44']) ? $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['45sampai64'])      ? $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['45sampai64']) ? $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['lebih65'])         ? $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['lebih65'])    ? $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['lebih65']     : ""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center; "> </td>
                <td style="text-align:left;   width:110px !important">b.&nbsp;Donor&nbsp;Pertama&nbsp;Usia&nbsp;>&nbsp;65&nbsp;Th </td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['umur17'])          ? $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['umur17'])     ? $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['18sampai24'])      ? $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['18sampai24']) ? $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['25sampai44'])      ? $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['25sampai44']) ? $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['45sampai64'])      ? $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['45sampai64']) ? $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['lebih65'])         ? $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['lebih65'])    ? $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['lebih65']     : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['umur17'])          ? $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['umur17']           : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['umur17'])     ? $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['umur17']      : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['18sampai24'])      ? $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['18sampai24']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['18sampai24']) ? $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['18sampai24']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['25sampai44'])      ? $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['25sampai44']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['25sampai44']) ? $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['25sampai44']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['45sampai64'])      ? $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['45sampai64']       : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['45sampai64']) ? $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['45sampai64']  : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['lebih65'])         ? $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['lebih65']          : ""; ?></td>
                <td style="text-align:center; "><?php echo isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['lebih65'])    ? $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['lebih65']     : ""; ?></td>
            </tr>
        </tbody>
    </table>
</div>