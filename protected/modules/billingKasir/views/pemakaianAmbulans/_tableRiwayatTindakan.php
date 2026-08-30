<table id="table_riwayattindakan" class="table table-bordered table-condensed table-striped">
    <thead>
        <th>No.</th>
        <th>Ruangan</th>
        <th>Tanggal Tindakan</th>
        <th width="30%">Tindakan/<br>Pemeriksa</th>
        <th>Jumlah</th>
        <th>Satuan</th>
        <th>Jumlah Tarif</th>
        <th>Hapus</th>
    </thead>
    <tbody>
        <?php 
        if (count((array)$modRiwayatTindakans) > 0){
            foreach ($modRiwayatTindakans AS $i => $tindakan){
        ?>
            <tr>
                <td>
                    <?php echo ($i + 1); ?>
                    <?php echo CHtml::hiddenField('riwayatTindakan['.$i.'][tindakanpelayanan_id]',$tindakan->tindakanpelayanan_id,array('readonly'=>true)); ?>
                </td>
                <td><?php echo ($tindakan->ruangan->ruangan_nama); ?></td>
                <td><?php echo ($format->formatDateTimeForUser($tindakan->tgl_tindakan)); ?></td>
                <td>
                    <?php echo ($tindakan->daftartindakan->kategoritindakan_nama)."-".($tindakan->daftartindakan->daftartindakan_nama)." ( Ket: ".$tindakan->keterangantindakan." )"; ?><br>
                    <?php 
                        echo "Pemeriksa: ".(isset($tindakan->dokterpemeriksa1_id)?$tindakan->dokter1->NamaLengkap:"");
                        echo (isset($tindakan->dokter2->NamaLengkap) ? " / ".$tindakan->dokter2->NamaLengkap : ""); 
                        echo (isset($tindakan->dokterPendamping->NamaLengkap) ? " / ".$tindakan->dokterPendamping->NamaLengkap : ""); 
                        echo (isset($tindakan->dokterAnastesi->NamaLengkap) ? " / ".$tindakan->dokterAnastesi->NamaLengkap : ""); 
                        echo (isset($tindakan->dokterDelegasi->NamaLengkap) ? " / ".$tindakan->dokterDelegasi->NamaLengkap : ""); 
                        echo (isset($tindakan->bidan->NamaLengkap) ? " / ".$tindakan->bidan->NamaLengkap : ""); 
                        echo (isset($tindakan->suster->NamaLengkap) ? " / ".$tindakan->suster->NamaLengkap : ""); 
                        echo (isset($tindakan->perawat->NamaLengkap) ? " / ".$tindakan->perawat->NamaLengkap : ""); 
                        ?>
                
                </td>
                <td><?php echo CHtml::textField('riwayatTindakan['.$i.'][qty_tindakan]',$tindakan->qty_tindakan,array('readonly'=>true,'class'=>'integer','style'=>'width:30px;')); ?></td>
                <td><?php echo ($tindakan->satuantindakan); ?></td>
                <td><?php echo CHtml::textField('riwayatTindakan['.$i.'][jumlah_tarif]',$format->formatNumberForUser($tindakan->qty_tindakan*$tindakan->tarif_satuan + $tindakan->tarifcyto_tindakan),array('readonly'=>true,'class'=>'integer','style'=>'width:100px;')); ?></td>
                <td>
                    <?php
                        echo CHtml::link("<i class=\"icon-remove\"></i>", 'javascript:void(0);', array('onclick'=>'hapusTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menghapus tindakan'));
                    ?>
                </td>
            </tr>
        <?php
            }
        } 
        ?>
        
        
    </tbody>
</table>

