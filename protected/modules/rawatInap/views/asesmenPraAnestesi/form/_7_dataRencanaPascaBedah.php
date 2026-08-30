<div class="col-sm-12">
    <div class="control-group hide">
        <div class="controls">
            <?= $form->checkBox($model, 'is_rencana_ambulatory',['id'=>'is_rencana_ambulatory']) ?> <label for="is_rencana_ambulatory">Ambulatory</label>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <?= $form->checkBox($model, 'is_rencana_rawatinap',['id'=>'is_rencana_rawatinap']) ?> <label for="is_rencana_rawatinap">Rawat Inap</label>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <?= $form->checkBox($model, 'is_rencana_icu',['id'=>'is_rencana_icu']) ?> <label for="is_rencana_icu">Rawat di ICU</label>
        </div>
    </div>
    <div class="control-group hide">
        <div class="controls">
            <?= $form->checkBox($model, 'is_rujuk',['id'=>'is_rujuk','onclick'=>'cekRujuk();']) ?> <label for="is_rujuk">Rujuk Ke</label>
        </div>
        <div class="controls">
            <?= $form->dropDownList($model, 'rujukke_id', CHtml::listData(RujukandariM::model()->findAll(),'rujukandari_id','namaperujuk'),['class'=>'rujukke_id','empty'=>'-- Pilih --']) ?>
        </div>
    </div>
</div>