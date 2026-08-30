<?php
/**
 * form pemeriksaan partograf lain - lain
 * issue RSST-1589, RSST-2474
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
?>
<p>&nbsp;</p>
<div class="panel panel-dark">
    <span class="group-title">
        Lain-Lain
    </span>
    <div class="panel-body" id="form-partograflainlain">
      
        <div class="col-sm-6">
            <?php echo CHtml::activeHiddenField($model, 'pemeriksaanpartograflain_id',array('readonly'=>true)); ?>
            <div class="control-group">
              <label class="control-label"></label>
              <div class="controls">
                &nbsp;
              </div>
            </div>
            <div class="control-group">
                <label class="control-label">Pendarahan <span class="required">*</span></label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model,'pendarahan',array('placeholder' =>'pendarahan', 'class'=>'required')) ?>
                </div>
            </div>                        
        </div>
                      
        <div class="col-sm-6">
            
            <div class="panel panel-dark">
                <span class="group-title">
                   Diagnosis
                </span>
                <div class="panel-body">
                    <div class="control-group">
                        <label class="control-label">&nbsp;&nbsp;&nbsp;Obstetri</label>
                        <div class="controls">
                            <?php echo CHtml::activeTextArea($model,'diagnosis_obstetri',array('placeholder' => 'diagnosis obstetri')) ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">&nbsp;&nbsp;&nbsp;Non Obstetri</label>
                        <div class="controls">
                            <?php echo CHtml::activeTextArea($model,'diagnosis_nonobstetri',array('placeholder' => 'diagnosis non obstetri')) ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">&nbsp;&nbsp;&nbsp;Janin</label>
                        <div class="controls">
                            <?php echo CHtml::activeTextArea($model,'diagnosis_janin',array('placeholder' => 'diagnosis janin')) ?>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            
        
        <div class="clear"></div>
        
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Dokter</label>
                <div class="controls">
                    <?php 
                        echo CHtml::activeHiddenField($model,'dokter_id',array('readonly'=>true));
                    
                        $this->widget('MyJuiAutoComplete', array(    
                            'model'=>$model,
                            'attribute' => 'dokter_nama',
                            'value' => '',
                            'sourceUrl' => Yii::app()->createUrl('/ActionAutoComplete/DropDokterRuangan',array('ruangan_id'=>Yii::app()->user->getState('ruangan_id'))),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);
                                        return false;
                                    }',
                                'select' => 'js:function( event, ui ) {
                                            setDokterPartoLain(ui.item.label,ui.item.pegawai_id);
                                            return false;
                                              }',
                            ),
                             'htmlOptions'=>array(
                                 'readonly'=>false,
                                 'placeholder'=>'Dokter',
                                 'size'=>20,
                                 'class'=>'dokter',
                                 'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'dokter_id') . '").val(""); ',
                                 'onkeypress'=>"return $(this).focusNextInputField(event);",
                             ),
                             //'tombolDialog'=>array('idDialog'=>'dialogDPJP','idTombol'=>'tombolDPJP'),
                        ));
                    ?>
                </div>
            </div>                        
            
        </div>
        
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Intruksi Dokter</label>
                <div class="controls">
                    <?php echo CHtml::activeTextArea($model,'intruksi_dokter',array('placeholder' => 'Catatan Dokter')) ?>
                </div>
            </div>            
        </div>
        
        <div class="clear"></div>
        
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Bidan</label>
                <div class="controls">
                    <?php 
                        echo CHtml::activeHiddenField($model,'bidan_id',array('readonly'=>true));
                    
                        $this->widget('MyJuiAutoComplete', array(    
                            'model'=>$model,
                            'attribute' => 'bidan_nama',
                            'value' => '',
                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/dropPetugasRuangan',array('ruangan_id'=>Yii::app()->user->getState('ruangan_id'),'jenis'=>'bidan')),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);
                                        return false;
                                    }',
                                'select' => 'js:function( event, ui ) {
                                                setBidanPartoLain(ui.item.label,ui.item.pegawai_id);
                                                return false;
                                              }',
                            ),
                             'htmlOptions'=>array(
                                 'readonly'=>false,
                                 'placeholder'=>'Bidan',
                                 'size'=>20,
                                 'class'=>'bidan',
                                 'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'bidan_id') . '").val(""); ',
                                 'onkeypress'=>"return $(this).focusNextInputField(event);",
                             ),
                             //'tombolDialog'=>array('idDialog'=>'dialogDPJP','idTombol'=>'tombolDPJP'),
                        ));
                    ?>
                </div>
            </div>                        
        </div>
        
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Catatan Bidan</label>
                <div class="controls">
                    <?php echo CHtml::activeTextArea($model,'catatan_bidan',array('placeholder' => 'Catatan Bidan')) ?>
                </div>
            </div>    
        </div>
        
        <div class="clear"></div>
        
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Perawat</label>
                <div class="controls">
                    <?php 
                        echo CHtml::activeHiddenField($model,'perawat_id',array('readonly'=>true));
                    
                        $this->widget('MyJuiAutoComplete', array(    
                            'model'=>$model,
                            'attribute' => 'perawat_nama',
                            'value' => '',
                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/DropPetugasRuangan',array('ruangan_id'=>Yii::app()->user->getState('ruangan_id'),'jenis'=>'paramedis')),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);
                                        return false;
                                    }',
                                'select' => 'js:function( event, ui ) {                                    
                                                setPerawatPartoLain(ui.item.label,ui.item.pegawai_id);
                                                return false;
                                              }',
                            ),
                             'htmlOptions'=>array(
                                 'readonly'=>false,
                                 'placeholder'=>'Perawat',
                                 'size'=>20,
                                 'class'=>'perawat',
                                 'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'perawat_id') . '").val(""); ',
                                 'onkeypress'=>"return $(this).focusNextInputField(event);",
                             ),
                             //'tombolDialog'=>array('idDialog'=>'dialogDPJP','idTombol'=>'tombolDPJP'),
                        ));
                    ?>
                </div>
            </div>                        
        </div>
        
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Catatan Perawat</label>
                <div class="controls">
                    <?php echo CHtml::activeTextArea($model,'catatan_perawat',array('placeholder' => 'Catatan Perawat')) ?>
                </div>
            </div>    
        </div>
        
        <div class="clear"></div>
        
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Cairan Infus</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model,'cairan_infus',array('placeholder' => 'Cairan Infus')) ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Oksigen</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model,'oksigen',array('placeholder' => 'Oksigen')) ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Laboratorium</label>
                <div class="controls">
                    <?php echo CHtml::activeTextArea($model,'laboratorium',array('placeholder' => 'Laboratorium')) ?>
                </div>
            </div>
        </div>
        
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Oksitosin</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model,'oksitosin',array('placeholder' => 'Oksitosi')) ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Produksi Urine</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model,'produksi_urine',array('placeholder' => 'Produksi urine')) ?>
                </div>
            </div>
        </div>
        
        <div class="clear"></div>
        <div class="col-sm-6">
            <?php 
            if (!isset($ubah)){
                echo CHtml::link(" <i class='".MyIcon::getIcons('tambah-baris')."'></i> Tambah","javascript:;",array('id'=>'tombol-tambah','onclick'=>'tambahPartografLain(this,"tambah");','class' => 'btn btn-danger',)); 
            }else{
                echo CHtml::link(" <i class='".MyIcon::getIcons('simpan')."'></i> Simpan","javascript:;",array('id'=>'tombol-ubah','onclick'=>'tambahPartografLain("dialog",'.$model->nourutlain.');','class' => 'btn btn-danger','style'=>'color:#fff;')); 
            } ?> 
        </div>
    </div>
</div>