<div class="col-sm-6">       
    <div class="control-group">        
        <?php echo CHtml::label("Nomor Transaksi<span class='required'>*<span>",'',array('class' => 'control-label')); ?>
        <div class="controls">            
            <?php echo CHtml::activeTextField($model, 'persiapanpengadaan_nomor', array('readonly' => true, 'class' => 'span4 required')) ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Tanggal Transaksi<span class="required">*</span></label>
        <div class="controls">
            <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'persiapanpengadaan_tanggal',
                    'mode' => 'datetime',
                    'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Pegawai Pembuat<span class="required">*</span></label>
        <div class="controls">
            <?php 
                echo CHtml::activeHiddenField($model, 'pegawaipembuat_id', array('readonly' => true));
                echo CHtml::activeTextField($model,'pegawaipembuat_nama',array('readonly' => true, 'class' => 'span4'));
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Unit Kerja<span class="required">*</span></label>
        <div class="controls">
            <?php 
                echo CHtml::activeHiddenField($model, 'unitkerja_id', array('readonly' => true, 'class'=>'required'));
                
                if(!empty($_GET['rencanaumumpengadaan_id'])):
                    echo CHtml::activeTextField($model,'namaunitkerja', array('class'=>'span4 namaunitkerja','readonly'=>true));
                else :
                    $this->widget('MyJuiAutoComplete', array(
                        'model'=>$model,
                        'attribute' => 'namaunitkerja',
                        'source' => 'js: function(request, response) {
                            $.ajax({
                                    url: "' . $this->createUrl('/actionAutoComplete/GetUnitKerjaPPK') . '",
                                    dataType: "json",
                                    data: {
                                        term: request.term,                                                                                                                     
                                    },
                                    success: function (data) {
                                        response(data);
                                    }
                            })
                         }',
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 3,
                            'focus' => 'js:function( event, ui ) {
                                $(this).val(ui.item.label);
                                return false;
                            }',
                            'select' => 'js:function( event, ui ) {
                                setUnitKerjaPPK(ui.item);
                                return false;
                            }',
                        ),
                        'tombolDialog'=>array("idDialog"=>'dialogUnitKerjaPPK',),
                        'htmlOptions'=>array(    
                            'onblur'=>'if(this.value==""){$("#'.CHtml::activeId($model, 'unitkerja_id').'").val("");}',
                            'class'=>'span4 required','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Ketik Unit Kerja '),
                    ));
                endif;
                
            ?>
        </div>
    </div>        
    
    
</div>

<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Bidang/Bagian/Instalasi<span class="required">*</span></label>
        <div class="controls">
            <?php 
                //echo CHtml::activeDropDownList($model,'instalasi_id', CHtml::listData(InstalasiM::model()->findAll("instalasi_aktif = TRUE ORDER BY instalasi_nama ASC"), 'instalasi_id', 'instalasi_nama'),array( 'empty' => '-- Pilih --','class'=>'ins_id'));
                echo CHtml::activeHiddenField($model,'instalasi_id', array('class'=>'ins_id'));
                echo CHtml::activeTextField($model,'instalasi_nama', array('class'=>'ins_id span4','readonly'=>true));
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Kategori Pengadaan<span class="required">*</span></label>
        <div class="controls">
            <?php 
                echo CHtml::activeTextField($model,'rencanaumumpengadaan_kategori', array('class'=>'rencanaumumpengadaan_kategori span4','readonly'=>true));
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Tahun Anggaran<span class="required">*</span></label>
        <div class="controls">
            <?php 
                $cri = new CDbCriteria();
                $cri->addCondition('isclosing_rencanaanggaran IS TRUE');
                $cri->addCondition('isclosing_closinganggaran IS FALSE');
                //$cri->addCondition('tahunanggaran = EXTRACT(YEAR FROM NOW())::text');
                $cri->order = " tahunanggaran DESC ";
                $thn_anggaran = CHtml::listData(PeriodeanggaranK::model()->findAll($cri), 'periodeanggaran_id', 'namaPeriode');
                if(!empty($_GET['rencanaumumpengadaan_id'])) :
                    echo CHtml::activeDropDownList($model,'periodeanggaran_id', $thn_anggaran,array('empty' => '-- Pilih --','class'=>'thn_id span4', 'readonly' => true));
                else :
                    echo CHtml::activeDropDownList($model,'periodeanggaran_id', $thn_anggaran,array('empty' => '-- Pilih --','class'=>'thn_id span4'));
                endif;
            ?>
        </div>
    </div>
        
    <div class="control-group">        
        <?php echo CHtml::label("RUP<span class='required'>*<span>",'',array('class' => 'control-label')); ?>
        <div class="controls">
            <?php 
                echo $form->hiddenField($model,'rencanaumumpengadaan_id',array('readonly'=>true,));
                echo $form->hiddenField($model,'rencanaumumpengadaan_nomortemp',array('readonly'=>true,));
                if(!empty($_GET['rencanaumumpengadaan_id'])) :
                    echo $form->textField($model,'rencanaumumpengadaan_nomor',array('readonly'=>true, 'class' => 'span4'));
                else :
                    $this->widget('MyJuiAutoComplete', array(
                        'model'=>$model,
                        'attribute' => 'rencanaumumpengadaan_nomor',
                        'source' => 'js: function(request, response) {
                            $.ajax({
                                    url: "' . $this->createUrl('/actionAutoComplete/GetRencanaPersiapanPengadaan') . '",
                                    dataType: "json",
                                    data: {
                                        term: request.term,                                                                                 
                                        instalasi_id:$(".ins_id").val(),
                                        rencanaumumpengadaan_kategori:$(".kat").val(),
                                        periodeanggaran_id:$(".thn_id").val(),
                                    },
                                    success: function (data) {
                                        response(data);
                                    }
                            })
                         }',
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 3,
                            'focus' => 'js:function( event, ui ) {
                                $(this).val(ui.item.label);
                                return false;
                            }',
                            'select' => 'js:function( event, ui ) {
                                loadRUP(ui.item.value);
                                return false;
                            }',
                        ),
                        'tombolDialog'=>array("idDialog"=>'dialogRUP', 'jsFunction' => 'setDialog();'),
                        'htmlOptions'=>array(   
                            'onblur' => 'cekRUPNomor(this);',
                            'class'=>'span4 required','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Ketik Rencana Umum Pengadaan '),
                    ));
                endif;
            ?>
        </div>
    </div>          
</div>