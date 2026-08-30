<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Satuan Hasil</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Rdkeadaan Masuk Ms' => array('index'),
            'Create',
        );

        $arrMenu = array();
        $this->menu = $arrMenu;
        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>
        <?php //$this->widget('UserTips',array('type'=>'create'));
        ?>
    </div>
</div>