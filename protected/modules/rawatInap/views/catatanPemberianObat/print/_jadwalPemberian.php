<table width="100%">
    <tr>
        <td class="borderclass padding5 bordertopnoneclass">Keterangan :</td>
    </tr>
    <tr>
        <td class="borderclass">
        <table width="100%">
            <tr>
                <td style="padding:5px; vertical-align:top; width:30%; ">
                    <div style="margin-left:10px;" >
                        Jadwal Pemberian Obat:<br>
                        1x1 Pagi 06-07<br>
                        1x1 Malam 21-22<br>
                        2x1 06-07 18-19<br>
                        3x1 06-07 12-13 19-20<br>
                        4x1 06-07 12-13 19-20<br>
                        5x1 05-07 10-11 15-16 20-21 23-24<br>
                        6x1 05-06 09-10 13-14 17-18 21-22 01-02<br>
                    </div>

                <td style="padding:5px; vertical-align:top;">
                    Tuliskan pada kolom tanda "tanda"
                    <table>
                        <tr>
                            <td><i class="icon-ok icon-black"></i></td>
                            <td>:</td>
                            <td>Setelah Obat diberikan</td>
                        </tr>
                        <tr>
                            <td>T</i></td>
                            <td>:</td>
                            <td>Pasien Menolak</td>
                        </tr>
                        <tr>
                            <td>K</i></td>
                            <td>:</td>
                            <td>Obat ditunda karena kondisi pasien</td>
                        </tr>
                        <tr>
                            <td>S</i></td>
                            <td>:</td>
                            <td>Obat distop oleh dokter</td>
                        </tr>
                        <tr>
                            <td>A</i></td>
                            <td>:</td>
                            <td>Reaksi Alergi</td>
                        </tr>
                        <tr>
                            <td>ESO</i></td>
                            <td>:</td>
                            <td>Reaksi Efek Samping Setelah Pemberian</td>
                        </tr>
                        <tr>
                            <td>TAP</td>
                            <td>:</td>
                            <td>Obat Tidak Tersedia</td>
                        </tr>
                    </table>

                </td>
                <td style="padding:5px; vertical-align:top;">
                    Riwayat Alergi:
                    <div style="width:150px; height:150px; border:1px solid;">
                        <?php if (isset($modAdmisi->pasienadmisi_id)){
                            $anmnesa = AnamnesisawalT::model()->findbyattributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
                            echo isset($anmnesa->riwayatalergi_obat) ? $anmnesa->riwayatalergi_obat : '';
                        }else{
                            $anmnesa = AnamnesaT::model()->findbyattributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
                            echo isset($anmnesa->riwayatalergiobat) ? $anmnesa->riwayatalergiobat : '';
                        }?>

                    </div>

                </td>
                <td style="padding:5px; vertical-align:top;">
                    Ruangan:
                    <div style="width:150px; height:25px; border:1px solid; padding:3px; ">
                        <?php if (isset($modAdmisi->pasienadmisi_id)){
                            echo $modAdmisi->ruangan->ruangan_nama;
                        }else{
                            echo $modPendaftaran->ruangan->ruangan_nama;
                        }?>
                    </div>
                </td>

            </tr>
        </table>
        </td>
    </tr>
</table>