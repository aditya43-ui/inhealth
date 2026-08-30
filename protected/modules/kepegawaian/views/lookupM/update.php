<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Minat Pekerjaan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Lookup Ms' => array('index'),
            $model->lookup_id => array('view', 'id' => $model->lookup_id),
            'Update',
        );
        $this->menu = array(
            //        array('label'=>Yii::t('mds','Update').' Minat Pekerjaan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
            //	array('label'=>Yii::t('mds','List').' Lookup', 'icon'=>'list', 'url'=>array('index')),
            //	array('label'=>Yii::t('mds','Create').' Lookup', 'icon'=>'file', 'url'=>array('create')),
            //	array('label'=>Yii::t('mds','View').' Lookup', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->lookup_id)),
            //	array('label'=>Yii::t('mds','Manage').' Minat Pekerjaan', 'icon'=>'folder-open', 'url'=>array('admin')),
        );
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_formUpdate', array('model' => $model)); ?>
    </div>
</div>