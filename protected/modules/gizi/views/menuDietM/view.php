<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Menu Diet</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Gzmenudiet Ms' => array('index'),
            $model->menudiet_id,
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Menu Diet ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Menu Diet', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Menu Diet', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Menu Diet', 'icon'=>'pencil','url'=>array('update','id'=>$model->menudiet_id))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Menu Diet','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->menudiet_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Menu Diet', 'icon' => 'folder-open', 'url' => array('admin'))) : '';

        $this->menu = $arrMenu;

        $zat = ZatMenuDietM::model()->findAllByAttributes(array(
            'menudiet_id' => $model->menudiet_id,
        ));

        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php
        $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'menudiet_id',
                'jenisdiet.jenisdiet_nama',
                'menudiet_nama',
                'menudiet_namalain',
                'jml_porsi',
                'ukuranrumahtangga',
            ),
        ));
        ?>

        <table class="table">
            <?php foreach ($zat as $item) : ?>
                <tr>
                    <td nowrap><?php echo $item->zatgizi->zatgizi_nama; ?></td>
                    <td style="text-align: right" width="100%"><?php echo number_format($item->kandunganmenudiet, 2, ",", ""); ?></td>
                    <td nowrap><?php echo $item->zatgizi->zatgizi_satuan; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Menu Diet', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('menuDietM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        );
        ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>