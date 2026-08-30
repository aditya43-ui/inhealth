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
    #tableLaporan{
        font-size: 8px !important;
    }
    
</style>
<table width="100%" class="border" border="1px solid" id="tableLaporan" >    
    <thead>
        <tr>
            <th style="text-align: center"> No. </th>
            <th style="text-align: center"> Alasan Penolakan </th>
            <th style="text-align: center"> Jumlah </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $hb_rendah = 'hb_rendah';
        $bb_rendah = 'bb_rendah';
        $medis_hb_17 = 'medis_hb_17';
        $medis_td_rendah = 'medis_td_rendah';
        $medis_tk_tinggi = 'medis_tk_tinggi';
        $medis_bb_lebih = 'medis_bb_lebih';
        $medis_vaksin = 'medis_vaksin';
        $perilakuberesiko = 'perilakuberesiko';
        $riwberpergian = 'riwberpergian';
        $lain_lain = 'lain_lain';
        ?>
        <tr>
            <td style="text-align:center;"> 1. </td>
            <td> Berat badan (< 45 kg) </td>
            <td style="text-align:center;"><?php echo isset($b['det']["$bb_rendah"]['jumlah']) ? $b['det']["$bb_rendah"]['jumlah'] : ""; ?></td>
        </tr>
        <tr>
            <td style="text-align:center;"> 2. </td>
            <td> Usia < 17 Tahun </td>
            <td style="text-align:center;"><?php echo isset($b['det']["$medis_hb_17"]['jumlah']) ? $b['det']["$medis_hb_17"]['jumlah'] : ""; ?></td>
        </tr>
        <tr>
            <td style="text-align:center;"> 3. </td>
            <td> Kadar Hb Rendah (> 12,5 Gr/dl)</td>
            <td style="text-align:center;"><?php echo isset($b['det']["$hb_rendah"]['jumlah']) ? $b['det']["$hb_rendah"]['jumlah'] : ""; ?></td>
        </tr>
        <tr>
            <td style="text-align:center;"> 4. </td>
            <td> Riwayat Medis Lain (Hipertensi, Hipotensi, Minum Obat, Pasca Operasi, Kadar Hb > 17 Gr / dl) </td>
            <td style="text-align:center;"><?php echo isset($b['det']["$medis_hb_17"]['jumlah']) ? $b['det']["$medis_hb_17"]['jumlah'] : ""; ?></td>
        </tr>
        <tr>
            <td style="text-align:center;"> 5. </td>
            <td> Perilaku Beresiko Tinggi (Homo Seksual, Tato/Tindik Kurang dari 6 Bulan, Sex Bebas, Penasun, Napi) </td>
            <td style="text-align:center;"><?php echo isset($b['det']["$perilakuberesiko"]['jumlah']) ? $b['det']["$perilakuberesiko"]['jumlah'] : ""; ?></td>
        </tr>
        <tr>
            <td style="text-align:center;"> 6. </td>
            <td> Riwayat Berpergian (Daerah Endemis Malaria, Negara dengan Kasus HIV Tinggi, Negara Dengan Kasus Sapi Gila) </td>
            <td style="text-align:center;"><?php echo isset($b['det']["$riwberpergian"]['jumlah']) ? $b['det']["$riwberpergian"]['jumlah'] : ""; ?></td>
        </tr>
        <tr>
            <td style="text-align:center;"> 7. </td>
            <td> Alasan Lain (Gagal Pengambilan darah) </td>
            <td style="text-align:center;"><?php echo isset($b['det']["$lain_lain"]['jumlah']) ? $b['det']["$lain_lain"]['jumlah'] : ""; ?></td>
        </tr>
    </tbody>
</table>