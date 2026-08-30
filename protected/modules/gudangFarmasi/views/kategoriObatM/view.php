<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Kategori Obat</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Lookup Ms' => array('index'),
            $model->lookup_id,
        );

        $this->menu = array();

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                //'lookup_id',
                //		'lookup_type',
                'lookup_name',
                //            array(
                //                     'label'=>'Nama',
                //                     'type'=>'raw',
                //                     'value'=>$this->renderPartial('_Lookup',array('lookup_id'=>$model->lookup_id),true),
                //                 ),
                //'komponentarif_aktif',
                //'lookup_value',
                'lookup_kode',
                'lookup_urutan',
                array(
                    'label' => 'Aktif',
                    'type' => 'raw',
                    'value' => (($model->lookup_aktif == 1) ? '' . Yii::t('mds', 'Yes') . '' : '' . Yii::t('mds', 'No') . ''),
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Kategori Obat', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>