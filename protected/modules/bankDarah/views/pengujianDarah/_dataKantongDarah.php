<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - digunakan sebagai view detail nama pendonor
* RSST-1498
*/
?>


        <p>&nbsp;</p>
        <div class="panel panel-primary panel-success">
	<div class="panel-heading">
            <div class="panel-title">Data Kantong Darah</div>
	</div>
            <div class="panel-body">
                <?php
                    if(isset($_GET['nomorbarcode_sample'])){
                ?>
                <div class="col-sm-6">
                    <?php
                        echo $form->hiddenField($model,'terimakantongdet_id',array('readonly'=>true));                        
                        echo $form->hiddenField($modTerima,'kantongdarah_id',array('readonly'=>true));                        
                        echo $form->hiddenField($modTerima,'pendonor_id',array('readonly'=>true));
                        echo $form->hiddenField($modTerima,'ruanganterima_id',array('readonly'=>true));                        
                        echo $form->hiddenField($modTerima,'create_ruangan',array('readonly'=>true));                        
                        echo $form->hiddenField($modTerima,'berubahdata',array('readonly'=>true));                        
                    ?>
                    <?php echo $form->textFieldRow($modTerima,'nomorbarcode_sample',array('readonly'=>true)) ?>                    
                    <?php echo $form->textFieldRow($model,'jenisterima_nama',array('readonly'=>true)) ?>
                    <?php echo $form->textFieldRow($modTerima,'tglterimakantong',array('readonly'=>true)); ?>                    
                    
                </div>
                
                <div class="col-sm-6">
                    <?php echo $form->textFieldRow($modTerima,'gol_darah',array('readonly'=>true))?>
                    <?php echo $form->textFieldRow($modTerima,'rhesus',array('readonly'=>true))?>
                    <?php echo $form->textFieldRow($modTerima,'ruangankirim_nama',array('readonly'=>true))?>
                </div>
                <?php
                    }else{
                ?>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Nomor Barcode Sample','', array('class'=>'control-label')) ?>
                        <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model'=>$modTerima,
                            'attribute'=>'nomorbarcode_sample',
                            'source'=>'js: function(request, response) {
                                           $.ajax({
                                               url: "'.$this->createUrl('AutocompleteKantongDarah').'",
                                               dataType: "json",
                                               data: {
                                                   nomorbarcode: request.term,
                                               },
                                               success: function (data) {
                                                       response(data);
                                               }
                                           })
                                        }',
                            'options'=>array(
                                   'minLength' => 3,
                                    'focus'=> 'js:function( event, ui ) {
                                         $(this).val("");
                                         return false;
                                     }',
                                   'select'=>'js:function( event, ui ) {
                                        $("#BDPengujiandarahT_terimakantongdet_id").val( ui.item.terimakantongdet_id);
                                        $("#BDTerimakantongdarahT_nomorbarcode_sample").val( ui.item.nomorbarcode_sample);
                                        $("#BDTerimakantongdarahT_rhesus").val( ui.item.rhesus);
                                        $("#BDTerimakantongdarahT_gol_darah").val( ui.item.gol_darah);
                                        $("#BDTerimakantongdarahT_ruangankirim_nama").val( ui.item.ruangan_nama);
                                        $("#BDTerimakantongdarahT_tglterimakantong").val(ui.item.tglterimakantong);
                                        $("#BDTerimakantongdarahT_jenisterima_nama").val( ui.item.jenisterima_nama);
                                        $("#BDTerimakantongdarahT_ruanganterima_id").val( ui.item.ruanganterima_id);
                                        $("#BDTerimakantongdarahT_pendonor_id").val( ui.item.pendonor_id);
                                        $("#BDTerimakantongdarahT_kantongdarah_id").val( ui.item.kantongdarah_id);
                                        return false;
                                    }',
                            ),
                            'tombolDialog'=>array('idDialog'=>'dialogKantongDarah','idTombol'=>'tombolDaftarTindakan'),
                            'htmlOptions'=>array('class' => 'span3 required', 'placeholder'=>'Ketik Nomor Barcode Sample','rel'=>'tooltip','title'=>'Ketik Nomor Barcode Sample',
                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                            ),
                        ));	
                        ?>
                        <?php //echo $form->hiddenField($model,'terimakantongdet_id',array()); ?>
                        <?php echo $form->hiddenField($modTerima,'ruanganterima_id',array()); ?>
                         <?php //echo $form->hiddenField($modTerima,'kantongdarahdet_id',array('readonly'=>true));                        
                        echo $form->hiddenField($modTerima,'pendonor_id',array('readonly'=>true, 'class' => 'required'));                        
                        echo $form->hiddenField($modTerima,'berubahdata',array('readonly'=>true));?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Jenis Kantong Darah</label>
                        <div class="controls">
                            <?php echo $form->textField($modTerima,'jenisterima_nama',array('readonly'=>true)); ?>  
                        </div>
                    </div>
                    
                    <?php echo $form->textFieldRow($modTerima,'tglterimakantong',array('readonly'=>true)); ?>                    
                    
                </div>
                
                <div class="col-sm-6">
                    <?php echo $form->textFieldRow($modTerima,'gol_darah',array('readonly'=>true))?>
                    <?php echo $form->textFieldRow($modTerima,'rhesus',array('readonly'=>true))?>
                    <?php echo $form->textFieldRow($modTerima,'ruangankirim_nama',array('readonly'=>true))?>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>


<div class="clear"></div>
<p>&nbsp;</p>

<?php
/* ====================================== Widget Dialog Kantong Darah ====================================== */
    
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogKantongDarah',
        'options'=>array(
            'title'=>'Daftar Kantong Darah',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>600,
            'height'=>650,
            'resizable'=>false,
            ),
    ));
//   $a = TariftindakanperdatotalV::model()->findByAttributes(array('kelompoktindakan_id'=>28));
$model = new BDInfokantongdarahV('searchInfoSampelDarah');
$model->unsetAttributes();
if(isset($_GET['BDInfokantongdarahV'])) {
    $model->attributes = $_GET['BDInfokantongdarahV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'daftartindakan-m-grid',
    'dataProvider'=>$model->searchSampelDarahForKonfirmasiGolDarah(),
    'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=> function($data){
                        $criteriaPengujian = new CDbCriteria();
                        $criteriaPengujian->addCondition("nomorbarcode_sample = '".$data['nomorbarcode_sample']."'");
                        $modPengujian = PengujiandarahT::model()->find($criteriaPengujian);
                        if(!empty($modPengujian)){
                            $pengujian_ke = $modPengujian->pengujian_ke + 1;
                            $goldar1 = $modPengujian->gol_darah;
                            if ($modPengujian->rhesus == Params::RHESUS_POSITIF){
                                $rhesus1 = Params::PENGUJIAN_GOLDARAH_POSITIF;
                            }else if($modPengujian->rhesus == Params::RHESUS_NEGATIF ){
                                $rhesus1 = Params::PENGUJIAN_GOLDARAH_NEGATIF;
                            }else{
                                $rhesus1 = '';
                            }
                        }else{
                            $pengujian_ke = 1;
                            $goldar1 = '';
                            $rhesus1 = '';
                        }
                        $tanggalterimakantong = MyFormatter::formatDateTimeForUser($data['tglterimakantong']);
                        return CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                            array(
                                "class"=>"btn-small",
                                "id" => "daftartindakan",
                                "onClick" => "
                                                $('#BDTerimakantongdarahT_nomorbarcode_sample').val('".$data['nomorbarcode_sample']."' );
                                                $('#BDTerimakantongdarahT_rhesus').val('".$data['rhesus']."');
                                                $('#BDTerimakantongdarahT_gol_darah').val('".$data['gol_darah']."');
                                                $('#BDTerimakantongdarahT_tglterimakantong').val('".$data['tglterimakantong']."');
                                                $('#BDTerimakantongdarahT_ruangankirim_nama').val('".$data['ruangankirim_nama']."');
                                                $('#BDTerimakantongdarahT_jenisterima_nama').val('".$data['nama_jenis']."');
                                                $('#BDTerimakantongdarahT_ruanganterima_id').val('".$data['ruanganterima_id']."');
                                                $('#BDTerimakantongdarahT_pendonor_id').val('".$data['pendonor_id']."');                                                
                                                $('#BDPengujiandarahT_pengujian_ke').val('".$pengujian_ke."');                                                    
                                                $('#BDPengujiandarahT_goldar1').val('".$goldar1."');                                                    
                                                $('#BDPengujiandarahT_rhesus1').val('".$rhesus1."');                                                
                                                $('#dialogKantongDarah').dialog('close');"

                             )
                         );
                        },
                ),
                array(
                    'header'=>'Nomor Sampel Darah',
                    'name' => 'nomorbarcode_sample',
                    'value'=>function($data){
                        echo $data['nomorbarcode_sample'];
                    },
                ), 
                array (
                    'header' => 'Golongan Darah',
                    'name' => 'gol_darah',
                    'value' => function($data){
                        echo $data['gol_darah']; 
                    }
                ),
                array(
                    'header' => 'Rhesus',
                    'name' => 'rhesus',
                    'value' => function ($data) {
                        echo $data['rhesus']; 
                    }
                ),         
                array(
                    'header' => 'Jenis Kantong',
                    'name' => 'nama_jenis',
                    'value' => '$data["nama_jenis"]',
                ),
    ),
        'afterAjaxUpdate'=>'function(id, data){
        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
/* ====================================== endWidget Dialog Kantong Darah ====================================== */
?>