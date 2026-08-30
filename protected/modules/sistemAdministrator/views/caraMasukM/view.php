<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Cara Masuk</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Sacara Masuk Ms' => array('index'),
            $model->caramasuk_id,
        );

        $this->menu = array(
            array('label' => Yii::t('mds', 'View') . ' Cara Masuk ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')),
            //	array('label'=>Yii::t('mds','List').' Cara Masuk', 'icon'=>'list', 'url'=>array('index')),
            //	array('label'=>Yii::t('mds','Create').' Cara Masuk', 'icon'=>'file', 'url'=>array('create')),
            //        array('label'=>Yii::t('mds','Update').' Cara Masuk', 'icon'=>'pencil','url'=>array('update','id'=>$model->caramasuk_id)),
            //	array('label'=>Yii::t('mds','Delete').' Cara Masuk','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->caramasuk_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?'))),
            //	array('label'=>Yii::t('mds','Manage').' Cara Masuk', 'icon'=>'folder-open', 'url'=>array('admin')),
        );

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'caramasuk_id',
                'caramasuk_nama',
                'caramasuk_namalainnya',
                'caramasuk_aktif',
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Cara Masuk', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('/sistemAdministrator/CaraMasukM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>