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
            <th>Penjelasan</th>
            <th>Tanggal</th>
            <th>Metode & Durasi</th>
            <th>Keterangan dan Evaluasi Respon</th>
            <th>Nama Edukator</th>
            <th>Paraf Pasien/Keluarga</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($model as $idx=>$item): 
            
            ?>
        <tr>
            <td><?php echo $idx+1; ?></td>
            <td><?php
            $det = CatatanedikasipenjT::model()->findAllByAttributes(array(
                'catatanedukasi_id'=>$item->catatanedukasi_id,
            ), array(
                'order'=>'urutan'
            ));
            
            if (count($det) > 0) {
                echo "<ul>";
                foreach ($det as $item2) {
                    if (!$item2->isceklis) {
                        continue;
                    }
                    echo "<li>";
                    echo $item2->nama_edukasi;
                    if ($item2->nama_edukasi == "Lainnya") {
                        echo ", ".$item2->lainnya;
                    }
                    echo "</li>";
                }
                echo "</ul>";
            } else {
                echo "-";
            }
            ?></td>
            <td><?php echo date('d/m/Y H:i:s', strtotime($item->tgl_edukasi)); ?></td>
            <td><?php echo $item->metodeedukasi."/".$item->durasi." Menit"; ?></td>
            <td><?php 
            $det = CatatanedukasiketEvaluasiT::model()->findAllByAttributes(array(
                'catatanedukasi_id'=>$item->catatanedukasi_id,
            ), array(
                'order'=>'urutan'
            ));
            
            if (count($det) > 0) {
                echo "<ul>";
                foreach ($det as $item2) {
                    if (!$item2->isceklis) {
                        continue;
                    }
                    echo "<li>";
                    echo $item2->keterangan_evaluasi;
                    if ($item2->keterangan_evaluasi == "Lainnya") {
                        echo ", ".$item2->lainnya;
                    }
                    echo "</li>";
                }
                echo "</ul>";
            } else {
                echo "-";
            }
            
             ?></td>
            <td><?php echo empty($item->edukator) ? "-" : $item->edukator->namaLengkap; ?></td>
            <td style="text-align: center;"><?php echo $item->hubungankeluarga; ?><br/><br/><br/><?php echo empty($item->penerimaedukasi) ? "" : "(".$item->penerimaedukasi.")"; ?></td>
        </tr>
        
        <?php endforeach; ?>
    </tbody>
</table>