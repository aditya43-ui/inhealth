<style>
    .horizon span {
        color: black;
    }
</style>
<div class="row-fluid form_naik_kelas">
    <div class="col-sm-8">
        <div class="control-group">
            <label class="control-label">Total Biaya Rumah Sakit</label>
            <div class="controls">
                <?= CHtml::hiddenField('Alokasi[iurbea_id]', '', ['class' => 'span3 iurbea_id', 'readonly'=>true]) ?>
                <?= CHtml::textField('Alokasi[totalbiayarumahsakit]', '', ['class' => 'span3 integer-decimal totalbiayarumahsakit', 'readonly'=>true]) ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">InaCBGS <span class="label_ina_1">Kelas I</span></label>
            <div class="controls">
                <?= CHtml::textField('Alokasi[inacbg_kelasperawatan]', '', ['class' => 'span3 integer-decimal kelasperawatan', 'readonly'=>true]) ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">InaCBGS <span class="label_ina_2">Kelas II</span></label>
            <div class="controls">
                <?= CHtml::textField('Alokasi[inacbg_kelastanggungan]', '', ['class' => 'span3 integer-decimal kelastanggungan', 'readonly'=>true]) ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Selisih InaCBGS <span class="label_ina_1">Kelas I</span> dan <span class="label_ina_2">InaCBGS Kelas II</span></label>
            <div class="controls">
                <?= CHtml::textField('Alokasi[totalselisihkelastanggunganperawatan]', '', ['class' => 'span3 integer-decimal totalselisihkelastanggunganperawatan', 'readonly'=>true]) ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Iur Bea Max. 75%</label>
            <div class="controls">
                <?= CHtml::textField('Alokasi[iurbeatujuhpuluhpersen]', '', ['class' => 'span3 integer-decimal iurbeatujuhpuluhpersen', 'readonly'=>true]) ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Iur Bayar Pasien</label>
            <div class="controls">
                <?= CHtml::textField('Alokasi[totaliurbiaya]', '', ['class' => 'span3 integer-decimal iurbayar', 'readonly'=>true]) ?>
            </div>
        </div>
    </div>
</div>