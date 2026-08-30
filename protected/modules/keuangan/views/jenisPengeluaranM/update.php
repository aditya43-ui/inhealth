<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Pengeluaran Umum</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Pengeluaran Umum' => array('admin'),
            'Update',
        );
        $arrMenu = array();
        array_push($arrMenu, array('label' => Yii::t('mds', 'Update') . ' Jenis Pengeluaran ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_formUpdate', array('model' => $model)); ?>
        <?php //$this->widget('UserTips',array('type'=>'update'));
        ?>
    </div>
</div>