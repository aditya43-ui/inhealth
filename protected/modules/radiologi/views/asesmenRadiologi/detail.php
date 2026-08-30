<style>
    .group-title{
        position: relative;
        top:-10px;       
        left:15px;               
        color:#001F3E;
        background: #fff;
        padding:10px;
    }
    
    .panel-darkk {

        border-color: #001F3E;
        -webkit-border-radius: 3px;
        -webkit-background-clip: padding-box;
        -moz-border-radius: 3px;
        -moz-background-clip: padding;
        border-radius: 3px;
        background-clip: padding-box;

    }
    
    .control-label{
        text-align:left !important;
        vertical-align: top !important;
    }
</style>

<div class="panel panel-gradient">    
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'asesmenedukasi-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
        ));
        
        if(Yii::app()->controller->module->id != 'asuhanKeperawatan'){
            echo $this->renderPartial($this->path_view.'_dataPasien', array(
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
            ), true);
        }
        ?>
        <div class="col-sm-6">
            <div class="control-group">
                 <?php echo $form->labelEx($model,'tgl_asesmen_keperawatan',array('class' => 'control-label')); ?>
                 <div class="controls">
                     <?php
                         $this->widget('MyDateTimePicker', array(
                                 'model' => $model,
                                 'attribute' => 'tgl_asesmen_keperawatan',
                                 'value'=>null,
                                 'mode' => 'datetime',
                                 'options' => array(
                                         'dateFormat' => Params::DATE_FORMAT,
                                         'maxDate' => 'd',
                                 ),
                                 'htmlOptions' => array(
                                         'readonly' => true,
                                         'onkeypress' => "return $(this).focusNextInputField(event)",
                                         'class'=>'span3 htpd',
                                 ),
                         ));
                     ?>
                 </div>
             </div>

             
             <?php echo $form->textAreaRow($model,'alasan_masuk',array('disabled'=>true,'class'=>'autogrow')); ?>

         </div>
        <div class="col-sm-6">
            <?php echo $form->textAreaRow($model,'riwayat_kesehatan',array('disabled'=>true,'class'=>'autogrow')); ?>

            <div class="control-group">
                <label class="control-label">Pernah Dirawat</label>
                <div class="controls">
                    <?php echo $form->checkBox($model,'pernahdirawat_ya',array('disabled'=>true,'onclick'=>'
                        if($(this).is(":checked")){
                            $("#'.CHtml::activeId($model, 'pernahdirawat_tidak').'").removeAttr("checked");
                        }
                    ')); ?> <label>Ya</label>
                </div>
                <div class="controls">
                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="controls">
                    <?php echo $form->checkBox($model,'pernahdirawat_tidak',array('disabled'=>true,'onclick'=>'
                        if($(this).is(":checked")){
                            $("#'.CHtml::activeId($model, 'pernahdirawat_ya').'").removeAttr("checked");
                        }
                    ')); ?> <label>Tidak</label>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Obat dari Rumah</label>
                <div class="controls">
                    <?php echo $form->checkBox($model,'obatdarirumah_ada',array('disabled'=>true,'onclick'=>'
                        if($(this).is(":checked")){
                            $("#'.CHtml::activeId($model, 'obatdarirumah_tidakada').'").removeAttr("checked");
                        }
                    ')); ?> <label>Ada</label>
                </div>
                <div class="controls">
                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="controls">
                    <?php echo $form->checkBox($model,'obatdarirumah_tidakada',array('disabled'=>true,'onclick'=>'
                        if($(this).is(":checked")){
                            $("#'.CHtml::activeId($model, 'obatdarirumah_ada').'").removeAttr("checked");
                        }
                    ')); ?> <label>Tidak Ada</label>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Berasal dari Daerah Endemik Malaria</label>
                <div class="controls">
                    <?php echo $form->checkBox($model,'dariedemikmalaria_ya',array('disabled'=>true,'onclick'=>'
                        if($(this).is(":checked")){
                            $("#'.CHtml::activeId($model, 'dariedemikmalaria_tidak').'").removeAttr("checked");
                        }
                    ')); ?> <label>Ya</label>
                </div>
                <div class="controls">
                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="controls">
                    <?php echo $form->checkBox($model,'dariedemikmalaria_tidak',array('disabled'=>true,'onclick'=>'
                        if($(this).is(":checked")){
                            $("#'.CHtml::activeId($model, 'dariedemikmalaria_ya').'").removeAttr("checked");
                        }
                    ')); ?> <label>Tidak</label>
                </div>
            </div>
        </div>
        <p>&nbsp;</p>
        <div class="col-sm-6">
            <div class="panel panel-darkk">
                <span class="group-title">
                    B1 Pernapasan
                </span>
                <div class="panel-body">
                    <?php echo $form->dropDownListRow($model,'pernafasan_sulitbernafas_ya', Params::getPilihanJawaban(),array('disabled'=>true,'class' => 'span2')); ?>

                    <div class="control-group">
                        <label class="control-label">RR</label>
                        <div class="controls">
                            <?php echo $form->textField($model,'pernafasan_respiratorrate',array('disabled'=>true,'class' => 'span2 numbers-only','style'=>'text-align:right;')) ?>
                        </div>
                        <div class="controls">
                            <?php echo $form->checkBox($model,'pernafasan_iscyanosis',array('disabled'=>true)); ?> <label>Cyanosis</label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Memakai O2</label>
                        <div class="controls">
                            <?php echo $form->textField($model,'pernafasan_pakai_o2',array('disabled'=>true,'class' => 'span1 numbers-only','style'=>'text-align:right;')); ?> <label> Menit</label>
                        </div>            
                    </div>

                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls">
                            <?php echo $form->checkBox($model,'pernafasan_pakai_casalcanul',array('disabled'=>true)); ?> <label>Nasal Canul</label>
                        </div>
                        <div class="controls">
                            <?php echo $form->checkBox($model,'pernafasan_pakai_sangkup',array('disabled'=>true)); ?> <label>Sungkup</label>
                        </div>
                    </div>        
                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls">
                            <?php echo $form->checkBox($model,'pernafasan_pakai_nonbreathing',array('disabled'=>true)); ?> <label>Re/Non-breathing mas</label>
                        </div>            
                    </div>

                </div>
            </div>
        </div>
        
        <div class="col-sm-6">
            <div class="panel panel-darkk">
                <span class="group-title">
                    B2 Sirkulasi
                </span>
                <div class="panel-body">
                    <div class="control-group">
                        <label class="control-label">Tensi</label>
                        <div class="controls">
                            <?php echo $form->textField($model,'sirkulasi_tensi_sistolik',array('disabled'=>true,'class'=>'numbers-only span1','style'=>'text-align:right;')); ?>
                        </div>            
                        <div class="controls">
                            <label>/</label>
                        </div>
                        <div class="controls">
                            <?php echo $form->textField($model,'sirkulasi_tensi_diastolik',array('disabled'=>true,'class'=>'numbers-only span1','style'=>'text-align:right;')); ?>
                        </div>   
                    </div>

                    <div class="control-group">
                        <label class="control-label">Nadi</label>
                        <div class="controls">
                            <?php echo $form->textField($model,'sirkulasi_nadi',array('disabled'=>true,'class'=>'span2')); ?>
                        </div>                        
                    </div>



                    <div class="control-group">
                        <label class="control-label">Perfus</label>
                        <div class="controls">
                            <?php echo $form->checkBox($model,'perfus_hangatkeringmerah',array('disabled'=>true)); ?> <label>Hangat Kering Merah</label>
                        </div>            
                        <div class="controls">
                            &nbsp;
                        </div>  
                        <div class="controls">
                            <?php echo $form->checkBox($model,'perfus_dinginpucat',array('disabled'=>true)); ?> <label>Dingin Pucat</label>
                        </div>  
                    </div>

                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls">
                            <?php echo $form->checkBox($model,'perfusi_sao2',array('disabled'=>true)); ?> <label>SaO<sub>2</sub></label>
                        </div>            
                        <div class="controls">
                            <?php echo $form->textField($model,'perfusi_sao2_keterangan',array('disabled'=>true,'class'=>'span2')); ?>
                        </div>                         
                    </div>

                    <div class="control-group">
                             <label class="control-label"></label>
                        <div class="controls">
                            <?php echo $form->checkBox($model,'perfusi_islainnya',array('disabled'=>true)); ?> <label>Dan Lain - Lain</label>
                        </div>  
                        <div class="controls">
                            <?php echo $form->textField($model,'perfusi_islainnya_keterangan',array('disabled'=>true,'class'=>'span2',
                                'onblur'=>"
                                    if($(this).val()!=''){
                                        $(".CHtml::activeId($model, 'perfusi_islainnya').").attr('checked',true);
                                    }else{
                                        $(".CHtml::activeId($model, 'perfusi_islainnya').").removeAttr('checked');
                                    }
                                "
                            )); ?>
                        </div>  
                    </div>

                </div>
            </div>
        </div>
        
        <div class="clear"></div>
        <p>&nbsp;</p>
         <div class="col-sm-6">
            <div class="panel panel-darkk">
                <span class="group-title">
                    B3 Persarafan
                </span>
                <div class="panel-body">
                    <div class="control-group">
                       <label>Kesadaran</label>
                        <div class="controls">
                        </div>
                    </div>       

                    <div class="control-group ">
                            <?php echo $form->labelEx($model,'persarafan_gcs_eye', array('class'=>'control-label')) ?>
                            <div class="controls">
                                    <?php $crit = new CDbCriteria();
                                            $crit->compare('LOWER(metodegcs_singkatan)',"e");
                                            $crit->addCondition('metodegcs_nilai is not null');
                                            $crit->order = 'metodegcs_nilai ASC';
                                             echo $form->dropDownList($model,'persarafan_gcs_eye',  
                                                            CHtml::listData(MetodegcsM::model()->findAll($crit), 'metodegcs_nilai', 'textMetodeGCSM'),array('disabled'=>true,'empty'=>'-- Pilih --', 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'hitungCGS()')); ?>
                            </div>
                    </div>
                    <div class="control-group ">
                            <?php echo $form->labelEx($model,'persarafan_gcs_verb', array('class'=>'control-label')) ?>
                            <div class="controls">
                                    <?php 
                                    $crit3 = new CDbCriteria();
                                    $crit3->compare('LOWER(metodegcs_singkatan)',"v");
                                    $crit3->addCondition('metodegcs_nilai is not null');
                                    $crit3->order = 'metodegcs_nilai ASC';
                                    echo $form->dropDownList($model,'persarafan_gcs_verb',
                                                    CHtml::listData(MetodegcsM::model()->findAll($crit3), 'metodegcs_nilai', 'textMetodeGCSM'),array('disabled'=>true,'empty'=>'-- Pilih --', 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'hitungCGS()')); ?>
                            </div>
                    </div>
                    <div class="control-group ">
                            <?php echo $form->labelEx($model,'persarafan_gcs_motorik', array('class'=>'control-label')) ?>
                            <div class="controls">
                                    <?php 
                                    $crit2 = new CDbCriteria();
                                    $crit2->compare('LOWER(metodegcs_singkatan)',"m");
                                    $crit2->addCondition('metodegcs_nilai is not null');
                                    $crit2->order = 'metodegcs_nilai ASC';
                                    echo $form->dropDownList($model,'persarafan_gcs_motorik',
                                                    CHtml::listData(MetodegcsM::model()->findAll($crit2), 'metodegcs_nilai', 'textMetodeGCSM'),array('disabled'=>true,'empty'=>'-- Pilih --', 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'hitungCGS()')); ?>
                            </div>
                    </div>

                    <?php echo $form->textFieldRow($model,'persarafan_total_gcs',array('readonly'=>true)); ?>

                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls">
                            <?php echo $form->checkBox($model,'persarafan_nilai_berubah',array('disabled'=>true)); ?> <label>Berubah</label>
                        </div>            
                        <div class="controls">
                            &nbsp;
                        </div>  
                        <div class="controls">
                            <?php echo $form->checkBox($model,'persarafan_gcs_normal',array('disabled'=>true)); ?> <label>Normal</label>
                        </div>  
                    </div>

                    <div class="control-group">
                        <label class="control-label">Psikologis</label>
                        <div class="controls">
                            <?php echo $form->checkBox($model,'persarafan_psikologis_tenang',array('disabled'=>true)); ?> <label>Tenang</label>
                        </div>            
                        <div class="controls">
                            &nbsp;&nbsp;
                        </div>  
                        <div class="controls">
                            <?php echo $form->checkBox($model,'persarafan_psikologis_cemas',array('disabled'=>true)); ?> <label>Cemas</label>
                        </div>  
                         <div class="controls">
                            &nbsp;
                        </div>  
                        <div class="controls">
                            <?php echo $form->checkBox($model,'persarafan_psikologis_takut',array('disabled'=>true)); ?> <label>Takut</label>
                        </div>  
                    </div>

                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls">
                            <?php echo $form->checkBox($model,'persarafan_psikologis_marah',array('disabled'=>true)); ?> <label>Marah</label>
                        </div>            
                        <div class="controls">
                            &nbsp;&nbsp;&nbsp;&nbsp;
                        </div>  
                        <div class="controls">
                            <?php echo $form->checkBox($model,'persarafan_psikologis_sedih',array('disabled'=>true)); ?> <label>Sedih</label>
                        </div>  

                    </div>

                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls">
                            <?php echo $form->checkBox($model,'persarafan_psikologis_lainnya',array('disabled'=>true)); ?> <label>Lainnya</label>
                        </div>            
                        <div class="controls">
                            &nbsp;
                        </div>  
                        <div class="controls">
                            <?php echo $form->textField($model,'persarafan_psikologis_lainketerangan',array('disabled'=>true,'placeholder'=>'lainnya','class' => 'span2',
                                'onblur'=>"
                                    if($(this).val()!=''){
                                        $(".CHtml::activeId($model, 'persarafan_psikologis_lainnya').").attr('checked',true);
                                    }else{
                                        $(".CHtml::activeId($model, 'persarafan_psikologis_lainnya').").removeAttr('checked');
                                    }
                                "
                            )); ?>
                        </div>  

                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-6">
            <div class="panel panel-darkk">
                <span class="group-title">
                    B4 Eliminasi
                </span>
                <div class="panel-body">        

                    <div class="control-group kemih_tidak">
                        <label class="control-label">Masalah Perkemihan</label>
                        <div class="controls">
                            <?php echo $form->checkBox($model,'eliminasi_tidakada',array('disabled'=>true,'class'=>'kemih_tidak', 'onclick'=>'validasiEliminasiTidak("1")')); ?> <label>Tidak Ada</label>
                        </div>                        
                    </div>

                    <div class="kemih_ada">
                        <div class="control-group">
                            <label class="control-label"><span class="eliminasi_ada">Masalah Perkemihan</span></label>
                            <div class="controls">
                                <?php echo $form->checkBox($model,'eliminasi_ada',array('disabled'=>true,'class'=>'kemih_ada', 'onclick'=>'validasiEliminasiAda("1")')); ?> <label>Ada :</label>
                            </div>                        
                            <div class="controls">

                            </div>             
                            <div class="controls eliminasi_ada">
                                <?php echo $form->checkBox($model,'eliminasi_ada_stoma',array('disabled'=>true,'class'=>'eliminasi_ada')); ?> <label>Stoma</label>
                            </div>                        
                        </div>
                        <div class="eliminasi_ada">
                            <div class="control-group">
                                <label class="control-label"></label>            
                                <div class="controls">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </div>             
                                <div class="controls">
                                    <?php echo $form->checkBox($model,'eliminasi_ada_inkontinensia',array('disabled'=>true,'class'=>'eliminasi_ada')); ?> <label>Inkontinensia Urin</label>
                                </div>                        
                            </div>

                            <div class="control-group">
                                <label class="control-label"></label>            
                                <div class="controls">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </div>             
                                <div class="controls">
                                    <?php echo $form->checkBox($model,'eliminasi_ada_retensi',array('disabled'=>true,'class'=>'eliminasi_ada')); ?> <label>Retensi Urin</label>
                                </div>                        
                            </div>

                            <div class="control-group">
                                <label class="control-label"></label>            
                                <div class="controls">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </div>             
                                <div class="controls">
                                    <?php echo $form->checkBox($model,'eliminasi_ada_kencingspontan',array('disabled'=>true,'class'=>'eliminasi_ada')); ?> <label>Kencing Spontan</label>
                                </div>                        
                            </div>

                            <div class="control-group">
                                <label class="control-label"></label>            
                                <div class="controls">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </div>             
                                <div class="controls">
                                    <?php echo $form->checkBox($model,'eliminasi_ada_striktur_uretra',array('disabled'=>true,'class'=>'eliminasi_ada')); ?> <label>Striktur Uretra</label>
                                </div>                        
                            </div>

                            <div class="control-group">
                                <label class="control-label"></label>            
                                <div class="controls">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </div>             
                                <div class="controls">
                                    <?php echo $form->checkBox($model,'eliminasi_ada_dialissi',array('disabled'=>true,'class'=>'eliminasi_ada')); ?> <label>Dialisis</label>
                                </div>                        
                            </div>

                            <div class="control-group">
                                <label class="control-label"></label>            
                                <div class="controls">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </div>             
                                <div class="controls">
                                    <?php echo $form->checkBox($model,'eliminasi_ada_dowerkateter',array('disabled'=>true,'class'=>'eliminasi_ada')); ?> <label>Dower Kateter</label>
                                </div>                        
                            </div>

                            <div class="control-group">
                                <label class="control-label"></label>            
                                <div class="controls">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </div>             
                                <div class="controls">
                                    <?php echo $form->checkBox($model,'eliminasi_ada_lainnya',array('disabled'=>true,'class'=>'eliminasi_ada')); ?> <label>Dll</label>
                                </div>                        
                            </div>
                            <div class="control-group">
                                <label class="control-label"></label>            
                                <div class="controls">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </div>             
                                <div class="controls">
                                    <?php echo $form->textField($model,'eliminasi_ada_keterangan',array('disabled'=>true,'placeholder'=>'lainnya','class'=>'span2 eliminasi_ada',
                                        'onblur'=>"
                                            if($(this).val()!=''){
                                                $(".CHtml::activeId($model, 'eliminasi_ada_lainnya').").attr('checked',true);
                                            }else{
                                                $(".CHtml::activeId($model, 'eliminasi_ada_lainnya').").removeAttr('checked');
                                            }
                                        "
                                    )); ?> 
                                </div>                        
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="clear"></div>
        <p>&nbsp;</p>
         <div class="col-sm-6">
            <div class="panel panel-darkk">
                <span class="group-title">
                    B5 Pencernaan dan Nutrisi
                </span>
                <div class="panel-body">        

                    <div class="control-group defekasi_tidakada">
                        <label class="control-label">Masalah Defekasi</label>
                        <div class="controls">
                            <?php echo $form->checkBox($model,'nutrisi_defekasi_tidakada',array('disabled'=>true,'class'=>'defekasi_tidakada', 'onclick'=>'validasiDefekasiTidak("1")')); ?> <label>Tidak Ada</label>
                        </div>                        
                    </div>

                    <div class="nutrisi_defekasi_ada">
                        <div class="control-group">
                            <label class="control-label"><span class="defekasi_ada">Masalah Defekasi</span></label>
                            <div class="controls">
                                <?php echo $form->checkBox($model,'nutrisi_defekasi_ada',array('disabled'=>true,'class'=>'nutrisi_defekasi_ada', 'onclick'=>'validasiDefekasiAda("1")')); ?> <label>Ada :</label>
                            </div>                        
                            <div class="controls">

                            </div>      
                            <div class="defekasi_ada">
                                <div class="controls">
                                    <?php echo $form->checkBox($model,'nutrisi_defekasi_ada_stoma',array('disabled'=>true,'class'=>'defekasi_ada')); ?> <label>Stoma</label>
                                </div>  
                                <div class="controls">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </div>  
                                <div class="controls">
                                    <?php echo $form->checkBox($model,'nutrisi_defekasi_ada_atresiaani',array('disabled'=>true,'class'=>'defekasi_ada')); ?> <label>Atresia Ani</label>
                                </div> 
                            </div>

                        </div>
                        <div class="control-group defekasi_ada">
                            <label class="control-label"></label>            
                            <div class="controls">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>             
                            <div class="controls">
                                <?php echo $form->checkBox($model,'nutrisi_defekasi_ada_konstipasi',array('disabled'=>true,'class'=>'defekasi_ada')); ?> <label>Konstipasi</label>
                            </div>                
                            <div class="controls">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                            <div class="controls">
                                <?php echo $form->checkBox($model,'nutrisi_defekasi_ada_diare',array('disabled'=>true,'class'=>'defekasi_ada')); ?> <label>Diare</label>
                            </div>  
                        </div>

                        <div class="control-group defekasi_ada">
                            <label class="control-label"></label>            
                            <div class="controls">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>             
                            <div class="controls">
                                <?php echo $form->checkBox($model,'nutrisi_defekasi_ada_inkontinensia',array('disabled'=>true,'class'=>'defekasi_ada')); ?> <label>Inkontinensia Alvi</label>
                            </div>                        
                        </div>
                    </div>


                    <table class="table table-bordered table-striped ">
                        <thead>
                            <tr>
                                <th colspan="2">Status Gizi/Nutisi</td>                    
                                <th>Penilaian</th>
                            </tr>
                            <tr class="even">
                                <td>1.</td>
                                <td><label>Pasien Kehilangan berat badan 5%</label></td>
                                <td style="text-align:left;">
                                    <div class="control-group">                                   
                                        <div class="controls">
                                            <?php echo $form->checkBox($model,'nutrisi_status_beratbadanhilang_ya',array('disabled'=>true,'class'=>'nutrisi_status', 'onclick'=>'cekNutrisiStatus()')); ?> <label>Ya</label>
                                        </div>             
                                        <div class="controls">
                                            <?php echo $form->checkBox($model,'nutrisi_status_beratbadanhilang_tidak',array('disabled'=>true)); ?> <label>Tidak</label>
                                        </div>                        
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><label>dalam waktu 3 bulan terakhir?</label></td>
                                <td style="text-align:left;">

                                </td>
                            </tr>
                            <tr class="even">
                                <td>2.</td>
                                <td><label>Asupan makan pasien kurang</label></td>
                                <td style="text-align:left;">
                                    <div class="control-group">                                   
                                        <div class="controls">
                                            <?php echo $form->checkBox($model,'nutrisi_status_asupankurang_ya',array('disabled'=>true,'class'=>'nutrisi_status', 'onclick'=>'cekNutrisiStatus()')); ?> <label>Ya</label>
                                        </div>             
                                        <div class="controls">
                                            <?php echo $form->checkBox($model,'nutrisi_status_asupankuran_tidak',array('disabled'=>true)); ?> <label>Tidak</label>
                                        </div>                        
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><label>dalam 1 minggu terakhir?</label></td>
                                <td style="text-align:left;">

                                </td>
                            </tr>
                            <tr class="even">
                                <td>3.</td>
                                <td><label>Pasien menderita penyakit yang berat?</label></td>
                                <td style="text-align:left;">
                                    <div class="control-group">                                   
                                        <div class="controls">
                                            <?php echo $form->checkBox($model,'nutrisi_status_deritapenyakit_ya',array('disabled'=>true,'class'=>'nutrisi_status', 'onclick'=>'cekNutrisiStatus()')); ?> <label>Ya</label>
                                        </div>             
                                        <div class="controls">
                                            <?php echo $form->checkBox($model,'nutrisi_status_deritapenyakit_tidak',array('disabled'=>true)); ?> <label>Tidak</label>
                                        </div>                        
                                    </div>
                                </td>
                            </tr>                
                        </thead>
                    </table>

                    <div class="col-sm-12" style="background:#ffe599;border:1px solid #333;display: none;" id="notif_nutrisi">
                        <label>
                        Perhatian : Pelu dilakukan konsultasi di poli gizi untuk <br/>
                        dilakukan asesmen awal gizi RM05d K
                        </label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-6">
            <div class="panel panel-darkk">
                <span class="group-title">
                    B6 Kulit dan Muskuloskeletal
                </span>
                <div class="panel-body">        

                    <div class="control-group">
                        <label class="control-label">Kulit</label>
                        <div class="controls">
                            <?php echo $form->checkBox($model,'kulit_icterus',array('disabled'=>true)); ?> <label>Icterus</label>
                        </div>                        
                        <div class="controls">
                        </div>
                        <div class="controls">
                            <?php echo $form->checkBox($model,'kulit_luka',array('disabled'=>true)); ?> <label>Luka</label>
                        </div>                        
                        <div class="controls">
                        </div>
                        <div class="controls">
                            <?php echo $form->checkBox($model,'kulit_lainnya',array('disabled'=>true)); ?> <label>Dll</label>
                        </div>        
                        <div class="controls">
                            <?php echo $form->textField($model,'kulit_keterangan',array('disabled'=>true,'class' => 'span2',
                                'onblur'=>"
                                    if($(this).val()!=''){
                                        $(".CHtml::activeId($model, 'kulit_lainnya').").attr('checked',true);
                                    }else{
                                        $(".CHtml::activeId($model, 'kulit_lainnya').").removeAttr('checked');
                                    }
                                "
                            )) ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Muskuloskeletal</label>
                        <div class="controls">
                            <?php echo $form->checkBox($model,'muskuloskeletal_deformitas',array('disabled'=>true)); ?> <label>Deformitas</label>
                        </div>                        
                        <div class="controls">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                        <div class="controls">
                            <?php echo $form->checkBox($model,'muskuloskeletal_decubitus',array('disabled'=>true)); ?> <label>Decubitus</label>
                        </div>                        
                    </div>

                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls">
                            <?php echo $form->checkBox($model,'muskuloskeletal_kekuatanotot',array('disabled'=>true)); ?> <label>Kekuatan Otot</label>
                        </div>                        
                        <div class="controls">
                            &nbsp;&nbsp;&nbsp;
                        </div>
                        <div class="controls">
                            <?php echo $form->dropDownList($model,'muskuloskeletal_kekuatanotot_ket', LookupM::getItems('muskuloskeletal_kekuatanotot'),array('disabled'=>true,'class' => 'span2')); ?> 
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <p>&nbsp;</p>
         <div class="col-sm-12">
            <div class="panel panel-darkk">
                <span class="group-title">
                    Sosial dan Ekonomi
                </span>
                <div class="panel-body">        
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label class="control-label">Hubungan pasien dengan anggota keluarga</label>

                            <div class="controls">
                                <?php echo $form->checkBox($model,'sosial_hubkeluarga_baik',array('disabled'=>true,'onclick'=>'
                                    if($(this).is(":checked")){
                                        $("#'.CHtml::activeId($model, 'sosial_hubkeluarga_tidakbaik').'").removeAttr("checked");
                                    }
                                ')); ?> <label>Baik</label>
                            </div>                        
                            <div class="controls">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
                            </div>                        
                            <div class="controls">
                                <?php echo $form->checkBox($model,'sosial_hubkeluarga_tidakbaik',array('disabled'=>true,'onclick'=>'
                                    if($(this).is(":checked")){
                                        $("#'.CHtml::activeId($model, 'sosial_hubkeluarga_baik').'").removeAttr("checked");
                                    }
                                ')); ?> <label>Tidak Baik</label>
                            </div>                        
                        </div>

                        <div class="control-group">
                            <label class="control-label">Tempat Tinggal</label>

                            <div class="controls">
                                <?php echo $form->checkBox($model,'sosial_tempattinggal_rumahpribadi',array('disabled'=>true)); ?> <label>Rumah Pribadi</label>
                            </div>                        
                            <div class="controls">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>                        
                            <div class="controls">
                                <?php echo $form->checkBox($model,'sosial_tempattinggal_rumahkeluarga',array('disabled'=>true)); ?> <label>Rumah Keluarga</label>
                            </div>                        
                        </div>
                        <div class="control-group">
                            <label class="control-label"></label>

                            <div class="controls">
                                <?php echo $form->checkBox($model,'sosial_tempattinggal_kontrak',array('disabled'=>true)); ?> <label>Kontrak</label>
                            </div>                        
                            <div class="controls">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    &nbsp;&nbsp;&nbsp;
                            </div>                        
                            <div class="controls">
                                <?php echo $form->checkBox($model,'sosial_tempattinggal_pantijompo',array('disabled'=>true)); ?> <label>Panti Jompo</label>
                            </div>                        
                        </div>

                        <div class="control-group">
                            <label class="control-label"></label>

                            <div class="controls">
                                <?php echo $form->checkBox($model,'sosial_tempattinggal_lainnya',array('disabled'=>true)); ?> <label>Lain - Lain</label>
                            </div>                        
                            <div class="controls">
                                <?php echo $form->textField($model,'sosial_tempattinggal_keteranganlain',array('disabled'=>true,'placeholder' => 'Lainnya',
                                    'onblur'=>"
                                        if($(this).val()!=''){
                                            $(".CHtml::activeId($model, 'sosial_tempattinggal_lainnya').").attr('checked',true);
                                        }else{
                                            $(".CHtml::activeId($model, 'sosial_tempattinggal_lainnya').").removeAttr('checked');
                                        }
                                    "
                                )); ?>
                            </div>                                        
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="control-group">
                            <label class="control-label">Penanggung Jawab Perawatan di Rumah</label>
                            <div class="controls">
                                <?php echo $form->textField($model,'sosial_penanggungjawab',array('disabled'=>true,'class'=>'span3')) ?>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        
        <p>&nbsp;</p>
         <div class="col-sm-12">
            <div class="panel panel-darkk">
                <span class="group-title">
                    Ketergantungan saat melaksanakan Actifity Daily Life
                </span>
                <div class="panel-body">        
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label class="control-label">Mobilisiasi : </label>

                            <div class="controls">
                                <?php echo $form->checkBox($model,'tergantung_mobilisasi_mandiri',array('disabled'=>true)); ?> <label>Mandiri</label>
                            </div>                        
                            <div class="controls">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                            </div>                        
                            <div class="controls">
                                <?php echo $form->checkBox($model,'tergantung_mobilisasi_dibantu',array('disabled'=>true)); ?> <label>Dibantu</label>
                            </div>                        
                        </div>

                        <div class="control-group">
                            <label class="control-label"></label>

                            <div class="controls">
                                <?php echo $form->checkBox($model,'tergantung_mobilisasi_tergantungpenuh',array('disabled'=>true)); ?> <label>Ketergantungan Penuh</label>
                            </div>                                        
                        </div>

                        <div class="control-group">
                            <label class="control-label">Personal : </label>

                            <div class="controls">
                                <?php echo $form->checkBox($model,'tergantung_personal_mandiri',array('disabled'=>true)); ?> <label>Mandiri</label>
                            </div>                        
                            <div class="controls">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                            </div>                        
                            <div class="controls">
                                <?php echo $form->checkBox($model,'tergantung_personal_dibantu',array('disabled'=>true)); ?> <label>Dibantu</label>
                            </div>                        
                        </div>

                        <div class="control-group">
                            <label class="control-label"></label>

                            <div class="controls">
                                <?php echo $form->checkBox($model,'tergantung_personal_tergantungpenuh',array('disabled'=>true)); ?> <label>Ketergantungan Penuh</label>
                            </div>                                        
                        </div>

                        <div class="control-group">
                            <label class="control-label">Toileting : </label>

                            <div class="controls">
                                <?php echo $form->checkBox($model,'tergantung_toileting_mandiri',array('disabled'=>true)); ?> <label>Mandiri</label>
                            </div>                        
                            <div class="controls">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                            </div>                        
                            <div class="controls">
                                <?php echo $form->checkBox($model,'tergantung_toileting_dibantu',array('disabled'=>true)); ?> <label>Dibantu</label>
                            </div>                        
                        </div>

                        <div class="control-group">
                            <label class="control-label"></label>

                            <div class="controls">
                                <?php echo $form->checkBox($model,'tergantung_toileting_tergantungpenuh',array('disabled'=>true)); ?> <label>Ketergantungan Penuh</label>
                            </div>                                        
                        </div>

                        <div class="control-group">
                            <label class="control-label">Berpakaian : </label>

                            <div class="controls">
                                <?php echo $form->checkBox($model,'tergantung_berpakaian_mandiri',array('disabled'=>true)); ?> <label>Mandiri</label>
                            </div>                        
                            <div class="controls">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                            </div>                        
                            <div class="controls">
                                <?php echo $form->checkBox($model,'tergantung_berpakaian_dibantu',array('disabled'=>true)); ?> <label>Dibantu</label>
                            </div>                        
                        </div>

                        <div class="control-group">
                            <label class="control-label"></label>

                            <div class="controls">
                                <?php echo $form->checkBox($model,'tergantung_berpakaian_tergantungpenuh',array('disabled'=>true)); ?> <label>Ketergantungan Penuh</label>
                            </div>                                        
                        </div>

                        <div class="control-group">
                            <label class="control-label">Makan/Minum : </label>

                            <div class="controls">
                                <?php echo $form->checkBox($model,'tergantung_mamin_mandiri',array('disabled'=>true)); ?> <label>Mandiri</label>
                            </div>                        
                            <div class="controls">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                            </div>                        
                            <div class="controls">
                                <?php echo $form->checkBox($model,'tergantung_mamin_dibantu',array('disabled'=>true)); ?> <label>Dibantu</label>
                            </div>                        
                        </div>

                        <div class="control-group">
                            <label class="control-label"></label>

                            <div class="controls">
                                <?php echo $form->checkBox($model,'tergantung_mamin_tergantungpenuh',array('disabled'=>true)); ?> <label>Ketergantungan Penuh</label>
                            </div>                                        
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="control-group alatbantu_tidakada">
                            <label class="control-label">Alat Bantu : </label>

                            <div class="controls">
                                <?php echo $form->checkBox($model,'alatbantu_tidakada',array( 'disabled'=>true,'class'=>'alatbantu_tidakada', 'onclick'=>'validasiAlatBantuTidak("1")')); ?> <label>Tidak Ada</label>
                            </div>                                                              
                        </div>

                         <div class="control-group alatbantu_ada">
                            <label class="control-label"><span class="alatbantu">Alat Bantu : </span></label>

                            <div class="controls">
                                <?php echo $form->checkBox($model,'alatbantu_ada',array('disabled'=>true, 'class'=>'alatbantu_ada', 'onclick'=>'validasiAlatBantuAda("1")')); ?> <label>Ada :</label>
                            </div>                        
                            <div class="controls">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                            </div>                        
                            <div class="controls alatbantu">
                                <?php echo $form->checkBox($model,'alatbantu_ada_pendengaran',array('disabled'=>true, 'class'=>'alatbantu')); ?> <label>Pendengaran</label>
                            </div>                        
                        </div>

                        <div class="alatbantu">
                            <div class="control-group">
                                <label class="control-label"></label>

                                <div class="controls">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </div>                        
                                <div class="controls">
                                    <?php echo $form->checkBox($model,'alatbantu_ada_penglihatan',array('disabled'=>true, 'class'=>'alatbantu')); ?> <label>Penglihatan</label>
                                </div>                        
                            </div>

                            <div class="control-group">
                                <label class="control-label"></label>

                                <div class="controls">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </div>                        
                                <div class="controls">
                                    <?php echo $form->checkBox($model,'alatbantu_ada_gerak',array('disabled'=>true, 'class'=>'alatbantu')); ?> <label>Gerak</label>
                                </div>                        
                            </div>

                            <div class="control-group">
                                <label class="control-label"></label>

                                <div class="controls">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </div>                        
                                <div class="controls">
                                    <?php echo $form->checkBox($model,'alatbantu_ada_jantung',array('disabled'=>true, 'class'=>'alatbantu')); ?> <label>Jantung</label>
                                </div>                        
                            </div>

                            <div class="control-group">
                                <label class="control-label"></label>

                                <div class="controls">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </div>                        
                                <div class="controls">
                                    <?php echo $form->checkBox($model,'alatbantu_ada_gigi',array('disabled'=>true, 'class'=>'alatbantu')); ?> <label>Jantung</label>
                                </div>                        
                            </div>

                             <div class="control-group">
                                <label class="control-label"></label>

                                <div class="controls">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </div>                        
                                <div class="controls">
                                    <?php echo $form->checkBox($model,'alatbantu_ada_lainnya',array('disabled'=>true, 'class'=>'alatbantu')); ?> <label>Lain - Lain</label>
                                </div>                        
                                <div class="controls">
                                    <?php echo $form->textField($model,'alatbantu_ada_keterangan',array('disabled'=>true,'class'=>'span2 alatbantu','placeholder'=>'lainnya',
                                        'onblur'=>"
                                            if($(this).val()!=''){
                                                $(".CHtml::activeId($model, 'alatbantu_ada_lainnya').").attr('checked',true);
                                            }else{
                                                $(".CHtml::activeId($model, 'alatbantu_ada_lainnya').").removeAttr('checked');
                                            }
                                        "
                                    )) ?>
                                </div>
                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <p>&nbsp;</p>
         <div class="col-sm-12">
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">Gangguan Fungsional</label>
                    <div class="controls">
                        <?php echo $form->checkBox($model,'gangguanfungsi_buta',array('disabled'=>true)); ?> <label>Buta</label>
                    </div>
                    <div class="controls">
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="controls">
                        <?php echo $form->checkBox($model,'gangguanfungsi_dayaingat',array('disabled'=>true)); ?> <label>Penurunan Daya Ingat</label>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                        <?php echo $form->checkBox($model,'gangguanfungsi_tuli',array('disabled'=>true)); ?> <label>Tuli</label>
                    </div>
                    <div class="controls">
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="controls">
                        <?php echo $form->checkBox($model,'gangguanfungsi_lemahanggotagerak',array('disabled'=>true)); ?> <label>Kelemahan Anggota</label>
                    </div>
                </div> 

                <div class="control-group">
                    <label class="control-label">Skrining Risiko Jatuh</label>
                    <div class="controls">
                        <?php echo $form->checkBox($model,'resikojatuh_ada',array('disabled'=>true,'onclick'=>'getDataResikoJatuh("ada")')); ?> <label>Ada</label>
                        <?php echo $form->hiddenField($model,'skoringresikojatuh_id',array('disabled'=>true,'class'=>'span2','readonly'=>true)); ?>
                    </div>
                    <div class="controls">
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="controls">
                        <?php echo $form->checkBox($model,'resikojatuh_tidakada',array('disabled'=>true,'onclick'=>'getDataResikoJatuh("tidak")')); ?> <label>Tidak</label>
                    </div>
                </div> 

                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="hover">
                        <div class="controls" style="border:1px solid #333;padding:5px;height:42px;width:42px;">

                        </div>
                        <div class="controls geseraja" style="border:1px solid #333;padding:5px;height:22px;width:20px;border-radius:20%;position: relative;left:-30px;top:5px;" onclick="calldialogAsesmenResikoJatuh(this)">

                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                        <label>Skrining Jatuh</label>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Skrining Nyeri</label>
                    <div class="controls">
                        <?php echo $form->checkBox($model,'skrining_nyeri_ada',array('disabled'=>true,'onclick'=>'getDataAsesmenNyeri("ada");')); ?> <label>Ada</label>
                    </div>
                    <div class="controls">
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="controls">
                        <?php echo $form->checkBox($model,'skrining_nyeri_tidakada',array('disabled'=>true,'onclick'=>'getDataAsesmenNyeri("tidak");')); ?> <label>Tidak</label>
                    </div>
                </div> 

                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="hover">
                    <div class="controls" style="border:1px solid #333;padding:5px;">
                        <?php  echo CHtml::image('images/icon_nyeri/6.png','alt',array('width'=>'30px','onclick'=>'calldialogAsesmenNyeri();')); ?>
            <!--        <a href="<?php // echo $this->createUrl('/rawatInap/AsesmenNyeri/Index',array('pendaftaran_id'=> $modPendaftaran->pendaftaran_id)) ?>">
                         <img src="images/icon_nyeri/6.png" title="sports" width="30px" />
                    </a>-->


                    </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                        <label>Skrining Nyeri</label>
                    </div>
                </div>
                 <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                       <?php echo $form->hiddenField($model,'asesmentnyeri_id',array('disabled'=>true,'class'=>'span2','readonly'=>true)); ?>
                       <?php echo $form->textField($model,'skor_nyeri',array('disabled'=>true,'class'=>'span2','readonly'=>true)); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Risiko Infeksi</label>
                    <div class="controls">
                        <?php echo $form->checkBox($model,'resikoinfeksi_ada',array('disabled'=>true,'onclick'=>'
                            if($(this).is(":checked")){
                                $("#'.CHtml::activeId($model, 'resikoinfeksi_tidakada').'").removeAttr("checked");
                                $("#'.CHtml::activeId($model, 'resikoinfeksi_tidakdiketahui').'").removeAttr("checked");
                            }
                        ')); ?> <label>Ada</label>
                    </div>
                    <div class="controls">
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="controls">
                        <?php echo $form->checkBox($model,'resikoinfeksi_tidakada',array('disabled'=>true,'onclick'=>'
                            if($(this).is(":checked")){
                                $("#'.CHtml::activeId($model, 'resikoinfeksi_ada').'").removeAttr("checked");
                                $("#'.CHtml::activeId($model, 'resikoinfeksi_tidakdiketahui').'").removeAttr("checked");
                            }
                        ')); ?> <label>Tidak Ada</label>
                    </div>
                </div> 

                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                        <?php echo $form->checkBox($model,'resikoinfeksi_tidakdiketahui',array('disabled'=>true,'onclick'=>'
                            if($(this).is(":checked")){
                                $("#'.CHtml::activeId($model, 'resikoinfeksi_tidakada').'").removeAttr("checked");
                                $("#'.CHtml::activeId($model, 'resikoinfeksi_ada').'").removeAttr("checked");
                            }
                        ')); ?> <label>Tidak Diketahui</label>
                    </div>
                </div> 

                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                        <?php echo $form->textField($model,'resikoinfeksi_ada_keterangan',array('disabled'=>true,'placeholder'=>'ada',
                            'onblur'=>'if($(this).val()==""){
                                    $("#'.CHtml::activeId($model, 'resikoinfeksi_ada').'").removeAttr("checked");
                                }else{
                                    $("#'.CHtml::activeId($model, 'resikoinfeksi_ada').'").attr("checked",true);
                                    $("#'.CHtml::activeId($model, 'resikoinfeksi_tidakada').'").removeAttr("checked");
                                    $("#'.CHtml::activeId($model, 'resikoinfeksi_tidakdiketahui').'").removeAttr("checked");
                                }',
                        )); ?> 
                    </div>       
                </div> 

                <div class="control-group">
                    <label class="control-label">Pencegahan yang harus dilakukan</label>
                    <div class="controls">
                        <?php echo $form->checkBox($model,'pencegahan_droplet',array('disabled'=>true)); ?> <label>Droplet</label>
                    </div>
                    <div class="controls">
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="controls">
                        <?php echo $form->checkBox($model,'pencegahan_udara',array('disabled'=>true)); ?> <label>Udara</label>
                    </div>
                </div> 

                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                        <?php echo $form->checkBox($model,'pencegahan_cairantubuh',array('disabled'=>true)); ?> <label>Cairan Tubuh</label>
                    </div>
                    <div class="controls">

                    </div>
                    <div class="controls">
                        <?php echo $form->checkBox($model,'pencegahan_cairankulit',array('disabled'=>true)); ?> <label>Cairan Kulit</label>
                    </div>
                </div> 

                 <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                           <?php echo $form->checkBox($model,'pencegahan_kontakkulit',array('disabled'=>true)); ?> <label>Kontak Langsung/Kulit</label>
                    </div>      
                </div> 

            </div>


            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">Risiko Sosial</label>
                    <div class="controls">
                           <?php echo $form->checkBox($model,'resikososial_hidupsendiri',array('disabled'=>true)); ?> <label>Hidup Sendiri</label>
                    </div>      
                </div> 

                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                           <?php echo $form->checkBox($model,'resikososial_tidakada',array('disabled'=>true)); ?> <label>Tidak Ada</label>
                    </div>      
                </div> 

                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                           <?php echo $form->checkBox($model,'resikososial_tidaktetap',array('disabled'=>true)); ?> <label>Tempat Tinggal Tidak Tetap</label>
                    </div>      
                </div>
                


                <div class="control-group">
                    <label class="control-label">Kondisi Psikologis Pasien</label>
                    <div class="controls">
                           <?php echo $form->checkBox($model,'kondisipasien_denial',array('disabled'=>true)); ?> <label>Denial (menolak)</label>
                    </div>      
                </div> 

                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                           <?php echo $form->checkBox($model,'kondisipasien_marah',array('disabled'=>true)); ?> <label>Marah</label>
                    </div>      
                </div> 

                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                           <?php echo $form->checkBox($model,'kondisipasien_bargaining',array('disabled'=>true)); ?> <label>Bargaining</label>
                    </div>      
                </div> 

                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                           <?php echo $form->checkBox($model,'kondisipasien_depresi',array('disabled'=>true)); ?> <label>Depresi/Cemas</label>
                    </div>      
                </div> 

                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                           <?php echo $form->checkBox($model,'kondisipasien_pasrah',array('disabled'=>true)); ?> <label>Pasrah</label>
                    </div>      
                </div> 

                <div class="control-group">
                    <label class="control-label">Masalah Keperawatan</label>
                    <div class="controls">
                           <?php echo $form->textArea($model,'masalahkeperawatan',array('disabled'=>true,'class'=>'autogrow')); ?>
                    </div>      
                </div> 
            </div>

            <div class="clear"></div>


            <div class="col-sm-12">
                 <div class="control-group">
                    <label class="control-label">Mengetahui :</label>
                    <div class="controls">

                    </div>      
                </div>         
            </div>

            <div class="clear"></div>
            <div class="col-sm-6">
                 <div class="control-group">
                    <label class="control-label">DPJP Utama</label>
                    <div class="controls">
                        <?php 
                            $dpjp = PegawaiM::model()->findByPk($model->dpjp_id);
                            echo $form->textField($model,'dpjp_id',array('disabled'=>true, 'value'=>$dpjp->NamaLengkap, 'class'=>'span4','placeholder'=>'')); ?>     
                    </div>      
                </div>  
            </div>    
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">Perawat/PPJP</label>
                    <div class="controls">
                        <?php 
                            $perawat = PegawaiM::model()->findByPk($model->perawat_id);
                            echo $form->textField($model,'perawat_id',array('disabled'=>true, 'value'=>$perawat->NamaLengkap, 'class'=>'span4','placeholder'=>'')); ?>
                    </div>      
                </div> 
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php
$this->endWidget();
?>
