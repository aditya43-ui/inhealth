<?php 
$profil=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$konfig = KonfigsystemK::model()->find();
?>

<style>
    
    body{
        font-size: 6pt;
    }
    
    #tab_label td {
        vertical-align: top;
        padding: 0;
        font-size: 6pt;
    }
    .content{
        margin-left:40px;
        margin-right: 50px;
        padding-top: 4mm !important;
    }
    #tab_label2 td {
        vertical-align: top;
        padding: 0;
        font-size: 7pt;
        font-weight: bold;
    }
    #tab_label3 td {
        vertical-align: top;
        padding: 0;
        font-size: 7pt;
        font-weight: bold;
    }
</style>
<!-- <div class="header" style="border-bottom: 1px solid black">
<?php //echo $this->renderPartial('application.views.headerReport.headerDefaultNewtiket'); ?>
</div> -->
<div class="content">
<div class="judulcontent"></div>
<div style="width:60px;">
    <img src="index.php?r=barcode/myBarcode&code=<?php echo $data->no_rekam_medik; ?>&is_text="> 
</div>
<table id="tab_label2">
    <tr>
        <!-- <td width="50">Nama</td>
        <td width="5">: </td> -->
        <td width="200"><?php echo $data->nama_pasien; ?> <?php if($data->jeniskelamin == "LAKI-LAKI"){
            echo "(L)";
        }else{
            echo "(P)";
        } ?></td>
    </tr>
</table>
<table id="tab_label3">
    <tr>
        <td width="40">No. RM</td>
        <td width="10">: </td>
        <td><?php echo $data->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>Reg</td>
        <td>: </td>
        <td><?php echo $data->no_pendaftaran; ?></td>
    </tr>
    <tr>
        <td>NIK</td>
        <td>: </td>
        <td><?php echo $data->no_identitas_pasien; ?></td>
    </tr>
</table>
<table id="tab_label">
    <tr>
        <td width="55">Tgl. Registrasi</td>
        <td>: </td>
        <td width="100"><?php echo $format->formatDateTimeForUser($data->tglmasukpenunjang); ?></td>
    </tr>
    <!-- <tr>
        <td>Tgl. Lahir</td>
        <td>: </td>
        <td><?php //echo $format->formatDateTimeForUser($data->tanggal_lahir); ?></td>
        <td></td>
        <td>Alamat</td>
        <td>: </td>
        <td><?php //echo $data->alamat_pasien; ?></td>
    </tr> -->
    <tr>
        <td width="50">Pemeriksaan</td>
        <td width="10">:</td>
        <td colspan="5">
            <?php 
            if (count((array)$hasil) == 0) {
                echo "-";
            } else {
                echo "<ul>";
            
            $jenis = array();
            foreach ($hasil as $item) {
                $pemeriksaan = PemeriksaanradM::model()->findByPk($item->pemeriksaanrad_id);
                if (!empty($pemeriksaan) && empty($jenis[$pemeriksaan->pemeriksaanrad_id])) {
                    echo "<li>".$pemeriksaan->pemeriksaanrad_nama."</li>";
                }
            }
            
                echo "</ul>";
            }
            ?>
            
            
        </td>
    </tr>
    <tr>
        <td>Dr. Pengirim</td>
        <td>: </td>
        <?php 
    
            $pemeriksaan = array();
            foreach($pemeriksaanRad as $key => $pemeriksaan){
        ?>
         <?php }?>
        <td><?php
        !empty($pemeriksaan['dokterpengirim']) ? $pemeriksaan['gelardepan'].$pemeriksaan['dokterpengirim'] : "-"; 
        // echo $pemeriksaan['dokterpengirim'] == NULL ? '-': $pemeriksaan['gelardepan'].$pemeriksaan['dokterpengirim']; ?></td>
       
        <td></td>
    </tr>
    <tr>
        <td>Dr. Pembaca</td>
        <td>: </td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Ruangan</td>
        <td>: </td>
        <td><?php echo $data->ruanganasal_nama; ?></td>
        <td></td>
    </tr>
</table>
</div>


    
