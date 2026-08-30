<?php


$profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());

$pemprov_logo = isset($pemprov_logo)?$pemprov_logo:false;
$identitas = isset($identitas)?$identitas:true;
$judul_laporan = isset($data['judul_laporan'])?$data['judul_laporan']:null;
$alias = isset($data['alias'])?$data['alias']:null;
$no_dok = isset($data['no_dok'])?$data['no_dok']:null;
$nama_lengkap = isset($data['nama_lengkap'])?$data['nama_lengkap']:null;
$tanggal_lahir = isset($data['tanggal_lahir'])?$data['tanggal_lahir']:null;
$no_rm = isset($data['no_rm'])?$data['no_rm']:null;
$page = !empty($page)?$page:'P';
$jenisresume =  !empty($jenisresume)?$jenisresume:'-';
$dokter =  !empty($dokter)?$dokter:'-';
$tglperiksa =  !empty($tglperiksa)?$tglperiksa:'-';
?>

<table class="w100   prinout-emr kop-header-pdf" >
    <tr >
        <td width="60%" align="center"  rowspan="3" >
            <?php 
                if (file_exists(Params::pathProfilRSDirectory().$profil->logo_rumahsakit)){
            ?>
                    <img src="<?php echo Params::urlProfilRSDirectory().$profil->logo_rumahsakit  ?>" width='80mm'/>
            <?php
                }
            ?>                       
        </td>        
        <td width="10%" align="center" rowspan="3"  >
            
        </td>     
        <td>
            &nbsp;
        </td>
        <?php if ($identitas){ ?>
        <td class=" font-gray border-left-gray border-top-gray" width="12%" style="padding-top:5px;">
            <div class="identitas-pasien">&nbsp;Nama Lengkap</div>
        </td>
        <td class="font-gray border-top-gray " width="1%" style="padding-top:5px;">
            <div class="identitas-pasien">:</div>
        </td>
        <td class="font-gray border-top-gray border-right-gray " style="padding-top:5px;" width="17%">
            <div class="identitas-pasien"><?= $nama_lengkap ?></div>
        </td>
        <?php } ?>
    </tr>
    <tr>        
        <td></td>
        <?php if ($identitas){ ?>
            <td class=" font-gray border-left-gray" style="vertical-align: middle;">
                <div class="identitas-pasien">&nbsp;Tgl. Lahir</div>
            </td>
            <td class=" font-gray" style="vertical-align: middle;">
                <div class="identitas-pasien" >:</div>
            </td>
            <td class=" font-gray border-right-gray" style="vertical-align: middle;">
                <div class="identitas-pasien   "><?= $tanggal_lahir ?></div>
            </td>
         <?php } ?>
    </tr>
    <tr>       
        <td ></td>
        <?php if ($identitas){ ?>
            <td class=" font-gray border-left-gray border-bottom-gray" >
                <div class="identitas-pasien">&nbsp;No. RM</div>
            </td>
            <td class=" font-gray border-bottom-gray" >
                <div class="identitas-pasien  ">:</div>
            </td>
            <td class=" font-gray border-right-gray  border-bottom-gray" >
                <div class="identitas-pasien  "><?= $no_rm ?></div>
            </td>
         <?php } ?>
    </tr>
    <tr>
        <th colspan="7"><h3><?= $jenisresume ?></h3></th>
    </tr>
    <tr>
        <td colspan="3">Dokter : <?= $dokter ?></td>
        <td colspan="4" style="text-align: right;">Tgl Pemeriksaan : <?= $tglperiksa ?></td>
    </tr>
    <tr>
        <td colspan="7" style="border-bottom: 3px solid #333;">&nbsp;</td>
    </tr>
</table>
<br/>
<br/>
<br/>