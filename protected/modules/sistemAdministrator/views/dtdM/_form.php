

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sadtd-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onSubmit'=>'return requiredCheck(this);'),
        'focus'=>'#'.CHtml::activeId($model,'dtd_noterperinci'),
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
        <?php echo $form->errorSummary($model); ?>
        <table style="width: 100%; border: none;">
            <tr>
                <td>
                     <?php echo $form->textFieldRow($model,'dtd_noterperinci',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>400)); ?>
                     <div class="control-group">
                      <?php echo $form->labelEx($model,'tabularlist_id',array('class'=>'control-label required')); ?>
                         <div class="controls inline">
                      <?php echo $form->dropDownList($model,'tabularlist_id',  CHtml::listData($model->getTabularItems(), 'tabularlist_id', 'tabularlist_block'), 
                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                'class'=>'span3')); ?> 
                         </div> 
                     </div>
                     <?php echo $form->textFieldRow($model,'dtd_nourut',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                     <?php echo $form->textFieldRow($model,'dtd_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                </td>
                <td>
                     <?php echo $form->textFieldRow($model,'dtd_kode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                     <?php echo $form->textFieldRow($model,'dtd_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)"));?>
                           
                     <?php echo $form->textFieldRow($model,'dtd_katakunci',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                     <?php //echo $form->checkBoxRow($model,'dtd_menular', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			<div class="control-group">
				<?php echo CHtml::label("",'dtd_menular', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo $form->checkBox($model,'dtd_menular',array()); ?> <label>Menular</label>
				</div>				
			</div>
                </td>
            </tr>
            </table>
            
                

                
                <?php /*
                <div class='control-group'>
                    <label class ='control-label'>Diagnosa</label>
                    <?php echo CHtml::hiddenField('diagnosa_id'); ?>
                    

                  <div class="controls">
                    <?php
                      echo CHtml::htmlButton('<i class="icon-plus icon-white"></i> Tambah Diagnosa', 
                              array(
                                  'onclick' => 'tambahDiagnosa();return false;',
                                  'class' => 'btn btn-danger',
                                  'rel' => "tooltip",
                                  'title' => "Klik untuk menambahkan Diagnosa Pasien",
                                  )
                      );
                    ?>   
                 * 
                 */ ?> 

                    

                  <?php
                  //========= Dialog buat cari data obatAlkes =========================
                  $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                      'id' => 'dialogCariDiagnosa',
                      'options' => array(
                          'title' => 'Pencarian Diagnosa',
                          'autoOpen' => false,
                          'modal' => true,
                          'width' => 900,
                          'height' => 450,
                          'resizable' => false,
                      ),
                  ));
                  

       
                  
                 //=======================   Isi Widget==============================================
                 
                
                 
                /*
                $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'sadtd-m-grid',
                'dataProvider'=>$modDiagnosa->searchDiagnosis(),
                'filter'=>$modDiagnosa,
                      'template'=>"{summary}\n{items}{pager}",
                      'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(
                        array(
                            'name'=>'No',
                            'value'=>'$data->diagnosa_id',
                            'filter'=>false,
                             ),
                            'diagnosa_kode',   
                            'diagnosa_nama',
                            'diagnosa_namalainnya',

                        array(
                            'header'=>'Pilih',
                            'type'=>'raw',
                            'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","#",array("class"=>"btn-small", 
                                            "id" => "selectPasien",
                                            "onClick" => "inputDiagnosa(this,$data->diagnosa_id, \'$data->diagnosa_kode\');return false;"))',
                        ),                 
                ),
                       'afterAjaxUpdate'=>'function(id, data){
                          jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                          $("table").find("input[type=text]").each(function(){
                              cekForm(this);
                          })
                      }',
              ));     
                 * 
                 */              
                  $this->endWidget();
                  //========= end obatAlkes dialog =============================
            ?>
            <?php /*
                  <fieldset>                  
                  <table id="tbl_diagnosa" class="table table-condensed" width="500%">
                      <thead>
                          <tr>
                              <th>No. </th>
                              <th>Nama Diagnosa</th>
                              <th>Nama Lain</th>                              
                              <th>Batal</th>
                          </tr>
                      </thead>
                      <tbody>
                         
                        <!--<tr id="is_kosong">
                              <td align="center" colspan="8">Data tidak ditemukan</td>
                          </tr>-->
                        
                      </tbody>
                  </table>
                </fieldset>

                    */ ?>
              
            
            <?php //echo $form->checkBoxRow($model,'dtd_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class=entypo-floppy"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        $this->createUrl('admin'), 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan DTD', array('{icon}'=>'<i class="entypo-folder"></i>')),
                                                                    $this->createUrl('Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));?>
                <?php 
                      $content = $this->renderPartial($this->path_view.'tips/tipsCreateUpdate',array(),true);
                      $this->widget('UserTips',array('content'=>$content)); ?>
	</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    var id_diagnosa = new Array();


    function setDiagnosa(){
        var xxx = null;
        $('#tbl_diagnosa tbody tr').each(function(){
            xxx = $(this).find('input[name$="[diagnosa_kode]"]').val();
            id_diagnosax[xxx]='yes';
        });
    }
    setDiagnosa();
    
    function tambahDiagnosa(){
        $('#dialogCariDiagnosa').dialog("open");
    }

    function inputDiagnosa(mine, params, kode){
        $('#tbl_diagnosa').children('tbody').find("#is_kosong").remove();
        
        if (id_diagnosa[kode] == undefined){
            $('#tbl_diagnosa').children('tbody').append(trUraian.replace());
            $("#PPPasienMorbiditasT_99_diagnosa_id").val(params);
            var x=0;
            $(mine).parents('tr').find('td').each(
                function(){
                    if(x == 1)
                    {
                        $("#RJDiagnosaM_99_diagnosa_kode").val($(this).text());
                        id_diagnosax.push($(this).text());
                    }else if(x == 2){
                        $("#RJDiagnosaM_99_diagnosa_nama").val($(this).text());
                    }else if(x == 3){
                        $("#RJDiagnosaM_99_diagnosa_namalainnya").val($(this).text());
                    }
                    x++;
                }
            );
            setTimeout(function(){
                renameInput('PPPasienMorbiditasT','tglmorbiditas');
                renameInput('PPPasienMorbiditasT','kelompokdiagnosa_id');
                renameInput('PPPasienMorbiditasT','pegawai_id');
                
                renameInput('PPPasienMorbiditasT','pasienmorbiditas_id');
                renameInput('PPPasienMorbiditasT','diagnosa_id');
                
                renameInput('RJDiagnosaM','diagnosa_kode');
                renameInput('RJDiagnosaM','diagnosa_nama');
                renameInput('RJDiagnosaM','diagnosa_namalainnya');
            }, 500);
            id_diagnosa[kode] = 'yes';
        }else{
            myAlert("Diagnosis yang Anda input telah terdaftar, silakan cek kembali!");
        }
        

    }


    function namaLain(nama)
    {
        document.getElementById('SADtdM_dtd_namalainnya').value = nama.value.toUpperCase();
    }



    function inputDiagnosa(obj,idDiagnosa)
    {
      var idDiagnosa = idDiagnosa;
      var idKelDiagnosa = $(obj).parent().parent().find('select[name^="kelompokDiagnosa_"]').val();
      var tglDiagnosa = $('#RMPasienMorbiditasT_0_tglmorbiditas').val();
      if(!cekInputDiagnosa(idDiagnosa)) {
          $(obj).parent().parent().css("background-color", "yellow");
          jQuery.ajax({'url':'<?php echo $this->createUrl('loadFormDiagnosis')?>',
                   'data':{tglDiagnosa:tglDiagnosa, idDiagnosa:idDiagnosa, idKelDiagnosa:idKelDiagnosa},
                   'type':'post',
                   'dataType':'json',
                   'success':function(data) {
                           $('#tbl_diagnosa tbody').append(data.form);
                          // renameInput('Morbiditas','diagnosa');
                          // renameInput('Morbiditas','kelompokDiagnosa');
                          // renameInput('Morbiditas','diagnosaTindakan');
                          // renameInput('Morbiditas','sebabDiagnosa');
                          // renameInput('Morbiditas','infeksiNosokomial');
                   } ,
                   'cache':false});
      }else{
		myConfirm('Apakah Anda Akan Membatalkan Diagnosa No. '+idDiagnosa+'?','Perhatian!',function(r){
			if(r){
				$('#tblDiagnosaPasien').find('input[class$="idDiagnosa"]').each(function(){
					if(this.value == idDiagnosa)
						remove(this, idDiagnosa);
				});
			}
		});
      }
function renameInput(modelName, attributeName)
    {
        var trLength = $('#sadtd-m-grid tbody tr').length;
        var i=-1;
        $('#tbl_diagnosa tbody tr').each(function(){
            if($(this).has('span[name$="[diagnosa_id]"]').length){
                i++;
            }
            $(this).find('span[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
            $(this).find('span[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
            
            $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
            $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
            
            $(this).find('textarea[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
            $(this).find('textarea[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
            
            $(this).find('span[name$="[nourut_ex]"]').text(i+1);
            $(this).find('input[name$="[nourut]"]').val(i+1);
        });
    }

function cekInputDiagnosa(idDiagnosa)
{
    var sudahAda = false;
    $('#tblDiagnosaPasien').find('input[class$="idDiagnosa"]').each(function(){
        if(this.value == idDiagnosa)
            sudahAda = true;
    });
    return sudahAda;
}
    }
</script>


