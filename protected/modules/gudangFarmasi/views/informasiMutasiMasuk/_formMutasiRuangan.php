<div class="col-sm-6">
    <?php $modMutasiRuangan->tglmutasioa = MyFormatter::formatDateTimeForUser($modMutasiRuangan->tglmutasioa); ?>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modMutasiRuangan, 'nomutasioa', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php
            echo CHtml::activeTextField($modMutasiRuangan, 'nomutasioa', array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)"))
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modMutasiRuangan, 'tglmutasioa', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php
            echo CHtml::activeTextField($modMutasiRuangan, 'tglmutasioa', array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)"))
            ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::activeLabel($modMutasiRuangan, 'ruanganasal_id', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php
            echo CHtml::activeTextField($modMutasiRuangan, 'ruanganasal_id', array('readonly'=>true, 'value'=>(isset($modMutasiRuangan->ruanganasal->ruangan_nama) ? $modMutasiRuangan->ruanganasal->ruangan_nama : $model->ruanganpenerima->ruangan_nama),'onkeyup'=>"return $(this).focusNextInputField(event)"))
            ?>
        </div>
    </div>
</div>
<div class="clear"></div>
