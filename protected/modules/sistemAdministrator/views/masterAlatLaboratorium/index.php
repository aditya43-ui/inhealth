<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Master <b>Alat Laboratorium</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Master Alat Laboratorium' //=>array('index'),
            //'Manage',
        );

        $arrMenu = array();
        $this->menu = $arrMenu;
        Yii::app()->clientScript->registerScript('search', "
                    $('.search-button').click(function(){
                            $('.search-form').toggle();				
                            return false;
                    });
                    $('.search-form form').submit(function(){
                            $.fn.yiiGridView.update('sapemeriksaanlabalat-m-grid', {
                                    data: $(this).serialize()
                            });
                            return false;
                    });
                    ");

        if (isset($_GET['sukses'])) :
            Yii::app()->user->setFlash('success', '<b>Berhasil!</b> Data berhasil disimpan.');
        endif;

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php $this->renderPartial($this->path_view . '_tabMenu', array()); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array()); ?>
        <div>
            <iframe id="frame" class="biru" src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>
        </div>
    </div>
</div>