<table id="table_riwayattindakan" class="table table-bordered table-condensed table-striped">
    <thead>
        <th>No.</th>
        <th>Ruangan</th>
        <th>Tanggal Tindakan</th>
        <th width="30%">Tindakan/<br>Pemeriksa</th>
        <th>Jumlah</th>
        <th>Satuan</th>
        <th>Jumlah Tarif</th>
        <th>No. Nota</th>
        <th>Hapus</th>
        <th>Verifikasi</th>
    </thead>
    <tbody>
        <?php 
        if (count((array)$modRiwayatTindakans) > 0){
            foreach ($modRiwayatTindakans AS $i => $tindakan){
        ?>
            <tr>
                <td>
                    <?php echo ($i + 1); ?>
                    <?php echo CHtml::hiddenField('riwayatTindakan['.$i.'][tindakanpelayanan_id]',$tindakan->tindakanpelayanan_id,array('readonly'=>true, 'class' => 'tindakanpelayanan_id')); ?>
                    <?php echo CHtml::hiddenField('riwayatTindakan['.$i.'][pendaftaran_id]',$tindakan->tindakanpelayanan_id,array('readonly'=>true, 'class' => 'pendaftaran_id')); ?>
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
						echo (isset($tindakan->perawat2->NamaLengkap) ? " / ".$tindakan->perawat2->NamaLengkap : ""); 
						echo (isset($tindakan->supir->NamaLengkap) ? " / ".$tindakan->supir->NamaLengkap : ""); 
                    ?>         
                </td>
                <td><?php echo CHtml::textField('riwayatTindakan['.$i.'][qty_tindakan]',$tindakan->qty_tindakan,array('readonly'=>true,'class'=>'integer2','style'=>'width:30px;')); ?></td>
                <td><?php echo ($tindakan->satuantindakan); ?></td>
                <td><?php echo CHtml::textField('riwayatTindakan['.$i.'][jumlah_tarif]',$format->formatNumberForPrint($tindakan->qty_tindakan*$tindakan->tarif_satuan + $tindakan->tarifcyto_tindakan),array('readonly'=>true,'class'=>'integer2','style'=>'width:100px;')); ?></td>
                <td><?php echo !empty($tindakan->nopelayanan) ? $modPendaftaran->no_pendaftaran . $tindakan->nopelayanan : '-'; ?></td>
                <td>
                    <?php
                        echo CHtml::link("<i class=\"icon-form-silang\"></i>", 'javascript:void(0);', array('onclick'=>'hapusTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menghapus tindakan','data-placement'=>'left'));
                    ?>
                </td>
                <td>
                    <?php
                        echo CHtml::checkBox('is_verifikasi['.$i.']', !empty($tindakan->verifikasitagihan_id), array('onchange'=>'verifTindakan(this);'));
                        echo CHtml::hiddenField('is_verif['.$i.']', 'no', array('class' => 'is_verif'));
                    ?>
                </td>
            </tr>
        <?php
            }
        } 
        ?>
        
        
    </tbody>
</table>

<script>
    
    function setVerif(obj) {

        if($(obj).is(':checked')) {
            $(obj).closest('tr').find('.is_verif').val('yes');
        } else {
            $(obj).closest('tr').find('.is_verif').val('no');
        }

    }

</script>
