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
                            <th rowspan="2">Nama Pemberi Edukasi <span>*</span></th>
                            <th rowspan="2">Nama Penerima Edukasi</th>
                        </tr>
                       
                    </thead>
                    <tbody>
                        <?php 
                            if (!empty($getDet)){
                                foreach($getDet as $det){
                                   $det->kel_id = $det->kel_data;
                                   $det->jam_awal = date('H:i:s',strtotime($det->tglpemeriksaan));
                                    $det->jam_akhir = date('H:i:s',strtotime($det->tglpemeriksaan.' +'.$det->durasi.' minutes'));
//                                    $cekPegawai = PegawaiM::model()->findByPk($det->pegawai_pemberiedukasi_id);
                                    $cekPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                                    $det->pegawai_pemberiedukasi_nama = $cekPegawai->namaLengkap;
                                    echo $this->renderPartial($this->path_view.'form/_rowTabel',array('modDet'=>$det));
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
</div>