<?php
    Yii::app()->clientScript->registerScript('search', "
    $('#formCari').submit(function(){
            $.fn.yiiGridView.update('rawatDarurat-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Informasi <b>Pasien Rawat Darurat</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . 'rawatDarurat/_search', ['modInfoKunjunganRDV' => $modInfoKunjunganRDV, 'model' => $model]) ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Rawat Darurat</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->renderPartial($this->path_view . 'rawatDarurat/_table', ['modInfoKunjunganRDV' => $modInfoKunjunganRDV]);

                ?>
            </div>
        </div>
    </div>
</div>