<div class="col-sm-6">
    <?= $form->textFieldRow($model,'usulanpenghapusanaset_tanggal',['class'=>'span3','readonly'=>true]) ?>    
    <div class="control-group">
        <label class="control-label">Lokasi Aset</label>
        <div class="controls">
            <?php
                $cri = new CDbCriteria();
                $cri->select = " t.lokasi_id, lok.lokasiaset_namalokasi ";
                $cri->join = " JOIN lokasiaset_m lok ON lok.lokasi_id = t.lokasi_id ";
                $cri->addCondition(" pegawai_id = ".Yii::app()->user->getState('pegawai_id')." AND penanggungjawabaset_aktif = TRUE ");
                $cri->order = " lok.lokasiaset_namalokasi ASC ";
                $lokasi = PenanggungjawabasetM::model()->findAll($cri);
            ?>
            <?= $form->dropDownList($model,'lokasi_id', CHtml::listData($lokasi, 'lokasi_id', 'lokasiaset_namalokasi'),['class'=>'span3 lokasi_id','onchange'=>'resetDataAset();']) ?>
        </div>
    </div>
        
</div>

<div class="col-sm-6">
    <?= $form->textFieldRow($model,'usulanpenghapusanaset_nomor',['class'=>'span3','readonly'=>true]) ?>
    <?= $form->hiddenField($model,'pegpengusul_id') ?>
    <?= $form->textFieldRow($model,'pegpengusul_nama',['class'=>'span3','readonly'=>true]) ?>
                
</div>