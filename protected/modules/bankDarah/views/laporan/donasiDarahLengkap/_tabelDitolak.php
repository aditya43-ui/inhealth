<style>
    tr:last-child > td:first-child{
        border-bottom-left-radius: 0px !important;
        border-bottom-right-radius: 0px !important;
    }
</style>
<div>
<?php 
    $style = 'table table-bordered table-condensed';
    if (!empty($_GET['caraPrint'])) {
        $style = 'table';
    } 
?>
    <table width="100%" class="table table-bordered table-condensed" border="1px" >
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
                <td style="text-align:center;"><?php echo isset($b['det']["$bb_rendah"]['jumlah']) ? $b['det']["$bb_rendah"]['jumlah'] :""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center;"> 2. </td>
                <td> Usia < 17 Tahun </td>
                <td style="text-align:center;"><?php echo isset($b['det']["$medis_hb_17"]['jumlah']) ? $b['det']["$medis_hb_17"]['jumlah'] :""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center;"> 3. </td>
                <td> Kadar Hb Rendah (> 12,5 Gr/dl)</td>
                <td style="text-align:center;"><?php echo isset($b['det']["$hb_rendah"]['jumlah']) ? $b['det']["$hb_rendah"]['jumlah'] :""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center;"> 4. </td>
                <td> Riwayat Medis Lain (Hipertensi, Hipotensi, Minum Obat, Pasca Operasi, Kadar Hb > 17 Gr / dl) </td>
                <td style="text-align:center;"><?php echo isset($b['det']["$medis_hb_17"]['jumlah']) ? $b['det']["$medis_hb_17"]['jumlah'] :""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center;"> 5. </td>
                <td> Perilaku Beresiko Tinggi (Homo Seksual, Tato/Tindik Kurang dari 6 Bulan, Sex Bebas, Penasun, Napi) </td>
                <td style="text-align:center;"><?php echo isset($b['det']["$perilakuberesiko"]['jumlah']) ? $b['det']["$perilakuberesiko"]['jumlah'] :""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center;"> 6. </td>
                <td> Riwayat Berpergian (Daerah Endemis Malaria, Negara dengan Kasus HIV Tinggi, Negara Dengan Kasus Sapi Gila) </td>
                <td style="text-align:center;"><?php echo isset($b['det']["$riwberpergian"]['jumlah']) ? $b['det']["$riwberpergian"]['jumlah'] :""; ?></td>
            </tr>
            <tr>
                <td style="text-align:center;"> 7. </td>
                <td> Alasan Lain (Gagal Pengambilan darah) </td>
                <td style="text-align:center;"><?php echo isset($b['det']["$lain_lain"]['jumlah']) ? $b['det']["$lain_lain"]['jumlah'] :""; ?></td>
            </tr>
        </tbody>
    </table>
</div>

