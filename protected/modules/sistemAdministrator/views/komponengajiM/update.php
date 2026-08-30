<div class="panel panel-gradient">
    <div class="panel-heading">
        <?php if ($this->hasTab) : ?>
            <div class="panel-title">
                <i class="far fa-edit"></i> Ubah <b>Komponen Gaji</b>
            </div>
        <?php else : ?>
            <div class="panel-title">
                <i class="far fa-edit"></i> Ubah <b>Komponen Gaji</b>
            </div>
        <?php endif; ?>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Komponen Gaji' => Yii::app()->request->getUrlReferrer(),
            'Ubah',
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Komponen Gaji ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KomponengajiM', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' KomponengajiM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' KomponengajiM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->komponengaji_id))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Komponen Gaji', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_formUpdate', array('model' => $model)); ?>
        <!--</div>-->
        <?php
        if ($this->hasTab) :
        ?>
        <?php
        else :
        ?>
            <!--<div class="biru">-->
        <?php
        endif;
        ?>
    </div>
</div>