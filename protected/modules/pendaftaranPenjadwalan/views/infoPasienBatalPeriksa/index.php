<!--<div class="white-container">-->
<?php
$this->breadcrumbs = array(
    'Informasi Pasien Pulang',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pasien Batal Periksa</b>
        </div>
    </div>
    <div class="panel-body">
        <!--<div class="rim2">Informasi Pasien <b>Batal Periksa</b></div>-->
        <?php
        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#search').submit(function(){
            $.fn.yiiGridView.update('daftarpasien-v-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
        ?>
        <!--<h6>Tabel Pasien <b>Batal Periksa</b></h6>-->
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>
                <!--</fieldset>-->
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Batal Periksa</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial($this->path_view . '_table', array('model' => $model)); ?>
            </div>
        </div>
        <!--<fieldset class="box">-->
    </div>
</div>