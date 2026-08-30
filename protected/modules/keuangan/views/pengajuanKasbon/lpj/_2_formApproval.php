<div class="col-md-6">
    <div class="control-group">
        <label class="control-label"> Pegawai Mengetahui <span class="required"> * </span> </label>
        <div class="controls"> <?= $form->textField($model, 'pegawai_mengetahui_nama', ['class' => 'span3', 'readonly' => true]) ?>

        </div>
    </div>
    <div class="control-group">
        <label class="control-label"> Pegawai Menyetujui I <span class="required"> * </span> </label>
        <div class="controls"> <?= $form->textField($model, 'pegawai_menyetujui1_nama', ['class' => 'span3', 'readonly' => true]) ?>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="control-group">
        <label class="control-label"> Pegawai Menyetujui II <span class="required"> * </span> </label>
        <div class="controls"> <?= $form->textField($model, 'pegawai_menyetujui2_nama', ['class' => 'span3', 'readonly' => true]) ?>
        </div>
    </div>
</div>