<table id="tabelDiagnosaobat" class="table table-striped table-bordered table-condensed table-responsive table-striped table-condensed">
    <thead>
        <tr>
            <th>Tgl Pelayanan</th>
            <th>Tgl Kunjungan Pasien / <br> 
                Tgl Admisi        
        </th>
            <th>Ruangan Asal</th>
            <th>Dokter</th>
            <th>Diagnosa</th>
            <th>Detail Obat</th>
        </tr>
    </thead>
    <tbody>
    <?php
        if(!empty($modPenjualanResep)){
           
            foreach($modPenjualanResep as $key=>$value){
                $diagnosa = PasienmorbiditasT::model()->findAllByAttributes(array(
                    'kelompokdiagnosa_id'=>2,
                    'pendaftaran_id'=>$value->pendaftaran_id
                ));
                $detailObat = FAObatalkesPasienT::model()->findAllByAttributes(array(
                    'penjualanresep_id'=>$value->penjualanresep_id
                ));
                $pasienadmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$value->pendaftaran_id));
                ?>
                    <tr>
                        <td><?= MyFormatter::formatDateTimeForUser($value->tglpenjualan) ?></td>
                        <td><?= MyFormatter::formatDateTimeForUser($value->pendaftaran->tgl_pendaftaran); ?> / <br>
                            <?= !empty($pasienadmisi) ? MyFormatter::formatDateTimeForUser($pasienadmisi->tgladmisi) :  '-'  ?>
                        </td>
                        <td> <?= $value->ruanganasal_nama ?> </td>
                        <td> <?= $value->pegawai->nama_pegawai ?> </td>
                        <td>
                            <?php 
                                if(!empty($diagnosa)){
                                    foreach($diagnosa as $namaDiag){
                                        echo ' - '.$namaDiag->diagnosa->diagnosa_nama .'<br>';
                                    }
                                }
                            ?>

                        </td>
                        <td>
                            <?php
                                if(!empty($detailObat)){
                                    foreach($detailObat as $obat){
                                        echo ' - '.$obat->obatalkes->obatalkes_nama .'<br>';
                                    }
                                }
                            ?>
                        </td>
                    </tr>
                <?php
            }
        }
    
    ?> 
    </tbody>
</table>