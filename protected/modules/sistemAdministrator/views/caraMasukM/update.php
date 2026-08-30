<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Jenis Penjamin</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Sacara Masuk Ms' => array('index'),
            $model->caramasuk_id => array('view', 'id' => $model->caramasuk_id),
            'Update',
        );

        $this->menu = array(
            array('label' => Yii::t('mds', 'Update') . ' Cara Masuk ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')),
            //	array('label'=>Yii::t('mds','List').' Cara Masuk', 'icon'=>'list', 'url'=>array('index')),
            //	array('label'=>Yii::t('mds','Create').' Cara Masuk', 'icon'=>'file', 'url'=>array('create')),
            //	array('label'=>Yii::t('mds','View').' Cara Masuk', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->caramasuk_id)),
            //	array('label'=>Yii::t('mds','Manage').' Cara Masuk', 'icon'=>'folder-open', 'url'=>array('admin')),
        );

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_formUpdate', array('model' => $model)); ?>
        <?php //$this->widget('UserTips',array('type'=>'update'));
        ?>

    </div>
</div>