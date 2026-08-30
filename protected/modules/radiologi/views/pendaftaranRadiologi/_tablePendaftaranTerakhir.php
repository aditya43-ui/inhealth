<div class="panel panel-success" style="margin-top: 17px;">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> 10 Pasien <b>Radiologi Terakhir</b>
            <?php echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), 'javascript:void(0);', array('rel' => 'tooltop', 'title' => 'Klik untuk me-refresh tabel', 'class' => 'btn btn-default', 'onclick' => "refreshDaftarPasien();", 'disabled' => FALSE)); ?>
        </div>
    </div>
    <div class="panel-body" style="max-height: 200px; overflow: auto;">
        <?php
        $modListPendaftaran = new ROPasienMasukPenunjangV();
        //$modListPendaftaran->instalasiasal_id = Params::INSTALASI_ID_RAD;
        $modListPendaftaran->ruangan_id = Params::RUANGAN_ID_RAD;
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'pendaftarterakhir-rj-grid',
            'dataProvider' => $modListPendaftaran->searchPendaftaranTerakhir(),
            'template' => "{pager}\n{items}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed table-responsive',
            'enableSorting' => false,
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '$row+1',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'name' => 'tgl_pendaftaran',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                ),
                'no_pendaftaran',
                'no_rekam_medik',
                'nama_pasien',
                array(
                    'name' => 'tempat_lahir',
                    'type' => 'raw',
                    'value' => '(!empty($data->tempat_lahir)?$data->tempat_lahir:"-")',
                ),
                'umur',
                'jeniskelamin',
                'alamat_pasien',
                //                    'no_mobile_pasien',
                array(
                    'name' => 'ruangan_nama',
                    'type' => 'raw',
                    'value' => '$data->ruangan_nama',
                ),
                array(
                    'name' => 'nama_pegawai',
                    'type' => 'raw',
                    'value' => '$data->gelardepan.$data->nama_pegawai.(isset($data->gelarbelakang_nama)?",".$data->gelarbelakang_nama : "")',
                ),
                //                    'carabayar_nama',
                //                    'penjamin_nama',
                array(
                    'name' => 'carabayar_nama',
                    'type' => 'raw',
                    'value' => '(isset($data->carabayar_nama)?$data->carabayar_nama:"")',
                ),
                array(
                    'name' => 'penjamin_nama',
                    'type' => 'raw',
                    'value' => '(isset($data->penjamin_nama)?$data->penjamin_nama:"")',
                ),
            ),
        ));
        ?>
    </div>
</div>