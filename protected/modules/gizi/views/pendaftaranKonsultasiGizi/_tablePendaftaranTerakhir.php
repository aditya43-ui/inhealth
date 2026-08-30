<div class="block-tabel">
    <h6>
        <?php  echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 'javascript:void(0);', array('rel'=>'tooltop','title'=>'Klik untuk me-refresh tabel','class' => 'btn btn-default','onclick'=>"refreshDaftarPasien();",'disabled'=>FALSE  )); ?>
        <b>10 Pasien Konsultasi Gizi Terakhir</b>
    </h6>
    <?php 
    $modListPendaftaran = new GZPasienMasukPenunjangV();
    $modListPendaftaran->instalasiasal_id = Yii::app()->user->getState("instalasi_id");
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pendaftarterakhir-grid',
            'dataProvider'=>$modListPendaftaran->searchPendaftaranTerakhir(),
            'template'=>"{pager}\n{items}",
            'itemsCssClass'=>'table table-striped table-condensed table-responsive',
            'enableSorting' => false,
            'columns'=>array(
                array(
                    'header'=>'No.',
                    'value' => '$row+1',
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'name'=>'tgl_pendaftaran',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                ),
                'no_pendaftaran',
                'no_rekam_medik',
                'nama_pasien',
                array(
                    'name'=>'tempat_lahir',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
                ),
                'umur',
                'jeniskelamin',
                'alamat_pasien',
//                    'no_mobile_pasien',
                array(
                    'name'=>'ruangan_nama',
                    'type'=>'raw',
                    'value'=>'$data->ruangan_nama',
                ),
                array(
                    'name'=>'nama_pegawai',
                    'type'=>'raw',
                    'value'=>'$data->gelardepan.$data->nama_pegawai.(isset($data->gelarbelakang_nama)?",".$data->gelarbelakang_nama : "")',
                ),
                'carabayar_nama',
                'penjamin_nama',
            ),
        )); 
    ?>
</div>