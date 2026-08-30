<div class="panel panel-gradient">
    <div class="panel-heading">
        <?php if ($this->hasTab) : ?>
            <div class="panel-title">
                <i class="far fa-edit"></i> Ubah <b>Golongan Gaji</b>
            </div>
        <?php else : ?>
            <div class="panel-title">
                <i class="far fa-edit"></i> Ubah <b>Golongan Gaji</b>
            </div>
        <?php endif; ?>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Golongan Gaji' => array('admin'),
            $model->golongangaji_id => array($this->path_view . 'view', 'id' => $model->golongangaji_id),
            'Update',
        );

        $arrMenu = array();
        //    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Golongan Gaji', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //(Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Golongan Gaji', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_formUpdate', array('model' => $model)); ?>
        <?php //$this->widget('UserTips',array('type'=>'update'));
        ?>
        <!--</div>-->
    </div>
</div>