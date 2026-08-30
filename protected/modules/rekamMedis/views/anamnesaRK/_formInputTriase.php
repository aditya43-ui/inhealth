<style>
    div.colorPicker-swatch {
height: 30px;
width: 73px;
}
div.colorPicker-picker {
height: 30px;
width: 83px;
}
div.colorPicker-palette{
width:79px;
}
.colorPicker_palette-1{display:none;}
</style>
<fieldset id="formTriase" class="box2">
    <legend class="rim">Triase</legend>
<table width='100%'>
    <tr>
        <td width="50%">                
                <div class="control-group">
                    <label class="control-label" for="namaTriase">Triase Pasien</label>
                    <div class="controls">
                        <div class="input-append" style='display:inline'>
                        <?php 
                            $this->widget('MyJuiAutoComplete', array(
                                            'name'=>'namaTriase',
                                            'source'=>'js: function(request, response) {
                                                           $.ajax({
                                                               url: "'.Yii::app()->createUrl('ActionAutoComplete/DaftarTriase').'",
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
                                                   'focus'=> 'js:function( event, ui ) {
                                                        $(this).val( ui.item.label);
                                                        return false;
                                                    }',
                                                   'select'=>'js:function( event, ui ) {
                                                        $("#triase_id").val(ui.item.triase_id); 
                                                        return false;
                                                    }',
                                            ),
                                            'tombolDialog'=>array('idDialog'=>'dialogTriase'),
                                        )); 
                        ?>
                </div>      
                    </div>
                </div>            
            <?php echo CHtml::hiddenField('triase_id', '', array('readonly'=>true)) ?>
            <?php echo CHtml::activeHiddenField($modAnamnesa,'petugas_triase_id',array('readonly'=>true)) ?>
			
        </td>
		<td width="50%">
			<div class="control-group">
				<label class="control-label">Pegawai Triase</label>
				<div class="controls">
					<div class="input-append" style='display:inline'>
					<?php 
						$this->widget('MyJuiAutoComplete', array(
										'name'=>'pegawai_triase',
										'source'=>'js: function(request, response) {
													   $.ajax({
														   url: "'.$this->createUrl('getPegawaiTriase').'",
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
											   'focus'=> 'js:function( event, ui ) {
													$(this).val( ui.item.label);
													return false;
												}',
											   'select'=>'js:function( event, ui ) {
													$("#'.CHtml::activeId($modAnamnesa, 'petugas_triase_id').'").val(ui.item.pegawai_id); 
													return false;
												}',
										),
										'htmlOptions'=>array(
											'onkeyup'=>"return $(this).focusNextInputField(event)",
											'onblur' => 'if(this.value === "") $("#petugas_triase_id").val(""); '
										),
										'tombolDialog'=>array('idDialog'=>'dialogPegawaiTriase'),
									)); 
					?>
					</div>      
				</div>
			</div>
		</td>
    </tr>
    <tr>
        <td colspan="2">
            <table width='100%' id="tblDataTriase" class="table table-striped table-condensed">
    <thead>
        <tr>
            <th>Warna Triase</th>
            <th>Nama Triase</th>
            <th>Keterangan</th>
            <th>Batal / Hapus</th>
        </tr>
    </thead>
    <tbody>
        <?php
            
            $anamnesa=AnamnesaT::model()->find('pendaftaran_id = '.$_GET['pendaftaran_id']);
//            echo $anamnesa->triase_id;
            if(!empty($anamnesa) && !empty($anamnesa->triase_id)){
                $modDetail = new RJTriase;
                $triase = RKTriase::model()->findByPk($anamnesa->triase_id);
        ?>
        <tr>
            <td><?php echo CHtml::activeHiddenField($modDetail,'['.$triase->triase_id.']triase_id',array('value'=>$triase->triase_id, 'class'=>'triase_id')).$this->renderPartial($this->path_view.'_warnaTriase', array('triase_id'=>$triase->triase_id), true); ?></td>
            <td><?php echo $triase->triase_nama; ?></td>
            <td><?php echo $triase->keterangan_triase; ?></td>
            <td><?php echo CHtml::link("<span class='icon-trash'>&nbsp;</span>",'',
                                   array('href'=>'#','onClick'=>'hapusTriase('.$anamnesa->anamesa_id.','.$anamnesa->triase_id.');return false;','style'=>'text-decoration:none;')); ?></td>
        </tr>
            <?php } ?>
    </tbody>
</table>
        </td>
    </tr>
</table>
</fieldset>
<?php
//========= Dialog buat cari data Alat Kesehatan (RACIKAN)  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogTriase',
    'options'=>array(
        'title'=>'Daftar Triase',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modTriase = new RKTriase('search');
$modTriase->unsetAttributes();
if(isset($_GET['RKTriase']))
    $modTriase->attributes = $_GET['RKTriase'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'triase-m-grid',
	'dataProvider'=>$modTriase->search(),
	'filter'=>$modTriase,
        'template'=>"{summary}\n{items}{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Nama Triase',
                    'name'=>'triase_nama',
                    'value'=>'$data->triase_nama',
                ),
                array(
                    'header'=>'Nama Lain',
                    'name'=>'triase_namalainnya',
                    'value'=>'$data->triase_namalainnya',
                ),
                array(
                    'header'=>'Warna Triase',
                    'name'=>'warna_triase',
                    'value'=>'$data->warna_triase',
                ),
                array(
                    'header'=>'Keterangan',
                    'name'=>'keterangan_triase',
                    'value'=>'$data->keterangan_triase',
                ),
                
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "$(\"#triase_id\").val(\"$data->triase_id\");  
                                                  $(\"#namaTriase\").val(\"$data->triase_nama\");
                                                  submitTriase();
                                                $(\'#dialogTriase\').dialog(\'close\');return false;"))',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>

<?php
//========= Dialog buat cari data Pegawai Triase =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiTriase',
    'options'=>array(
        'title'=>'Daftar Pegawai Triase',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiTriase = new RKPegawaiM('searchPegawaiTriase');
$modPegawaiTriase->unsetAttributes();
if(isset($_GET['RKPegawaiM'])){
    $modPegawaiTriase->attributes = $_GET['RKPegawaiM'];
    $modPegawaiTriase->gelarbelakang_nama = $_GET['RKPegawaiM']['gelarbelakang_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawai-triase-m-grid',
	'dataProvider'=>$modPegawaiTriase->searchPegawaiTriase(),
	'filter'=>$modPegawaiTriase,
	'template'=>"{summary}\n{items}{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectObat",
					"onClick" => "$(\"#'.CHtml::activeId($modAnamnesa, 'petugas_triase_id').'\").val(\"$data->pegawai_id\");  
								  $(\"#pegawai_triase\").val(\"$data->NamaLengkap\");
									$(\'#dialogPegawaiTriase\').dialog(\'close\');return false;"))',
			),
			'gelardepan',
            array(
                'name'=>'nama_pegawai',
                'header'=>'Nama Dokter',
            ),
            array(
                'name'=>'gelarbelakang_nama',
                'header'=>'Gelar Belakang',
                'value'=>'isset($data->gelarbelakang->gelarbelakang_nama) ? $data->gelarbelakang->gelarbelakang_nama : ""',
            ),
            'jeniskelamin',
            'agama',               
			
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>

<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        
$urlGetTriasePasien = $this->createUrl('GetTriasePasien');//MAsukan Dengan memilih Triase
$url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$mds = Yii::t('mds','Anda yakin akan membatalkan triase pasien?');

$jscript = <<< JS
        
function submitTriase()
{
    triase_id = $('#triase_id').val();
        triase = $("#tblDataTriase tbody").find(".triase_id");
        jumlah =  triase.length;
        if (jumlah != 1){
            $.post("${urlGetTriasePasien}", { triase_id: triase_id},
            function(data){
                $('#tblDataTriase').append(data.tr);
                $('#namaTriase').val('');
            hitungUrutan();
            }, "json");
        }else{
            $('#tblDataTriase tbody tr').parent().remove();
            $.post("${urlGetTriasePasien}", { triase_id: triase_id},
            function(data){
                $('#tblDataTriase').append(data.tr);
                $('#namaTriase').val('');
            hitungUrutan();
            }, "json");
        }
}    
       
function hitungUrutan(){
    noUrut = 1;
    $("#tblDataTriase tbody tr").find(".noUrut").each(function(){
        $(this).val(noUrut);
        noUrut++;
    });
}            
JS;
Yii::app()->clientScript->registerScript('masukantriase',$jscript, CClientScript::POS_HEAD);
?>
<script>
function hapusTriase(anamesa_id, triase_id){
    var anamesa_id = anamesa_id;
    var triase_id = triase_id;
    var url = '<?php echo $url."/hapusTriase"; ?>';
	myConfirm("Yakin Akan Menghapus Data Triase Pasien?","Perhatian!",function(r) {
		if(r)
		{
			$.post(url, {anamesa_id: anamesa_id, triase_id:triase_id},
			function(data){
				if(data.status == 'proses_form'){
						location.reload();
						$('#tblDataTriase tbody tr').parent().remove();
					}else{
						myAlert('Data gagal dihapus!')
					}
			},"json");
		}
	});
}    

function batalTriase(){
	myConfirm("Anda yakin akan membatalkan triase pasien?","Perhatian!",function(r) {
		if(r)
		{
			$('#tblDataTriase tbody tr').parent().remove();
			hitungUrutan();
		}
	});
}
    
function hapus(){
	myConfirm("Anda yakin akan membatalkan triase pasien?","Perhatian!",function(r) {
		if(r)
		{
			$('#tblDataTriase tbody tr').parent().remove();
			hitungUrutan();
		}
	});
}    
</script>

