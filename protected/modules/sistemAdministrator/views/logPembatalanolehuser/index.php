<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pembatalan Log User</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
        $('#logpembatalanolehuser-v-search').submit(function(){
            $.fn.yiiGridView.update('logpembatalanolehuser-v-grid', {
                data: $(this).serialize()
            });
            return false;
        });
        ");
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pembatalan Log User</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $this->renderPartial($this->path_view . '_table', array('model' => $model)); ?>
            </div>
        </div>
    </div>
</div>
<!--search-form-->