<?php echo $form->hiddenField($modPasienMasukPenunjang, 'pasienmasukpenunjang_id', array('readonly'=>true,'class'=>'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, 'pasienkirimkeunitlain_id', array('readonly'=>true,'class'=>'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, 'ruangan_id', array('readonly'=>true,'class'=>'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, 'jeniskasuspenyakit_id', array('readonly'=>true,'class'=>'span3', 'value' => '459')); ?>

<?php //$form->dropDownListRow($modPasienMasukPenunjang,'jeniskasuspenyakit_id', CHtml::listData(RMPendaftaranT::model()->getJenisKasusPenyakitItems(Params::RUANGAN_ID_FISIOTERAPI), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
<?php // echo $form->dropDownListRow($modPasienMasukPenunjang,'kelaspelayanan_id', CHtml::listData(RMPendaftaranT::model()->getKelasPelayananItems(Params::RUANGAN_ID_FISIOTERAPI), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('onchange'=>'setChecklistPemeriksaanRehab();setTindakanPemeriksaanReset();','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
<div class="control-group">
    <?php echo Chtml::label('Dokter <span class="required">*</span>','',array('class'=>'control-label required')); ?>
    <div class="controls">
    <?php echo $form->hiddenField($modPasienMasukPenunjang,'pegawai_id',array('class'=>'control-label required')); ?>
    <?php 
                        $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modPasienMasukPenunjang,
                                'attribute' => 'nama_pegawai',
                                'source' => 'js: function(request, response) {
                                    $.ajax({
                                            url: "",
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
                                        $(this).val(ui.item.nama_pegawai);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                        setPegawai(ui.item);
                                        return false;
                                    }',
                                ),
                                'tombolDialog'=>array("idDialog"=>'dialogDpjp',),
                                'htmlOptions'=>array(    
                                    'onblur'=>'if(this.value==""){$("#'.CHtml::activeId($modPasienMasukPenunjang, 'pegawai_id').'").val("");}',
                                    'class'=>'span3 required','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Nama Dokter '),
                            ));
                    
                    ?>
    </div>
</div>
<div class="control-group">
    <?php echo Chtml::label('PPDS ','',array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo $form->hiddenField($modPasienMasukPenunjang,'ppds_id',array('class'=>'control-label')); ?>

        <?php 
                        $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modPasienMasukPenunjang,
                                'attribute' => 'nama_ppds',
                                'source' => 'js: function(request, response) {
                                    $.ajax({
                                            url: "",
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
                                        $(this).val(ui.item.ppds_nama);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                        setPpds(ui.item);
                                        return false;
                                    }',
                                ),
                                'tombolDialog'=>array("idDialog"=>'dialogPpds',),
                                'htmlOptions'=>array(    
                                    'onblur'=>'if(this.value==""){$("#'.CHtml::activeId($modPasienMasukPenunjang, 'ppds_id').'").val("");}',
                                    'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Nama PPDS '),
                            ));
                    
                    ?>
    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('Tgl. Tindakan', 'tgl_tindakan_semua', array('class'=>'control-label')); ?>
    <div class="controls">
            <?php   
                    $this->widget('MyDateTimePicker',array(
                                    'name'=>'tgl_tindakan_semua',
                                    'mode'=>'datetime',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions'=>array('readonly'=>true,'class'=>'span3'),
            )); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Tindakan Terapi <span class="required">*</span>', 'tindakanterapi_rehab', array('class'=>'control-label')); ?>
    <div class="controls">
        <?php 
            echo $form->dropDownList($modPasienMasukPenunjang, 'tindakanterapi_rehab', LookupM::getItems('tindakan_terapi'), ['empty' => '-- Pilih --', 'class' => 'search-dropdown required', 'multiple' => 'multiple'])
        ?>
    </div>
</div>

<?php

 
$this->beginWidget('zii.widgets.jui.CJuiDialog',
array(
    'id'=>'dialogDpjp',
    'options'=>array(
        'title'=>'Pencarian Dokter' ,
        'autoOpen'=>false,
        'width' => 600,
        'height' => 500,
        'resizable' => true,
    ),
)
);
                
$modDpjp = new DokterV('search');

if(isset($_GET['DokterV'])){
$modDpjp->attributes= $_GET['DokterV'];     
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'dialog-dpjp-grid',
    'dataProvider'=>$modDpjp->searchDialogDpjp(),
    'filter'=>$modDpjp,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',                                                
                'value'=>function($data){       
                    
                    $dt['pegawai_id'] = $data->pegawai_id;
                    $dt['pegawai_nama'] = $data->namaLengkap;
                    $res = json_encode($dt);

                    return CHtml::Link("<i class='icon-form-check'></i>","javascript:;",array("class"=>"btn-small", 
                                "id" => "selectBahan",
                                "onClick" => 'setPegawai('.$res.');'));
                },
            ), 
            array(
                'header' => 'Nama Dokter',
                'name' => 'nama_pegawai',                        
                'value' => function($data){
                    return $data->namaLengkap;
                }
            ),  
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
    
$this->endWidget('zii.widgets.jui.CJuiDialog'); 

?>

<?php

 
$this->beginWidget('zii.widgets.jui.CJuiDialog',
array(
    'id'=>'dialogPpds',
    'options'=>array(
        'title'=>'Pencarian PPDS',
        'autoOpen'=>false,
        'width' => 600,
        'height' => 500,
        'resizable' => true,
    ),
)
);
                
$modPpds = new PpdsM('search');

if(isset($_GET['PpdsM'])){
$modPpds->attributes= $_GET['PpdsM'];     
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'dialog-ppds-grid',
    'dataProvider'=>$modPpds->searchDialogPPDS(),
    'filter'=>$modPpds,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',                                                
                'value'=>function($data){      
                    
                    $dt['ppds_id'] = $data->ppds_id;
                    $dt['nama_ppds'] = $data->ppds_nama;
                    $res = json_encode($dt);

                    return CHtml::Link("<i class='icon-form-check'></i>","javascript:;",array("class"=>"btn-small", 
                                "id" => "selectBahan",
                                "onClick" => 'setPpds('.$res.');'));
                },
            ), 
            array(
                'header' => 'Nama PPDS',
                'name' => 'ppds_nama',                        
                'value' => function($data){
                    return $data->ppds_nama;
                }
            ),  
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
    
$this->endWidget('zii.widgets.jui.CJuiDialog'); 

?>

<script>

function setPegawai(data, obj){        
                
    $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'pegawai_id') ?>").val(data.pegawai_id);
    $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'nama_pegawai') ?>").val("" + data.pegawai_nama + "");
    $("#dialogDpjp").dialog('close');


}

function setPpds(data, obj){        
                
    $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'ppds_id') ?>").val(data.ppds_id);
    $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'nama_ppds') ?>").val("" + data.nama_ppds + "");
    $("#dialogPpds").dialog('close');


}


</script>

