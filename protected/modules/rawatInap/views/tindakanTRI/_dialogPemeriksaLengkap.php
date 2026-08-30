<?php 
//========= Dialog buat cari data pemeriksa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPemeriksaLengkap',
    'options'=>array(
        'title'=>'Petugas',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>300,
        'resizable'=>false,
		'close'=>"js:function(){ cekPerawat(); }",	
    ),
));
?> 

<div class="col-sm-6">
    <?php echo CHtml::hiddenField('baris', '', array('id'=>'rowTindakan','readonly'=>true)) ?>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modTindakan, 'Dokter Pemeriksa'); ?>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete',array(
                        'name'=>'dokterpemeriksa1_id',
                        'value'=>'',
                        'sourceUrl'=> Yii::app()->createUrl('rawatInap/tindakanTRI/GetDokter'),
                        'options'=>array(
                           'showAnim'=>'fold',
                           'minLength' => 4,
                           'focus'=> 'js:function( event, ui ) {
                                $("#dokterpemeriksa1_id").val( ui.item.label);
                                return false;
                            }',
                           'select'=>'js:function( event, ui ) {
                                setDokterPemeriksa1(ui.item);
                                return false;
                            }',

                        ),
                        'tombolDialog'=>array("idDialog"=>'dialogDokter', 'jsFunction'=>"setPilihDokter(1);"),
                        'htmlOptions'=>array(
                            'onblur' => 'if(this.value === ""){ $("#dokterpemeriksa1_id").val("");updateDokterPemeriksa1(this.value);} ',
                            'onkeypress'=>"return $(this).focusNextInputField(event)"),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modTindakan, 'dokterdelegasi_id'); ?>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete',array(
                        'name'=>'dokterdelegasi_id',
                        'value'=>'',
                        'sourceUrl'=> Yii::app()->createUrl('rawatInap/tindakanTRI/GetDokter'),
                        'options'=>array(
                           'showAnim'=>'fold',
                           'minLength' => 4,
                           'focus'=> 'js:function( event, ui ) {
                                $("#dokterdelegasi_id").val( ui.item.label);
                                return false;
                            }',
                           'select'=>'js:function( event, ui ) {
                                setDokterDelegasi(ui.item);
                                return false;
                            }',

                        ),
                        'tombolDialog'=>array("idDialog"=>'dialogDokter', 'jsFunction'=>"setPilihDokter(3);"),
                        'htmlOptions'=>array(
                            'onblur' => 'if(this.value === ""){ $("#dokterdelegasi_id").val("");updateDokterDelegasi(this.value);} ',
                            'onkeypress'=>"return $(this).focusNextInputField(event)"),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modTindakan, 'dokteranastesi_id'); ?>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete',array(
                        'name'=>'dokteranastesi_id',
                        'value'=>'',
                        'sourceUrl'=> Yii::app()->createUrl('rawatInap/tindakanTRI/GetDokter'),
                        'options'=>array(
                           'showAnim'=>'fold',
                           'minLength' => 4,
                           'focus'=> 'js:function( event, ui ) {
                                $("#dokteranastesi_id").val( ui.item.label);
                                return false;
                            }',
                           'select'=>'js:function( event, ui ) {
                                setDokterAnastesi(ui.item);
                                return false;
                            }',

                        ),
                        'tombolDialog'=>array("idDialog"=>'dialogDokter', 'jsFunction'=>"setPilihDokter(4);"),
                        'htmlOptions'=>array(
                            'onblur' => 'if(this.value === ""){ $("#dokteranastesi_id").val("");updateDokterAnastesi(this.value);} ',
                            'onkeypress'=>"return $(this).focusNextInputField(event)"),
            )); ?>
        </div>
    </div>
    <!--<div class="control-group">
        <?php echo CHtml::activeLabel($modTindakan, 'dokterpemeriksa2_id'); ?>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete',array(
                        'name'=>'dokterpemeriksa2_id',
                        'value'=>'',
                        'sourceUrl'=> Yii::app()->createUrl('rawatInap/tindakanTRI/GetDokter'),
                        'options'=>array(
                           'showAnim'=>'fold',
                           'minLength' => 4,
                           'focus'=> 'js:function( event, ui ) {
                                $("#dokterpemeriksa2_id").val( ui.item.label);
                                return false;
                            }',
                           'select'=>'js:function( event, ui ) {
                                setDokterPemeriksa2(ui.item);
                                return false;
                            }',

                        ),
                        'tombolDialog'=>array("idDialog"=>'dialogDokter', 'jsFunction'=>"setPilihDokter(2);"),
                        'htmlOptions'=>array(
                            'onblur' => 'if(this.value === "") $("#dokterpemeriksa2_id").val(""); ',
                            'onkeypress'=>"return $(this).focusNextInputField(event)"),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modTindakan, 'dokterpendamping_id'); ?>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete',array(
                        'name'=>'dokterpendamping_id',
                        'value'=>'',
                        'sourceUrl'=> Yii::app()->createUrl('rawatInap/tindakanTRI/GetDokter'),
                        'options'=>array(
                           'showAnim'=>'fold',
                           'minLength' => 4,
                           'focus'=> 'js:function( event, ui ) {
                                $("#dokterpendamping_id").val( ui.item.label);
                                return false;
                            }',
                           'select'=>'js:function( event, ui ) {
                                setDokterPendamping(ui.item);
                                return false;
                            }',

                        ),
                        'tombolDialog'=>array("idDialog"=>'dialogDokter', 'jsFunction'=>"setPilihDokter(5);"),
                        'htmlOptions'=>array(
                            'onblur' => 'if(this.value === "") $("#dokterpendamping_id").val(""); ',
                            'onkeypress'=>"return $(this).focusNextInputField(event)"),
            )); ?>
        </div>
    </div>
-->
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::activeLabel($modTindakan, 'perawat_id'); ?>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete',array(
                        'name'=>'perawat_id',
                        'value'=>'',
                        'sourceUrl'=> Yii::app()->createUrl('rawatInap/tindakanTRI/getPerawat'),
                        'options'=>array(
                           'showAnim'=>'fold',
                           'minLength' => 4,
                           'focus'=> 'js:function( event, ui ) {
                                $("#bidan_id").val( ui.item.label);
                                return false;
                            }',
                           'select'=>'js:function( event, ui ) {
                                setPerawat(ui.item);
                                return false;
                            }',

                        ),
                        'tombolDialog'=>array("idDialog"=>'dialogPerawat', 'jsFunction'=>"setPilihPerawat(1);"),
                        'htmlOptions'=>array(
                            'onblur' => 'if(this.value === ""){ $("#perawat_id").val("");updatePerawat(this.value);} ',
                            'onkeypress'=>"return $(this).focusNextInputField(event)"),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modTindakan, 'perawat2_id'); ?>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete',array(
                        'name'=>'perawat2_id',
                        'value'=>'',
                        'sourceUrl'=> Yii::app()->createUrl('rawatInap/tindakanTRI/getPerawat'),
                        'options'=>array(
                           'showAnim'=>'fold',
                           'minLength' => 4,
                           'focus'=> 'js:function( event, ui ) {
                                $("#perawat2_id").val( ui.item.label);
                                return false;
                            }',
                           'select'=>'js:function( event, ui ) {
                                setPerawat2(ui.item);
                                return false;
                            }',

                        ),
                        'tombolDialog'=>array("idDialog"=>'dialogPerawat', 'jsFunction'=>"setPilihPerawat(2);"),
                        'htmlOptions'=>array(
                            'onblur' => 'if(this.value === ""){ $("#perawat2_id").val("");updatePerawat2(this.value);} ',
                            'onkeypress'=>"return $(this).focusNextInputField(event)"),
            )); ?>
        </div>
    </div>
    <?php /*
    <div class="control-group">
        <?php echo CHtml::activeLabel($modTindakan, 'perawat_3'); ?>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete',array(
                        'name'=>'perawat_id',
                        'value'=>'',
                        'sourceUrl'=> Yii::app()->createUrl('rawatInap/tindakanTRI/GetPerawat'),
                        'options'=>array(
                           'showAnim'=>'fold',
                           'minLength' => 4,
                           'focus'=> 'js:function( event, ui ) {
                                $("#perawat_id").val( ui.item.label);
                                return false;
                            }',
                           'select'=>'js:function( event, ui ) {
                                setPerawat(ui.item);
                                return false;
                            }',

                        ),
                        'htmlOptions'=>array(
                            'onblur' => 'if(this.value === ""){ $("#perawat_id").val("");updatePerawat(this.value);} ',
                            'onkeypress'=>"return $(this).focusNextInputField(event)"),
            )); ?>
        </div>
    </div>
     * 
     */ ?>
	<div class="control-group">
        <?php echo CHtml::activeLabel($modTindakan, 'perawat3_id', array('label'=>'Perawat 3')); ?>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete',array(
                        'name'=>'perawat3_id',
                        'value'=>'',
                        'sourceUrl'=> Yii::app()->createUrl('rawatInap/tindakanTRI/getPerawat'),
                        'options'=>array(
                           'showAnim'=>'fold',
                           'minLength' => 2,
                           'focus'=> 'js:function( event, ui ) {
                                $("#perawat3_id").val( ui.item.label);
                                return false;
                            }',
                           'select'=>'js:function( event, ui ) {
                                setPerawat3(ui.item);
                                return false;
                            }',

                        ),
                        'tombolDialog'=>array("idDialog"=>'dialogPerawat', 'jsFunction'=>"setPilihPerawat(3);"),
                        'htmlOptions'=>array(
                            'onblur' => 'if(this.value === "") {$("#perawat3_id").val(""); updatePerawat3(this.value);}',
                            'onkeypress'=>"return $(this).focusNextInputField(event)"),
            )); ?>
        </div>
    </div>
</div>

<div class="clear">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ok',array('{icon}'=>'<i class="entypo-check"></i>')),
                                array('class' => 'btn btn-danger', 'onKeypress'=>'return formSubmit(this,event)',
                                      'onclick'=>'$("#dialogPemeriksaLengkap").dialog("close");')); ?>
</div>

<?php

$this->endWidget();
//========= end pemeriksa dialog =============================
?>  

<?php 
//========= Dialog buat cari dokter =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDokter',
    'options'=>array(
        'title'=>'Data Dokter',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>500,
        'height'=>500,
        'resizable'=>false,
    ),
));

$datDokter = new DokterV();

if (Yii::app()->user->getState('dokterruangan')) {
    $datDokter->ruangan_id = Yii::app()->user->getState('ruangan_id');
}

if (isset($_GET['DokterV'])) {
    $datDokter->attributes = $_GET['DokterV'];
}
$provider = $datDokter->search();
$provider->criteria->group = $provider->criteria->select = 'pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama';

$this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'dokter-v-grid2',
        'dataProvider'=>$provider,
        'filter'=>$datDokter,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectDokter",
                                    "onClick" => "pilihDokter(".$data->pegawai_id."); return false;"))',
                    //'filter'=>CHtml::activeHiddenField($modTindakan,'tipepaket_id').CHtml::activeHiddenField($modTindakan,'kelaspelayanan_id').CHtml::activeHiddenField($modTindakan,'penjamin_id').CHtml::activeHiddenField($modTindakan,'jenistarif_id'),
                ),
                array(
                    'name'=>'nama_pegawai',
                    'value'=>'$data->namaLengkap',
                    'type'=>'raw',
//                        'filter'=>CHtml::activeHiddenField($modTindakan,'tipepaket_id'),
                ),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end data dokter =============================
?> 


<?php 
//========= Dialog buat cari perawat =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPerawat',
    'options'=>array(
        'title'=>'Data Perawat',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>500,
        'height'=>500,
        'resizable'=>false,
    ),
));

$datPerawat = new PegawaiV();
//$datPerawat->unsetAttributes();
$datPerawat->kelompokpegawai_id = array(Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN,Params::KELOMPOKPEGAWAI_ID_BIDAN);
if (isset($_GET['PegawaiV'])) {
    $datPerawat->attributes = $_GET['PegawaiV'];
	$datPerawat->nama_pegawai = $_GET['PegawaiV']['nama_pegawai'];
}
$provider = $datPerawat->search();
$provider->criteria->group = $provider->criteria->select = 'pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama';

$this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'perawat-v-grid2',
        'dataProvider'=>$provider,
        'filter'=>$datPerawat,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPerawat",
                                    "onClick" => "pilihPerawat(".$data->pegawai_id."); return false;"))',
                    //'filter'=>CHtml::activeHiddenField($modTindakan,'tipepaket_id').CHtml::activeHiddenField($modTindakan,'kelaspelayanan_id').CHtml::activeHiddenField($modTindakan,'penjamin_id').CHtml::activeHiddenField($modTindakan,'jenistarif_id'),
                ),
                array(
                    'name'=>'nama_pegawai',
                    'value'=>'$data->namaLengkap',
                    'type'=>'raw',
//                        'filter'=>CHtml::activeHiddenField($modTindakan,'tipepaket_id'),
                ),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end data perawat =============================

?>
<?php 
//========= Dialog buat cari supir =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogSupir',
    'options'=>array(
        'title'=>'Pencarian Supir',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>500,
        'height'=>500,
        'resizable'=>false,
    ),
));

$dtSupir = new PegawaiV();
$dtSupir->unsetAttributes();
//  $datPerawat->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN;
$dtSupir->jabatan_id = Params::getPegSupirByJab();
if (isset($_GET['PegawaiV'])) {
    $dtSupir->attributes = $_GET['PegawaiV'];
}
$provider = $dtSupir->search();
$provider->criteria->group = $provider->criteria->select = 'pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama';

$this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'supir-v-grid2',
        'dataProvider'=>$provider,
        'filter'=>$dtSupir,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectSupir",
                                    "onClick" => "pilihSupir(".$data->pegawai_id."); return false;"))',
                    //'filter'=>CHtml::activeHiddenField($modTindakan,'tipepaket_id').CHtml::activeHiddenField($modTindakan,'kelaspelayanan_id').CHtml::activeHiddenField($modTindakan,'penjamin_id').CHtml::activeHiddenField($modTindakan,'jenistarif_id'),
                ),
                array(
                    'name'=>'nama_pegawai',
                    'value'=>'$data->namaLengkap',
                    'type'=>'raw',
//                        'filter'=>CHtml::activeHiddenField($modTindakan,'tipepaket_id'),
                ),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end data supir =============================

?>

<script>
var idPilihDokter = 0;
var idPilihPerawat = 0;

function setPilihDokter(val) {
    idPilihDokter = val;
    $("#dialogDokter").dialog('open');
}

function pilihDokter(id) {
    $("#dialogDokter").dialog('close');
    $.post("<?php echo Yii::app()->createUrl('rawatInap/tindakanTRI/GetDokter'); ?>", {
        id: id
    }, function(data) {
        var res = data[0];
        switch(idPilihDokter) {
            case 1: setDokterPemeriksa1(res); $("#dokterpemeriksa1_id").val(res.label); break;
            case 2: setDokterPemeriksa2(res); $("#dokterpemeriksa2_id").val(res.label); break;
            case 3: setDokterDelegasi(res); $("#dokterdelegasi_id").val(res.label); break;
            case 4: setDokterAnastesi(res); $("#dokteranastesi_id").val(res.label); break;
            case 5: setDokterPendamping(res); $("#dokterpendamping_id").val(res.label); break;
        }
        
    }, 'json');
}

function setPilihPerawat(val) {
    idPilihPerawat = val;
    $("#dialogPerawat").dialog('open');
}

function pilihPerawat(id) {
    $("#dialogPerawat").dialog('close');
    $.post("<?php echo Yii::app()->createUrl('rawatInap/tindakanTRI/getPerawat'); ?>", {
        id: id
    }, function(data) {
        var res = data[0];
        
        console.log(idPilihPerawat);
        
        switch(idPilihPerawat) {
            case 1: setPerawat(res); $("#perawat_id").val(res.label); break;
            case 2: setPerawat2(res); $("#perawat2_id").val(res.label); break;
            case 3: setPerawat3(res); $("#perawat3_id").val(res.label); break;
        }
        
    }, 'json');
}

/** awal --- fungsi untuk set and get data supir**/
function setPilihSupir(val) {
    idPilihSupir = val;
    $("#dialogSupir").dialog('open');
}

function pilihSupir(id) {
    $("#dialogSupir").dialog('close');
    $.post("<?php echo Yii::app()->createUrl('/ActionAutoComplete/getSupir'); ?>", {
        id: id
    }, function(data) {
        var res = data[0];
        
        //console.log(idPilihSupir);
         setSupir(res);
      
        $("#supir_id").val(res.label);  
        
        
    }, 'json');
}
/** akhir --- fungsi untuk set and get data supir**/

function cekPerawat(){
	var no = $("#dialogPemeriksaLengkap #rowTindakan").val();
	var kelompoktindakan_id = $('#RITindakanPelayananT_'+no+'_keltindakanid').val();
	
	var perawat = $('#RITindakanPelayananT_'+no+'_perawat_id').val();
	var perawat2 = $('#RITindakanPelayananT_'+no+'_perawat2_id').val();
	
	if (kelompoktindakan_id == <?php echo Params::KELOMPOKTINDAKAN_ID_AMBULANS ?>){
		$("#perawat_id").attr('style','');
		$("#perawat2_id").attr('style','');

		if (perawat == ''){
			$("#perawat_id").attr('style','border:1px solid red;');		
		}
		if (perawat2 == ''){
			$("#perawat2_id").attr('style','border:1px solid red;');		
		}

		if (perawat == '' || perawat2 == ''){
			alert("Data perawat belum diisi atau belum di pilih ");
			$("#dialogPemeriksaLengkap").dialog('open');
		}
	}
}
</script>