<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
        <?php  echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltop','title'=>'Klik untuk me-refresh tabel','class'=>'btn btn-danger','onclick'=>"refreshDaftarPasien();",'disabled'=>FALSE  )); ?>
        <strong>10 Pasien Laboratorium Terakhir</strong>
        </div>
    </div>
    <div class="panel-body">
    <?php 
    $modListPendaftaran = new LBPasienMasukPenunjangV();
    $modListPendaftaran->ruangan_id = Yii::app()->user->getState('ruangan_id');
    //$modListPendaftaran->instalasiasal_id = Params::INSTALASI_ID_LAB_PA;
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pendaftarterakhir-rj-grid',
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
</div>