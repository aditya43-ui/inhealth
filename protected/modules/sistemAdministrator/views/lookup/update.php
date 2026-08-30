<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i>
            <?php
            if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_APOTEK) {
                echo 'Ubah <b>Etiket</b>';
            } else {
                echo 'Ubah <b>Lookup</b>';
            }
            ?>
        </div>
    </div>
    <div class="panel-body">
        <?php
            if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_APOTEK) {
                $this->breadcrumbs = array(
                    'Etiket' => array('index'),
                    $model->lookup_id => array('view', 'id' => $model->lookup_id),
                    'Update',
                );
            } else {
                $this->breadcrumbs = array(
                    'Lookup Ms' => array('index'),
                    $model->lookup_id => array('view', 'id' => $model->lookup_id),
                    'Update',
                );
            }
        $this->menu = array(
            //            array('label'=>Yii::t('mds','Update').' Lookup ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
        );

        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model, 'modDetail' => $modDetail)); ?>
    </div>
</div>