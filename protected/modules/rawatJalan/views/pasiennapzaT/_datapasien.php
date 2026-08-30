
<fieldset>
    <legend class="rim2">Transaksi Pasien Napza </legend>
    <br>
    <table class="table table-condensed">
        <tr>
            <td>
                <!--<div class="control-group">-->
                    <!--?php echo CHtml::activeLabel($modPasien, 'tgl_pendaftaran', array('class' => 'control-label')); ?>-->
                    <?php echo CHtml::activeHiddenField($modPasien, 'tgl_pendaftaran', array('class' => 'control-label' )); ?>
                    <!--div class="controls">-->
                        <?php //echo CHtml::activeTextField($modPasien, 'tgl_pendaftaran', array('readonly' => true)); ?>
<!--<span id="tgl_pendaftaran"></span>
                    </div>
                </div>-->
                <div class="control-group">
                    <label class="control-label">No. Pendaftaran</label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'no_pendaftaran', array('readonly' => true, 'class' => 'span2')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'umur', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'umur', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'jeniskasuspenyakit_nama', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?>
                    </div>
                </div>
                 <div class="control-group">
                    <?php //echo $form->hiddenField($modPasien, 'diagnosa_id', array('class' => 'control-label')); ?>
                <label class="control-label">Diagnosa</label>
                    <div class="controls">
                        <?php echo CHtml::textField('diagnosa_nama', '', array('readonly' => true)); ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group">
                    <div class="control-label">  <?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'no_rek')); ?></div>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modPasien,
                            'attribute' => 'no_rekam_medik',
                            'value' => '',
                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/PasienRawatJalan'),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);

                                        return false;
                                    }',
                                'select' => 'js:function( event, ui ) {
                                         // $("#' . CHtml::activeId($modPasien, 'tgl_pendaftaran') . '").val(ui.item.tgl_pendaftaran);
                                              $("#tgl_pendaftaran").text(ui.item.tgl_pendaftaran);
                                          $("#' . CHtml::activeId($modPasien, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);   
                                          $("#' . CHtml::activeId($modPasien, 'umur') . '").val(ui.item.umur);     
                                          $("#' . CHtml::activeId($modPasien, 'jeniskasuspenyakit_nama') . '").val(ui.item.jeniskasuspenyakit_nama);
                                          $("#' . CHtml::activeId($modPasien, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);   
                                          $("#' . CHtml::activeId($modPasien, 'nama_pasien') . '").val(ui.item.nama_pasien);     
                                          $("#' . CHtml::activeId($modPasien, 'jeniskelamin') . '").val(ui.item.jeniskelamin);  
                                          $("#' . CHtml::activeId($modPasien, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);  
                                          $("#' . CHtml::activeId($modPasien, 'nama_bin') . '").val(ui.item.nama_bin);   
                                          $("#' . CHtml::activeId($modPasien, 'nama_pegawai') . '").val(ui.item.nama_pegawai);   
                                          $("#' . CHtml::activeId($model, 'pendaftaran_id') . '").val(ui.item.pendaftaran_id);     
                                          $("#' . CHtml::activeId($model, 'pasien_id') . '").val(ui.item.pasien_id);    
                                          $("#' . CHtml::activeId($model, 'pasienadmisi_id') . '").val(ui.item.pasienadmisi_id);
                                          $("#' . CHtml::activeId($modPasien, 'masukkamar_id') . '").val(ui.item.masukkamar_id); 
                                          $("#' . CHtml::activeId($modPasien, 'tglmasukkamar') . '").val(ui.item.tglmasukkamar); 
                                          $("#diagnosa_nama").val(ui.item.diagnosa); 
                                          $("#' . CHtml::activeId($modAnamnesa, 'keluhanutama') . '").val(ui.item.keluhanutama); 
                                          $("#' . CHtml::activeId($modAnamnesa, 'keluhantambahan') . '").val(ui.item.keluhantambahan); 
                                          $("#' . CHtml::activeId($modAnamnesa, 'riwayatpenyakitterdahulu') . '").val(ui.item.riwayatpenyakitterdahulu); 
                                          $("#' . CHtml::activeId($modAnamnesa, 'riwayatpenyakitkeluarga') . '").val(ui.item.riwayatpenyakitkeluarga); 
                                          $("#' . CHtml::activeId($modPeriksaFisik, 'tekanandarah') . '").val(ui.item.tekanandarah); 
                                          $("#' . CHtml::activeId($modPeriksaFisik,  'detaknadi') . '").val(ui.item.detaknadi); 
                                          $("#' . CHtml::activeId($modPeriksaFisik, 'pernapasan') . '").val(ui.item.pernapasan); 
                                          $("#' . CHtml::activeId($modPeriksaFisik, 'suhutubuh') . '").val(ui.item.suhutubuh); 
                                          $("#' . CHtml::activeId($modPeriksaFisik, 'paramedis_nama') . '").val(ui.item.pegawai); 
                                          $("#' . CHtml::activeId($modPeriksaFisik, 'beratbadan_kg') . '").val(ui.item.beratbadan); 
                                          $("#' . CHtml::activeId($modPeriksaFisik, 'tinggibadan_cm') . '").val(ui.item.tinggibadan); 
                                          $("#' . CHtml::activeId($modPeriksaFisik, 'kelainanpadabagtubuh') . '").val(ui.item.kelainanpadabagtubuh); 
                                          if (!jQuery.isNumeric(ui.item.diagnosa_id)){
                                              ui.item.diagnosa_id = 0;
                                          }
                                          $("#' . CHtml::activeId($model, 'diagnosa_id') . '").val(ui.item.diagnosa_id); 
                                          //setRiwayat();
                                              }',
                            ),
                            'tombolDialog'=>array('idDialog'=>'dialogPasien'),
                                'htmlOptions'=>array(
                                    'class'=>'span3',
                                    'placeholder'=>'No. Rekam Medik',
                                    ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($model, 'pasien_id', array('readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($model, 'pendaftaran_id', array('readonly' => true)); ?>
                        <?php //echo CHtml::activeHiddenField($model, 'pasienadmisi_id', array('readonly' => true)); ?>
                        
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'nama_bin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'nama_bin', array('readonly' => true)); ?>
                    </div>
                </div>
              <!--div class="control-group">
                     //echo CHtml::activeLabel($modPasien, 'nama_pegawai', array('class' => 'control-label')); ?>
                    <div class="controls">
                       // echo CHtml::activeTextField($modPasien, 'nama_pegawai', array('readonly' => true)); ?>
                    </div>
                </div>-->
                
            </div>

            </td>
        </tr><tr class='detailDiagnosa'>
            <td width="50%">
               
                <?php 
				//$modAnamnesa = new AnamnesaT;
                  //echo $form->textAreaRow($modAnamnesa, 'keluhanutama', array('rows' => 3, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); 
                 //echo $form->textAreaRow($modAnamnesa, 'keluhantambahan', array('rows' => 3, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); 
                 //echo $form->textFieldRow($modAnamnesa, 'riwayatpenyakitterdahulu', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
                 //echo $form->textFieldRow($modAnamnesa, 'riwayatpenyakitkeluarga', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
                ?>
            </td>
            <td width="50%">
<!--//echo $form->textFieldRow($modPeriksaFisik, 'tekanandarah', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                 //echo $form->textFieldRow($modPeriksaFisik, 'detaknadi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                //echo $form->textFieldRow($modPeriksaFisik, 'suhutubuh', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                 //echo $form->textFieldRow($modPeriksaFisik, 'beratbadan_kg', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                 //echo $form->textFieldRow($modPeriksaFisik, 'tinggibadan_cm', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                 //echo $form->textFieldRow($modPeriksaFisik, 'pernapasan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                 //echo $form->textFieldRow($modPeriksaFisik, 'paramedis_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                 //echo $form->textFieldRow($modPeriksaFisik, 'kelainanpadabagtubuh', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>-->
            </td>
        </tr>
    </table>
</fieldset>

<?php
//========= Dialog buat cari data Pasien=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPasien = new RJInfokunjunganrjV('searchKunjunganPasien');
$modPasien->statusperiksa = "SEDANG PERIKSA";
$modPasien->tgl_pendaftaran = date('Y-m-d');
if(isset($_GET['RJInfokunjunganrjV'])){
    $modPasien->attributes = $_GET['RJInfokunjunganrjV'];
    $format = new MyFormatter();
    $modPasien->tgl_pendaftaran  = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_pendaftaran']);
    $modPasien->statusperiksa  = $_REQUEST['RJInfokunjunganrjV']['statusperiksa'];
//    $modPasien->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_awal']);
//    $modPasien->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_akhir']);

}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modPasien->searchRJ(),
    'filter' => $modPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                            "id" => "selectPasien",
                                            "onClick" => "$(\"#RJInfokunjunganrjV_no_rekam_medik\").val(\"$data->no_rekam_medik\");
                                                          $(\"#RJInfokunjunganrjV_jeniskelamin\").val(\"$data->jeniskelamin\");
                                                          $(\"#RJInfokunjunganrjV_nama_pasien\").val(\"$data->nama_pasien\");
                                                          $(\"#RJInfokunjunganrjV_nama_bin\").val(\"$data->nama_bin\");
                                                          $(\"#RJInfokunjunganrjV_nama_pegawai\").val(\"$data->nama_pegawai\");
                                                          $(\"#RJInfokunjunganrjV_jeniskasuspenyakit_nama\").val(\"$data->jeniskasuspenyakit_nama\");
                                                        //  $(\"#RJInfokunjunganrjV_tgl_pendaftaran\").val(\"$data->tgl_pendaftaran\");
                                                         $(\"#tgl_pendaftaran\").text(\"$data->tgl_pendaftaran\");
                                                          $(\"#RJInfokunjunganrjV_no_pendaftaran\").val(\"$data->no_pendaftaran\");
                                                          $(\"#RJPasiennapzaT_pendaftaran_id\").val(\"$data->pendaftaran_id\");
                                                          $(\"#RJPasiennapzaT_pasien_id\").val(\"$data->pasien_id\");
                                                          $(\"#RJInfokunjunganrjV_umur\").val(\"$data->umur\");
                                                          $(\"#dialogPasien\").dialog(\"close\");    
                                                "))',
        ),
         'no_rekam_medik',  
                //tgl_pendaftaran',
                array(
                    'name'=>'tgl_pendaftaran',
                    'value'=>'$data->tgl_pendaftaran',
                    'filter'=>$this->widget('MyDateTimePicker',array(
                    'model'=>$modPasien,
                    'attribute'=>'tgl_pendaftaran',
                    'mode'=>'date',
                    'options'=> array(
                        'dateFormat'=>Params::DATE_FORMAT
                    ),
                        'htmlOptions'=>array('readonly'=>false, 'class'=>'dtPicker3','onclick'=>'showDateTime();'),
                    ),true
                    ),
                    'htmlOptions'=>array('width'=>'80','style'=>'text-align:center'),
                ),
                'no_pendaftaran',
                'nama_pasien', 
                'alamat_pasien',
                'penjamin_nama',
                'nama_pegawai',
                'jeniskasuspenyakit_nama',

                array(
                    'name'=>'statusperiksa',
                    'type'=>'raw',
                    'value'=>'$data->statusperiksa',
                    'filter' =>CHtml::activeDropDownList($modPasien,'statusperiksa',
                        LookupM::getItems('statusperiksa'),array('options' => array('STATUS PERIKSA'=>array('selected'=>true)))),
                ),
       
    ),
    'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});

            jQuery(\'#RJInfokunjunganrjV_tgl_pendaftaran\').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional[\'id\'], {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
        }',
));

$this->endWidget();
//========= end Dialog Pasien =============================
?>