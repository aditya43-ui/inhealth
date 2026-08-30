<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class='fas fa-tablets'></i> Transaksi <b>Pemakaian Obat & Alkes Ruangan</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Transaksi Pemakaian Obat & Alkes Ruangan',
        );
        $arrMenu = array();
        $this->menu = $arrMenu;
        Yii::app()->clientScript->registerScript('search', "
                    $('.search-button').click(function(){
                            $('.search-form').toggle();				
                            return false;
                    });
                    $('.search-form form').submit(function(){
                            $.fn.yiiGridView.update('pemakaianbahp-form', {
                                    data: $(this).serialize()
                            });
                            return false;
                    });
                ");
        ?>
        <?php
        if (!empty($_GET['pemakaianobat_id'])) {
            Yii::app()->user->setFlash('success', "Data " . $model->nopemakaian_obat . " Berhasil disimpan");
        ?>
        <?php }
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial($this->path_view . '_form', array(
            'model' => $model, 'modDetails' => $modDetails
        )); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modDetails' => $modDetails)); ?>
    </div>
</div>