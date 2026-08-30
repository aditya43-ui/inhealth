<style>
    .tab_detail {
        width: 100%;
        color: black;
        border-collapse: collapse;
    }
    
    .tab_detail th, .tab_detail td {
        border: 1px solid black;
        padding: 5px;
    }
    
    .tab_header td {
        vertical-align: top;
    }
</style>

<?php echo $this->renderPartial($this->path_view."_headerPrint", array(
    'daftar'=>$pendaftaran, 'judulLaporan'=>$judulLaporan
), true); ?>

<table class="tab_detail">
    <thead>
        <tr>
            <th>No.</th>
            <th>Penjelasan/KIE</th>
            <th>Tanggal</th>
            <th>Metode & Durasi</th>
            <th>Keterangan dan Evaluasi</th>
            <th>Nama Edukator</th>
            <th>Paraf Pasien/Keluarga</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($model as $idx=>$item): 
            
            ?>
        <tr>
            <td><?php echo $idx+1; ?></td>
            <td><?php echo $item->penjelasan_kie; ?></td>
            <td><?php echo date('d/m/Y H:i:s', strtotime($item->tgl_edukasi)); ?></td>
            <td><?php echo $item->metodeedukasi."/".$item->durasi." Menit"; ?></td>
            <td><?php echo $item->keterangan_dan_evaluasi; ?></td>
            <td><?php echo empty($item->edukator) ? "-" : $item->edukator->namaLengkap; ?></td>
            <td style="text-align: center;"><?php echo $item->hubungankeluarga; ?><br/><br/><br/><?php echo empty($item->penerimaedukasi) ? "" : "(".$item->penerimaedukasi.")"; ?></td>
        </tr>
        
        <?php endforeach; ?>
        
    </tbody>
</table>
<br>
<table width="170%">
    <tr>
        <td></td>
        <td width="50%">
        <?php $url_photopasien = (!empty($item->foto_penerimaedukas) ? $item->foto_penerimaedukas : Params::urlAmbilObatDirectory() . "no_photo.jpeg"); ?>
        <img id="photo-preview" src="<?php echo $url_photopasien ?>" style="width: 160px;"><br>
        </td>
    </tr>
</table>