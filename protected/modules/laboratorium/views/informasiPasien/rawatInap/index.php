<?php
    Yii::app()->clientScript->registerScript('search', "
        $('#formCari').submit(function(){
            $.fn.yiiGridView.update('rawatInap-grid', {
                data: $(this).serialize()
            });
            return false;
        });
        ");
    ?>
<div class="panel panel-pr_imary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Informasi <b>Pasien Rawat Inap</b>
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
                <?php $this->renderPartial($this->path_view . 'rawatInap/_search', ['modPPInfoKunjunganRIV' => $modPPInfoKunjunganRIV]) ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Informasi Pasien Rawat Inap</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                    $this->renderPartial($this->path_view . 'rawatInap/_table', ['modPPInfoKunjunganRIV' => $modPPInfoKunjunganRIV])
                ?>
            </div>
        </div>
    </div>
</div>