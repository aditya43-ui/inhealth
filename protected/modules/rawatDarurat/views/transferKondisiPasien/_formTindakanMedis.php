<div class="row">
    <div class="col-sm-12">
        <table class="table table-bordered table-condensed">
            <thead>
                <th>Tindakan</th>
            </thead>
            <tbody>
        <?php foreach ($modTindakans as $i => $modTindakan) { ?>
            <tr>
                <td>
                    <?php echo $modTindakan->tgl_tindakan; ?> <br/>
                    <?php echo !empty($modTindakan->tipePaket->tipepaket_nama) ? $modTindakan->tipePaket->tipepaket_nama:"-"; ?> <br/>

                    <?php echo $modTindakan->daftartindakan->daftartindakan_nama; ?>,
                    <?php echo $modTindakan->qty_tindakan; ?>
                    <?php echo $modTindakan->satuantindakan; ?> <br/>

                    Pemeriksa : 
                    <?php
                        echo (isset($modTindakan->dokter1->namaLengkap) ? $modTindakan->dokter1->namaLengkap : '');
                        echo (!empty($modTindakan->dokterpemeriksa1_id)) ? ',' : '';
                    ?>
                    <?php echo ((isset($modTindakan->dokter2)) ? $modTindakan->dokter2->namaLengkap : null); echo (!empty($modTindakan->dokterpemeriksa2_id)) ? ',' : ''; ?>
                    <?php echo ((isset($modTindakan->dokterPendamping)) ? $modTindakan->dokterPendamping->namaLengkap : null); echo (!empty($modTindakan->dokterpendamping_id)) ? ',' : ''; ?>
                    <?php echo ((isset($modTindakan->dokterAnastesi)) ? $modTindakan->dokterAnastesi->namaLengkap : null); echo (!empty($modTindakan->dokteranastesi_id)) ? ',' : ''; ?>
                    <?php echo ((isset($modTindakan->dokterDelegasi)) ? $modTindakan->dokterDelegasi->namaLengkap : null); echo (!empty($modTindakan->dokterdelegasi_id)) ? ',' : ''; ?>
                    <?php echo ((isset($modTindakan->bidan)) ? $modTindakan->bidan->nama_pegawai : null); echo (!empty($modTindakan->bidan_id)) ? ',' : ''; ?>
                    <?php echo ((isset($modTindakan->bidan2)) ? $modTindakan->bidan2->nama_pegawai : null); echo (!empty($modTindakan->bidan2_id)) ? ',' : ''; ?>
                    <?php echo ((isset($modTindakan->suster)) ? $modTindakan->suster->nama_pegawai : null); echo (!empty($modTindakan->suster_id)) ? ',' : ''; ?>
                    <?php echo ((isset($modTindakan->perawat)) ? $modTindakan->perawat->nama_pegawai : null); echo (!empty($modTindakan->perawat_id)) ? ',' : ''; ?>
                    <?php echo ((isset($modTindakan->perawat2)) ? $modTindakan->perawat2->nama_pegawai : null); echo (!empty($modTindakan->perawat2_id)) ? ',' : ''; ?>
                </td>
            </tr>
        <?php } ?>
            </tbody>
        </table>
    </div>
</div>