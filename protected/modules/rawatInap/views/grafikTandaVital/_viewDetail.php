<style>
    #imgtag {
        position: relative;
        min-width: 300px;
        min-height: 300px;
        float: none;
        border: 3px solid #FFF;
        cursor: crosshair;
        text-align: center;
    }

    .tab_thorax td {
        border: 1px solid black;
    }

    .tab_thorax {
        border: 1px solid black;
    }

    #tab_norton td,
    #tab_norton th {
        border: 1px solid black;
        padding: 2px;
    }

    #tab_norton th {
        font-weight: bold;
        text-align: center;
    }

    #tab_norton .skor,
    #tab_norton .total_skor {
        text-align: right;
    }
</style>
<table style="width: 100%; border: none; margin: 20px;">
    <tr>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('nama_pasien')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?>
        </td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('tgl_pendaftaran')); ?>:</label>
            <?php echo MyFormatter::formatDateTimeForUser(CHtml::encode($modPendaftaran->tgl_pendaftaran)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('jeniskelamin')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?>
        </td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('no_pendaftaran')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?>
        </td>
    </tr>
    <tr>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('umur')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->umur); ?>
        </td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Kelas Pelayanan')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->kelaspelayanan->kelaspelayanan_nama); ?>
        </td>
    </tr>
    <tr>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Jenis Penjamin / Penjamin ')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama); ?> / <?php echo CHtml::encode($modPendaftaran->penjamin->penjamin_nama); ?>

        </td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Nama Dokter')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->pegawai->nama_pegawai); ?>
        </td>
    </tr>
    <tr>
        <td>
        </td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($model->getAttributeLabel('Petugas Pengisi')); ?>:</label>
            <?php echo CHtml::encode($model->petugaspengisi->namaLengkap); ?>
        </td>
    </tr>
</table>

<table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
    <tr>
        <td colspan="4"><b>Monitoring Kondisi Tubuh</b></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Tanggal Monitoring</td>
        <td colspan="2" width="70%"><?php echo MyFormatter::formatDateTimeForUser($model->tgl_monitoring); ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Jam Monitoring</td>
        <td colspan="2" width="70%"><?php echo $model->jam_monitoring; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Pernapasan</td>
        <td colspan="2" width="70%"><?php echo $model->pernapasan; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Suhu Tubuh</td>
        <td colspan="2" width="70%"><?php echo $model->suhu; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Nadi</td>
        <td colspan="2" width="70%"><?php echo $model->nadi; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Tekanan Darah (mm/Hg)</td>
        <td colspan="2" width="70%"><?php echo $model->td_systolic . " / " . $model->td_dyastolic; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Infeksi Nosokomial</td>
        <td colspan="2" width="70%"><?php echo $model->mosokomial; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Berat Badan</td>
        <td colspan="2" width="70%"><?php echo $model->berat_badan; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Tinggi Badan</td>
        <td colspan="2" width="70%"><?php echo $model->tinggi_badan; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">BAB</td>
        <td colspan="2" width="70%"><?php echo $model->bab; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Cairan Masuk</td>
        <td colspan="2" width="70%"><?php echo $model->cairan_masuk; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Cairan Keluar</td>
        <td colspan="2" width="70%"><?php echo $model->cairan_keluar; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Keterangan</td>
        <td colspan="2" width="70%"><?php echo $model->keterangan; ?></td>
    </tr>
</table>