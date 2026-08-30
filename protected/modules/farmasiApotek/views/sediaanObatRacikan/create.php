<!--fieldset class="box"-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Sediaan Obat Racikan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Sediaan Obat Racikan Ms' => array('index'),
            'Create',
        );

        $arrMenu = array();
        array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' Sediaan Obat Racikan ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
        // array_push($arrMenu,array('label'=>Yii::t('mds','List').' FALookupM', 'icon'=>'list', 'url'=>array('index'))) ;
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Sediaan Obat Racikan', 'icon' => 'folder-open', 'url' => array('Admin'))) :  '';

        //$this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php
        echo $this->renderPartial($this->path_view . '_form', array('model' => $model));
        ?>
    </div>
</div>
<!--</fieldset>-->