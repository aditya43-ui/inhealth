<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Menu</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Menu' => array('admin'),
            'Ubah',
        );

        $this->menu = array(
            //        array('label'=>Yii::t('mds','Update').' Menu ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
            //	array('label'=>Yii::t('mds','List').' Menu', 'icon'=>'list', 'url'=>array('index')),
            //	array('label'=>Yii::t('mds','Create').' Menu', 'icon'=>'file', 'url'=>array('create')),
            //	array('label'=>Yii::t('mds','View').' Menu', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->menu_id)),
            //	array('label'=>Yii::t('mds','Manage').' Menu', 'icon'=>'folder-open', 'url'=>array('admin')),
        );

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_formUpdate', array('model' => $model)); ?>
        <?php //$this->widget('UserTips',array('type'=>'update'));
        ?>
    </div>
</div>