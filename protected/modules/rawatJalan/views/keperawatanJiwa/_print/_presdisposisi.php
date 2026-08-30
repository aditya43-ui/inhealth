<style>
    .tab_riwayat_keluarga th, .tab_riwayat_keluarga td {
        border: 1px solid black;
        padding: 2px;
    }
    
    .tab_riwayat_keluarga th {
        text-align: center;
        font-weight: bold;
    }
</style>
<table class="form_predispo" width="100%">
    <tr>
        <td width="15">1. </td>
        <td>Pernah mengalami gangguan jiwa di masa lalu ? <?php echo $model->prediosposisi_gangunajiwa_masalalu ? "Ya" : "Tidak"; ?></td>
    </tr>
    <tr>
        <td>2</td>
        <td>Pengobatan Sebelumnya : <?php echo $model->prediosposisi_pengobatansebelumnya; ?></td>
    </tr>
    <tr>
        <td>3</td>
        <td>
            <table id="tab_aniaya">
                <tr>
                    <td></td>
                    <td class='rad_center' width="50">Pelaku</td>
                    <td class='rad_center' width="50">Korban</td>
                    <td class='rad_center' width="50">Saksi</td>
                    <td class='rad_center' width="50">Usia</td>
                </tr>
                <tr>
                    <td>Aniaya Fisik</td>
                    <td class='rad_center'><?php echo $model->prediosposisi_aniayafisik == "Pelaku" ? '<i class="entypo-check"></i>' : ''; ?></td>
                    <td class='rad_center'><?php echo $model->prediosposisi_aniayafisik == "Korban" ? '<i class="entypo-check"></i>' : ''; ?></td>
                    <td class='rad_center'><?php echo $model->prediosposisi_aniayafisik == "Saksi" ? '<i class="entypo-check"></i>' : ''; ?></td>
                    <td class='rad_center'><?php echo $model->prediosposisi_aniayafisik_usia; ?></td>
                </tr>
                <tr>
                    <td>Aniaya Seksual</td>
                    <td class='rad_center'><?php echo $model->prediosposisi_aniayaseksual == "Pelaku" ? '<i class="entypo-check"></i>' : ''; ?></td>
                    <td class='rad_center'><?php echo $model->prediosposisi_aniayaseksual == "Korban" ? '<i class="entypo-check"></i>' : ''; ?></td>
                    <td class='rad_center'><?php echo $model->prediosposisi_aniayaseksual == "Saksi" ? '<i class="entypo-check"></i>' : ''; ?></td>
                    <td class='rad_center'><?php echo $model->prediosposisi_aniayaseksual_usia; ?></td>
                </tr>
                <tr>
                    <td>Penolakan</td>
                    <td class='rad_center'><?php echo $model->prediosposisi_penolakan == "Pelaku" ? '<i class="entypo-check"></i>' : ''; ?></td>
                    <td class='rad_center'><?php echo $model->prediosposisi_penolakan == "Korban" ? '<i class="entypo-check"></i>' : ''; ?></td>
                    <td class='rad_center'><?php echo $model->prediosposisi_penolakan == "Saksi" ? '<i class="entypo-check"></i>' : ''; ?></td>
                    <td class='rad_center'><?php echo $model->prediosposisi_penolakan_usia; ?></td>
                </tr>
                <tr>
                    <td>Kekerasan dalam Keluarga</td>
                    <td class='rad_center'><?php echo $model->prediosposisi_krt == "Pelaku" ? '<i class="entypo-check"></i>' : ''; ?></td>
                    <td class='rad_center'><?php echo $model->prediosposisi_krt == "Korban" ? '<i class="entypo-check"></i>' : ''; ?></td>
                    <td class='rad_center'><?php echo $model->prediosposisi_krt == "Saksi" ? '<i class="entypo-check"></i>' : ''; ?></td>
                    <td class='rad_center'><?php echo $model->prediosposisi_krt_usia; ?></td>
                </tr>
                <tr>
                    <td>Tindakan Kriminal</td>
                    <td class='rad_center'><?php echo $model->prediosposisi_kriminal == "Pelaku" ? '<i class="entypo-check"></i>' : ''; ?></td>
                    <td class='rad_center'><?php echo $model->prediosposisi_kriminal == "Korban" ? '<i class="entypo-check"></i>' : ''; ?></td>
                    <td class='rad_center'><?php echo $model->prediosposisi_kriminal == "Saksi" ? '<i class="entypo-check"></i>' : ''; ?></td>
                    <td class='rad_center'><?php echo $model->prediosposisi_kriminal_usia; ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            <b>Jelaskan No. 1, 2, 3:</b><br>
            <?php echo empty($model->prediosposisi_kriminal) ? "-" : $model->prediosposisi_kriminal ?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            <b>Masalah Keperawatan</b><br>
            <?php echo empty($model->prediosposisi_masalahkeperawatan) ? "-" : $model->prediosposisi_masalahkeperawatan ?>
        </td>
    </tr>
    <tr>
        <td>4</td>
        <td>Adakah anggota keluarga yang mengalami gangguan jiwa ? <?php echo $model->prediosposisi_anggotakeluraga_gangguan ? "Ya" : "Tidak"; ?></td>
    </tr>
    <tr>
        <td></td>
        <td>
            <table width="100%" class="tab_riwayat_keluarga">
                <thead>
                    <tr>
                    <th width="33%">Hubungan Keluarga</th>
                    <th>Gejala</th>
                    <th width="33%">Riwayat Pengobatan/Perawatan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $model->prediosposisi_hubungankeluarga ?></td>
                        <td><?php echo $model->prediosposisi_gejala ?></td>
                        <td><?php echo $model->prediosposisi_riwayatpengobatan ?></td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td></td>
        <td><b>Masalah Keperawatan</b><br><?php echo empty($model->prediosposisi_masalahkeperawatan_keluarga) ? "-" : $model->prediosposisi_masalahkeperawatan_keluarga; ?></td>
    </tr>
    <tr>
        <td>5</td>
        <td>Pengalaman masa lalu yang tidak menyenangkan<br><?php echo empty($model->prediosposisi_pengalamanmasalalu) ? "-" : $model->prediosposisi_pengalamanmasalalu; ?></td>
    </tr>
    <tr>
        <td></td>
        <td><b>Masalah Keperawatan</b><br><?php echo empty($model->prediosposisi_masalahkeperawatan_masalalu) ? "-" : $model->prediosposisi_masalahkeperawatan_masalalu; ?></td>
    </tr>
</table>
