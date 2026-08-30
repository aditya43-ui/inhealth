<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            SKALA RESIKO JATUH MORSE FALL SCALE UNTUK PASIEN DEWASA (>=13 TAHUN)
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Riwayat Pengkajian Resiko Jatuh</div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view_dewasa.'_riwayat',array('model'=>$model,'modPendaftaran'=>$modPendaftaran)); ?>
            </div>
        </div>    
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Pengkajian Resiko Jatuh</div>
            </div>
            <div class="panel-body">
                <div class="formdewasa">
                    <?php echo CHtml::activeHiddenField($model, 'pendaftaran_id'); ?>
                    <?php echo CHtml::hiddenField('checkSimpanData',''); ?>
                    <?php echo CHtml::activeHiddenField($model, 'pengkajianresikojatuh_id'); ?>
                    <?php $this->renderPartial($this->path_view_dewasa.'_form',array('model'=>$model,'modHasil'=>$modHasil, 'modIntervensi'=>$modIntervensi,'modDetail'=>$modDetail)); ?>
                </div>
            </div>
        </div>    

    </div>
</div>