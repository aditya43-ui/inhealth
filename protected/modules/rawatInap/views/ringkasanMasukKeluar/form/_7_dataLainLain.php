<div class="col-sm-6">
    <?= $form->textFieldRow($model, 'alergipasien', []) ?>
    <?= $form->textFieldRow($model, 'pemeriksaanpennunjang_blm', []) ?>
    <?= $form->textFieldRow($model, 'diet', []) ?>
    <?= $form->textFieldRow($model, 'instruksi', []) ?>
    <?= $form->textAreaRow($model, 'tandavitalkeluar', []) ?>

    <div class="control-group set-dis kelompok">
        <label class="control-label">Kondisi Ibadah Sholat</label>
        <?php
        $lookup = LookupM::getItemsUrutan('kondisisholat_ringkasan');

        foreach ($lookup as $key => $val) {
            $id = 'kondisiibadah_' . str_replace(' ', '_', strtolower($key));
        ?>
            <div class="controls">
                <?= $form->checkBox($model, 'kondisiibadah', ['class' => 'salahsatu tidak-ada', 'value' => $key, 'uncheckValue' => null, 'id' => $id]) ?> <label for="<?= $id ?>"><?= $val ?></label>
            </div>
        <?php
        }
        ?>
    </div>

    <div class="control-group set-dis kelompok">
        <label class="control-label">Kondisi Psiko-Spiritual</label>
        <?php
        $lookup = LookupM::getItemsUrutan('kondisipsiko_ringkasan');

        foreach ($lookup as $key => $val) {
            $id = 'kondisipsiko_' . str_replace(' ', '_', strtolower($key));
        ?>
            <div class="controls">
                <?= $form->checkBox($model, 'kondisipsiko', ['class' => 'salahsatu tidak-ada', 'value' => $key, 'uncheckValue' => null, 'id' => $id]) ?> <label for="<?= $id ?>"><?= $val ?></label>
            </div>
        <?php
        }
        ?>
    </div>

    <div class=" set-dis kelompok">
        <div class="control-group tindak-lanjut-cek">
            <label class="control-label">Tindak lanjut</label>
            <?php
            $lookup = LookupM::getItemsUrutan('tindaklanjut_ringkasan');

            foreach ($lookup as $key => $val) {
                $id = 'tindakanjut_' . str_replace(' ', '_', strtolower($key));
            ?>
                <div class="controls">
                    <?= $form->checkBox($model, 'tindakanjut', ['class' => 'salahsatu tidak-ada', 'value' => $key, 'uncheckValue' => null, 'id' => $id]) ?> <label for="<?= $id ?>"><?= $val ?></label>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <label>Tanggal</label>
        </div>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tglkontrol',
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array('id' => 'tglkontrol', 'readonly' => true, 'class' => 'span3 ket-dis', 'style' => 'width:150px;'),
            ));
            ?>
        </div>
    </div>
</div>

<div class="col-sm-6">
    <div class=" set-dis kelompok">
        <div class="control-group cara-keluar-cek">
            <label class="control-label">Cara Keluar</label>
            <?php
            $lookup = LookupM::getItemsUrutan('carakeluar_ringkasan');

            foreach ($lookup as $key => $val) {
                $id = 'carakeluar_' . str_replace(' ', '_', strtolower($key));
            ?>
                <div class="controls">
                    <?= $form->checkBox($model, 'carakeluar', ['class' => 'salahsatu tidak-ada', 'value' => $key, 'uncheckValue' => null, 'id' => $id]) ?> <label for="<?= $id ?>"><?= $val ?></label>
                </div>
            <?php
            }
            ?>
        </div>

        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="controls">
                <?= $form->textArea($model, 'lainlain', ['id' => 'lainlain', 'rows' => 4, 'class' => 'ket-dis']) ?>
            </div>
        </div>
    </div>

    <div class=" set-dis kelompok">
        <div class="control-group">
            <label class="control-label">Kondisi Keluar</label>
            <?php
            $lookup = LookupM::getItemsUrutan('kondisikeluar_ringkasan');

            foreach ($lookup as $key => $val) {
                $id = 'kondisikeluar_' . str_replace(' ', '_', strtolower($key));
            ?>
                <div class="controls">
                    <?= $form->checkBox($model, 'kondisikeluar', ['class' => 'salahsatu tidak-ada', 'value' => $key, 'uncheckValue' => null, 'id' => $id]) ?> <label for="<?= $id ?>"><?= $val ?></label>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <div class=" set-dis kelompok">
        <div class="control-group">
            <label class="control-label">Tanggal Keluar</label>
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglkeluar',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => false, 'class' => 'span3', 'style' => 'width:150px;'),
                ));
                ?>
        </div>
    </div>
</div>

<div class="clear"></div>