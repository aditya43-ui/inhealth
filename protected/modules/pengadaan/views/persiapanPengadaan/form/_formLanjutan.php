<div class="col-sm-12">    
    <div id="form-lanjutan">
        <div class="control-group">        
            <?php echo CHtml::label("Program",'',array('class' => 'control-label')); ?>
            <div class="controls" style="width:77%">            
                <?php 
                    echo CHtml::activeHiddenField($model, 'programkerja_id', array('readonly' => true));
                    echo CHtml::activeTextField($model, 'programkerja_nama', array('style'=>'width:100% !important;','readonly' => true, 'class' => 'span3 required')); 
                ?>
            </div>
        </div>

        <div class="control-group">        
            <?php echo CHtml::label("Kegiatan",'',array('class' => 'control-label')); ?>
            <div class="controls" style="width:77%">            
                <?php 
                    echo CHtml::activeHiddenField($model, 'subprogram_id', array('readonly' => true));
                    echo CHtml::activeTextField($model, 'subprogramkerja_nama', array('style'=>'width:100% !important;','readonly' => true, 'class' => 'span3 required'));
                ?>
            </div>
        </div>
        
        <div class="control-group">        
            <?php echo CHtml::label("Sub Kegiatan",'',array('class' => 'control-label')); ?>
            <div class="controls" style="width:77%">            
                <?php                     
                    echo CHtml::activeHiddenField($model, 'subkegiatanprogram_id', array('style'=>'width:100% !important;','readonly' => true, 'class' => 'span3 required'));
                    echo CHtml::activeTextField($model, 'subkegiatanprogram_nama', array('style'=>'width:100% !important;','readonly' => true, 'class' => 'span3 required'));
                ?>
            </div>
        </div>

        <div class="control-group">        
            <?php echo CHtml::label("Nama Pekerjaan",'',array('class' => 'control-label')); ?>
            <div class="controls" style="width:77%">            
                <?php echo CHtml::activeTextField($model, 'nama_pekerjaan', array('style'=>'width:100% !important;','readonly' => true, 'class' => 'span3 required')) ?>
            </div>
        </div>
        
        <div class="control-group">        
            <?php echo CHtml::label("Kode Rekening",'',array('class' => 'control-label')); ?>
            <div class="controls" style="width:77%">            
                <div id="sumberdana">
                    
                </div>
            </div>
        </div>

        <div class="control-group">        
            <?php echo CHtml::label("Pagu pada DPA",'',array('class' => 'control-label')); ?>
            <div class="controls">            
                <?php echo CHtml::activeTextField($model, 'dpa_pagu', array('readonly' => true, 'class' => 'integer-decimal required')) ?>
            </div>
        </div>
        <div class="control-group">        
            <?php echo CHtml::label("Kode SIRUP ",'',array('class' => 'control-label')); ?>
            <div class="controls">            
                <?php echo CHtml::activeTextField($model, 'kode_sirup', array('class' => '')) ?>
            </div>
        </div> 
    </div>
    
    <div id="form-penyedia" class="hide">
        <div class="control-group">        
            <?php echo CHtml::label("Jenis Pengadaan",'',array('class' => 'control-label')); ?>
            <div class="controls">    
                <?php echo CHtml::activeHiddenField($model, 'jenispengadaan_id', array('readonly' => true, 'class' => '')) ?>
                <?php echo CHtml::activeTextField($model, 'jenispengadaan_nama', array('readonly' => true, 'class' => '')) ?>
            </div>
        </div>
        
        <div class="control-group">        
            <?php echo CHtml::label("Metode Pengadaan",'',array('class' => 'control-label')); ?>
            <div class="controls">            
                <?php 
                    echo CHtml::activeHiddenField($model, 'metodepengadaan_nama',  array( 'class' => '','readonly'=>true)); 
                    echo CHtml::activeDropDownList($model, 'metodepengadaan_id', CHtml::listData(MetodepengadaanM::model()->findAll(" metodepengadaan_aktif = TRUE ORDER BY metodepengadaan_urutan ASC "), 'metodepengadaan_id', 'metodepengadaan_nama'), array( 'class' => '', 'empty' => '-- Pilih --', 'onchange'=>'gantiNamaMetode(this);')); 
                ?>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Pemanfaatan Barang/Jasa</label>
            <div class="controls">
                <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'pemanfaatanbarang_tglawal',
                        'mode' => 'date',
                        'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                               // 'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                ?>
            </div>
            <div class="controls">
                <label>/</label>
            </div>
            <div class="controls">
                <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'pemanfaatanbarang_tglakhir',
                        'mode' => 'date',
                        'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                //'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                ?>
            </div>
        </div>                
        
        <div class="control-group">
            <label class="control-label">Pelaksanaan Pemilihan Penyedia</label>
            <div class="controls">
                <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'pemilihanpenyedia_tglawal',
                        'mode' => 'date',
                        'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                //'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                ?>
            </div>
            <div class="controls">
                <label>/</label>
            </div>
            <div class="controls">
                <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'pemilihanpenyedia_tglakhir',
                        'mode' => 'date',
                        'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                //'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                ?>
            </div>
        </div> 
    </div>                    
    
    <div id="form-swakelola" class="hide">
        <div class="control-group">        
            <?php echo CHtml::label("Tipe Swakelola",'',array('class' => 'control-label')); ?>
            <div class="controls">            
                <?php echo CHtml::activeDropDownList($model,'swakelola_tipe', LookupM::getItemsUrutan('swakelolatipe'),array('empty' => '-- Pilih --')); ?>
            </div>
        </div>                                
    </div>   
    
    <div id="form-tanggalkontrak" class="hide">
        <div class="control-group">
            <label class="control-label">Pelaksanaan <span id="judul-tanggal">Kontrak</span></label>
            <div class="controls">
                <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'pelaksanaankontrak_tglawal',
                        'mode' => 'date',
                        'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                //'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                ?>
            </div>
            <div class="controls">
                <label>/</label>
            </div>
            <div class="controls">
                <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'pelaksanaankontrak_tglakhir',
                        'mode' => 'date',
                        'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                //'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                ?>
            </div>
        </div>
    </div>
</div>