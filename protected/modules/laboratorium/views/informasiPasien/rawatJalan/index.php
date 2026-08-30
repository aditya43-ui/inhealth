<?php
Yii::app()->clientScript->registerScript('search', "
$('#formCari').submit(function(){
        $.fn.yiiGridView.update('rawatJalan-grid', {
                data: $(this).serialize()
        });
        return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Informasi <b>Pasien Rawat Jalan</b>
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
                <?php $this->renderPartial($this->path_view . 'rawatJalan/_search', [
                    'modInfoVerifikasiKunjuganRJ' => $modInfoVerifikasiKunjuganRJ
                ]) ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Informasi Pasien Rawat Jalan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                    $this->renderPartial($this->path_view . 'rawatJalan/_table', [
                        'modInfoVerifikasiKunjuganRJ' => $modInfoVerifikasiKunjuganRJ
                    ])
                ?>
            </div>
        </div>
    </div>
</div>