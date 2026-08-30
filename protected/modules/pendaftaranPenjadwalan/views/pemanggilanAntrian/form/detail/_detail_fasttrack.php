<div class="form-horizontal" id="form-fast-track" style="padding:20px;">
    <div class="control-group">
        <label class="control-label">Penanggung Jawab</label>
        <div class="controls">
            <?= CHtml::textField('penanggung_jawab','',['class'=>'nama_pj','disabled'=>true]); ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">No Rekam Medik</label>
        <div class="controls">
            <?= CHtml::textField('no_rm','',['class'=>'no_rm','disabled'=>true]); ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Nama Pasien</label>
        <div class="controls">
            <?= CHtml::textField('nama_pasien','',['class'=>'nama_pasien','disabled'=>true]); ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Alasan Fast Track</label>
        <div class="controls">
            <?= CHtml::textArea('alasan','',['rows'=>3,'class'=>'alasan','disabled'=>true]); ?>
        </div>
    </div>
</div>