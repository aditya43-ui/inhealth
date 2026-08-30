<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kontrakpemeliharaan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>  
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
                    <?php echo CHtml::label('Tanggal Kontrak <span class="required">*</span>', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                    'model'=>$modKontrakPemeliharaan,
                                    'attribute'=>'kontrakpem_tgl',
                                    'mode'=>'date',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                        'onSelect'=> 'js:function( visitedDate ) {
                                            $("#'.CHtml::activeId($modKontrakPemeliharaan,'kontrakpem_sdtgl').'").datepicker( "option", "minDate", visitedDate );
                                        }',
                                    ),
                                    'htmlOptions'=>array('style' => 'width: 180px','class'=>'dtPicker3 required','onclick'=>"return $(this).focusNextInputField(event)"),
                                )); ?>
                    </div>
        </div>
        <div class="control-group">
                    <?php echo CHtml::label('Berlaku Sampai <span class="required">*</span>', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                    'model'=>$modKontrakPemeliharaan,
                                    'attribute'=>'kontrakpem_sdtgl',
                                    'mode'=>'date',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions'=>array('style' => 'width: 180px','class'=>'dtPicker3 required','onclick'=>"return $(this).focusNextInputField(event)"),
                                )); ?>
                    </div>
        </div>
        <div class="control-group">
                        <?php echo CHtml::label('Frekuensi <span class="required">*</span>','',array('class'=>'control-label'));?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modPrevent, 'frekuansi_prev', LookupM::getItems('setiapfrekuensi'), array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        </div>
                        <div class="controls">
                            <?php echo $form->textField($modPrevent,'frekuensi_jml_prev',array('class'=>'span1 numbers-only required','readonly'=>false)); ?>
                        </div>
                        <div class="controls">
                            <?php echo $form->dropDownList($modPrevent, 'frekuensi_sat_prev', LookupM::getItems('periodefrekuensi'), array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        </div>
        </div>
        <div class="control-group">
                        <?php echo CHtml::label('Vendor','',array('class'=>'control-label')); ?>
                    <div class="controls">
                            <?php echo $form->hiddenField($modKontrakPemeliharaan, 'supplier_id', array('readonly' => true)); ?>
                            <?php
                       $this->widget('MyJuiAutoComplete', array(
                        'name' => 'supplier_nama',
                        'source' => 'js: function(request, response) {
                                $.ajax({
                                        url: "' . $this->createUrl('AutoCompleteSupplier') . '",
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
                                        $(this).val( ui.item.label);										
                                        return false;
                                }',
                                'select' => 'js:function( event, ui ) {
                                        $("#'.Chtml::activeId($modKontrakPemeliharaan, 'supplier_id') . '").val(ui.item.supplier_id); 
                                        $("#supplier_nama").val(ui.item.supplier_nama); 
                                        return false;
                                }',
                        ),
                        'htmlOptions' => array(
                                'class'=>'span3',
                                'onkeyup'=>"return $(this).focusNextInputField(event)",        
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogSupplier'),
                ));
                ?>
                    </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
                <?php echo CHtml::label('No Kontrak <span class="required">*</span>','',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modKontrakPemeliharaan,'kontrakpem_no',array('readonly'=>false,'class'=>'span3 required')); ?>
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label('Nilai Kontrak','',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modKontrakPemeliharaan,'kontrakpem_nilai',array('readonly'=>false,'class'=>'span3 integer2')); ?>
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label('Keterangan','',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modKontrakPemeliharaan,'kontrakpem_ket',array('readonly'=>false,'class'=>'span3')); ?>
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("Dokumen",'',array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->fileField($modKontrakPemeliharaan,'kontrakpem_file',array('maxlength'=>150,'Hint'=>'Isi Jika Akan Menambahkan File lampiran')); ?>
                </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($modKontrakPemeliharaan->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' =>(isset($_GET['sukses']))? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)','disabled'=>(isset($_GET['sukses']))? true : false));
    ?>
</div>
<?php $this->endWidget(); ?>
<table width="100%" class="table table-bordered table-striped table-condensed">
    <thead>
        <th>No</th>
        <th>Periode Kontrak</th>
        <th>Vendor</th>
        <th>Frekuensi</th>
        <th>Nilai Kontrak</th>
        <th>Keterangan</th>
        <th style="text-align: center">Dokumen</th>
        <th style="text-align: center">Hapus</th>

    </thead>
    <tbody>
        <?php
        $no = 1;
        if(count($modKontrakDetail) > 0){
            foreach($modKontrakDetail AS $i=>$value){ 
                $modSuplier = SupplierM::model()->findByPk($value->supplier_id);
                $modPrevmainten = MAPrevmaintenT::model()->findByAttributes(array('kontrakpemeliharaan_id'=>$value->kontrakpemeliharaan_id));
    ?>
            <tr>   
                <td><?php echo $no++; ?></td>
                <td><?php echo MyFormatter::formatDateTimeForUser($value->kontrakpem_tgl)." - ".MyFormatter::formatDateTimeForUser($value->kontrakpem_sdtgl); ?> </td>
                <td><?php echo $modSuplier->supplier_nama; ?></td>
                <td><?php echo (!empty($modPrevmainten->prevmainten_id))? $modPrevmainten->frekuansi_prev." ".$modPrevmainten->frekuensi_jml_prev." ".$modPrevmainten->frekuensi_sat_prev : "-"; ?></td>
                <td  style="text-align: right"><?php echo !empty($value->kontrakpem_nilai)? MyFormatter::formatNumberForUser($value->kontrakpem_nilai) : ""; ?></td>
                <td><?php echo $value->kontrakpem_ket; ?></td>
                <td style="text-align: center"> <?php echo !empty($value->kontrakpem_file) ? CHtml::link($value->kontrakpem_file,$this->createUrl('Unduh',array('id'=>$value->kontrakpemeliharaan_id)),array('title'=>'Unduh Berkas','rel'=>'tooltip','style'=>'color:blue;'))."<br>" : ""; ?></td>
                <td style="text-align: center"><?php echo CHtml::link('<i class="glyphicon glyphicon-trash"></i>',$this->createUrl('Delete',array('id'=>$value->kontrakpemeliharaan_id)),array('title'=>'Hapus','rel'=>'tooltip','onclick' => 'myConfirm("Apakah anda ingin hapus data ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('Delete',array('id'=>$value->kontrakpemeliharaan_id)) . '";} ); return false;')) ; ?></td>
            </tr>
    <?php
            }
        } ?>
    </tbody>
</table>

<?php 
//========= Dialog buat cari vendor =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogSupplier',
    'options'=>array(
        'title'=>'Pencarian Distributor',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modSupplier = new SupplierM('search');
$modSupplier->unsetAttributes();
$modSupplier->supplier_aktif = true;

if(isset($_GET['GFSupplierM'])) {
    $modSupplier->attributes = $_GET['GFSupplierM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'supplier-grid',
	'dataProvider'=>$modSupplier->search(),
	'filter'=>$modSupplier,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($modKontrakPemeliharaan,'supplier_id').'\").val(\"$data->supplier_id\");
                                                  $(\"#supplier_nama\").val(\"$data->supplier_nama\");
                                                
                                                  $(\"#dialogSupplier\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'Nama',
                    'name'=>'supplier_nama',
                    'value'=>'$data->supplier_nama',
                    'filter'=>Chtml::activeTextField($modSupplier, 'supplier_nama', array('class' => 'numbers-only'))
                ),
                array(
                    'header'=>'Alamat',
                    //n 'filter'=>  CHtml::activeTextField($modSupplier, 'supplier_alamat'),
                    'value'=>'$data->supplier_alamat',
                    'filter'=>Chtml::activeTextField($modSupplier, 'supplier_alamat'),
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
                   jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); }',
        ));
$this->endWidget();
//========= end  dialog =============================
?>

<script type="text/javascript">
    $(document).ready(function () {
        $('form').bind('click keyup select change', function (event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function () {
            cekDisabled('form');
        });
        cekDisabled('form');
     });
</script>