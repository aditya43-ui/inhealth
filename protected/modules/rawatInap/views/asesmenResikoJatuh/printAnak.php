<?php
/**
 * view untuk menampilkan data ke dalam bentuk prinout (khusus anak)
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @link    <http://innovamedika.com>
 */
?>

<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
@page {
   size: 7in 9.25in;
   margin: 27mm 16mm 27mm 16mm;
}
@media print {
  html, body {
    width: 210mm;
    height: 297mm;
  }
  div.footer {
        position: fixed;
        bottom: 0;
    }
}
table.footer {
    position: fixed;
    bottom: 0;
}

.text1 {
    writing-mode:tb-rl;
    -webkit-transform:rotate(-90deg);
    -moz-transform:rotate(-90deg);
    -o-transform: rotate(-90deg);
    -ms-transform:rotate(-90deg);
    transform: rotate(180deg);
    white-space:nowrap;
    float:left;
}

</style>

<table width="100%" border="1">
    <tr>
        <td rowspan="3" style="width:70%"><?php echo $this->renderPartial('rawatInap.views.asesmenResikoJatuh._headerPrint'); ?></td>
        <td style="width:20%">Nama Lengkap</td>
        <td style="width:30%"><?php echo $modPasien->nama_pasien; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Tgl. Lahir </td>
        <td style="width:30%"><?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?></td>
    </tr>
    <tr>
        <td style="width:20%">No. Rekam Medik</td>
        <td style="width:30%"><?php echo $modPasien->no_rekam_medik; ?></td>
    </tr>
</table>
<span style="float:right; padding-top: 10px;"><h4>RM 05b</h4></span>
<div style="padding-top: 10px; padding-bottom: 10px; text-align:center; font-weight:bold">
    <h4 style='padding-left:35px'>ASESMEN PASIEN JATUH KHUSUS ANAK</h4><br>
    <h5 style='margin-top:-15px'><i>RISK FALL FOR CHILD</i></h5>
</div>
<table width="100%" class="table-condensed" border="1px">
    <tr style="background-color:#afdc7e">
        <td colspan='12'>Diisi oleh Perawat</td>
    </tr>
    <tr>
        <td colspan='12'>
            Lakukan pengkajian risiko jatuh pada saat pasien masuk, terdapat perubahan kondisi pasien/terapi, pasien <br>
            dipindahkan ke ruangan/departemen lain, pasien risiko tinggi setiap 24jam atau sesaat setelah terjadi kasus jatuh.<br>
            <b>Skor  :  0 -24  Tidak Ada Risiko (TR)<br>
                        7 -11 Resiko Rendah (RR)<br>
                        ≥ 12  Resiko Tinggi (RT)</b>
        </td>
    </tr>
    <tr>
        <td rowspan='13'>
            <b class="text1" style="padding:10px;">SKOR RISIKO JATUH</b>
        </td>
        <td colspan="3" rowspan="2"><b><p style="margin: 0; text-align: center;">Pengkajian Faktor Risiko</p></b></td>
        
        <td width="10px"><b>Tgl</b></td>
        <?php if(count((array)$model)>0){

                foreach ($model as $value){
                    echo "<td>"; echo date('d M Y', strtotime( isset($value->tgl_skoring) ? $value->tgl_skoring:"-")); 
                    echo "</td>";
                    
                }
            }
        ?>
    </tr>
    <tr>
        
        <td><b>jam</b></td>
        <?php if(count((array)$model)>0){

                foreach ($model as $value){
                    echo "<td>"; echo date('H:i:s', strtotime( isset($value->tgl_skoring) ? $value->tgl_skoring:"-"));
                    echo "</td>";
                    
                }
            }
        ?>
    </tr>
    <tr>
        <td>Riwayat jatuh</td>
        <td colspan="2">Kejadian jatuh dalam 3 bulan terakhir</td>
        <td>25</td>
        <?php if(count((array)$model)>0){
                foreach ($model as $value){
                    echo "<td>"; echo isset($value->riwayatjatuh_skor) ? $value->riwayatjatuh_skor:"-"; 
                    echo "</td>";
                    
                }
            }
        ?>
    </tr>
    <tr>
        <td>Status mental</td>
        <td colspan="2">Tidak konsisten perintah</td>
        <td>15</td>
        <?php if(count((array)$model)>0){
                foreach ($model as $value){
                    echo "<td>"; echo isset($value->statusmental_skor) ? $value->statusmental_skor:"-"; 
                    echo "</td>";
                    
                }
            }
        ?>
    </tr>
    <tr>
        <td rowspan="2">Pengobatan<br><span style="color:transparent">:</span></td>
        <td colspan="2">Efek samping obat</td>
        <td>20</td>
        <?php if(count((array)$model)>0){
                foreach ($model as $value){
                    if($value->pengobatan_keterangan == 'Efek Samping Obat'){
                        echo "<td>"; echo isset($value->pengobatan_skor) ? $value->pengobatan_skor:"-"; 
                        echo "</td>";
                    } else{
                        echo "<td>0</td>";
                    }
                }
            }
        ?>
    </tr>
    <tr>
        <td colspan="2">Post GA/RA (24 jam)</td>
        <td>45</td>
        <?php if(count((array)$model)>0){
                foreach ($model as $value){
                    if($value->pengobatan_keterangan == 'Post GA/ RA (24 Jam)'){
                        echo "<td>"; echo isset($value->pengobatan_skor) ? $value->pengobatan_skor:"-"; 
                        echo "</td>";
                    } else{
                        echo "<td>0</td>";
                    }
                }
            }
        ?>
    </tr>
    <tr>
        <td rowspan="4">Mobilitas</td>
        <td rowspan="2">Gaya berjalan</td>
        <td>Kelemahan</td>
        <td>10</td>
        <?php if(count((array)$model)>0){
                foreach ($model as $value){
                    if($value->mobgayaberjalan_keterangan == 'Kelemahan'){
                        echo "<td>"; echo isset($value->mobgayaberjalan_skor) ? $value->mobgayaberjalan_skor:"-"; 
                        echo "</td>";
                    } else{
                        echo "<td>0</td>";
                    }
                }
            }
        ?>
    </tr>
    <tr>
        <td>Kerusakan</td>
        <td>20</td>
        <?php if(count((array)$model)>0){
                foreach ($model as $value){
                    if($value->mobgayaberjalan_keterangan == 'Kerusakan'){
                        echo "<td>"; echo isset($value->mobgayaberjalan_skor) ? $value->mobgayaberjalan_skor:"-"; 
                        echo "</td>";
                    } else{
                        echo "<td>0</td>";
                    }
                }
            }
        ?>
    </tr>
    <tr>
        <td rowspan="2">Alat bantu</td>
        <td>Walker, tongkat</td>
        <td>15</td>
        <?php if(count((array)$model)>0){
                foreach ($model as $value){
                    if($value->mobilitasalatbantu_keterangan == 'Walker, Tongkat'){
                        echo "<td>"; echo isset($value->mobilitasalatbantu_skor) ? $value->mobilitasalatbantu_skor:"-"; 
                        echo "</td>";
                    } else{
                        echo "<td>0</td>";
                    }
                }
            }
        ?>
    </tr>
    <tr>
        <td>Kursi roda, berpegangan dinding</td>
        <td>30</td>
        <?php if(count((array)$model)>0){
                foreach ($model as $value){
                    if($value->mobilitasalatbantu_keterangan == 'Kursi Roda, Berpegangan Dinding'){
                        echo "<td>"; echo isset($value->mobilitasalatbantu_skor) ? $value->mobilitasalatbantu_skor:"-"; 
                        echo "</td>";
                    } else{
                        echo "<td>0</td>";
                    }
                }
            }
        ?>
    </tr>
    <tr>
        <td rowspan="2">Kondisi penyakit</td>
        <td colspan="2">Penyakit penyerta/penyulit</td>
        <td>15</td>
        <?php if(count((array)$model)>0){
                foreach ($model as $value){
                    if($value->kondisipenyakit_keterangan == 'Penyakit Penyerta/ Penyulit'){
                        echo "<td>"; echo isset($value->konsidipenyakit_skor) ? $value->konsidipenyakit_skor:"-"; 
                        echo "</td>";
                    } else{
                        echo "<td>0</td>";
                    }
                }
            }
        ?>
    </tr>
    <tr>
        <td colspan="2">Terapi intravena</td>
        <td>20</td>
        <?php if(count((array)$model)>0){
                foreach ($model as $value){
                    if($value->kondisipenyakit_keterangan == 'Terapi Intravena'){
                        echo "<td>"; echo isset($value->konsidipenyakit_skor) ? $value->konsidipenyakit_skor:"-"; 
                        echo "</td>";
                    } else{
                        echo "<td>0</td>";
                    }
                }
            }
        ?>
    </tr>
    <tr>
        <td colspan="3"><b><p style="margin: 0; text-align: center;">TOTAL SKOR</p></b></td>
        <td>215</td>
        <?php if(count((array)$model)>0){
                foreach ($model as $value){
                    echo "<td>"; echo isset($value->totalskor) ? $value->totalskor:"-"; 
                    echo "</td>";
                }
            }
        ?>
    </tr>
    <tr>
        <td colspan="5">Klasifikasi risiko jatuh berdasarkan skor</td>
        <?php if(count((array)$model)>0){
                foreach ($model as $value){
                    if($value->totalskor < 24){
                        echo "<td> <b>TR</b> </td>";
                    } else if ($value->totalskor < 45 && $value->totalskor > 24){
                        echo "<td> <b>RR</b> </td>";
                    } else if ($value->totalskor >= 45){
                        echo "<td> <b>RT</b> </td>";
                    }
                }
            }
        ?>
    </tr>
    
    <tr>
        <td colspan="5"><b><p style="margin: 0; text-align: center;">Paraf / Inisial Perawat</p></b></td> 
        <?php if(count((array)$model)>0){
                foreach ($model as $value){
                    echo "<td>"; echo isset($value->pegawai->nama_pegawai) ? $value->pegawai->nama_pegawai:"-"; 
                    echo "</td>";
                    
                }
            }
        ?>
    </tr>
    <tr>
        <td colspan="4" rowspan="2">
            Beri tanda (√) jika sudah dilakukan, (-) jika belum atau tidak <br> 
            dilakukan, (*) jika pasien menolak sekaligus berikan penjelasan.
        </td> 
        <td><b>Tgl</b></td>
        <?php if(count((array)$model)>0){

                foreach ($model as $value){
                    echo "<td>"; echo date('d M Y', strtotime( isset($value->tgl_skoring) ? $value->tgl_skoring:"-")); 
                    echo "</td>";
                    
                }
            }
        ?>
    </tr>
    <tr>
        <td><b>Jam</b></td>
        <?php if(count((array)$model)>0){

                foreach ($model as $value){
                    echo "<td>"; echo date('H:i:s', strtotime( isset($value->tgl_skoring) ? $value->tgl_skoring:"-")); 
                    echo "</td>";
                    
                }
            }
        ?>
    </tr>
    <tr>
        <td><p style="margin: 0; text-align: center;"><b>RT</b><br>a.</p></td>
        <td colspan="4"><span style="color:transparent">a</span><br>Memastikan tempat tidur/brankard dalam posisi rendah dan roda terkunci</td>
        <?php if(count((array)$model)>0){
                foreach ($model as $value){
                    if($value->imp_rt_rodaterkunci == 'BELUM/ TIDAK DILAKUKAN'){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>-</b></p> </td>";
                    } else if ($value->imp_rt_rodaterkunci == 'SUDAH DILAKUKAN' ){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>√</b></p> </td>";
                    } else if ($value->imp_rt_rodaterkunci == 'PASIEN MENOLAK SEKALIGUS DIBERIKAN PENJELASAN'){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>*</b></p> </td>";
                    }else {
                        echo "<td>  </td>";
                    }
                }
            }
        ?>
    </tr>
    <tr>
        <td><p style="margin: 0; text-align: center;">b.</p></td>
        <td colspan="4">Menutup pagar tempat tidur/brankard<br>
            - Beri tanda (√) apabila pagar sebelah kanan telah dinaikkan<br>
            - Beri tanda (√) apabila pagar sebelah kiri telah dinaikkan
        </td>
        <?php if(count((array)$model)>0){
                foreach ($model as $value){
                    if($value->imp_rt_menutuppagarbrankard_kanan == 'BELUM/ TIDAK DILAKUKAN'){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>-</b></p> <br>";
                    } else if ($value->imp_rt_menutuppagarbrankard_kanan == 'SUDAH DILAKUKAN' ){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>√</b></p> <br>";
                    } else if ($value->imp_rt_menutuppagarbrankard_kanan == 'PASIEN MENOLAK SEKALIGUS DIBERIKAN PENJELASAN'){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>*</b></p> <br>";
                    }else {
                        echo "<td>  <br>";
                    }
                }
            }
         if(count((array)$model)>0){
                foreach ($model as $value){
                    if($value->imp_rt_menutuppagarbrankard_kiri == 'BELUM/ TIDAK DILAKUKAN'){
                        echo " <p style='margin: 0; text-align: center;'><b>-</b></p> </td>";
                    } else if ($value->imp_rt_menutuppagarbrankard_kiri == 'SUDAH DILAKUKAN' ){
                        echo " <p style='margin: 0; text-align: center;'><b>√</b></p> </td>";
                    } else if ($value->imp_rt_menutuppagarbrankard_kiri == 'PASIEN MENOLAK SEKALIGUS DIBERIKAN PENJELASAN'){
                        echo " <p style='margin: 0; text-align: center;'><b>*</b></p> </td>";
                    }else {
                        echo "  </td>";
                    }
                }
            }
        ?>
    </tr>
    <tr>
        <td><p style="margin: 0; text-align: center;">c.</p></td>
        <td colspan="4">Orientasikan pasien/penunggu tentang lingkungan/ruangan</td>
        <?php if(count((array)$model)>0){
                foreach ($model as $value){
                    if($value->imp_rt_orientasikanpasien == 'BELUM/ TIDAK DILAKUKAN'){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>-</b></p> </td>";
                    } else if ($value->imp_rt_orientasikanpasien == 'SUDAH DILAKUKAN' ){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>√</b></p> </td>";
                    } else if ($value->imp_rt_orientasikanpasien == 'PASIEN MENOLAK SEKALIGUS DIBERIKAN PENJELASAN'){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>*</b></p> </td>";
                    }else {
                        echo "<td>  </td>";
                    }
                }
            }
        ?>
    </tr>
    <tr>
        <td><p style="margin: 0; text-align: center;">d.</p></td>
        <td colspan="4">Beri tanda segitiga kuning pada tempat tidur pasien</td>
        <?php if(count((array)$model)>0){
                foreach ($model as $value){
                    if($value->imp_rt_beritandasegitiakuning == 'BELUM/ TIDAK DILAKUKAN'){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>-</b></p> </td>";
                    } else if ($value->imp_rt_beritandasegitiakuning == 'SUDAH DILAKUKAN' ){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>√</b></p> </td>";
                    } else if ($value->imp_rt_beritandasegitiakuning == 'PASIEN MENOLAK SEKALIGUS DIBERIKAN PENJELASAN'){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>*</b></p> </td>";
                    }else {
                        echo "<td>  </td>";
                    }
                }
            }
        ?>
    </tr>
    <tr>
        <td><p style="margin: 0; text-align: center;">e.</p></td>
        <td colspan="4">Pastikan pasien memiliki pin warna kuning penanda risiko tinggi jatuh pada <br>gelang identifikasi</td>
        <?php if(count((array)$model)>0){
                foreach ($model as $value){
                    if($value->imp_rt_beripinkuning== 'BELUM/ TIDAK DILAKUKAN'){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>-</b></p> </td>";
                    } else if ($value->imp_rt_beripinkuning == 'SUDAH DILAKUKAN' ){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>√</b></p> </td>";
                    } else if ($value->imp_rt_beripinkuning == 'PASIEN MENOLAK SEKALIGUS DIBERIKAN PENJELASAN'){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>*</b></p> </td>";
                    }else {
                        echo "<td>  </td>";
                    }
                }
            }
        ?>
    </tr>
    <tr>
        <td><p style="margin: 0; text-align: center;">f.</p></td>
        <td colspan="4">Lakukan pemasangan fiksasi fisik apabila diperlukan dengan persetujuan <br>keluarga</td>
        <?php if(count((array)$model)>0){
                foreach ($model as $value){
                    if($value->imp_rt_pasangfiksasifisik == 'BELUM/ TIDAK DILAKUKAN'){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>-</b></p> </td>";
                    } else if ($value->imp_rt_pasangfiksasifisik == 'SUDAH DILAKUKAN' ){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>√</b></p> </td>";
                    } else if ($value->imp_rt_pasangfiksasifisik == 'PASIEN MENOLAK SEKALIGUS DIBERIKAN PENJELASAN'){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>*</b></p> </td>";
                    }else {
                        echo "<td>  </td>";
                    }
                }
            }
        ?>
    </tr>
    <tr>
        <td colspan="5" rowspan="2"><b><p style="margin: 0; text-align: center;">Paraf / Inisial Perawat</p></b></td> 
        <?php if(count((array)$model)>0){
                foreach ($model as $value){
                    echo "<td>"; echo isset($value->pegawai->nama_pegawai) ? $value->pegawai->nama_pegawai:"-"; 
                    echo "</td>";
                    
                }
            }
        ?>
    </tr>
    <tr>
    </tr>
    <tr>
        <td><p style="margin: 0; text-align: center;"><b>RR</b><br>a.</p></td>
        <td colspan="4"><span style="color:transparent">a</span><br>Memastikan tempat tidur/brankard dalam posisi rendah dan roda terkunci</td>
        <?php if(count((array)$model)>0){
                foreach ($model as $value){
                    if($value->imp_rr_rodaterkunci == 'BELUM/ TIDAK DILAKUKAN'){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>-</b></p> </td>";
                    } else if ($value->imp_rr_rodaterkunci == 'SUDAH DILAKUKAN' ){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>√</b></p> </td>";
                    } else if ($value->imp_rr_rodaterkunci == 'PASIEN MENOLAK SEKALIGUS DIBERIKAN PENJELASAN'){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>*</b></p> </td>";
                    }else {
                        echo "<td>  </td>";
                    }
                }
            }
        ?>
    </tr>
    <tr>
        <td><p style="margin: 0; text-align: center;">b.</p></td>
        <td colspan="4">Menutup pagar tempat tidur/brankard<br>
            - Beri tanda (√) apabila pagar sebelah kanan telah dinaikkan<br>
            - Beri tanda (√) apabila pagar sebelah kiri telah dinaikkan
        </td>
        <?php if(count((array)$model)>0){
                foreach ($model as $value){
                    if($value->imp_rr_menutuppagarbrankard_kanan == 'BELUM/ TIDAK DILAKUKAN'){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>-</b></p> <br>";
                    } else if ($value->imp_rr_menutuppagarbrankard_kanan == 'SUDAH DILAKUKAN' ){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>√</b></p> <br>";
                    } else if ($value->imp_rr_menutuppagarbrankard_kanan == 'PASIEN MENOLAK SEKALIGUS DIBERIKAN PENJELASAN'){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>*</b></p> <br>";
                    }else {
                        echo "<td>  <br>";
                    }
                }
            }
            if(count((array)$model)>0){
                foreach ($model as $value){
                    if($value->imp_rr_menutuppagarbrankard_kiri == 'BELUM/ TIDAK DILAKUKAN'){
                        echo " <p style='margin: 0; text-align: center;'><b>-</b></p> </td>";
                    } else if ($value->imp_rr_menutuppagarbrankard_kiri == 'SUDAH DILAKUKAN' ){
                        echo " <p style='margin: 0; text-align: center;'><b>√</b></p> </td>";
                    } else if ($value->imp_rr_menutuppagarbrankard_kiri == 'PASIEN MENOLAK SEKALIGUS DIBERIKAN PENJELASAN'){
                        echo " <p style='margin: 0; text-align: center;'><b>*</b></p> </td>";
                    }else {
                        echo "  </td>";
                    }
                }
            }
        ?>
    </tr>
    <tr>
        <td><p style="margin: 0; text-align: center;">c.</p></td>
        <td colspan="4">Orientasikan pasien/penunggu tentang lingkungan/ruangan</td>
        <?php if(count((array)$model)>0){
                foreach ($model as $value){
                    if($value->imp_rr_orientasipasien == 'BELUM/ TIDAK DILAKUKAN'){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>-</b></p> </td>";
                    } else if ($value->imp_rr_orientasipasien == 'SUDAH DILAKUKAN' ){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>√</b></p> </td>";
                    } else if ($value->imp_rr_orientasipasien == 'PASIEN MENOLAK SEKALIGUS DIBERIKAN PENJELASAN'){
                        echo "<td> <p style='margin: 0; text-align: center;'><b>*</b></p> </td>";
                    } else {
                        echo "<td>  </td>";
                    }
                }
            }
        ?>
    </tr>
    <tr>
        <td colspan="5" rowspan="2"><b><p style="margin: 0; text-align: center;">Paraf / Inisial Perawat</p></b></td> 
        <?php if(count((array)$model)>0){
                foreach ($model as $value){
                    echo "<td>"; echo isset($value->pegawai->nama_pegawai) ? $value->pegawai->nama_pegawai:"-"; 
                    echo "</td>";
                    
                }
            }
        ?>
    </tr>
    <tr>
    </tr>
</table>
<table style="width: 100%; border: none;">
    <tr>
        <td style="text-align: left;">Diadaptasi dari skala morse</td>
        <td style="text-align: right;"></td>
    </tr>
</table>
<table style="width: 100%; border: none;">
    <tr>
        <td style="text-align: left;"><span style="color:transparent">s</span></td>
        <td style="text-align: right;"></td>
    </tr>
</table>
<table width="100%" class="footer">
    <tr>
        <td style="text-align: left;">Revisi : 17/01/17</td>
        <td style="text-align: right;">Hal 1 dari 2</td>
    </tr>
</table>