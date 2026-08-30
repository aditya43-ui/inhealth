
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'lkpemeriksaanlabdet-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary($model); ?>

            <div class="control-group">
                <label class="control-label" for="bidang">Pemeriksaan Bank Darah</label>
                <div class="controls">
                <?php echo $form->hiddenField($modPemeriksaanLab,'pemeriksaanlab_id'); ?>
                        
                    <?php 
                            $this->widget('MyJuiAutoComplete', array(
                                            
                                            'name'=>'pemeriksaanlab_nama',
                                            'value'=>$modPemeriksaanLab->pemeriksaanlab_nama,
                                            'source'=>'js: function(request, response) {
                                                           $.ajax({
                                                               url: "'.Yii::app()->createUrl('ActionAutoComplete/searchPeriksaLabIsNotNull').'",
                                                               dataType: "json",
                                                               data: {
                                                                   term: request.term,
                                                               },
                                                               success: function (data) {
                                                                       response(data);
                                                               }
                                                           })
                                                        }',
                                             'options'=>array(
                                                   'showAnim'=>'fold',
                                                   'minLength' => 3,
                                                   'focus'=> 'js:function( event, ui ) {
                                                        $(this).val( ui.item.label);
                                                        return false;
                                                    }',
                                                   'select'=>'js:function( event, ui ) { 
                                                        $("#'.CHtml::activeId($modPemeriksaanLab, 'daftartindakan_id').'").val(ui.item.daftartindakan_id);
                                                        $("#daftartindakan_nama").val(ui.item.daftartindakan_nama);
                                                        return false;
                                                    }',
                                            ),
                                            'htmlOptions'=>array(
                                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                    'readonly'=>true,
                                            ),
                                            'tombolDialog'=>array('idDialog'=>'dialogPemeriksaanLab','jsFunction'=>'return false;'),
                                        )); 
                         ?>
                </div>
            </div>
            <?php //echo $form->textFieldRow($modPemeriksaanLab,'pemeriksaanlab_kode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'pemeriksaanlab_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'pemeriksaanlabdet_nourut',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	
<?php
foreach ($modDetails as $i => $nilaiRuj) {
    $jenKelamin = $nilaiRuj->nilairujukan->nilairujukan_jeniskelamin;
    $kelompokumur = $nilaiRuj->nilairujukan->kelompokumur;
    $idNilai = $nilaiRuj->nilairujukan_id;
    $kelDetail = $nilaiRuj->nilairujukan->kelompokdet;
    $nilai[$jenKelamin][$kelompokumur][$kelDetail][$idNilai]['namapemeriksaandet'] = $nilaiRuj->nilairujukan->namapemeriksaandet;
    $nilai[$jenKelamin][$kelompokumur][$kelDetail][$idNilai]['nilairujukan_id'] = $nilaiRuj->nilairujukan->nilairujukan_id;
    $nilai[$jenKelamin][$kelompokumur][$kelDetail][$idNilai]['nilairujukan_nama'] = $nilaiRuj->nilairujukan->nilairujukan_nama;
    $nilai[$jenKelamin][$kelompokumur][$kelDetail][$idNilai]['nilairujukan_min'] = $nilaiRuj->nilairujukan->nilairujukan_min;
    $nilai[$jenKelamin][$kelompokumur][$kelDetail][$idNilai]['nilairujukan_max'] = $nilaiRuj->nilairujukan->nilairujukan_max;
    $nilai[$jenKelamin][$kelompokumur][$kelDetail][$idNilai]['nilairujukan_satuan'] = $nilaiRuj->nilairujukan->nilairujukan_satuan;
    $nilai[$jenKelamin][$kelompokumur][$kelDetail][$idNilai]['nilairujukan_ket'] = $nilaiRuj->nilairujukan->nilairujukan_keterangan;
     
//    echo $form->textFieldRow($nilaiRuj->nilairujukan,'kelompokumur',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));
//    echo $form->textFieldRow($nilaiRuj->nilairujukan,'nilairujukan_jeniskelamin',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));
//    echo $form->textFieldRow($nilaiRuj->nilairujukan,'nilairujukan_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));
//    echo $form->textFieldRow($nilaiRuj->nilairujukan,'nilairujukan_min',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));
//    echo $form->textFieldRow($nilaiRuj->nilairujukan,'nilairujukan_max',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));
}
?>
        
<table>
    <tr>
        <?php
        $colspan = 0;
        foreach($nilai as $jenisKelamin=>$rujukanUmur){
            $colspan++;
            echo '<td>';
            
            echo '<table style="margin:0;">';
            echo '<tr><td>';
            echo '<label class="checkbox inline">';
            echo CHtml::checkBox('nilaiJeniskelamin',true,array('value'=>$jenisKelamin, 'onkeypress'=>"return $(this).focusNextInputField(event);"));
            echo $jenisKelamin;
            echo '</label>';
            echo '</td></tr>';
            echo '<tr><td>';
            
            echo '<table class="table-condensed" style="margin:0;">';
                foreach($rujukanUmur as $kelUmur=>$keldetail){
                    echo '<tr><td>'.$kelUmur.'</td><tr>';
                    echo '<tr><td>';
                    
                    echo '<table class="table table-bordered" style="margin:0;">';
                    echo '<thead><tr><th>Pemeriksaan Detail</th><th>Min</th><th>Max</th><th>Nilai Normal</th><th>Satuan</th></tr></thead>';
                    foreach($keldetail as $kelompok=>$nilaiRuj){
                        echo '<tr><th colspan="5">'.$kelompok.'</th></tr>';
                        
                        foreach($nilaiRuj as $id=>$periksaDetail){
                            echo '<tr><td>'.$periksaDetail['namapemeriksaandet'].'</td>';
                            echo '<td>'.CHtml::textField("nilaiNormal[$jenisKelamin][$kelUmur][$id][nilaiMin]", $periksaDetail['nilairujukan_min'], array('class'=>'inputFormTabel lebar2',)).'</td>';
                            echo '<td>'.CHtml::textField("nilaiNormal[$jenisKelamin][$kelUmur][$id][nilaiMax]", $periksaDetail['nilairujukan_max'], array('class'=>'inputFormTabel lebar2',)).'</td>';
                            echo '<td>'.CHtml::textField("nilaiNormal[$jenisKelamin][$kelUmur][$id][nilaiNama]", $periksaDetail['nilairujukan_nama'], array('class'=>'span1',)).'</td>';
                            echo '<td>'.CHtml::dropDownList("nilaiNormal[$jenisKelamin][$kelUmur][$id][nilaiSatuan]", $periksaDetail['nilairujukan_satuan'], LookupM::getItems('satuanhasillab'),array('class'=>'inputFormTabel lebar3','empty'=>'-- Pilih --')).'</td>';
                            echo '</tr>';
                        }
                    }
                    echo '</table>';
                    
                    echo '</td></tr>';
                }
            echo '</table>';
            
            echo '</td></tr>';
            echo '</table>';
            
            echo '</td>';
        }
        ?>
    </tr>
<!--<tr>
        <td colspan="<?php echo $colspan; ?>">
            <table class="table table-bordered">
                <thead><tr><th>Satuan</th><th>Metode</th><th>Keterangan</th></tr></thead>
                <tr>
                    <td>
                          <?php echo $form->dropDownList($modDetails[0]->nilairujukan,'nilairujukan_satuan',LookupM::getItems('satuanhasillab'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'empty'=>'--'.$model->getAttributeLabel('nilairujukan_satuan').'--')); ?>
                    </td>
                    <td>
                          <?php echo $form->textField($modDetails[0]->nilairujukan,'nilairujukan_metode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30,'placeholder'=>$model->getAttributeLabel('nilairujukan_metode'))); ?>
                    </td>
                    <td>
                          <?php echo $form->textArea($modDetails[0]->nilairujukan,'nilairujukan_keterangan',array('class'=>'col-sm-6', 'onkeypress'=>"return $(this).focusNextInputField(event);",'placeholder'=>$model->getAttributeLabel('nilairujukan_keterangan'))); ?>
                    </td>
                </tr>
            </table> 
        </td>
    </tr>-->
</table>
        
        <div class="form-actions">
                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/'.pemeriksaanbankdarahdetail.'/admin'), 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
                <?php $this->widget('UserTips',array('type'=>'update'));?>
	</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari Pemeriksaan Bank Darah =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPemeriksaanLab',
    'options'=>array(
        'title'=>'Pemeriksaan Bank Darah',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modTindakanLab = new BDPemeriksaanlabtindV('searchPeriksaLabIsNotNullDialog');
$modTindakanLab->unsetAttributes();
if(isset($_GET['BDPemeriksaanlabtindV']))
    $modTindakanLab->attributes = $_GET['BDPemeriksaanlabtindV'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sainstalasi-m-grid',
	'dataProvider'=>$modTindakanLab->searchPeriksaLabIsNotNullDialog(),
	'filter'=>$modTindakanLab,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            'jenispemeriksaanlab_nama',
            'pemeriksaanlab_nama',
            'daftartindakan_nama',
            'kategoritindakan_nama',
            'kelompoktindakan_nama',
            //'daftartindakan_kode',
            'harga_tariftindakan',            
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>",
                            "#",
                            array(
                                "class"=>"btn-small", 
                                "id" => "selectTindakan",
                                "onClick" => "
                                $(\"#'.CHtml::activeId($modPemeriksaanLab, 'pemeriksaanlab_id').'\").val(\'$data->pemeriksaanlab_id\');
                                $(\"#pemeriksaanlab_nama\").val(\'$data->pemeriksaanlab_nama\');
                                $(\'#dialogPemeriksaanLab\').dialog(\'close\');return false;"))'
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>