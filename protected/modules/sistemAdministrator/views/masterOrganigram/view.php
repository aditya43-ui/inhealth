<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Detail Organigram</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php
                $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'organigram_id',
                        array(
                            'name' => 'organigramasal_id',
                            'value' => isset($model->organigramasal->pegawai->NamaLengkap) ? $model->organigramasal->pegawai->NamaLengkap : (isset($model->organigramasal->organigram_unitkerja) ? $model->organigramasal->organigram_unitkerja : "-"),
                        ),
                        'organigram_kode',
                        'organigram_unitkerja',
                        'organigram_formasi',
                        'organigram_pelaksanakerja',
                    ),
                ));
                ?>
            </div>
            <div class="col-sm-6">
                <?php
                $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        array(
                            'name' => 'pegawai_id',
                            'value' => isset($model->pegawai->NamaLengkap) ? $model->pegawai->NamaLengkap : "-",
                        ),
                        array(
                            'label' => 'Jabatan',
                            'value' => isset($model->pegawai->jabatan->jabatan_nama) ? $model->pegawai->jabatan->jabatan_nama : "-",
                        ),
                        'organigram_urutan',
                        array(
                            'name' => 'organigram_periode',
                            'value' => MyFormatter::formatDateTimeForUser($model->organigram_periode),
                        ),
                        array(
                            'name' => 'organigram_sampaidengan',
                            'value' => MyFormatter::formatDateTimeForUser($model->organigram_sampaidengan),
                        ),
                        'organigram_keterangan',
                        array(
                            'name' => 'organigram_aktif',
                            'value' => ($model->organigram_aktif) ? "Aktif" : "Non-aktif",
                        ),
                    ),
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Organigram ', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('content' => '')); ?>
        </div>
    </div>
</div>