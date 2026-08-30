<div class="col-sm-6">       
    <div class="control-group">        
        <?php echo CHtml::label("Nomor Transaksi<span class='required'>*<span>",'',array('class' => 'control-label')); ?>
        <div class="controls">            
            <?php echo CHtml::activeTextField($model, 'persiapanpengadaan_nomor', array('readonly' => true, 'class' => 'span3 required')) ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Tanggal Transaksi<span class="required">*</span></label>
        <div class="controls">
            <?php echo CHtml::activeTextField($model, 'persiapanpengadaan_tanggal', array('readonly' => true, 'class' => 'span3 required')) ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Pegawai Pembuat<span class="required">*</span></label>
        <div class="controls">
            <?php 
                echo CHtml::activeHiddenField($model, 'pegawaipembuat_id', array('readonly' => true));
                echo CHtml::activeTextField($model,'pegawaipembuat_nama',array('readonly' => true,'class'=>'span3'));
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Unit Kerja</label>
        <div class="controls">
            <?php 
                echo CHtml::activeHiddenField($model, 'unitkerja_id', array('readonly' => true));
                echo CHtml::activeTextField($model,'namaunitkerja',array('readonly' => true,'class'=>'span3'));
            ?>
        </div>
    </div>        
</div>

<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Bidang/Bagian/Instalasi<span class="required">*</span></label>
        <div class="controls">
            <?php 
                echo CHtml::activeTextField($model,'instalasi_nama',array('readonly' => true,'class'=>'span3'));
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Kategori Pengadaan<span class="required">*</span></label>
        <div class="controls">
            <?php 
                echo CHtml::activeTextField($modRencana,'rencanaumumpengadaan_kategori',array('readonly' => true,'class'=>'span3'));
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Tahun Anggaran<span class="required">*</span></label>
        <div class="controls">
            <?php 
                $modPeriode = PeriodeanggaranK::model()->findByPk($model->periodeanggaran_id);
                if(!empty($modPeriode)){
                    $tahunanggaran = $modPeriode->tahunanggaran." - ".$modPeriode->anggaran_nama;
                }else{
                    $tahunanggaran = '-';
                }
                echo CHtml::textField('periodeanggaran_id',$tahunanggaran,array('readonly' => true,'class'=>'span3'));
            ?>
        </div>
    </div>
        
    <div class="control-group">        
        <?php echo CHtml::label("RUP<span class='required'>*<span>",'',array('class' => 'control-label')); ?>
        <div class="controls">
            <?php 
                echo CHtml::activeTextField($modRencana,'rencanaumumpengadaan_nomor',array('readonly' => true,'class'=>'span3'));
            ?>
        </div>
    </div>          
</div>