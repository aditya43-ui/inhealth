<div class="col-sm-12">
    <div class="control-group">
        <label class="control-label" style="width:100%;"><h3><u>KESIMPULAN PEMERIKSAAN</u></h3></label>
    </div>
</div>

<div class="col-sm-12">    
    <div class="control-group">
        <?= $form->labelEx($model,'kesimpulan',['class'=>'control-label']) ?>
        <div class="controls" style="width:80%;">
            <?= $form->textArea($model,'kesimpulan', ['rows'=>6,'style'=>'width:100%;']) ?>
        </div>
    </div>                
</div>

<div class="col-sm-12">
    <div class="control-group">
        <label class="control-label" style="width:100%;"><h3><u>REKOMENDASI</u></h3></label>
    </div>
</div>

<div class="col-sm-12">    
    <div class="control-group">
        <?= $form->labelEx($model,'rekomendasi',['class'=>'control-label']) ?>
        <div class="controls" style="width:80%;">
            <?= $form->textArea($model,'rekomendasi', ['rows'=>6,'style'=>'width:100%;']) ?>
        </div>
    </div>       
    
    <div class="control-group">
        <label class="control-label">Dokter Penanggung Jawab</label>
        <div class="controls">
            <?= $form->dropDownList($model,'ruangan_id', CHtml::listData(RuanganM::model()->findAll(" ruangan_aktif = true AND instalasi_id = ".Params::INSTALASI_ID_RJ." ORDER BY ruangan_nama ASC "), 'ruangan_id', 'ruangan_nama'),[
                'class'=>'span3', 
                'empty'=>'-- Pilih --',
                'ajax'=>array(
                    'type'=>'POST',
                    'url'=>$this->createUrl('/actionDynamic/getPegawaiRuangan',array('attr'=>'ruangan_id','encode'=>false,'namaModel'=>get_class($model))),
                    'update'=>'#'.CHtml::activeId($model, 'dpjp_id')
                )
            ]) ?>
        </div>
        <div class="controls">
            <?= $form->dropDownList($model,'dpjp_id', PegawairuanganV::getDropPegawai($model->ruangan_id, true),['class'=>'span3', 'empty'=>'-- Pilih --']) ?>
        </div>
    </div>
</div>