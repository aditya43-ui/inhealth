<?php 
/**
 * menampilkan detail riwayat risiko jatuh
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */
?>
<style type="text/css" media="print">
    @media print{
        @page {
            margin-bottom: 0;
            margin-top: 0; 
        }
    }
</style>
<h3 style="text-align: center; font-weight: bold; text-transform: uppercase"> Detail Asesment Resiko Jatuh </h3>
<table width="40%" style="margin-top: 30px">
    <tr> 
        <td width="25%"> <h5 style="font-weight: bold"> Tanggal Skoring </h5> </td>
        <td width="1%"> : </td>
        <td width="25%"> <?php echo MyFormatter::formatDateTimeForUser($modResikoJatuh->tgl_skoring) ?> </td>
    </tr>
    <tr>
        <td width="25%">  <h5 style="font-weight: bold"> Pegawai Skoring </h5> </td>
        <td width="1%"> : </td>
        <td width="25%"> <?php echo isset($modResikoJatuh->pegawai->namaLengkap) ? $modResikoJatuh->pegawai->namaLengkap :" "; ?> </td>
    </tr>
    
</table>
<table width="100%" class="table table-striped">
    <thead>
        <tr>
            <th style="text-align: center"> No </th>
            <th style="text-align: center"> Pengkajian </th>
            <th style="text-align: center"> Penilaian </th>
            <th style="text-align: center"> Skoring </th>
        </tr>
    </thead>
    <tbody>
        <?php if ($model->masihAnak): 
            $upper_limit_rendah = 6;
            $upper_limit_tinggi = 11;
            
            ?>
        <tr>
            <td> 1. </td>
            <td> Usia </td>
            <td> <?php echo $modResikoJatuh->anak_usia_keterangan ?></td>
            <td style="text-align: center"> <?php echo $modResikoJatuh->anak_usia_skor ?></td>
        </tr>
        <tr>
            <td> 2. </td>
            <td> Jenis Kelamin </td>
            <td> <?php echo $modResikoJatuh->anak_jeniskelamin_keterangan ?></td>
            <td style="text-align: center"> <?php echo $modResikoJatuh->anak_jeniskelamin_skor ?></td>
        </tr>
        <tr>
            <td> 3. </td>
            <td> Diagnosis </td>
            <td> <?php echo $modResikoJatuh->anak_diagnosis_keterangan ?></td>
            <td style="text-align: center"> <?php echo $modResikoJatuh->anak_diagnosis_skor ?></td>
        </tr>
        <tr>
            <td> 4. </td>
            <td> Gangguan Kognitif </td>
            <td> <?php echo $modResikoJatuh->anak_gangguankognitif_keterangan ?></td>
            <td style="text-align: center"> <?php echo $modResikoJatuh->anak_gangguankognitif_skor ?></td>
        </tr>
        <tr>
            <td> 5. </td>
            <td> Faktor Lingkungan </td>
            <td> <?php echo $modResikoJatuh->anak_faktorlingkungan_keterangan ?></td>
            <td style="text-align: center"> <?php echo $modResikoJatuh->anak_faktorlingkungan_skor ?></td>
        </tr>
        <tr>
            <td> 6. </td>
            <td> Pembedahan / Sedasi / Anestesi</td>
            <td> <?php echo $modResikoJatuh->anak_pembedahan_keterangan ?></td>
            <td style="text-align: center"> <?php echo $modResikoJatuh->anak_pembedahan_skor ?></td>
        </tr>
        <tr>
            <td> 7. </td>
            <td> Penggunaan Medika Mentosa</td>
            <td> <?php echo $modResikoJatuh->anak_medikamentosa_keterangan ?></td>
            <td style="text-align: center"> <?php echo $modResikoJatuh->anak_medikamentosa_skor ?></td>
        </tr>
        <?php else : 
            $upper_limit_rendah = 24;
            $upper_limit_tinggi = 50;
            
            ?>
        <tr>
            <td> 1. </td>
            <td> Riwayat Jatuh </td>
            <td> <?php echo $modResikoJatuh->riwayatjatuh_keterangan ?></td>
            <td style="text-align: center"> <?php echo $modResikoJatuh->riwayatjatuh_skor ?></td>
        </tr>
        <tr>
            <td> 2. </td>
            <td> Status Mental </td>
            <td> <?php echo $modResikoJatuh->statusmental_keterangan ?></td>
            <td style="text-align: center"> <?php echo $modResikoJatuh->statusmental_skor ?></td>
        </tr>
        <tr>
            <td> 3. </td>
            <td> Pengobatan </td>
            <td> <?php echo $modResikoJatuh->pengobatan_keterangan ?></td>
            <td style="text-align: center"> <?php echo $modResikoJatuh->pengobatan_skor ?></td>
        </tr>
        <tr>
            <td> 4. </td>
            <td> Pengobatan </td>
            <td> <?php echo $modResikoJatuh->mobgayaberjalan_keterangan ?></td>
            <td style="text-align: center"> <?php echo $modResikoJatuh->mobgayaberjalan_skor ?></td>
        </tr>
        <tr>
            <td> 5. </td>
            <td> Mobilitas Alat Bantu </td>
            <td> <?php echo $modResikoJatuh->mobilitasalatbantu_keterangan ?></td>
            <td style="text-align: center"> <?php echo $modResikoJatuh->mobilitasalatbantu_skor ?></td>
        </tr>
        <tr>
            <td> 6. </td>
            <td> Kondisi Penyakit</td>
            <td> <?php echo $modResikoJatuh->kondisipenyakit_keterangan ?></td>
            <td style="text-align: center"> <?php echo $modResikoJatuh->konsidipenyakit_skor ?></td>
        </tr>
        <?php endif; ?>
        <tr>
            <td colspan="3" style="text-transform: uppercase; vertical-align: baseline ;text-align: center; font-weight: bold"> Total Scoring </td>
            <?php if ($modResikoJatuh['totalskor'] <= $upper_limit_rendah) { ?>
                <td style="text-align: center"> <?php echo $modResikoJatuh->totalskor ?>  <br> <?php echo "Tidak Ada Resiko"?></td>
            <?php } else if ($modResikoJatuh['totalskor'] > $upper_limit_rendah && $modResikoJatuh['totalskor'] <= $upper_limit_tinggi) { ?>
                <td style="text-align: center; font-weight: bold"><?php echo $modResikoJatuh->totalskor ?>  <br> <?php echo "Resiko Rendah"?></td>
            <?php } else { ?>
                <td style="text-align: center; font-weight: bold"><?php echo $modResikoJatuh->totalskor ?>  <br>  <?php echo "Resiko Tinggi"?></td>
            <?php } ?>
        </tr>
    </tbody>
</table>
<br>
<h4 style="text-align: center; font-weight: bold; text-transform: bold">  
Implementasi Resiko Tinggi dan Resiko Rendah
 </h4>
<?php if ($modResikoJatuh->totalskor > $upper_limit_rendah && $modResikoJatuh->totalskor <= $upper_limit_tinggi) { ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="text-align: center"> No. </th>
                <th style="text-align: center"> Kegiatan </th>
                <th style="text-align: center"> Status / Implementasi </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td> 1. </td>
                <td> Memastikan Tempat Tidur / Brankard Dalam Posisi Rendah dan Roda Terkunci </td>
                <td> <?php echo $modResikoJatuh->imp_rr_rodaterkunci ?> </td>
            </tr>
            <tr>
                <td> 2. </td>
                <td> Menutup Pagar Tempat Tidur / Brankard sebelah Kiri</td>
                <td> <?php echo $modResikoJatuh->imp_rr_menutuppagarbrankard_kiri ?> </td>
            </tr>
            <tr>
                <td> 3. </td>
                <td> Orientasi Pasien / Penunggu tentang Lingkungan / Ruangan</td>
                <td> <?php echo $modResikoJatuh->imp_rr_orientasipasien ?> </td>
            </tr>
        </tbody>
    </table>
<?php } else if ($modResikoJatuh->totalskor > $upper_limit_tinggi) { ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="text-align: center"> No. </th>
                <th style="text-align: center"> Kegiatan </th>
                <th style="text-align: center"> Status / Implementasi </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td> 1. </td>
                <td> Memastikan Tempat Tidur / Brankard Dalam Posisi Rendah dan Roda Terkunci </td>
                <td> <?php echo $modResikoJatuh->imp_rt_rodaterkunci ?> </td>
            </tr>
            <tr>
                <td> 2. </td>
                <td> Menutup Pagar Tempat Tidur / Brankard sebelah Kanan</td>
                <td> <?php echo $modResikoJatuh->imp_rt_menutuppagarbrankard_kanan ?> </td>
            </tr>
            <tr>
                <td> 3. </td>
                <td> Menutup Pagar Tempat Tidur / Brankard sebelah Kiri </td>
                <td> <?php echo $modResikoJatuh->imp_rt_menutuppagarbrankard_kiri ?> </td>
            </tr>
            <tr>
                <td> 4. </td>
                <td>  	Orientasi Pasien / Penunggu tentang Lingkungan / Ruangan</td>
                <td> <?php echo $modResikoJatuh->imp_rt_orientasikanpasien ?> </td>
            </tr>
            <tr>
                <td> 5. </td>
                <td>  Beri tanda Segitiga Kuning pada Tempat Tidur</td>
                <td> <?php echo $modResikoJatuh->imp_rt_beritandasegitiakuning ?> </td>
            </tr>
            <tr>
                <td> 6. </td>
                <td> Pastikan Pasien memiliki pin warna kuning penanda RT jatuh pada gelang </td>
                <td> <?php echo $modResikoJatuh->imp_rt_beripinkuning ?> </td>
            </tr>
            <tr>
                <td> 7. </td>
                <td> Lakukan Pemanasa Fiksasi Apabila Diperlukan dengan persetujuan Keluarga</td>
                <td> <?php echo $modResikoJatuh->imp_rt_pasangfiksasifisik ?> </td>
            </tr>
        </tbody>
    </table>
<?php } else { echo " "; }?>
    
    
    
