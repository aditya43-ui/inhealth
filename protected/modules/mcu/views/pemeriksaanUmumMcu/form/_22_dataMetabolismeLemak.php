<div class="col-sm-12">
    <div class="control-group">
        <label class="controls"><strong><u>METABOLISME GLUKOSA</u></strong></label>       
    </div>
</div>

<div class="col-sm-12">           
    <div class="control-group">
        <label class="control-label">Kolestrol Total</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'lemak_kolestrol',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div>                
    
    <div class="control-group">
        <label class="control-label">Kolestrol HDL</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'lemak_hdl',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div> 
    
    <div class="control-group">
        <label class="control-label">Kolestrol LDL Direct</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'lemak_ldl',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div> 
        
    <div class="control-group">
        <label class="control-label">Trigliserida</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'lemak_trigliserida',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div> 
    
    <div class="control-group">
        <label class="control-label">*Anjuran</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'lemak_anjuran',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div> 
    
    <div class="control-group">
        <label class="control-label">Urine Lengkap</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'lemak_urinlengkap',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Hasil Pemeriksaan EKG</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'lemak_hasilekg',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Hasil Pemeriksaan Rontgent Thorax</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'lemak_hasilthorax',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Hasil Didapat</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'lemak_hasildidapat',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Saran</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'lemak_saran',['rows'=>5, 'style'=>'width:100%;']) ?>
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
                    'update'=>'#'.CHtml::activeId($model, 'pegawai_id')
                )
            ]) ?>
        </div>
        <div class="controls">
            <?= $form->dropDownList($model,'pegawai_id', PegawairuanganV::getDropPegawai($model->ruangan_id, true),['class'=>'span3', 'empty'=>'-- Pilih --']) ?>
        </div>
    </div>
</div>



<div class="clear"></div>

<hr/>