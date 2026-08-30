<div class="panel panel-darkk">
    <span class="group-title">
        Hasil Evaluasi dan Verifikasi Informasi dan Edukasi Terintegrasi
    </span>
    <div class="panel-body overflow-x"> 
        <table class="table table-bordered table-striped" id="table-hasilevaluasi">
            <thead>
                <tr>
                    <th rowspan="2">Tanggal Edukasi</th>
                    <th rowspan="2">Materi Edukasi</th>
                    <th rowspan="2">Metode Edukasi</th>
                    <th colspan="2">Durasi Waktu</th>
                    <th rowspan="2">Hasil Evaluasi/Verifikasi</th>
                    <th rowspan="2">Nama Pemberi Edukasi <span class="required">*</span></th>
                    <th rowspan="2">Nama Penerima Edukasi</th>
                </tr>
                <tr>
                    <th>Waktu Mulai</th>
                    <th>Waktu Selesai</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($getDet2)) {
                    $getDet2->kel_id = $getDet2->kel_data;
                    $getDet2->jam_awal = date('H:i:s', strtotime($getDet2->tglpemeriksaan));
                    $getDet2->jam_akhir = date('H:i:s', strtotime($getDet2->tglpemeriksaan . ' +' . $getDet2->durasi . ' minutes'));
                    $cekPegawai = PegawaiM::model()->findByPk($getDet2->pegawai_pemberiedukasi_id);
                    $getDet2->pegawai_pemberiedukasi_nama = $cekPegawai->namaLengkap;
                    $this->renderPartial($this->path_view . 'form/_rowUbah', array('modDet' => $getDet2));
                }
                ?>
            </tbody>
        </table>
    </div>
</div>