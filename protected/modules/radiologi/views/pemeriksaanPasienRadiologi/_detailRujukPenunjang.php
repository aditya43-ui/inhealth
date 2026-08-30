<style>
    body {
        color: black;
    }
    
    .tab_header {
        width: 100%;
    }
    
    .tab_header td {
        padding: 2px;
        vertical-align: top;
    }
    
    .tab_header .unwrap {
        width:100%;
    }
    
    .tab_header td:not(.unwrap) {
        white-space: nowrap;
    }
</style>

<table class="tab_header">
    <tr>
        <td>Tgl. Pendaftaran</td>
        <td>:</td>
        <td class="unwrap"><?php echo MyFormatter::formatDateTimeForUser($penunjang->tgl_pendaftaran); ?></td>
        <td>Tgl. Masuk Penunjang</td>
        <td>:</td>
        <td><?php echo MyFormatter::formatDateTimeForUser($penunjang->tglmasukpenunjang); ?></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
        <td>:</td>
        <td class="unwrap"><?php echo $penunjang->no_pendaftaran; ?></td>
        <td>No. Masuk Penunjang</td>
        <td>:</td>
        <td><?php echo $penunjang->no_masukpenunjang; ?></td>
    </tr>
    <tr>
        <td>No. Rekam Medik</td>
        <td>:</td>
        <td class="unwrap"><?php echo $penunjang->no_rekam_medik; ?></td>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $penunjang->namadepan." ".$penunjang->nama_pasien; ?></td>
    </tr>
    <tr>
        <td>Instalasi Asal</td>
        <td>:</td>
        <td class="unwrap"><?php echo $penunjang->instalasiasal_nama; ?></td>
        <td>Ruangan Asal</td>
        <td>:</td>
        <td><?php echo $penunjang->ruanganasal_nama; ?></td>
    </tr>
    <tr>
        <td>Jenis Penjamin</td>
        <td>:</td>
        <td class="unwrap"><?php echo $penunjang->carabayar_nama; ?></td>
        <td>Penjamin</td>
        <td>:</td>
        <td><?php echo $penunjang->penjamin_nama; ?></td>
    </tr>
    <tr>
        <td colspan="6"><hr></td>
    </tr>
    <tr>
        <td>Tgl. Rujukan</td>
        <td>:</td>
        <td class="unwrap"><?php echo MyFormatter::formatDateTimeForUser($model->pemeriksaankeluar_tgl); ?></td>
        <td>Pemeriksaan</td>
        <td>:</td>
        <td>
            <?php
            $daftar = DaftartindakanM::model()->findByPk($tindakan->daftartindakan_id);
            echo $daftar->daftartindakan_nama;
            
            ?>
        </td>
    </tr>
    <tr>
        <td>Klinik Rujukan</td>
        <td>:</td>
        <td class="unwrap">
            <?php
            $klinik = LabklinikrujukanM::model()->findByPk($model->labklinikrujukan_id);
            echo !empty($klinik->labklinikrujukan_nama) ? $klinik->labklinikrujukan_nama : "-";
            ?>
        </td>
        <td>Dokter Pengirim</td>
        <td>:</td>
        <td>
            <?php
            $peg = PegawaiM::model()->findByPk($model->dokterpengirim_id);
            echo $peg->namaLengkap;
            ?>
        </td>
    </tr>
    <tr>
        <td>Perawat</td>
        <td>:</td>
        <td class="unwrap">
            <?php
            $peg = PegawaiM::model()->findByPk($tindakan->perawat_id);
            echo $peg->namaLengkap;
            ?>
        </td>
        <td>Supir</td>
        <td>:</td>
        <td>
            <?php
            $peg = PegawaiM::model()->findByPk($tindakan->supir_id);
            echo $peg->namaLengkap;
            ?>
        </td>
    </tr>
    <tr>
        <td>Alasan Dirujuk</td>
        <td>:</td>
        <td class="unwrap"><?php echo $model->pemeriksaankeluar_alasan; ?></td>
        <td>Keterangan</td>
        <td>:</td>
        <td class="unwrap"><?php echo $model->pemeriksaankeluar_ket; ?></td>
    </tr>
</table>
