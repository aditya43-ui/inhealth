<?php
/** 
 * form peminjam
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
?>
<div class="col-sm-6">
    <div class="control-group">		
        <?php echo CHtml::label("Tanggal Peminjaman <span class='required'>*</span>",'tglpengajuan_cuti', array('class' => 'control-label')) ?>
        <div class="controls">
            <div class="input-append">
                <?php
                     echo $form->textField($model,'peminjamanbrg_tanggal',array('readonly'=>true,'class'=>'span4-date'))
                ?>
                 <span id="GUPeminjamanbrgT_peminjamanbrg_tanggal_date" class="add-on"><i class="icon-calendar"></i></span>
            </div>
        </div>
    </div>
   
    <div class="control-group">        
        <?php echo CHtml::label("Nama Peminjam<span class='required'>*<span>",'',array('class' => 'control-label')); ?>
        <div class="controls">            
            <?php 
                echo $form->hiddenField($model,'pegpeminjam_id',array('readonly'=>true,));
                
                $this->widget('MyJuiAutoComplete', array(
                    'model'=>$model,
                    'attribute' => 'pegpeminjam_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                                url: "' . $this->createUrl('/actionAutoComplete/dropPetugasSemua') . '",
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
                            setPeminjam(ui.item);
                            return false;
                        }',
                    ),
                    'tombolDialog'=>array("idDialog"=>'dialogPegawai','jsFunction'=>"setDialog('peminjam',this);"),
                    'htmlOptions'=>array(                    
                        'onblur' => 'if(this.value==""){$("#'.CHtml::activeId($model, 'pegpeminjam_id').'").val("")}',
                        'class'=>'required','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Ketik Peminjam'),
                ));
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">NIP</label>
        <div class="controls">
            <?php 
                echo CHtml::activeTextField($model,'nip',array('readonly' => true));
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Jabatan</label>
        <div class="controls">
            <?php 
                echo CHtml::activeTextField($model,'jabatan_nama',array('readonly' => true));
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Unit Kerja</label>
        <div class="controls">
            <?php 
                echo CHtml::activeTextField($model,'namaunitkerja',array('readonly' => true));
            ?>
        </div>
    </div>
</div>

<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Nomor Peminjaman<span class="required">*</span></label>
        <div class="controls">
            <?php 
                echo CHtml::activeTextField($model,'peminjamanbrg_nomor',array('readonly' => true, 'class' => 'required'));
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Tanggal Peminjaman<span class="required">*</span></label>
        <div class="controls">
            <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tanggal_awal',
                    'mode' => 'date',
                    'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 required', 'onkeypress' => "return $(this).focusNextInputField(event)",'style'=>'width:80px;'
                    ),
                ));
            ?>
        </div>
        <div class="controls">
            <label>s/d</label>
        </div>
        <div class="controls">
            <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tanggal_akhir',
                    'mode' => 'date',
                    'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 required', 'onkeypress' => "return $(this).focusNextInputField(event)",'style'=>'width:80px;'
                    ),
                ));
            ?>
        </div>
    </div>
        
    <div class="control-group">        
        <?php echo CHtml::label("Ruangan Peminjam<span class='required'>*<span>",'',array('class' => 'control-label')); ?>
        <div class="controls">
            <?php 
                echo $form->hiddenField($model,'ruangan_id',array('readonly'=>true,));

                $this->widget('MyJuiAutoComplete', array(
                    'model'=>$model,
                    'attribute' => 'ruangan_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                                url: "' . $this->createUrl('/actionAutoComplete/GetRuangan') . '",
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
                            setRuangan(ui.item);
                            return false;
                        }',
                    ),
                    'tombolDialog'=>array("idDialog"=>'dialogRuangan','jsFunction'=>"setDialog('ruangan',this);"),
                    'htmlOptions'=>array(   
                        'onblur' => 'if(this.value==""){$("#'.CHtml::activeId($model, 'ruangan_id').'").val("")}',
                        'class'=>'required','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Ketik Ruangan '),
                ));
            ?>
        </div>
    </div>    
    
    <div class="control-group">        
        <?php echo CHtml::label("Keperluan<span class='required'>*<span>",'',array('class' => 'control-label')); ?>
        <div class="controls">
            <?php 
              echo CHtml::activeTextArea($model, 'peminjamanbrg_keperluan',array('class' => 'autogrow required'));
            ?>
        </div>
    </div>
</div>