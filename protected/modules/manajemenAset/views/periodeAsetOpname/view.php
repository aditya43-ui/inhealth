
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Periode Aset Opname</b>
        </div>
    </div>
    <div class="panel-body">
    <?php
    $this->breadcrumbs=array(
            'Periode Aset Opname'=>array('admin'),
            $model->periodeasetopname_id,
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(                    
                    'periodeasetopname_nama',
                    [
                        'label' => 'Tanggal',
                        'value' => MyFormatter::formatDateTimeForUser($model->tanggal_awal,"long").' - '.MyFormatter::formatDateTimeForUser($model->tanggal_akhir,"long")
                    ],                    
                    [
                        'label' => 'Status',
                        'value' => ($model->periodeasetopname_aktif)?'Aktif':'Tidak Aktif'
                    ],
            ),
    )); ?>
        <div class="form-actions">
    <?= $this->renderPartial('_buttonPengaturan',['model'=>$model],true); ?>    
    <?php $this->widget('UserTips',array('type'=>'view'));?>
        </div>
</div>
</div>