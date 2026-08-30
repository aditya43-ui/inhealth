
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Area</b>
        </div>
    </div>
    <div class="panel-body">
    <?php
    $this->breadcrumbs=array(
            'Area'=>array('admin'),
            $model->area_id,
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'area_id',
                    'area_nama',
                    'area_kode',                                       
                    [
                        'label' => 'Status',
                        'value' => ($model->area_aktif)?'Aktif':'Tidak Aktif'
                    ],
            ),
    )); ?>
        <div class="form-actions">
    <?= $this->renderPartial($this->path_view.'_buttonPengaturan',['model'=>$model],true); ?>    
    <?php $this->widget('UserTips',array('type'=>'view'));?>
        </div>
</div>