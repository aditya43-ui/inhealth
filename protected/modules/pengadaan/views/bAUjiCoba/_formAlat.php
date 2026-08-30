<div style="max-width:100%;overflow-x: scroll;">
    <table id="tblAlat" class="table table-responsive table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th style="text-align: center;" rowspan="2"> No. </th>
                <th style="text-align: center;" rowspan="2"> Tanggal </th>
                <th style="text-align: center;" rowspan="2"> Nama Alat yang Diuji Fungsi / Uji Coba <span class="required">*</span> </th>
                <th style="text-align: center;" rowspan="2"> Keterangan </th>
                <th style="text-align: center;" rowspan="2"> Satuan <span class="required">*</span> </th>
                <th style="text-align: center;" rowspan="2"> Jumlah <span class="required">*</span> </th>
                <th style="text-align: center;" colspan="2"> Kelengkapan </th>
                <th style="text-align: center;" rowspan="2"> Berfungsi Baik </th>
                <th style="text-align: center;" rowspan="2" class="aksi"> Aksi </th>
            </tr>
            <tr>
                <th style="text-align: center;"> Ada </th>
                <th style="text-align: center;"> Tidak </th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (!empty($model->baujifungsi_id)) {
                $cekUji = BaujifungsiT::model()->findByAttributes(array('baujifungsi_id' => $model->baujifungsi_id));
                $modCekDetail = BaujifungsidetT::model()->findAllByAttributes(array('baujifungsi_id' => $cekUji->baujifungsi_id));
                if (!empty($modCekDetail)) {
                    $models = BaujifungsidetT::model()->findAllByAttributes(array('baujifungsi_id' => $cekUji->baujifungsi_id));
                } else {
                    $models = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id));
                }
            } else {
                $models = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id));
            }
            
            $model_ = new BaujifungsidetT;
            if(count($models) > 0){
                foreach ($models AS $i=>$modSurat){
                    if (!empty($modSurat->dokumenpelaksanaananggarandet_id)) {
                        $model_->barang_id = $modSurat->barang_id;
                        $model_->jenis_barang = $modSurat->jenis_barang;
                        $model_->nama_barang = $modSurat->barang_nama;
                        $model_->satuan_barang = $modSurat->barang_satuan;
                        $model_->jumlah_barang = $modSurat->barang_jumlah;
                        $model_->hasil = $model_->hasil;
                        $model_->islengkap = 0;
                        $model_->isfungsibaik = false;
                        $model_->baujifungsidet_tanggal = date('d M Y');
                    } else {
                        $model_->baujifungsidet_id = $modSurat->baujifungsidet_id;
                        $model_->baujifungsi_id = $modSurat->baujifungsi_id;
                        $model_->barang_id = $modSurat->barang_id;
                        $model_->jenis_barang = $modSurat->jenis_barang;
                        $model_->nama_barang = $modSurat->nama_barang;
                        $model_->jumlah_barang = $modSurat->jumlah_barang;
                        $model_->satuan_barang = $modSurat->satuan_barang; 
                        $model_->hasil_uji = $modSurat->hasil_uji;
                        $model_->keterangan_uji = $modSurat->keterangan_uji;
                        $model_->islengkap = empty($modSurat->islengkap)? 0 : $modSurat->islengkap;
                        $model_->isfungsibaik = empty($modSurat->isfungsibaik)? false : $modSurat->isfungsibaik;
                        $model_->baujifungsidet_tanggal = empty($modSurat->baujifungsidet_tanggal)? date('d M Y') : MyFormatter::formatDateTimeForUser($modSurat->baujifungsidet_tanggal);
                    }
                    echo $this->renderPartial('_rowAlat',array('model'=>$model_, 'i' => $i),true);
                }
            } else {
                echo $this->renderPartial('_rowAlat',array('model'=>$model_, 'i' => 0),true);
            }
            ?>
        </tbody>
    </table>
</div>

