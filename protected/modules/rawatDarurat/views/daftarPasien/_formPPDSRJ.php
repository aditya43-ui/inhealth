<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'ppdsrj-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'),
        'focus' => '#' . CHtml::activeId($model, 'pendaftaran_id'),
));

if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}

$this->widget('bootstrap.widgets.BootAlert');?>

<?php echo CHtml::hiddenField('norow', '', array('readonly' => TRUE)); ?>

<p class="help-block"><?php echo Yii::t('mds','Fields with <span>*</span> are required.') ?></p>
<?php echo $form->errorSummary(array($model)); ?>
    <div class="row-fluid">
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo $form->labelEx($model,'pendaftaran_id', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                         echo $form->textField($modPendaftaran,'no_pendaftaran',array('class'=>'span3','readonly'=>true));
                        ?>
                    <?php echo $form->error($model, 'pendaftaran_id'); ?> 
                </div>
            </div>

            <div class="control-group ">
                <?php echo $form->labelEx($modPasien,'nama_pasien', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                         echo $form->textField($modPasien,'nama_pasien',array('class'=>'span3','readonly'=>true));
                      //   echo $form->hiddenField($modPasien,'ruangan_id',array('class'=>'span3','readonly'=>true));
                        ?>
                    <?php echo $form->error($model, 'pasienadmisi_id'); ?> 
                </div>
            </div>


            <div class="control-group ">
                <?php echo $form->labelEx($modRuangan,'ruangan_nama', array('class'=>'control-label')) ?>
                <div class="controls">
                <?php   
                         echo $form->textField($modRuangan,'ruangan_nama',array('class'=>'span3','readonly'=>true));
                         echo $form->hiddenField($modRuangan,'ruangan_id',array('class'=>'span3','readonly'=>true));
                        ?>
                <?php echo $form->error($modRuangan, 'ruangan_id'); ?> 
                </div>
            </div>

            <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                   PPDS *                 
                </div>
            </div>
            <div class="panel-body">
<?php

$modPpds = new PasienPpdsT();
$modPpds->unsetAttributes();

if (isset($_GET['PasienPpdsT'])) {
    $modPpds->attributes = $_GET['PasienPpdsT'];
    $modPpds->ppds_nama = $_GET['PasienPpdsT']['ppds_nama'];
}
?>
<table width="100%" id="ppds-t-form" class=" col-sm-10 table table-bordered table-condensed">
    <thead>
     <tr >
        <th> No Urut </th>
        <th> Nama PPDS </th>
        <th>  </th>
     </tr>
    </thead>
    <?php $x = $model->urutan_ppds=1; ?> 
    <tbody>
        <tr class="no-row">
        <td class ="nomor"><?php echo $x++; ?></td>
        <td class ="ppds">
        <?php 
        echo CHtml::activeHiddenField($modPpds, '[i]ppds_id', array('class'=>'ppds_id'));
        $this->widget('MyJuiAutoComplete', array(
                                'model' => $modPpds,
                                'attribute' => '[i]ppds_nama',
                                'name'=>'ppds_nama',
                                'sourceUrl' => Yii::app()->createUrl('rawatJalan/DaftarPasien/AutoPPDS'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.value);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) { 
                                        setDaftar(ui.item, this);
                                        return false;
                                    }',
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => 'Nama PPDS',
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'class' => 'ppds_nama span4 required',
                                    'onblur'=>'if(this.value==""){clearDaftarHasil(this);}'
                                ),
                                'tombolDialog' => array(
                                    'idDialog' => 'dialogPPPDS',
                                    'jsFunction' => 'setRow(this);$("#dialogPPPDS").dialog("open");'
                                ),
                            ));
                             ?>
        </td>
        <td style="width: 120px; text-align: center;" >    
        <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onclick' => 'tambahBaris()')); ?>
    
    </td>
    </tr>
    </tbody>
</table>

    <div class="form-actions">

         <?php echo "<br>".CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)', 'onclick'=>'verifikasiSubmit(); return false;')); ?>
    </div>
    </div>
                        </div>
    <?php $this->endWidget(); ?>


<?php  $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPPPDS',
    'options' => array(
        'title' => 'Pencarian PPDS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));


$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ppds-m-grid',
    'dataProvider' => $modPpds->searchPPDS(),
    'filter' => $modPpds,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih PPDS',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                "id" => "selectPPDS",
                                "onClick" => "
                                        setPPDS($data->ppds_id, \"$data->ppds_nama\");
                                        $(\"#dialogPPPDS\").dialog(\"close\");    
                                        return false;
                                    "))',
        ),
        array(
            'name' => 'ppds_nama',
            'value' => '$data->ppds->ppds_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Pemberi Tugas dialog =============================
?>

<script>


function alertFunction() {
    alert("Nama PPDS tidak sesuai Login Anda");
}


var row = <?php echo CJSON::encode(array('row'=>$this->renderPartial('_rowLookup', array('model'=>$model), true))); ?>;

function tambahBaris(){
		$('#ppds-t-form').append(row.row);
		renameInputRow($("#ppds-t-form"));
	}

function setPPDS(id, nama) {

    var no = $("#norow").val();

    $('.ppds_id:eq(' + (no - 1) + ')').val(id);
    $('.ppds_nama:eq(' + (no - 1) + ')').val(nama);

}

    function setRow(obj) {
            var no = $(obj).parents("tr").find('.nomor').html();
            console.log('nomor: ' + no);
            $("#norow").val(no);
        }


    function hapusBaris(obj){
        var pasien_ppds_id = $(obj).parents("tr").find("input[name$='[ppds_id]']").val();
		if(pasien_ppds_id !== ""){
			myConfirm("Apakah Anda yakin akan menghapus data ini dari database?","Perhatian!",
			function(r){
				if(r){
					$.ajax({
						type:'POST',
						url:'<?php echo $this->createUrl('Delete'); ?>&id='+pasien_ppds_id,
						data: {id : pasien_ppds_id},//
						dataType: "json",
						success:function(data){
							if(data.sukses == 1){
								$(obj).parents('tr').detach();
								renameInputRow($("#ppds-t-form"));
							}
							myAlert(data.pesan);
							var rowCount = $("#ppds-t-form").find('tbody tr').length;
							if(rowCount==0){
								tambahLookup();
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
					});
				}
			});
		}else{
			$(obj).parents('tr').detach();
			renameInputRow($("#ppds-t-form"));
		}
	}



    function setDaftar(data, obj){            
            console.log("PILIH", $(obj).parents(".ppds"), data);

            $(obj).parents('.ppds').find('.no').html(row+1);
            $(obj).parents('.ppds').find('.ppds_id').val(data.ppds_id);
            $(obj).val(data.ppds_nama);
            
            $("#dialogDaftarHasil").dialog("close");
        }
    
        function clearDaftarHasil(obj){            
            $(obj).parents("tr").find('.ppds_id').val('');
        }
        

    function renameInputRow(obj_table){
		var row = 0;
		$(obj_table).find("tbody > tr").each(function(){
		
			$(this).find('input,select,textarea').each(function(){ //element <input>
				var old_name = $(this).attr("name").replace(/]/g,"");
				var old_name_arr = old_name.split("[");
				if(old_name_arr.length == 3){
					$(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
					$(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
				}
			});
            $(this).find('.nomor').html(row+1);
            $(this).find('.ppds').val(row.ppds_id);

			row++;
		});

		//====button visibility
		//init
		$(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().show();
		$(obj_table).find('tr td.rowbutton .icon-minus-sign').parent().show();
		//set
		$(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().hide();
		$(obj_table).find('tr:last-child td.rowbutton .icon-plus-sign').parent().show();
		var rowCount = $(obj_table).find('tbody tr').length;

		if(rowCount==0){

			$(obj_table).find('tr:first-child td.rowbutton .icon-plus-sign').parent().show();
			$(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().hide();
			id = $(obj_table).find('tr:first-child input[name*="[pasien_ppds_id]"]').val();
			if(id!=""){
				$(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().show();
			}
		}
		//====end button visibility

	}

    </script>
