<div class="col-sm-12">
    <div class="col-sm-6">
        <div class="control-group">
            <label class="controls">Pemeriksaan Penunjang / Diagnosa Terpenting</label>
        </div>
        <div class="control-group">
            <div class="controls" style="width:100%">
                <?php echo $form->textArea($model, 'pemeriksaanpenunjang', array('rows' => 4, 'id' => 'pemeriksaanpenunjang')) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <label class="controls">Terapi/ Pengobatan selama di Rumah Sakit</label>
        </div>
        <div class="control-group">
            <div class="controls" style="width:100%">
                <?php echo $form->textArea($model, 'terapiselamadirs', array('rows' => 4, 'id' => 'terapiselamadirs')) ?>
            </div>
        </div>
    </div>
</div>
<br>
<div class="control-group">
    <label class="controls">Hasil Konsultasi</label>
    <div class="controls">
        <?= $form->textField($model, 'hasilkonsultasi') ?>
    </div>
</div>