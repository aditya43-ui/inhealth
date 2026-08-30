<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();
?>
<?php
//    foreach ($modPenjualanDetail as $i=>$modObat){ 
//        
//    }
?>
<style>       
    table.a  tr td 
    {
        vertical-align: top;
    }

    table.a  tr td label
    {
        font-size:6pt;
    }

    table.a  tr td 
    {
        font-size:6pt;
    }

    table  tr td label
    {
        font-size:5pt;
    }

    table  tr td 
    {
        font-size:6pt;
    }

    #base_catatan {
        border-top: 1px solid black;
        padding-top: 2px;
    }

    #catatan {
        margin: 0;
    }
    #catatan li {
        font-size: 4.5pt;
    }

    @media (min-width:0px) and (max-width: 1000px) {
        table
        {
            width:100%;
            padding:10px;
        }

    }
</style>
<?php
$ruangan = null;

if ($modKirim->jenispesanmenu == Params::JENISPESANMENU_PASIEN || $modKirim->jenispesanmenu == Params::JENISPESANMENU_PENDAMPING) {
    $pesan = PesanmenudietT::model()->findByAttributes(array(
        'kirimmenudiet_id' => $modKirim->kirimmenudiet_id
    ));

    if (!empty($pesan)) {
        $ruangan = $pesan->ruangan_id;
    }

//	$detail = KirimmenupasienT::model()->findAllByAttributes(array('pendaftaran_id' => $modDetailKirim->pendaftaran_id, 'pasienadmisi_id' => $modDetailKirim->pasienadmisi_id, 'kirimmenudiet_id' => $modDetailKirim->kirimmenudiet_id));
    if ($modKirim->jenispesanmenu == Params::JENISPESANMENU_PASIEN) {
        if (!empty($jeniswaktu)) {
            $detail = KirimmenupasienT::model()->findAllByAttributes(array('kirimmenudiet_id' => $modDetailKirim->kirimmenudiet_id, 'jeniswaktu_id' => $jeniswaktu));
        } else {
            $detail = KirimmenupasienT::model()->findAllByAttributes(array('kirimmenudiet_id' => $modDetailKirim->kirimmenudiet_id));
        }
    } else {
        if (!empty($jeniswaktu)) {
            $detail = KirimmenupegawaiT::model()->findAllByAttributes(array('kirimmenudiet_id' => $modDetailKirim->kirimmenudiet_id, 'jeniswaktu_id' => $jeniswaktu));
        } else {
            $detail = KirimmenupegawaiT::model()->findAllByAttributes(array('kirimmenudiet_id' => $modDetailKirim->kirimmenudiet_id));
        }
    }

//        $no = 2;
    foreach ($detail as $i => $menu) {
        if ($i != 0) {
            echo "<pagebreak/>";
        }
        
        
        ?>

        <?php // if($no % 2 == 0){ ?>
        <?php // } ?>    
        <table width="100%" class="tab_header">
            <tbody>
                <tr>
                    <td align="center" style="border-bottom: 2px solid #000000" nowrap>       
                        <div>
                            <img src="<?php echo Params::urlProfilRSDirectory() . $modProfilRs->logo_rumahsakit_2 ?> " style="height: 30px;"/>
                        </div>
                        <div style="font-size: 4.5pt; font-weight: normal;">
                            <?php echo $konfig->alamatheadersurat; ?>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <?php
        $nama_ruangan = "";
        $nama_kamar = "";
        $no_rekam_medik = "";
        $nama_pasien = "";
        $tgl_lahir = "";

        if ($modKirim->jenispesanmenu == Params::JENISPESANMENU_PASIEN) {

            $pendaftaran = PendaftaranT::model()->findByPk($menu->pendaftaran_id);
            if (!empty($menu->pasienadmisi_id)) {
                $admisi = PasienadmisiT::model()->findByPk($menu->pasienadmisi_id);

                $dat_ruangan = RuanganM::model()->findByPk($menu->ruangan_id);
                $nama_ruangan = $dat_ruangan->ruangan_nama;

                $kamar = KamarruanganM::model()->findByPk($menu->kamarruangan_id);
                if (!empty($kamar)) {
                    $nama_kamar = $kamar->kamarruangan_nokamar . ":" . $kamar->kamarruangan_nobed;
                }
            } else {
                $dat_ruangan = RuanganM::model()->findByPk($menu->ruangan_id);
                $nama_ruangan = $dat_ruangan->ruangan_nama;
            }

            $no_rekam_medik = isset($menu->pasien_id) ? $menu->pasien->no_rekam_medik : "";
            $nama_pasien = isset($menu->pasien_id) ? $menu->pasien->namadepan . ' ' . $menu->pasien->nama_pasien : " ";
            $tgl_lahir = !empty($menu->pasien_id) ? MyFormatter::formatDateTimeForUser($menu->pasien->tanggal_lahir) : '-';

        } else {
            $pendaftaran = PendaftaranT::model()->findByPk($pesan->pendaftaran_id);
            $no_rekam_medik = isset($pendaftaran->pasien_id) ? $pendaftaran->pasien->no_rekam_medik : "";
            $nama_pasien = isset($pendaftaran->pasien_id) ? $pendaftaran->pasien->namadepan . ' ' . $pendaftaran->pasien->nama_pasien : " ";
            $tgl_lahir = !empty($pendaftaran->pasien_id) ? MyFormatter::formatDateTimeForUser($pendaftaran->pasien->tanggal_lahir) : '-';

            if (!empty($pesan->pendaftaran->pasienadmisi_id)) {
                $masuk = MasukkamarT::model()->findByAttributes(array(
                    'pasienadmisi_id' => $pesan->pendaftaran->pasienadmisi_id,
                    'ruangan_id' => $pesan->ruangan_id,
                ));

                if (!empty($masuk)) {
                    $nama_ruangan = $masuk->ruangan->ruangan_nama;
                    $nama_kamar = $masuk->kamarruangan->kamarruangan_nokamar;
                }
            } else {
                $str .= ", " . $pesan->pendaftaran->kelaspelayanan->kelaspelayanan_nama;
            }
        }
        ?>
        <table style="width: 100%; border: none;">
        <!--<tr>
                <td colspan="3" style="text-align: center; border-bottom: 1px solid #000; font-size: 8pt;">
                    <b><?php // echo strtoupper(Yii::app()->user->getState('nama_rumahsakit')); ?></b>
                </td>
            </tr>-->
            <tr>
                <td width='32%'>
                    <label class='control-label'>Nama Pasien</label>
                </td>
                <td>:</td>
                <td width='60%'> <?php echo $nama_pasien; ?> 
                    <?php echo $modKirim->jenispesanmenu == Params::JENISPESANMENU_PENDAMPING ? " (PENDAMPING)" : ""; ?>
                </td>
            </tr>
            <tr>
                <td width='32%'>
                    <label class='control-label'>No. RM</label>
                </td>
                <td>:</td>
                <td width='60%'> <?php echo $no_rekam_medik; ?> </td>
            </tr>
            <?php if ($modKirim->jenispesanmenu != Params::JENISPESANMENU_PENDAMPING) { ?>
            <tr>
                <td width='32%'>
                    <label class='control-label'>Tgl lahir</label>
                </td>
                <td>:</td>
                <td width='60%'> <?php echo $tgl_lahir; ?> </td>
            </tr>
            <?php } ?>
            <tr>
                <td width='32%'>
                    <label class='control-label'>Ruangan</label>
                </td>
                <td>:</td>
                <td width='60%'> <?php echo $nama_ruangan; ?> </td>
            </tr>
            <tr>
                <td width='32%'>
                    <label class='control-label'>No. Kamar</label>
                </td>
                <td>:</td>
                <td width='60%'> <?php echo $nama_kamar; ?> </td>
            </tr>
            <tr>
                <td width='32%'>
                    <label class='control-label'>Jenis Diet</label>
                </td>
                <td>:</td>
                <td width='60%'> <?php echo isset($menu->menudiet->jenisdiet_id) ? $menu->menudiet->jenisdiet->jenisdiet_nama : ""; ?>
                </td>
            </tr>
            <tr>
                <td width='32%'>
                    <label class='control-label'>Jenis Makanan</label>
                </td>
                <td>:</td>
                <td width='60%'> <?php echo isset($menu->menudiet->menudiet_id) ? $menu->menudiet->menudiet_nama : ""; ?> </td>
            </tr>
            <tr>
                <td width='32%'>
                    <label class='control-label'>Jam Makan</label>
                </td>
                <td>:</td>
                <td width='60%'> <?php echo isset($menu->jeniswaktu_id) ? $menu->jeniswaktu->jeniswaktu_nama : ""; ?> </td>
            </tr>
        </table>
        <div id="base_catatan">
            <ul id="catatan">
                <li>MAKANAN DAN MINUMAN / SUSU HARAP SEGERA DIKONSUMSI MAKSIMAL 1 JAM SETELAH PENYAJIAN</li>
                <li>MOHON ALAT MAKANAN TIDAK DIKELUARKAN DARI RUANGAN. TERIMA KASIH.</li>
            </ul>
        </div>

        <?php
//        $no++;
    }
} else {

    $detail = KirimmenupegawaiT::model()->findAllByAttributes(array('pegawai_id' => $modDetailKirim->pegawai_id, 'kirimmenudiet_id' => $modDetailKirim->kirimmenudiet_id));
    foreach ($detail as $i => $menu) {
        ?>
        <div>
            <table style='width:50%;padding:10px;' align="left" id="menudiet-pegawai" class="table table-striped table-bordered table-condensed">
                <tr>
                    <td><b>NIK</b></td>
                    <td><?php echo isset($menu->pegawai_id) ? $menu->pegawai->nomorindukpegawai : ""; ?></td>
                </tr>
                <tr>
                    <td><b>Nama Pegawai</b></td>
                    <td><?php echo isset($menu->pegawai_id) ? $menu->pegawai->NamaLengkap : ""; ?></td>
                </tr>
                <tr>
                    <td><b>Jenis Diet</b></td>
                    <td><?php echo isset($menu->menudiet->jenisdiet_id) ? $menu->menudiet->jenisdiet->jenisdiet_nama : ""; ?></td>
                </tr>
                <tr>
                    <td><b>Menu Makanan</b></td>
                    <td><?php echo isset($menu->menudiet->menudiet_id) ? $menu->menudiet->menudiet_nama : ""; ?></td>
                </tr>
            </table>
        </div>
    <?php } ?>
<?php } ?>
