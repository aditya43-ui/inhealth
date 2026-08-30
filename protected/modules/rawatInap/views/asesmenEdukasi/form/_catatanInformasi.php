<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Catatan Informasi dan Edukasi Terintegrasi
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tanggal dan Jam</th>
                    <th>Materi Edukasi</th>
                    <th>Metode Edukasi</th>
                    <th>Durasi Waktu</th>
                    <th>Hasil Evaluasi/Verifikasi</th>
                    <th>Nama Pemberi Informasi/Edukasi</th>
                    <th>Nama Penerima Edukasi</th>
                    <th>Ubah</th>
                    <th>Hapus</th>
                </tr>                
            </thead>
            <tbody>
                <?php
                    if (!empty($getDet)){
                        foreach ($getDet as $det){
                            $det->jam_awal = date('H:i:s',strtotime($det->tglpemeriksaan));
                            $det->jam_akhir = date('H:i:s',strtotime($det->tglpemeriksaan.' +'.$det->durasi.' minutes'));
                            
                            echo $this->renderPartial($this->path_view.'form/_rowInformasi',array('modDet'=>$det));
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>