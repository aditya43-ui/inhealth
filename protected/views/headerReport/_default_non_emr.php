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
?>

<table class="w100   prinout kop-header-pdf" >
    <tr >
        <td width="10%" align="center"  rowspan="4" style="border-bottom: 3px solid #333;vertical-align: middle;">
            <?php 
                if (file_exists(Params::pathProfilRSDirectory().$profil->logo_rumahsakit)){
            ?>
                    <img src="<?php echo Params::urlProfilRSDirectory().$profil->logo_rumahsakit  ?> " width='80mm'/>
            <?php
                }
            ?>                       
        </td>
        <td align="center" nowrap width="35%" style="vertical-align: bottom">   
            <div class="prov">
                <?php echo 'PEMERINTAH PROVINSI DAERAH TINGKAT I JAWA TIMUR'; ?>
            </div>                                  
        </td>
        <td width="10%" align="center" rowspan="4"  style="border-bottom: 3px solid #333;vertical-align: middle;">
            
        </td>            
       
    </tr>
     <tr>
        <td align="center" nowrap  style="vertical-align: middle">              
            <div class="rs">
                <?php echo $profil->nama_rumahsakit; ?>
            </div>                                
        </td>       
        
        
    </tr>
    <tr>
        <td align="center" nowrap  style="vertical-align: middle">              
            <div class="rs">
                <?php echo $profil->nama_rumahsakit; ?>
            </div>                                
        </td>       
        
        
    </tr>
    <tr>
        <td align="center" nowrap style="border-bottom: 3px solid #333;">             
            <div class="alamat">
                <?php echo $profil->alamatlokasi_rumahsakit; ?>
            </div>                        
        </td>
        
    </tr>
</table>

    

<?php if (!empty($judul_laporan) || !empty($alias)): ?>
<table class="w100 prinout title-header">
    <tr>
        <td width='15%'>
            &nbsp;
        </td>
        <td align="center">
            <div class="judul-kopsurat w100">
                <?= !empty($judul_laporan)?'<span class="judul">'.$judul_laporan.'</span>':'' ?>
                <br/>
                <?= !empty($alias)?'<span class="alias"><i>'.$alias.'</i></span>':'' ?>
            </div>
        </td>
        <td align='right' width='15%'>            
            <b>
            <div class="judul">
                <?= $no_dok ?>
            </div>            
                </b>
        </td>
    </tr>
</table>

<?php else: ?>
    <span>&nbsp;</span>
<?php endif; ?>