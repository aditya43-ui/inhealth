<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
    </div>
    <div class="panel-body">            
            <?php
            $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                    'action'=>Yii::app()->createUrl($this->route),
                    'method'=>'get',
                    'id'=>'carimutasiaset-form',
                    'type'=>'horizontal',
                    'focus'=>'#'.CHtml::activeId($model,'no_pendaftaran'),
                    'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),

            )); ?>
            <div class="row-fluid">
                <div class="col-sm-6">
                    <div class="control-group">
                         <label class="control-label">
                           Tanggal Mutasi
                        </label>           
                        <div class="controls">
                            <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                                <i class="entypo-calendar"></i>
                                <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                                <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                                <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                            </div>
                        </div>
                    </div>
                           
                   <?php if (!$model->is_pj_aset){ ?>
                        <div class="control-group ">        
                            <label class="control-label">Ruangan Asal</label>
                            <div class="controls">
                                <?php 

                                echo $form->hiddenField($model, 'ruanganasal_id',['class'=>'ruanganasal_id']); 
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $model,                                        
                                    'attribute' => 'ruanganasal_nama',
                                    'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('/actionAutoComplete/getRuangan') . '",
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
                                        'minLength' => 2,
                                        'focus' => 'js:function( event, ui ) {
                                                $(this).val( ui.item.label);
                                                return false;
                                         }',
                                        'select' => 'js:function( event, ui ) { 
                                                setRuangan(ui.item,"asal");
                                                return false;
                                        }',
                                    ),
                                    'htmlOptions' => array(
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'placeholder' => "Ketik Ruangan Asal",
                                        'class' => 'span3 ruanganasal_nama',
                                        'onblur'=>'if(this.value==""){$("#' . CHtml::activeId($model, 'ruanganasal_id') . '").val("")}'
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogRuangan','jsFunction'=>'$("#dialogRuangan").dialog("open");$("#jenis").val("asal")'),    
                                ));
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                    
                    <div class="control-group ">        
                        <label class="control-label">Lokasi Asal Aset</label>
                        <div class="controls">
                            <?php echo $form->hiddenField($model, 'lokasiasal_id',['class'=>'lokasiasal_id']); ?>   
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,                                        
                                'attribute' => 'lokasiasal_nama',
                                'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('/actionAutoComplete/getLokasiAset') . '",
                                        dataType: "json",
                                        data: {
                                            term: request.term,
                                            ruangan_id: $(".ruanganasal_id").val(),
                                            notpj: "'.(($model->is_pj_aset)?'tidak':'ya').'"
                                        },
                                        success: function (data) {
                                                response(data);
                                        }
                                    })
                                }',
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.label);
                                            return false;
                                     }',
                                    'select' => 'js:function( event, ui ) { 
                                            setLokasi(ui.item,"asal");
                                            return false;
                                    }',
                                ),
                                'htmlOptions' => array(
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'placeholder' => "Ketik lokasi ",
                                    'class' => 'span3 lokasiasal_nama',
                                    'onblur'=>'if(this.value==""){$("#' . CHtml::activeId($model, 'lokasiasal_id') . '").val("")}'
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogLokasi', 'jsFunction'=>'$("#dialogLokasi").dialog("open");$("#jenis").val("asal");refreshGridLokasi("asal");'),    
                            ));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                   
                     <div class="control-group">
                        <?php echo Chtml::label("No Mutasi",'jeniskasuspenyakit_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php 
                                echo $form->textField($model, 'nomutasiaset',array());
                            ?>
                        </div>
                    </div>     
                    
                    <?php if (!$model->is_pj_aset){ ?>
                        <div class="control-group ">        
                            <label class="control-label">Ruangan Tujuan</label>
                            <div class="controls">
                                <?php 

                                echo $form->hiddenField($model, 'ruangantujuan_id',['class'=>'ruangantujuan_id']); 
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $model,                                        
                                    'attribute' => 'ruangantujuan_nama',
                                    'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('/actionAutoComplete/getRuangan') . '",
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
                                        'minLength' => 2,
                                        'focus' => 'js:function( event, ui ) {
                                                $(this).val( ui.item.label);
                                                return false;
                                         }',
                                        'select' => 'js:function( event, ui ) { 
                                                setRuangan(ui.item,"tujuan");
                                                return false;
                                        }',
                                    ),
                                    'htmlOptions' => array(
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'placeholder' => "Ketik Ruangan Tujuan",
                                        'class' => 'span3 ruangantujuan_nama',
                                        'onblur'=>'if(this.value==""){$("#' . CHtml::activeId($model, 'ruangantujuan_id') . '").val("")}'
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogRuangan','jsFunction'=>'$("#dialogRuangan").dialog("open");$("#jenis").val("tujuan")'),    
                                ));
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                             
                    <div class="control-group ">        
                        <label class="control-label">Lokasi Aset Tujuan</label>
                        <div class="controls">
                            <?php echo $form->hiddenField($model, 'lokasitujuan_id',['class'=>'lokasitujuan_id']); ?>   
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,                                        
                                'attribute' => 'lokasitujuan_nama',
                                'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('/actionAutoComplete/getLokasiAset') . '",
                                        dataType: "json",
                                        data: {
                                            term: request.term,
                                            ruangan_id: $(".ruangantujuan_id").val(),
                                            notpj: "ya"
                                        },
                                        success: function (data) {
                                                response(data);
                                        }
                                    })
                                }',
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.label);
                                            return false;
                                     }',
                                    'select' => 'js:function( event, ui ) { 
                                            setLokasi(ui.item,"tujuan");
                                            return false;
                                    }',
                                ),
                                'htmlOptions' => array(
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'placeholder' => "Ketik lokasi aset tujuan",
                                    'class' => 'span3 lokasitujuan_nama',
                                    'onblur'=>'if(this.value==""){$("#' . CHtml::activeId($model, 'lokasitujuan_id') . '").val("")}'
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogLokasi', 'jsFunction'=>'$("#dialogLokasi").dialog("open");$("#jenis").val("tujuan");refreshGridLokasi("tujuan");'),    
                            ));
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                $insT = UnitkerjaM::model()->findAllByAttributes(array(
                    'unitkerja_aktif' => TRUE,
                ), array(
                    'order' => 'namaunitkerja ASC',
                ));
                $ruT = RuanganM::model()->findAllByAttributes(array(
                    'ruangan_aktif' => true,
                ), array(
                    'order' => 'ruangan_nama ASC',
                ));
                echo $form->dropDownListRow($model, 'unittujuan_id', CHtml::listData($insT, 'unitkerja_id', 'namaunitkerja'), array(
                    'empty' => '-- Pilih --',
                    'class' => 'span3',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/actionDynamic/GetRuanganDariUnitKerja', array('encode' => false, 'namaModel' => get_class($model), 'attr' => 'unittujuan_id')),
                        'success' => 'function(data){$("#' . CHtml::activeId($model, "ruangtujuan_id") . '").html(data); }',
                    ),
                ));
                echo $form->dropDownListRow($model, 'ruangtujuan_id', CHtml::listData($ruT, 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50));
                ?>
            </div>
            <!--fieldset class="box"-->
            <div class="form-action">
            <?php //echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>          
            <?php 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),
                array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan'));
                echo CHtml::hiddenField('pendaftaran_id');
                echo CHtml::hiddenField('pasien_id');
            ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw "></i>')), 
                Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                array('class'=>'btn btn-default spasi',
                    'onclick'=>'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); 
            ?>													
            <?php 
                $content = $this->renderPartial('../tips/transaksi',array(),true);
                $this->widget('UserTips',array('type'=>'admin','content'=>$content));
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw "></i>')),
                Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                array(
                    'class' => 'btn btn-danger spasi',
                    'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            );
            ?>
            <?php
            $content = $this->renderPartial('../tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>