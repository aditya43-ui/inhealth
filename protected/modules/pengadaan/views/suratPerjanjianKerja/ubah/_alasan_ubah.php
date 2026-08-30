<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"> <b> Keterangan Perubahan Data Kontrak </b></div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Alasan Perubahan<span class="required">*</span></label>
                <div class="controls">
                    <?= $form->textArea($model, 'alasan_perubahan',['class'=>'required autogrow']); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Tanggal Perubahan<span class="required">*</span></label>
                <div class="controls">
                    <?= $form->textField($model, 'tanggal_perubahan',['class'=>'autogrow','readonly'=>true]); ?>
                </div>
            </div>
        </div>
    </div>
</div>