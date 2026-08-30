<div class="white-container">
    <legend class="rim2">Informasi <b>Verifikasi Berkas MCU</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
    ?>
    <?php
    Yii::app()->clientScript->registerScript('search', "
        $('#pencarian-form').submit(function(){
            $('#verifikasiberkasmcu-v-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('verifikasiberkasmcu-v-grid', {
                data: $(this).serialize()
            });
            return false;
        });
        ");
    ?>

    <div class="block-tabel">
        <h6>Tabel <b>Verifikasi Berkas MCU</b></h6>
        <?php $this->renderPartial($this->path_view . '_tabelVerifikasiBerkas', array('model' => $model)); ?>
    </div>

    <fieldset class="box" id="form-verifikasi">
        <legend class="rim">Pencarian</legend>
        <div class="row">
            <?php $this->renderPartial($this->path_view . '_formPencarian', array('model' => $model)); ?>
        </div>
    </fieldset>
</div>

<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>