
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Jadwal Pemberian Obat</b>
        </div>
    </div>
    <div class="panel-body">
    <?php
    $this->breadcrumbs=array(
            'Jadwal Pemberian Obat'=>array('admin'),
            $model->jadwalpemberianobat_id,
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    [
                        'label' => 'ID',
                        'name' => 'jadwalpemberianobat_id'
                    ],
                    [
                        'label' => 'Subjenis',
                        'name' => 'lookup_name',
                        'value' => !empty($model->subjenis)?$model->subjenis->subjenis_nama:'-'
                    ],                               
                    'signa_oa',  
                    'jadwal',
                    'urutan',
                    [
                        'label' => 'Status',
                        'value' => ($model->jadwalpemberianobat_aktif)?'Aktif':'Tidak Aktif'
                    ],
            ),
    )); ?>
        <div class="form-actions">
    <?= $this->renderPartial($this->path_view.'_buttonPengaturan',['model'=>$model],true); ?>    
    <?php $this->widget('UserTips',array('type'=>'view'));?>
        </div>
</div>