<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();
$logomui = 'logo_mui.png';
$logoslhs = 'logo_slhs.png';
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
        float: right;
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
$modRuangan = RuanganM::model()->findByPk($model->ruangan_id);
$modJenis = JenisdietM::model()->findByPk($model->jenisdiet_id);


$resModDetails = array();
if ($model->jenispesanmenu == Params::JENISPESANMENU_PENDAMPING) {
    $modDetails = PesanmenupegawaiT::model()->findAllByAttributes(array('pesanmenudiet_id' => $model->pesanmenudiet_id));
    foreach ($modDetails as $modDetail) {
        $modJenisWaktu = JenisWaktuM::model()->findByPk($modDetail->jeniswaktu_id);
        $modPasien = empty($model->pendaftaran) ? new PasienM : PasienM::model()->findByPk($model->pendaftaran->pasien_id);
        $modPasienAdmisi = empty($model->pendaftaran_id) ? new PasienadmisiT : PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
        $modKamarRuangan = KamarruanganM::model()->findByPk($modPasienAdmisi->kamarruangan_id);
        $modMenuDiet = MenuDietM::model()->findByPk($modDetail->menudiet_id);
        
        
        $resModDetails[] = array(
            'modDetail'=>$modDetail,
            'modJenisWaktu'=>$modJenisWaktu,
            'modPasien'=>$modPasien,
            'modPasienAdmisi'=>$modPasienAdmisi,
            'modKamarRuangan'=>$modKamarRuangan,
            'modMenuDiet'=>$modMenuDiet,
        );
    }
} else if ($model->jenispesanmenu == Params::JENISPESANMENU_PEGAWAI) {
    $modDetails = PesanmenupegawaiT::model()->findAllByAttributes(array('pesanmenudiet_id' => $model->pesanmenudiet_id));
    foreach ($modDetails as $modDetail) {
        $modJenisWaktu = JenisWaktuM::model()->findByPk($modDetail->jeniswaktu_id);
        $modPasien = empty($model->pendaftaran) ? new PasienM : PasienM::model()->findByPk($model->pendaftaran->pasien_id);
        $modPasienAdmisi = empty($model->pendaftaran_id) ? new PasienadmisiT : PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
        $modKamarRuangan = KamarruanganM::model()->findByPk($modPasienAdmisi->kamarruangan_id);
        $modMenuDiet = MenuDietM::model()->findByPk($modDetail->menudiet_id);
        
        $resModDetails[] = array(
            'modDetail'=>$modDetail,
            'modJenisWaktu'=>$modJenisWaktu,
            'modPasien'=>$modPasien,
            'modPasienAdmisi'=>$modPasienAdmisi,
            'modKamarRuangan'=>$modKamarRuangan,
            'modMenuDiet'=>$modMenuDiet,
        );
        
    }

} else {    
    $modDetails = PesanmenudetailT::model()->findAllByAttributes(array('pesanmenudiet_id' => $model->pesanmenudiet_id));
    foreach ($modDetails as $modDetail) {
        $modJenisWaktu = JenisWaktuM::model()->findByPk($modDetail->jeniswaktu_id);
        $modPasien = PasienM::model()->findByPk($modDetail->pasien_id);
        $modPasienAdmisi = empty($modDetail->pendaftaran_id) ? new PasienadmisiT : PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $modDetail->pendaftaran_id));
        $modKamarRuangan = KamarruanganM::model()->findByPk($modPasienAdmisi->kamarruangan_id);
        $modMenuDiet = MenuDietM::model()->findByPk($modDetail->menudiet_id);
        $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $modDetail->pendaftaran_id));;
        // var_dump($modPendaftaran);die;
        $resModDetails[] = array(
            'modDetail'=>$modDetail,
            'modJenisWaktu'=>$modJenisWaktu,
            'modPasien'=>$modPasien,
            'modPasienAdmisi'=>$modPasienAdmisi,
            'modKamarRuangan'=>$modKamarRuangan,
            'modMenuDiet'=>$modMenuDiet,
        );
    }
    
}

foreach ($resModDetails as $idx=>$items) {
    $modDetail = $items['modDetail'];
    $modJenisWaktu = $items['modJenisWaktu'];
    $modPasien = $items['modPasien'];
    $modPasienAdmisi = $items['modPasienAdmisi'];
    $modKamarRuangan = $items['modKamarRuangan'];
    $modMenuDiet = $items['modMenuDiet'];

    if ($idx != 0) {
        echo "<pagebreak/>";
    }
    
    $path = Params::pathProfilRSDirectory().$modProfilRs->logo_rumahsakit_2;

    $res = "";
    $ext = "png";

    if (file_exists($path)) {
        $content = file_get_contents($path);
        $ext_data = pathinfo($path);

        if (!empty($ext_data) && is_array($ext_data) && !empty($ext_data)) {
            $ext = $ext_data['extension'];
        }

        $res = "data:image/".$ext.";base64,". base64_encode($content);
    }
    // var_dump($model->pendaftaran->pasien_id);die;
    

?>
<table width="100%" class="tab_header">
    <tbody>
        <tr>
            <td align="left" width="20%" rowspan="5">       
                <div>
                    <img src="<?php echo $res; ?> " style="height: 30px;"/>
                </div>
            </td>
            <td style="font-size: 8pt" class="textright" width="20%">
                <?php echo (!empty($modProfilRs->nama_rumahsakit)? substr($modProfilRs->nama_rumahsakit,0,11) :""); ?>
            </td>
            <td width="20%" height="20%" rowspan="4" class="textright">
                <img src="<?php echo Params::pathLogoLabel().$logomui?>" style="float:left; max-width: 50px; width:50px; height:50px" class='image_report'/>
            </td>
            <td width="20%" height="20%" rowspan="4" class="textright">
                <img src="<?php echo Params::pathLogoLabel().$logoslhs?>" style="float:left; max-width: 60px; width:60px; height:50px" class='image_report'/>
            </td>
        </tr>
        <tr>
            <td class="textbold textright" style="font-size: 8pt">
                <?php echo (!empty($modProfilRs->nama_rumahsakit)? substr($modProfilRs->nama_rumahsakit,11,19) :""); ?>
            </td>
        </tr>
        <tr>
            <td style="font-size: 4.5pt; font-weight: normal;">
                <?php echo (!empty($modProfilRs->alamatlokasi_rumahsakit)? substr($modProfilRs->alamatlokasi_rumahsakit,0,29) :""); ?>
            </td>
        </tr>
        <tr>
            <td style="font-size: 4.5pt; font-weight: normal;">
                <?php echo (!empty($modProfilRs->alamatlokasi_rumahsakit)? substr($modProfilRs->alamatlokasi_rumahsakit,29) :""); ?>
            </td>
        </tr>
        <tr>
            <td style="font-size: 4.5pt; font-weight: normal;">
                Telp. <?php echo (!empty($modProfilRs->no_telp_profilrs)? $modProfilRs->no_telp_profilrs :""); ?> (Hunting)
            </td>
            <td>
                <p>17350044811218</p>
            </td>
            <td>
                <p style="text-align: center;">050/0014-LHS<br>DPMPTSP/OL/2018</p>
            </td>
        </tr>
        <tr>
            <td style="border-bottom: 2px solid #000000" nowrap colspan="4">
            </td>
        </tr>
    </tbody>
</table>
<div>
    <table width="100%" class="a">
        <tr>
            <td width='32%'>
                No RM
            </td>
            <td>
                :
            </td>
            <td width='60%'>
                <?php echo!empty($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : '-'; ?>/<?php echo !empty($modPasien->no_identitas_pasien)?$modPasien->no_identitas_pasien:'-';?>
            </td>
        </tr>
        <tr>
            <td width='32%'>
                Nama
            </td>
            <td>
                :
            </td>
            <td width='60%'>
                <?php echo !empty($modPasien->nama_pasien) ? $modPasien->nama_pasien : '-'; ?> 
                <?php //echo $model->jenispesanmenu == Params::JENISPESANMENU_PENDAMPING ? " (PENDAMPING)" : ""; ?>
            </td>
        </tr>
        <tr>
            <td width='32%'>
                Tgl Lahir
            </td>
            <td>
                :
            </td>
            <td width='60%'>
                <?php echo !empty($modPasien->tanggal_lahir) ? MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir) : '-'; ?>- <?php echo !empty($modPendaftaran->umur)?$modPendaftaran->umur:"";?>
            </td>
        </tr>
        <tr>
            <td width='32%'>
                Diet
            </td>
            <td>
                :
            </td>
            <td width='60%'>
                <?php echo!empty($modJenis->jenisdiet_nama) ? $modJenis->jenisdiet_nama : '-'; ?> 
            </td>
        </tr>
    </table>
</div>

<div id="base_catatan">
    <ul id="catatan">
        <li>MAKANAN DAN MINUMAN / SUSU HARAP SEGERA DIKONSUMSI MAKSIMAL 1 JAM SETELAH PENYAJIAN</li>
        <li>MOHON ALAT MAKANAN TIDAK DIKELUARKAN DARI RUANGAN. TERIMA KASIH.</li>
    </ul>
</div>


<?php
}
?>