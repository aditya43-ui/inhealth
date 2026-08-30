<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?> 
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js'); ?>  
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'UbahRadiografer-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        )
    );
?>
<?php echo $form->errorSummary(array($modPasienMasukPenunjang)); ?>
 <div class="panel panel-gradient panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">Ubah DPJTM</div>
            </div>
            <div class="panel-body">
                <div class="col-sm-12">
                    <?php echo CHtml::hiddenField("jenisdialog","",array('readonly'=>true)); ?>
                    <div class="control-group">
                        <?php echo CHtml::label('DPJTM Lama','',array('class'=>'control-label')); ?>
                        <div class="controls">
                           <?php echo CHtml::activeTextField($modPegawai,'nama_pegawai',array('readonly'=>true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                    <?php echo CHtml::label("DPJTM Baru", '',array('class'=>'control-label required'))?>                                   
                        <div class="controls">
                             <?php //echo $form->dropDownList($modPasienMasukPenunjang,'pegawai_id', CHtml::listData(LBPendaftaranT::model()->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span4')); 
                                echo $form->hiddenField($modPasienMasukPenunjang, 'pegawai_id', array('readonly' => true, 'class' => 'span4 required pegawai_id'));

                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $modPasienMasukPenunjang,
                                    'attribute' => 'pegawai_nama',
                                    'source' => 'js: function(request, response) {
                                            $.ajax({
                                                url: "' . $this->createUrl('/ActionAutoComplete/DropPetugasRuangan') . '",
                                                dataType: "json",
                                                data: {
                                                    term: request.term,   
                                                    ruangan_id:'.Yii::app()->user->getState('ruangan_id').',
                                                    kelompokpegawai_id:'.Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP.'
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
                                                return false;
                                            }',
                                        'select' => 'js:function( event, ui ) {
                                                setPegawai(ui.item,"dpjtm",this);
                                                return false;
                                            }',
                                    ),
                                    'htmlOptions' => array(
                                        'class' => 'span3 required pegawai_nama',
                                        'placeholder' => 'Ketik Nama DPJTM',
                                        'onblur' => 'if(this.value==""){$("#'.CHtml::activeId($modPasienMasukPenunjang, 'pegawai_id').'").val("");}'
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogPetugas','jsFunction'=>'setDialog("dpjtm","dialogPetugas",this);'),
                                ));
                            
                            ?>
                    </div>
                    </div>
                </div>
              
            </div>
</div>                         
<div class="form-actions">
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary submit', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
    ?>
	<?php
        echo CHtml::htmlButton(
			Yii::t('mds','{icon} Cancel', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
			array('class'=>'btn btn-danger', 'type'=>'button','onClick'=>'closeDialog();')
		);
    ?>
</div>         
<?php $this->endWidget(); 

$this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogPetugas',
            'options'=>array(
                'title'=>'Pencarian Petugas <span class="judul-dialog-petugas"></span>' ,
                'autoOpen'=>false,
                'width' => 760,
                'height' => 600,
                'resizable' => true,
            ),
        )
    );
        	            
    $modPeg = new PegawairuanganV('search');
    
    if(isset($_GET['PegawairuanganV'])){
        $modPeg->attributes = $_GET['PegawairuanganV'];        
        $modPeg->namaunitkerja = isset($_GET['PegawairuanganV']['namaunitkerja'])?$_GET['PegawairuanganV']['namaunitkerja']:null;  
        $modPeg->jabatan_nama = isset($_GET['PegawairuanganV']['jabatan_nama'])?$_GET['PegawairuanganV']['jabatan_nama']:null;
        $modPeg->default = isset($_GET['PegawairuanganV']['default'])?$_GET['PegawairuanganV']['default']:null;
        $modPeg->notkelompokpegawai_id = isset($_GET['PegawairuanganV']['notkelompokpegawai_id'])?$_GET['PegawairuanganV']['notkelompokpegawai_id']:null;
    }
    
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'dialog-pegawai-grid',
            'dataProvider'=>$modPeg->searchDialogPegawai(),
            'filter'=>$modPeg,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                'columns'=>array(            
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>function($data) {
                                $load = $data->attributes;
                                $load['namaLengkap'] = $data->namaLengkap;
                                $load['namaunitkerja'] = $data->namaunitkerja;
                                $load['jabatan_nama'] = $data->jabatan_nama;
                                $res = json_encode($load);

                                return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"javascript:;",array("class"=>"btn-small", 
                                        "onclick" => 'setPegawai('.$res.');'));
                            },
                    ),
                   'nomorindukpegawai',
                    array(
                        'header' => 'Nama Pegawai',
                        'name' => 'nama_pegawai',
                        'value' => '$data->namaLengkap',
                        'filter' => CHtml::activeHiddenField($modPeg, 'notkelompokpegawai_id').CHtml::activeHiddenField($modPeg, 'kelompokpegawai_id').CHtml::activeHiddenField($modPeg, 'ruangan_id').CHtml::activeTextField($modPeg, 'nama_pegawai')
                    ),
                    'jabatan_nama',
                    'namaunitkerja'
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');  

?>

<script>
    function refreshDialog(filter){
        $.fn.yiiGridView.update('dialog-pegawai-grid', {
           data: {
               "PegawairuanganV[ruangan_id]":filter.ruangan_id,                                            
               "PegawairuanganV[kelompokpegawai_id]":filter.kelompokpegawai_id,
               "PegawairuanganV[notkelompokpegawai_id]":filter.notkelompokpegawai_id,
               "PegawairuanganV[default]":filter.default,
           }
       }); 
   }


   function setDialog(jenis,dlg,obj){        
       $("#jenisdialog").val(jenis);       

       var kelompokpegawai_id = 1;              
       var filter = {};
       var dev = 'ada';

       if (jenis == 'dpjtm'){
           $(".judul-dialog-petugas").html('DPJTM');             
           dev = '';
       }

       filter = {
           'kelompokpegawai_id':kelompokpegawai_id,
           'ruangan_id':<?php echo Yii::app()->user->getState('ruangan_id'); ?>,           
           'default':dev
       }

       refreshDialog(filter);

       $("#"+dlg).dialog('open');
   }

   function setPegawai(data,jenis, obj){        
        if (typeof jenis === 'undefined'){
            var jenis = $("#jenisdialog").val();
        }

        if (jenis == 'dpjtm'){
            $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'pegawai_id') ?>").val(data.pegawai_id);        
            $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'pegawai_nama') ?>").val(data.namaLengkap);        
        }
       
        $("#dialogPetugas").dialog('close');
       
   }
</script>