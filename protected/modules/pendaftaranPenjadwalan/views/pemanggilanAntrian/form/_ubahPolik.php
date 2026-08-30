<?= CHtml::activeHiddenField($model, 'antrian_id',['class'=>'required']); ?>
<div class="control-group">
    <label class="control-label">Barcode</label>
    <div class="controls">
        <?= CHtml::activeTextField($model, 'barcode',['class'=>'','disabled'=>true]); ?>
    </div>
</div>

<div class="control-group">
    <label class="control-label">No. Antrian</label>
    <div class="controls">
        <?= CHtml::activeHiddenField($model, 'noantrian',['class'=>'required']); ?>
        <?= CHtml::activeTextField($model, 'noantrian',['class'=>'','disabled'=>true]); ?>
    </div>
</div>

<div class="control-group">
    <label class="control-label">Klinik Asal</label>
    <div class="controls">
        <?= CHtml::textField('klinikasal', $model->ruangan->ruangan_nama,['class'=>'','disabled'=>true]); ?>
    </div>
</div>

<div class="control-group">
    <label class="control-label">Jenis Antrian</label>
    <div class="controls">
        <?php
            $model->modelantrian_id = null;
        ?>
        <?= CHtml::activeDropDownList($model,'modelantrian_id', ModelantrianM::dropModelAntrian([ 1, 2, 3]),[
            'onchange'=>'setRuanganPolik(this.value)',
            'empty'=>'-- Pilih --','class'=>'required']); ?>
    </div>
</div>

<div class="control-group">
    <label class="control-label">Klinik Tujuan</label>
    <div class="controls">
        <?php
            $model->modelantrian_id = null;
        ?>
        <?= CHtml::activeDropDownList($model,'ruangan_id', [],[            
            'empty'=>'-- Pilih --','class'=>'required ruangan_id']); ?>
    </div>
</div>

<div class="form-actions">     
    <?= CHtml::htmlButton("Simpan",['class'=>'btn btn-info','onclick'=>'ubahPoliklinik('.$model->antrian_id.',"simpan");']) ?>    
</div>