<!--div class="white-container"-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Kasus Penyakit Obat</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Rjkasuspenyakitdiagnosa Ms' => array('index'),
            $model->jeniskasuspenyakit_id => array('view', 'id' => $model->jeniskasuspenyakit_id),
            'Update',
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Diagnosa Kasus Penyakit ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Diagnosa Kasus Penyakit ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;
        $this->menu = $arrMenu;
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form', array('model' => $model, 'modDetails' => $modDetails)); ?>
        <?php //$this->widget('UserTips',array('type'=>'update'));
        ?>
        <!--/div-->
    </div>
</div>