<?php

// header

?>

<style>
    
    .tab_informasi th, .tab_informasi td {
        padding: 2px;
        border: 1px solid black;
    }
    
    .tab_informasi th {
        font-weight: bold;
        text-align: center;
        vertical-align: middle;
    }
    
    .tab_head2 {
        border: 1px solid black;
        marign-bottom: 10px;
    }
    
    .tab_head2 td {
        vertical-align: bottom;
    }
    
    .mid {
        text-align: center;
        vertical-align: middle;
    }
    
    table td {
        padding: 2px;
    }
    
    
</style>
<?php $profil=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<table width="100%">
    <tr>
        <td width="100">
            <img src="<?php echo Params::urlProfilRSPDFPath().$profil->logo_rumahsakit ?> " style="float:left; max-width: 100px; width:100px;" class='image_report'/>
        </td>
        <td style="text-align: center;"><h3><b>SURAT <?php echo strtoupper($surat->jenissurat); ?> TINDAKAN <?php echo $model->jenisanestesi; ?></b></h3></td>
    </tr>
</table>
<table width="100%" class="tab_head2">
    <tr>
        <td colspan="2" style="text-align: center;">PEMBERIAN INFORMASI</td>
    </tr>
    <tr>
        <td width="200">Dokter Pelaksana Tindakan</td>
        <td>: <?php echo empty($model->dokterpelaksanatindakan) ? "-" : $model->dokterpelaksanatindakan->namaLengkap; ?></td>
    </tr>
    <tr>
        <td>Pemberi Informasi</td>
        <td>: <?php echo empty($model->pemberiinformasi) ? "-" : $model->pemberiinformasi->namaLengkap; ?></td>
    </tr>
    <tr>
        <td>Penerima Informasi/<br/>Pemberi Persetujuan</td>
        <td>: <?php echo empty($model->penerimainformasi_nama) ? "-" : $model->penerimainformasi_nama; ?></td>
    </tr>
</table>
<br/>
<table width="100%" class="tab_informasi">
    <thead>
        <tr>
            <th>No.</th>
            <th>Jenis Informasi</th>
            <th>Isi Informasi</th>
            <th>Status Pemberian Informasi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($detail as $idx=>$item): 
            
            $jenis = JenisinformasiM::model()->findByPk($item->jenisinformasi_id);
            
            ?>
        <tr>
            <td width="10" class="mid"><?php echo $idx + 1; ?></td>
            <td width="200" style="vertical-align: middle;"><?php echo $jenis->jenisinformasi_nama; ?></td>
            <td>
                <?php
                if ($jenis->tipeinput_isiinformasi == Params::TIPEINPUT_ISIINFORMASI_PENJELASANTETAP) {
                    echo $item->pemberianinformasi_isian;
                } else if ($jenis->tipeinput_isiinformasi == Params::TIPEINPUT_ISIINFORMASI_DIINPUTOLEHUSER) {
                    echo $item->pemberianinformasi_isian;
                } else if ($jenis->tipeinput_isiinformasi == Params::TIPEINPUT_ISIINFORMASI_CHECKBOX) {
                    $ceklis = ChecklistpemberianinformasiT::model()->findAllByAttributes(array(
                        'pemberianinformasidet_id'=>$item->pemberianinformasidet_id,
                    ), array(
                        'order'=>'checklistpemberianinformasi_id asc'
                    ));
                    echo "<ul>";
                    foreach ($ceklis as $item2) {
                        if (!$item2->checklistpemberianinformasi_ceklis) {
                            continue;
                        }
                        echo "<li>".$item2->checklistpemberianinformasi_nama."</li>";
                    }
                    echo "</ul>";
                }  
                
                
                ?>
            </td>
            <td width="150" class="mid"><?php echo $item->pemberianinformasi_hasil; ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3">Dengan ini menyatakan bahwa saya telah menerangkan hal-hal di atas secara benar dan jelas serta 
            memberikan kesempatan untuk bertanya dan berdiskusi.</td>
            <td class="mid">Tanda Tangan<br/><br/><br/><br/>Pemberi Informasi</td>
        </tr>
        <tr>
            <td colspan="3">Dengan ini menyatakan bahwa saya telah menerima informasi sebagaimana diatas yang saya beri 
            tanda/paraf di kolom kanannya, dan telah memahaminya.</td>
            <td class="mid">Tanda Tangan<br/><br/><br/><br/>Pasien/Keluarga</td>
        </tr>
    </tbody>
</table>