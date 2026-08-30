
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Gedung</b>
        </div>
    </div>
    <div class="panel-body">
    <?php
    $this->breadcrumbs=array(
            'Gedung'=>array('admin'),
            $model->gedung_id,
    );
    $this->pageTitle = 'Lihat Gedung';
    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'gedung_id',
                    'gedung_nama',
                    'gedung_kode',                                       
                    [
                        'label' => 'Status',
                        'value' => ($model->gedung_aktif)?'Aktif':'Tidak Aktif'
                    ],
            ),
    )); ?>
        <div class="form-actions">
    <?= $this->renderPartial($this->path_view.'_buttonPengaturan',['model'=>$model],true); ?>    
    <?php $this->widget('UserTips',array('type'=>'view'));?>
        </div>
</div>