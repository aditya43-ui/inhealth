<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - form inputan wrk order
* RSST-1584
*/
?>

<div class="panel panel-darkk">
    <span class="group-title">
        Work Order - Preventive Maintance
    </span>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Tanggal Pemeliharaan</label>
                <div class="controls">
                     <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglpemeliharaan',
                            'mode' => 'datetime',
                            'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('placeholder'=>'Tanggal','readonly' => true, 'class' => ' ', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            ),
                        ));
                    ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Jenis Peralatan</label>
                <div class="controls">
                    <?php echo $form->textField($model,'jenisperalatan',array('class'=>'','readonly'=>true)); ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Nomor Aset</label>
                <div class="controls">
                    <?php echo $form->textField($model,'nomoraset',array('class'=>'','readonly'=>true)); ?>
                </div>
            </div>
                
        </div>
        
        <div class="col-sm-6">
            
            
            <div class="control-group">
                <label class="control-label">Teknisi</label>
                <div class="controls">
                    <?php echo $form->checkBox($model,'isinternal',array('onclick'=>'cekTeknisi(this);')); ?> <label>Internal</label>
                </div>                
            </div>
            <div id="eksternal">
                <div class="control-group">
                        <label class="control-label">Vendor <span class="required">*</span></label>
                        <div class="controls">
                            <?php echo $form->dropDownList($model,'wo_supplier_id', CHtml::listData(SupplierM::model()->getSupplierUmumItems(),'supplier_id','supplier_nama'),array('class'=>'required','empty'=>'-- Pilih --')); ?>
                        </div>
                    </div>
                 <div class="control-group" >
                    <label class="control-label"></label>
                    <div class="controls">
                        <?php
                                echo $form->hiddenField($model,'teknisiperalatan_id',array('readonly'=>true));

                                $this->widget('MyJuiAutoComplete', array(    
                                   'model'=>$model,
                                   'attribute' => 'teknisiperalatan_nama',
                                   'value' => '',                               
                                    'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.Yii::app()->createUrl('/ActionAutoComplete/DropTeknisi').'",
                                                   dataType: "json",
                                                   data: {
                                                       term: request.term,
                                                       ruangan_id: '.Yii::app()->user->getState('ruangan_id').'
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
                                               $(this).val( ui.item.label);
                                               return false;
                                           }',
                                       'select' => 'js:function( event, ui ) {                                                    
                                                        setTeknisi(ui.item,"auto");
                                                        return false;
                                                     }',
                                   ),
                                    'htmlOptions'=>array(
                                        'readonly'=>false,
                                        'placeholder'=>'Teknisi Eksternal',
                                        'size'=>20,
                                        'class'=>'',
                                        'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'teknisiperalatan_id') . '").val(""); ',
                                        'onkeypress'=>"return $(this).focusNextInputField(event);",
                                    ),
                                    'tombolDialog'=>array('idDialog'=>'dialogTeknisi','idTombol'=>'tombolDPJP', 'jsFunction'=>""),

                               ));
                           ?>
                    </div>
                </div>
            </div>
                                        
            <div id="internal" hidden>
                
                
                <div class="control-group" >
                    <label class="control-label">Nama Teknisi</label>
                    <div class="controls">
                        <?php
                                echo $form->hiddenField($model,'teknisiint_id',array('readonly'=>true));

                                $this->widget('MyJuiAutoComplete', array(    
                                   'model'=>$model,
                                   'attribute' => 'teknisiint_nama',
                                   'value' => '',                               
                                    'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.Yii::app()->createUrl('/ActionAutoComplete/getPegawai').'",
                                                   dataType: "json",
                                                   data: {
                                                       term: request.term,
                                                       is_peg_internalaset: "ya"
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
                                               $(this).val( ui.item.label);
                                               return false;
                                           }',
                                       'select' => 'js:function( event, ui ) {
                                                        pilih(3);
                                                        setPegawai(ui.item,"auto");
                                                        return false;
                                                     }',
                                   ),
                                    'htmlOptions'=>array(
                                        'readonly'=>false,
                                        'placeholder'=>'Teknisi Internal',
                                        'size'=>20,
                                        'class'=>'',
                                        'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'teknisiperalatan_id') . '").val(""); ',
                                        'onkeypress'=>"return $(this).focusNextInputField(event);",
                                    ),
                                    'tombolDialog'=>array('idDialog'=>'dialogPegawai','idTombol'=>'tombolDPJP', 'jsFunction'=>"pilih(3);$('#judul').html('Teknisi Internal');"),

                               ));
                           ?>
                    </div>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Keterangan</label>
                <div class="controls">
                    <?php echo $form->textArea($model,'ket_pemeliharaan') ?>
                </div>
            </div>
        </div>
        
        <div class="clear"></div>
        
        <div class="form-actions">
            <?php
               echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                   Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class'=>(isset($_GET['sukses']))? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled'=>(isset($_GET['sukses']))? true : false));
               echo '&nbsp;';
               echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('index',array('prevmainten_id'=>$_GET['prevmainten_id'])), array('class' => 'btn btn-default',
                    'onclick' => 'if(!confirm("' . Yii::t('mds', 'Do You want to cancel?') . '")) return false;'));
           ?>

       </div>

    </div>
</div>
<?php if(isset($_GET['sukses'])){ ?>
<script>
    parent.location.reload();
</script>
<?php } ?>