<div class ="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::activeLabel($modReturResep, 'tglretur',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('BKReturresepT[tglretur]', $modReturResep->tglretur, array('readonly'=>true)); ?>
            <?php echo CHtml::hiddenField('BKReturresepT[pasien_id]', $modReturResep->pasien_id, array('readonly'=>true)); ?>
            <?php echo CHtml::hiddenField('BKReturresepT[returresep_id]', $modReturResep->returresep_id, array('readonly'=>true)); ?>
        </div>
    </div>
    
    <div class="control-group">
        <?php echo CHtml::activeLabel($modReturResep, 'noreturresep',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('BKReturresepT[noreturresep]', $modReturResep->noreturresep, array('readonly'=>true)); ?>
        </div>
    </div>
    
    <div class="control-group">
        <?php echo CHtml::label('No Resep', 'noresep',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('BKReturresepT[noresep]',(isset($modReturResep->penjualanresep->noresep) ? $modReturResep->penjualanresep->noresep : ""), array('readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Jenis Penjualan', 'jenispenjualan',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('BKReturresepT[jenispenjualan]', isset($modReturResep->penjualanresep->jenispenjualan) ? $modReturResep->penjualanresep->jenispenjualan : "", array('readonly'=>true)); ?>
        </div>
    </div>
</div>

<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::activeLabel($modReturResep, 'nama_pasien',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('BKReturresepT[nama_pasien]', isset($modReturResep->pasien->nama_pasien) ? $modReturResep->pasien->nama_pasien : "", array('readonly'=>true)); ?>
        </div>
    </div>
    
    <div class="control-group">
        <?php echo CHtml::activeLabel($modReturResep, 'mengetahui_id',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('BKReturresepT[mengetahui_nama]', isset($modReturResep->pegawai->NamaLengkap) ? $modReturResep->pegawai->NamaLengkap : "-", array('readonly'=>true)); ?>
        </div>
    </div>
    
    <div class="control-group">
        <?php echo CHtml::activeLabel($modReturResep, 'pegretur_id',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('BKReturresepT[pegretur_nama]', isset($modReturResep->pegawairetur->NamaLengkap) ? $modReturResep->pegawairetur->NamaLengkap : "", array('readonly'=>true)); ?>
        </div>
    </div>
</div>