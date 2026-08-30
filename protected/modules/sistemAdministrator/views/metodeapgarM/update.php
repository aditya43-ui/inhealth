<!--div class="white-container"-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Metode Apgar</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Psmetodeapgar Ms' => array('index'),
            $model->metodeapgar_id => array('view', 'id' => $model->metodeapgar_id),
            'Update',
        );
        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Metode Apgar ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;   
        $this->menu = $arrMenu;
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php
        echo $this->renderPartial($this->path_view . '_formUpdate', array('model' => $model));
        ?>
    </div>
</div>