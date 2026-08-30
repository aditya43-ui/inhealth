<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            SKALA RESIKO JATUH HUMPTY DUMPTY UNTUK PASIEN ANAK (<13 TAHUN)
        </div>
    </div>
    <div class="panel-body">
        <?php
            echo $this->renderPartial($this->path_view_anak."_riwayat", array(
                'model'=>$model,
                'modPendaftaran'=>$modPendaftaran
            ), true);
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Pengkajian Resiko Jatuh</div>
            </div>
            <div class="panel-body">
                <div class="formanak">
                    <?php echo CHtml::activeHiddenField($model, 'pendaftaran_id'); ?>
                    <?php echo CHtml::hiddenField('checkSimpanData',''); ?>
                    <?php echo CHtml::activeHiddenField($model, 'pengkajianresikojatuh_id'); ?>
                    <?php $this->renderPartial($this->path_view_anak.'_form',array('model'=>$model,'modHasil'=>$modHasil, 'modIntervensi'=>$modIntervensi,'modDetail'=>$modDetail)); ?>
                </div>
            </div>
        </div>    

    </div>
</div>