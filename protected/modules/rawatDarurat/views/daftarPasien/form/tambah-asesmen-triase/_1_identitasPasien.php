
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><b>BIODATA PASIEN</b></div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <?= $form->textFieldRow($model, 'namapasien') ?>
        </div>
        
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">No. RM</label>
                <div class="controls">
                    <?= CHtml::textField('norm','',['readonly'=>true]) ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">No. Registrasi</label>
                <div class="controls">
                    <?= CHtml::textField('noregistrasi','',['readonly'=>true]) ?>
                </div>
            </div>
        </div>
    </div>
</div>