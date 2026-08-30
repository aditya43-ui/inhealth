<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Jurnal Rekening Penerimaan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php

        $this->breadcrumbs = array(
            'Jurnal Rekening Penerimaan' => array('admin'),
            'Ubah',
        );

        //$arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Jurnal Rek Penerimaan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jurnal Rek Penerimaan ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        //$this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php echo $this->renderPartial('_formUpdate', array('model' => $model)); ?>
        <!--</div>-->
    </div>
</div>