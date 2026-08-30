<?php
$model->load_all = true;
$data = $model->search_riwayat_implementasi_by_rencana();
?>

<table with="100%" class="status">
    <tr class="identitas">
        <td width="20%">No. Rekam Medik</td>
        <td wdith="2%">:</td>
        <td><?= $rencana->no_rekam_medik; ?></td>
        <td width="10%"></td>
        <td width="20%">Tanggal Lahir</td>
        <td width="2%">:</td>
        <td><?= MyFormatter::formatDateTimeForUser($pasien->tanggal_lahir); ?></td>
    </tr>
    <tr class="identitas">
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?= $rencana->nama_pasien; ?></td>
        <td></td>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td><?= $rencana->jeniskelamin; ?></td>
    </tr>
    <tr class="identitas">
        <td >Ruangan</td>
        <td>:</td>
        <td><?= $rencana->ruangan_nama; ?></td>
    </tr>
    <tr class="identitas">
        <td>Intervensi</td>
        <td>:</td>
        <td><?php 
            $li = '';
            if (!empty($data->getData())){
                foreach($data->getData() as $load){
                   foreach($load["det"] as $det){
                        if (isset($det['indikator'])){
                            foreach($det['indikator'] as $imp){
                                $li .= "<li>".$imp."</li>";
                            }
                        }
                    }  
                }
                
                if (!empty($li)){
                    $li = "<ol>".$li."</ol>";
                }
                
                echo $li;
            }
        ?></td>
    </tr>
</table>