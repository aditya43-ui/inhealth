<table style="width: 100%; border: none;">
    <tr>
        <td width="33%">
            <fieldset class="box2" id="form-nonracikan">
                <legend class="rim">Non Racikan</legend>
                <div class="control-group">
                    <?php echo CHtml::hiddenField('obatalkes_id'); ?>
                    <label class="control-label" for="namaObat">Nama Obat</label>
                    <div class="controls">
                        <?php 
                            $this->widget('MyJuiAutoComplete', array(
                                            'name'=>'namaObatNonRacik',
                                            'source'=>'js: function(request, response) {
                                                           $.ajax({
                                                               url: "'.$this->createUrl('AutocompleteObatReseptur').'",
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
                                                   'minLength' => 2,
                                                   'select'=>'js:function( event, ui ) {
                                                       $(this).val( ui.item.label);
                                                       $("#form-nonracikan #obatalkes_id").val(ui.item.obatalkes_id);
                                                        return false;
                                                    }',
                                            ),
                                            'tombolDialog'=>array('idDialog'=>'dialogObat'),
                                            'htmlOptions'=>array("rel"=>"tooltip","title"=>"Pencarian Data Obat/Alkes",'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                        )); 
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Signa</label>
                    <div class="controls">
                         <?php echo CHtml::dropDownList('signa', '', LookupM::getItems('signa_oa'),array('class'=>'inputFormTabel span3','style'=>'width:100px;','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="qty">Jumlah</label>
                    <div class="controls">
                        <?php echo CHtml::textField('qtyNonRacik', '1', array('readonly'=>false,'onblur'=>'$("#qty").val(this.value);','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span1 numbersOnly')) ?>
                        <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                                array('onclick'=>'tambahObatNonRacik(this);return false;',
                                      'class' => 'btn btn-danger',
                                      'onkeypress'=>"tambahObatNonRacik(this);return false;",
                                      'rel'=>"tooltip",
                                      'title'=>"Klik untuk menambahkan resep",)); ?>
                    </div>
                </div>
            </fieldset>
        </td>
        <td>
            <fieldset class="box2" id="form-racikan">
                <legend class="rim">Racikan</legend>
                <table style="width: 100%; border: none;">
                    <tr>
                        <td>
                            <div class="control-group">
                              <?php echo CHtml::hiddenField('obatalkes_id'); ?>
                                <label class="control-label" for="racikanKe">R ke</label>
                                <div class="controls">
                                    <?php echo CHtml::dropDownList('racikanKe', '', CustomFunction::getDaftarAngka(),array('disabled'=>false,'class'=>'inputFormTabel span1','onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="namaObatRacik">Nama Obat</label>
                                <div class="controls">
                                    <?php 
                                        $this->widget('MyJuiAutoComplete', array(
                                                        'name'=>'namaObatRacik',
                                                        'source'=>'js: function(request, response) {
                                                                       $.ajax({
                                                                           url: "'.$this->createUrl('AutocompleteObatReseptur').'",
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
                                                               'minLength' => 2,
                                                               'select'=>'js:function( event, ui ) {
                                                                    $(this).val( ui.item.label);
                                                                    $("#form-racikan #obatalkes_id").val(ui.item.obatalkes_id);
                                                                    return false;
                                                                }',
                                                        ),
                                                        'htmlOptions'=>array("rel"=>"tooltip","title"=>"Pencarian Data Obat/Alkes",'disabled'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                                        'tombolDialog'=>array('idDialog'=>'dialogObatRacikan'),
                                                    )); 
                                    ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="permintaan">Permintaan Dosis</label>
                                <div class="controls">
                                    <?php echo CHtml::textField('permintaan', '', array('disabled'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span1 numbersOnly')) ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="jmlKemasan">Jumlah Kemasan</label>
                                <div class="controls">
                                    <?php echo CHtml::textField('jmlKemasanObat', '', array('disabled'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span1 numbersOnly')) ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="control-group">
                                <label class="control-label" for="kekuatanObat">Kekuatan</label>
                                <div class="controls">
                                    <?php echo CHtml::textField('kekuatanObat', '', array('disabled'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span1 numbersOnly')) ?>
                                    <span id="satuanKekuatanObat"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Signa</label>
                                <div class="controls">
                                     <?php echo CHtml::dropDownList('signa', '', LookupM::getItems('signa_oa'),array('class'=>'inputFormTabel span3','style'=>'width:100px;','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="qty">Jumlah</label>
                                <div class="controls">
                                    <?php echo CHtml::textField('qtyRacik', '1', array('readonly'=>false,'onkeyup'=>'$("#qty").val($(this).val());','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span1 numbersOnly')) ?>
                                    <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                                            array('onclick'=>'tambahObatRacik(this);return false;',
                                                  'class' => 'btn btn-danger',
                                                  'onkeypress'=>"tambahObatRacik(this);return false;",
                                                  'rel'=>"tooltip",
                                                  'title'=>"Klik untuk menambahkan resep",
                                                  'disabled'=>false,)); ?>
                                </div>
                            </div>
                            <div style='border:1px solid #cccccc; border-radius:2px;padding:10px; width: 100%;float:right;margin-top:10px;'>
                                <span style='font-size:9pt'>Keterangan : </span><br>
                                <span style='font-size:8pt'>Jumlah = Permintaan*Jumlah Kemasan/Kekuatan</span>
                            </div>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </td>
    </tr>
</table>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogObat',
    'options'=>array(
        'title'=>'Daftar Obat Alkes',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>900,
        'minHeight'=>400,
        'resizable'=>false,
    ),
));

$modObatDialog = new FAObatalkesM('searchObatFarmasi');
$modObatDialog->unsetAttributes();
$format = new MyFormatter();
if (isset($_GET['FAObatalkesM']))
    $modObatDialog->attributes = $_GET['FAObatalkesM'];
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'obatAlkesDialog-m-grid',
    'dataProvider'=>$modObatDialog->searchObatFarmasi(),
    'filter'=>$modObatDialog,
//    'template'=>"{summary}\n{items}",
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Obat/Alkes","class"=>"btn_small",
                "id"=>"selectObat",
                "onClick"=>"
                            $(\"#form-nonracikan #obatalkes_id\").val(\"$data->obatalkes_id\");
                            $(\"#form-nonracikan #namaObatNonRacik\").val(\"$data->obatalkes_nama\");
                            $(\"#dialogObat\").dialog(\"close\");
                            return false;
                ",
               ))'
        ),

        'obatalkes_kode',
        'obatalkes_nama',
        array(
            'header'=>'Tanggal Kedaluwarsa',
            'name'=>'tglkadaluarsa',
            'filter'=>'',
        ),       /* 
        array(
            'name'=>'satuankecil.satuankecil_nama',
            'header'=>'Satuan Kecil',
        ),
        array(
            'name'=>'satuanbesar.satuanbesar_nama',
            'header'=>'Satuan Besar',
        ),
         * 
         */
        array(
            'header'=>'HJA Resep',
            'type'=>'raw',
            'value'=>'number_format($data->hjaresep, 0, ",", ".")',
            'filter'=>'',
            'htmlOptions'=>array('style'=>'text-align:right;'),
        ),
        array(
            'header'=>'HJA Non Resep',
            'value'=>'number_format($data->hjanonresep, 0, ",", ".")',
            'filter'=>'',
            'htmlOptions'=>array('style'=>'text-align:right;'),
        ),
        array(
            'header'=>'Jumlah Stok',
            'type'=>'raw',
            'value'=>'$data->StokObatRuangan." ".$data->satuankecil->satuankecil_nama',
            'htmlOptions'=>array(
                'style'=>'text-align: right',
            )
        ),

        
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
        
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogObatRacikan',
    'options'=>array(
        'title'=>'Daftar Obat Alkes Racikan',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>900,
        'minHeight'=>400,
        'resizable'=>false,
    ),
));

$modObatDialogRacikan = new FAObatalkesM('searchObatFarmasi');
$modObatDialogRacikan->unsetAttributes();
$format = new MyFormatter();
if (isset($_GET['FAObatalkesM']))
    $modObatDialogRacikan->attributes = $_GET['FAObatalkesM'];
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'obatAlkesDialogRacikan-m-grid',
    'dataProvider'=>$modObatDialogRacikan->searchObatFarmasi(),
    'filter'=>$modObatDialogRacikan,
    'template'=>"{summary}\n{items}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Obat/Alkes","class"=>"btn_small",
                "id"=>"selectObat",
                "onClick"=>"
                           
                            $(\"#form-racikan #obatalkes_id\").val(\"$data->obatalkes_id\");
                            $(\"#form-racikan #namaObatRacik\").val(\"$data->obatalkes_nama\");

                            $(\"#dialogObatRacikan\").dialog(\"close\");
                            return false;
                ",
               ))'
        ),

            'obatalkes_kode',
            'obatalkes_nama',
            array(
                'header'=>'Tanggal Kedaluwarsa',
                'name'=>'tglkadaluarsa',
                'filter'=>'',
            ),        /*
            array(
                'name'=>'satuankecil.satuankecil_nama',
                'header'=>'Satuan Kecil',
            ),
            array(
                'name'=>'satuanbesar.satuanbesar_nama',
                'header'=>'Satuan Besar',
            ),*/
            array(
                'header'=>'HJA Resep',
                'type'=>'raw',
                'value'=>'number_format($data->hjaresep, 0, ",", ".")',
                'filter'=>'',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'header'=>'HJA Non Resep',
                'value'=>'number_format($data->hjanonresep, 0, ",", ".")',
                'filter'=>'',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'header'=>'Jumlah Stok',
                'type'=>'raw',
                'value'=>'$data->StokObatRuangan." ".$data->satuankecil->satuankecil_nama',
                'htmlOptions'=>array(
                    'style'=>'text-align: right',
                )
            ),

        
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
        
$this->endWidget();
?>