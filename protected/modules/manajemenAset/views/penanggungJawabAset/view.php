
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Penanggung Jawab Aset Ruangan</b>
        </div>
    </div>
    <div class="panel-body">
    <?php
    $this->breadcrumbs=array(
            'Penanggung Jawab Aset Ruangan'=>array('admin'),
            $model->penanggungjawabaset_id,
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'penanggungjawabaset_id',
                    'pegawai.namaLengkap',
                    'lokasi.lokasiaset_namalokasi',
                    'ruangan.ruangan_nama',                    
                    [
                        'label' => 'Status',
                        'value' => ($model->penanggungjawabaset_aktif)?'Aktif':'Tidak Aktif'
                    ],
            ),
    )); ?>
        <div class="form-actions">
    <?= $this->renderPartial('_buttonPengaturan',['model'=>$model],true); ?>    
    <?php $this->widget('UserTips',array('type'=>'view'));?>
        </div>
</div>