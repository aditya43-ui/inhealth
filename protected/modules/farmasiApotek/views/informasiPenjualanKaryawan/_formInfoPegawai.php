<div class="row">
<div class="col-sm-4">
    <div class="control-group">
        <label class="control-label" for="FAPegawaiV_nomorindukpegawai">NIP</label>
        <div class="controls">
            <?php echo CHtml::hiddenField('pasien_id',$modPenjualan->pasien_id,array()); ?>
            <?php echo CHtml::activeHiddenField($modPenjualan,'pasienpegawai_id',array()); ?>
            <?php 
               $this->widget('MyJuiAutoComplete', array(
                    'name'=>'nomorindukpegawai',
                    'value'=>$modInfoPegawai->nomorindukpegawai,
                    'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "'.$this->createUrl('AutocompleteInfoPegawai').'",
                                       dataType: "json",
                                       data: {
                                           nomorindukpegawai: request.term,
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                     'options'=>array(
                           'minLength' => 4,
                            'focus'=> 'js:function( event, ui ) {
                                 $(this).val( "");
                                 return false;
                             }',
                           'select'=>'js:function( event, ui ) {
                                $(this).val( ui.item.value);
                                setInfoPegawai(ui.item.pegawai_id, ui.item.nomorindukpegawai, ui.item.nama_pegawai);
                                return false;
                            }',
                    ),
                    'tombolDialog'=>array('idDialog'=>'dialogPegawai'),
                    'htmlOptions'=>array('placeholder'=>'NIP','class'=>'all-caps','rel'=>'tooltip','title'=>'No. pendaftaran / klik icon untuk mencari data pegawai',
                        'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
                        ),
                )); 
            ?>                    
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="FAPegawaiV_nama_pegawai">Nama</label>
        <div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                    'name'=>'nama_pegawai',
                    'value'=>$modInfoPegawai->nama_pegawai,
                    'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "'.$this->createUrl('AutocompleteInfoPegawai').'",
                                       dataType: "json",
                                       data: {
                                           nama_pegawai: request.term,
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                     'options'=>array(
                           'minLength' => 4,
                            'focus'=> 'js:function( event, ui ) {
                                 $(this).val( "");
                                 return false;
                             }',
                           'select'=>'js:function( event, ui ) {
                                $(this).val( ui.item.value);
                                setInfoPegawai(ui.item.pegawai_id, ui.item.nomorindukpegawai, ui.item.nama_pegawai);
                                return false;
                            }',
                    ),
                    'htmlOptions'=>array('placeholder'=>'Nama Pegawai','class'=>'all-caps','rel'=>'tooltip','title'=>'No. pendaftaran / klik icon untuk mencari data pegawai',
                        'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
                        ),
                ))
            ?>                    
        </div>
    </div>
     <div class="control-group">
        <?php echo CHtml::label("Jenis Kelamin", 'jeniskelamin', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('jeniskelamin',$modInfoPegawai->jeniskelamin,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class="col-sm-4">
    <div class="control-group">
        <?php echo CHtml::label("Alamat Pegawai", 'alamat_pegawai', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textArea('alamat_pegawai',$modInfoPegawai->alamat_pegawai,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class="col-sm-4">
    <div style="text-align: center;">
        <?php 
            if(file_exists(Params::pathPegawaiTumbsDirectory().'kecil_'.$modInfoPegawai->photopegawai)){
                $url_photopasienpegawai = Params::pathPegawaiTumbsDirectory().'kecil_'.$modInfoPegawai->photopegawai;
            } else {
                $url_photopasienpegawai = Params::urlPhotoPasienDirectory().'no_photo.jpeg';
            }
        ?>
        <img id="photo-preview" src="<?php echo $url_photopasienpegawai; ?>"width="128px"/> 
    </div><br>
</div>
</div>
<?php 
//========= Dialog buat cari data pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawai',
    'options'=>array(
        'title'=>'Pencarian Data Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>480,
        'resizable'=>false,
    ),
));
$modDialogPegawai = new FAPegawaiV('search');
$modDialogPegawai->unsetAttributes();
if(isset($_GET['FAPegawaiV'])) {
    $modDialogPegawai->attributes = $_GET['FAPegawaiV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'datakunjungan-grid',
        'dataProvider'=>$modDialogPegawai->search(),
        'filter'=>$modDialogPegawai,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                    "id" => "selectPegawai",
                    "onClick" => "
                        setInfoPegawai($data->pegawai_id, \"\", \"\", \"\");
                        $(\"#dialogPegawai\").dialog(\"close\");
                    "))',
            ),
            'gelardepan',
            'nomorindukpegawai',
            'nama_pegawai',
            'jeniskelamin',            
            'alamat_pegawai',            
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>