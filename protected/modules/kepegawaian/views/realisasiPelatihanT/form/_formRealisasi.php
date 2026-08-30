<?php
/**
* - digunakan untuk menampilkan form inputan realisasi
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
?>

<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->labelEx($modRealisasi,'tgl_ditetapkan', array('class'=>' control-label')); ?>
        <div class="controls">
            <?php 
                $this->widget('MyDateTimePicker', array(
                'model'=>$modRealisasi,
                'attribute'=>'tgl_ditetapkan',
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array('readonly' => true,
                    'class'=>'span2 required',
                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
            ?>
        </div>
    </div>
    
    <?php echo $form->textFieldRow($modRealisasi,'no_sk',array('maxlength'=>50,'class'=>'required')) ?>
    
    <div class="control-group">
        <?php echo $form->labelEx($modRealisasi, 'pejabatyangmendiklat', array('class' => ' control-label')); ?>
        <div class="controls">
            <?php echo $form->hiddenField($modRealisasi, 'pejabatyangmendiklat',array('readonly'=>true)); ?>
            <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model'=>$modRealisasi,
                    'attribute' => 'pejabatyangmendiklat_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                             url: "' . $this->createUrl('AutocompletePegawaiDiklat') . '",
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
                            $("#'.Chtml::activeId($modRealisasi, 'pejabatyangmendiklat') . '").val(ui.item.pegawai_id); 
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'class'=>'pegawaimenyetujui_nama required',
                        'onkeypress'=>"return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modRealisasi, 'pejabatyangmendiklat') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawaiDiklat'),
                ));
            ?>
        </div>
    </div>
</div>

<div class="col-sm-6" hidden>    
        <div class="control-group">
            <?php echo $form->labelEx($modRealisasi, 'mengetahui_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($modRealisasi, 'mengetahui_id',array('readonly'=>true)); ?>
                <?php echo $form->hiddenField($modRealisasi, 'pemberitugas_id',array('readonly'=>true)); ?>
                <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model'=>$modRealisasi,
                        'attribute' => 'pegawaimengetahui_nama',
                        'source' => 'js: function(request, response) {
                            $.ajax({
                                 url: "' . $this->createUrl('AutocompletePegawaiMengetahui') . '",
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
                                $("#'.Chtml::activeId($modRealisasi, 'mengetahui_id') . '").val(ui.item.pegawai_id); 
                                return false;
                            }',
                        ),
                        'htmlOptions' => array(
                            'class'=>'pegawaimengetahui_nama',
                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                            'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modRealisasi, 'mengetahui_id') . '").val(""); '
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                    ));
                ?>
            </div>
        </div>
        <?php /*
        <div class="control-group">
            <?php echo $form->labelEx($model,'tglmengetahui', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php 
                $this->widget('MyDateTimePicker', array(
                'model'=>$model,
                'attribute'=>'tglmengetahui',
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array('readonly' => true,
                    'class'=>'span2',
                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>
        </div>     
         * 
         */ ?>   
        <div class="control-group">
            <?php echo $form->labelEx($modRealisasi, 'menyetujui_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($modRealisasi, 'menyetujui_id',array('readonly'=>true)); ?>
                <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model'=>$modRealisasi,
                        'attribute' => 'pegawaimenyetujui_nama',
                        'source' => 'js: function(request, response) {
                            $.ajax({
                                 url: "' . $this->createUrl('AutocompletePegawaiMenyetujui') . '",
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
                                $("#'.Chtml::activeId($modRealisasi, 'menyetujui_id') . '").val(ui.item.pegawai_id); 
                                return false;
                            }',
                        ),
                        'htmlOptions' => array(
                            'class'=>'pegawaimenyetujui_nama',
                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                            'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modRealisasi, 'menyetujui_id') . '").val(""); '
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui'),
                    ));
                ?>
            </div>
        </div>
        <?php /*
        <div class="control-group">
            <?php echo $form->labelEx($model,'tglmenyetujui', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php 
                $this->widget('MyDateTimePicker', array(
                'model'=>$model,
                'attribute'=>'tglmenyetujui',
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array('readonly' => true,
                    'class'=>'span2',
                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>
        </div>
           */ ?>
    </div>

<?php

//========= Dialog buat cari data Diklat Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiDiklat',
    'options'=>array(
        'title'=>'Pencarian Pegawai Diklat',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modPegawaiDiklat = new KPPegawaiV('searchPegawaiMengetahui');
$modPegawaiDiklat->unsetAttributes();
if(isset($_GET['KPPegawaiV'])) {
    $modPegawaiDiklat->attributes = $_GET['KPPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengetahui-grid',
	'dataProvider'=>$modPegawaiDiklat->searchPegawaiMengetahui(),
	'filter'=>$modPegawaiDiklat,
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
                                                  $(\"#'.CHtml::activeId($modRealisasi,'pejabatyangmendiklat').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($modRealisasi,'pejabatyangmendiklat_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiDiklat\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                ),                
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiDiklat, 'nama_pegawai'),
                    'value'=>'$data->namaLengkap',
                ),
                array(
                    'header'=>'Jabatan',
                    'filter'=>  CHtml::activeDropDownList($modPegawaiDiklat, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --')),
                    'value'=> function($data){
                        $j = JabatanM::model()->findByPk($data->jabatan_id);
                        
                        if (!empty($j)){
                            return $j->jabatan_nama;
                        }else{
                            return '-';
                        }
                    }   
                ),                              
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Diklat dialog =============================
?>