<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="row">
    <div class="col-sm-4">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'name' => 'pasien_id',
                    'type' => 'raw',
                    'value' => $model->pasien->nama_pasien
                ),
                array(
                    'name' => 'jenispeserta_id',
                    'type' => 'raw',
                    'value' => isset($model->jenispeserta_id) ? $model->jenispeserta->jenispeserta_nama : '-'
                ),
                array(
                    'name' => 'penjamin_id',
                    'type' => 'raw',
                    'value' => $model->penjamin->penjamin_nama
                ),
                array(
                    'name' => 'carabayar_id',
                    'type' => 'raw',
                    'value' => $model->carabayar->carabayar_nama
                ),
                array(
                    'name' => 'nokartuasuransi',
                    'type' => 'raw',
                    'value' => $model->nokartuasuransi
                ),
                array(
                    'name' => 'nopeserta',
                    'type' => 'raw',
                    'value' => $model->nopeserta
                ),
                array(
                    'name' => 'namapemilikasuransi',
                    'type' => 'raw',
                    'value' => $model->namapemilikasuransi
                ),
            ),
        )); ?>
    </div>
    <div class="col-sm-4">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'name' => 'tglcetakkartuasuransi',
                    'type' => 'raw',
                    'value' =>  MyFormatter::formatDateTimeForUser($model->tglcetakkartuasuransi)
                ),
                array(
                    'name' => 'kelastanggunganasuransi_id',
                    'type' => 'raw',
                    'value' => $model->kelastanggunganasuransi->kelaspelayanan_nama
                ),
                array(
                    'name' => 'kodefeskestk1',
                    'type' => 'raw',
                    'value' => $model->kodefeskestk1
                ),
                array(
                    'name' => 'nama_feskestk1',
                    'type' => 'raw',
                    'value' => $model->nama_feskestk1
                ),
                array(
                    'name' => 'kodefeskesgigi',
                    'type' => 'raw',
                    'value' => $model->kodefeskesgigi
                ),
                array(
                    'name' => 'namafeskesgigi',
                    'type' => 'raw',
                    'value' => $model->namafeskesgigi
                ),
                array(
                    'name' => 'namaperusahaan',
                    'type' => 'raw',
                    'value' => $model->namaperusahaan
                ),
            ),
        )); ?>
    </div>
    <div class="col-sm-4">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'name' => 'nomorpokokperusahaan',
                    'type' => 'raw',
                    'value' => $model->nomorpokokperusahaan
                ),
                array(
                    'name' => 'masaberlakukartu',
                    'type' => 'raw',
                    'value' =>  MyFormatter::formatDateTimeForUser($model->masaberlakukartu)
                ),
                array(
                    'name' => 'nokartukeluarga',
                    'type' => 'raw',
                    'value' => $model->nokartukeluarga
                ),
                array(
                    'name' => 'nopassport',
                    'type' => 'raw',
                    'value' => $model->nopassport
                ),
                array(
                    'name' => 'status_konfirmasi',
                    'type' => 'raw',
                    'value' => $model->status_konfirmasi
                ),
                array(
                    'name' => 'tgl_konfirmasi',
                    'type' => 'raw',
                    'value' =>  MyFormatter::formatDateTimeForUser($model->tgl_konfirmasi)
                ),
                array(
                    'name' => 'hubkeluarga',
                    'type' => 'raw',
                    'value' => $model->hubkeluarga
                ),
            ),
        )); ?>
    </div>
</div>