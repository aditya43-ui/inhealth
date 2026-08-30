
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Lihat <b>Brine Tank</b>
        </div>
    </div>
    <div class="panel-body">
    <?php
    $this->breadcrumbs=array(
            'Brine Tank'=>array('admin'),
            $model->hd_brinetank_id,
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'hd_brinetank_id',
                    'jaringansumberbiomaterial_nama',
                    'nama_lain',
                    [
                        'label' => 'Satuan',
                        'value' => !empty($model->satuankecil->satuankecil_nama)?$model->satuankecil->satuankecil_nama:null
                    ],
                    'urutan',
                    [
                        'label' => 'Status',
                        'value' => ($model->jaringansumberbiomaterial_aktif)?'Aktif':'Tidak Aktif'
                    ],
            ),
    )); ?>
    <?= $this->renderPartial('_buttonPengaturan',['model'=>$model],true); ?>    
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>