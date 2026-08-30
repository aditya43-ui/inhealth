<div class="row">
    <div class="col-sm-6">
        <legend class="btn-info">Data Kunjungan</legend>
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$modKunjungan,
            'attributes'=>array(
                'no_pendaftaran',
                array(
                    'name'=>'tgl_pendaftaran',
                    'value'=>MyFormatter::formatDateTimeForUser($modKunjungan->tgl_pendaftaran),
                ),
                'no_rekam_medik',
                'nama_pasien',
                'jeniskelamin',
                array(
                    'name'=>'tanggal_lahir',
                    'value'=>MyFormatter::formatDateTimeForUser($modKunjungan->tanggal_lahir),
                ),
            ),
    )); ?>
    </div>
    
    <div class="col-sm-6">
        <legend class="btn-info">Data Retur</legend>
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                array(
                    'name'=>'tglretur',
                    'value'=>MyFormatter::formatDateTimeForUser($model->tglretur),
                ),
                array(
                    'name'=>'noretur',
                    'type'=>'raw',
                    'value'=>'-- Otomatis --',
                ),
				'alasanretur',
				'keteranganretur',
                array(
                    'label'=>$model->getAttributeLabel('mengetahui_id'),
                    'type'=>'raw',
                    'value'=>(!empty($model->mengetahui_id) ? $model->pegawai->gelardepan." ".$model->pegawai->nama_pegawai.(isset($model->pegawai->gelarbelakang->gelarbelakang_nama) ? ", ".$model->pegawai->gelarbelakang->gelarbelakang_nama : "") : "-"),
                ),
                array(
                    'label'=>$model->getAttributeLabel('pegretur_id'),
                    'type'=>'raw',
                    'value'=>(!empty($model->pegretur_id) ? $model->pegawairetur->gelardepan." ".$model->pegawairetur->nama_pegawai.(isset($model->pegawairetur->gelarbelakang->gelarbelakang_nama) ? ", ".$model->pegawairetur->gelarbelakang->gelarbelakang_nama : "") : "-"),
                ),
                array(
                    'label'=>"Total Penjualan",
                    'type'=>'raw',
                    'value'=>'<div style="text-align:right;">'.MyFormatter::formatUang($model->totalpenjualan,"",2).'</div>',
                ),
                array(
                    'label'=>$model->getAttributeLabel('totalretur'),
                    'type'=>'raw',
                    'value'=>'<div style="text-align:right;">'.MyFormatter::formatUang($model->totalretur,"",2).'</div>',
                ),
            ),
        )); ?>
    </div>
</div>