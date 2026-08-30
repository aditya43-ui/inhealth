<!--<div class="white-container">
    <legend class="rim2">Tambah <b>Komponen Gaji</b></legend>-->
<div class="panel panel-gradient">
    <?php if ($this->hasTab) : ?>
        <div class="panel-heading">
            <div class="panel-title">
                <i class="far fa-plus-square"></i> Tambah <b>Komponen Gaji</b>
            </div>
        </div>
    <?php else : ?>
        <div class="panel-heading">
            <div class="panel-title">
                <i class="far fa-plus-square"></i> Tambah <b>Komponen</b>
            </div>
        </div>
    <?php endif; ?>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Komponen Gaji' => Yii::app()->request->getUrlReferrer(),
            'Tambah',
        );
        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Komponen gaji ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KomponengajiM', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').'   Komponen gaji', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

        $this->menu = $arrMenu;
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>
        <!--</div>-->
        <?php
        if ($this->hasTab) :
        ?>
            </fieldset>
        <?php
        else :
        ?>
    </div>
    <!--<div class="biru">-->
<?php
        endif;
?>
</div>