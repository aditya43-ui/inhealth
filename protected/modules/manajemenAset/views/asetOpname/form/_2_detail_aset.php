<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Nama Aset</label>
        <div class="controls">
            <?= CHtml::activeHiddenField($model, 'invperalatan_id',['class'=>'inv_invperalatan_id','readonly'=>true]) ?>
            <?= CHtml::activeTextField($model, 'invperalatan_namabrg',['readonly'=>true]) ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Nomor Aset</label>
        <div class="controls">
            <?= CHtml::activeTextField($model, 'invperalatan_kode',['readonly'=>true]) ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Nomor Seri</label>
        <div class="controls">
            <?= CHtml::activeTextField($model, 'peralatan_noseri',[]) ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Pemilik Aset</label>
        <div class="controls">
            <?= CHtml::activeDropDownList($model, 'pemilikbarang_id', CHtml::listData(PemilikbarangM::model()->findAll("pemilikbarang_aktif = TRUE ORDER BY pemilikbarang_nama ASC"), 'pemilikbarang_id', 'pemilikbarang_nama'),['empty'=>'-- Pilih --']) ?>            
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Asal Aset</label>
        <div class="controls">
            <?= CHtml::activeDropDownList($model, 'asalaset_id', CHtml::listData(AsalasetM::model()->findAll("asalaset_aktif = TRUE ORDER BY asalaset_nama ASC"), 'asalaset_id', 'asalaset_nama'),['empty'=>'-- Pilih --']) ?>            
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Lokasi Aset</label>
        <div class="controls">
            <?= CHtml::activeHiddenField($modAset, 'lokasiawal_id') ?>
            <?php //  CHtml::activeHiddenField($model, 'lokasi_id') ?>
            <?php //  CHtml::activeHiddenField($model, 'ruangan_id') ?>
            <?= CHtml::activeTextField($model, 'lokasiaset_namalokasi',['readonly'=>true]) ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Ruangan Aset</label>
        <div class="controls">
            <?= CHtml::activeTextField($model, 'ruanganaset_nama',['readonly'=>true]) ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Tanggal Perolehan</label>
        <div class="controls">
            <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tanggal_perolehan',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3 tanggal_perolehan'
                    ),
                ));
            ?>
        </div>
    </div>
</div>

<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Merk</label>
        <div class="controls">
            <?= CHtml::activeTextField($model, 'invperalatan_merk',[]) ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Ukuran</label>
        <div class="controls">
            <?= CHtml::activeTextField($model, 'invperalatan_ukuran',[]) ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Bahan</label>
        <div class="controls">
            <?= CHtml::activeTextField($model, 'invperalatan_bahan',[]) ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Tipe/Model</label>
        <div class="controls">
            <?= CHtml::activeTextField($model, 'peralatan_model',[]) ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Cara Perolehan</label>
        <div class="controls">
            <?= CHtml::activeDropDownList($model, 'cara_perolehan', LookupM::getItemsUrutan('cara_perolehan'),['empty'=>'-- Pilih --']) ?>            
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Sumber Dana</label>
        <div class="controls">
            <?= CHtml::activeDropDownList($model, 'sumberdana', CHtml::listData(SumberdanaM::model()->findAll("sumberdana_aktif = TRUE ORDER BY sumberdana_nama ASC"), 'sumberdana_nama', 'sumberdana_nama'),['empty'=>'-- Pilih --']) ?>            
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Kondisi <span class="required">*</span></label>
        <div class="controls">
            <?= CHtml::activeHiddenField($modAset, 'kondisi_awal') ?>
            <?= CHtml::activeDropDownList($model, 'invperalatan_keadaan', LookupM::getItemsUrutan('kondisi_barang'),['class'=>'required','empty'=>'-- Pilih --']) ?>            
        </div>
    </div>
</div>