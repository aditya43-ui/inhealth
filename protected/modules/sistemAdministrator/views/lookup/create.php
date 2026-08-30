<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i>
            <?php
            if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_APOTEK) {
                echo 'Tambah <b>Etiket</b>';
            } else {
                echo 'Tambah <b>Lookup</b>';
            }
            ?>
        </div>
    </div>
    <div class="panel-body">
        <?php
            if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_APOTEK) {
                $this->breadcrumbs = array(
                    'Etiket' => array('index'),
                    'Create',
                );
            } else {
                $this->breadcrumbs = array(
                    'Lookup' => array('index'),
                    'Create',
                );
            }
        $this->menu = array(
            //        array('label'=>Yii::t('mds','Create').' Lookup ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
        );

        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model, 'modDetail' => $modDetail)); ?>
    </div>
</div>