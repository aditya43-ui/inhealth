<?php
    $i = !empty($i)?$i:0;
    $jadwalempty = !empty($jadwalempty)?$jadwalempty:0;
?>

<tr id="<?= $model->resepturdetail_id; ?>" row-data="<?= $i; ?>">
    <td>
        <?php
            $subjenis_nama = '';
            $subjenis_id = '';
            if (!empty($model->subjenis_nama)) {
                $subjenis_nama = $model->subjenis_nama.'<br/>';
                $subjenis_id = $model->subjenis_id;            
            }           
        ?>
        <span class="no_urut"><?= $i+1 ?></span>
        <input type="hidden" name="CatatanPemberianObat[<?= $i; ?>][obatalkes_id]" value="<?= $model->obatalkes_id; ?>" />
        <input type="hidden" name="CatatanPemberianObat[<?= $i; ?>][dosisobat]" value="<?= $model->signa_reseptur; ?>" />
        <input type="hidden" name="CatatanPemberianObat[<?= $i; ?>][aturanpakaiobat]" value="<?= $model->etiket; ?>" />
        <input type="hidden" name="CatatanPemberianObat[<?= $i; ?>][jenisinfus]" value="<?= $subjenis_nama; ?>" />
        <input type="hidden" name="CatatanPemberianObat[<?= $i; ?>][penerimaan_status]" value="Belum Diterima" />                                                                                
        <input type="hidden" name="CatatanPemberianObat[<?= $i; ?>][resepturdetail_id]" value="<?= $model->resepturdetail_id ?>" />                                                                                
    </td>
    <td class="riwayat-nama-obat">
        <?php       
        echo $subjenis_nama;
        echo (!empty($model->racikan)?$model->racikan_nama:'').'<br/>';
        echo !empty($model->obatlain_nama) ? $model->obatlain_nama : $model->obatalkes_nama.'<br/>';
        
        
        
        ?>                
    </td>
    <td class="riwayat-signa"><?= $model->signa_reseptur; ?></td>
    <td class="riwayat-etiket"><?= $model->etiket; ?></td>
    <td class="riwayat-qty"><?= $model->qty_reseptur.' '.$model->satuankecil_nama; ?></td>
    <td class="riwayat-jadwal-pemberian">
    <?php              
        if (!empty($model->listJadwal)) {
            foreach ($model->listJadwal as $key => $jadwal) {
    ?>                                                    
                <input type="hidden" name="CatatanPemberianObat[<?= $i; ?>][jadwal_pemberian][<?= $key; ?>][jadwal]" value="<?= $jadwal->jadwal; ?>" />
                <input <?= ($jadwalempty)?'checked':'' ?> type="checkbox" value="<?= $jadwal->jadwalpemberianobat_id; ?>" name="CatatanPemberianObat[<?= $i; ?>][jadwal_pemberian][<?= $key; ?>][jadwalpemberianobat_id]">
                <?= $jadwal->jadwal; ?>
    <?php
            }
        } else {
            echo "-";
        }        
    ?>
    </td>
</tr>