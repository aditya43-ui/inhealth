<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Form Rujukan Keluar
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Lkrujukankeluar Ms' => array('index'),
            'Create',
        );

        $arrMenu = array();
        array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' Rujukan Keluar ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
        //array_push($arrMenu,array('label'=>Yii::t('mds','List').' Rujukan Keluar', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Rujukan Keluar', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

        $this->menu = $arrMenu;

        //    $this->widget('bootstrap.widgets.BootAlert'); 
        ?>

        <?php echo $this->renderPartial($this->path_view . 'addMaster._form', array('model' => $model)); ?>
    </div>
</div>