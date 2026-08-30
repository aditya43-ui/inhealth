<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); ?>

    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'penerimaan-distibusidarah-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>
<div class="panel panel-primary panel-success">
        <div class="panel-heading">
            <div class="panel-title">Pencarian Data Distribusi Darah</div>
	</div>
                <div class="panel-body">
                    <div class="col-sm-6">
                           <div class="control-group">
                            <?php echo CHtml::label('No Pengiriman','',array('class'=>'control-label')); ?>
                            <div class="controls">
                            <?php echo CHtml::hiddenField('distribusidarah_id',isset($distribusidarah_id) ? $distribusidarah_id : "",array('readonly'=>true)); ?>
                            <?php if(empty($distribusidarah_id)) { ?>
                            <?php 
                                $this->widget('MyJuiAutoComplete', array(
                                    'name'=>'nomor_pengiriman',
                                    'source'=>'js: function(request, response) {
                                    $.ajax({
                                    url: "'.$this->createUrl('AutocompleteKirimKantong').'",
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
                                $(this).val("");
                                return false;
                            }',
                            'select'=>'js:function( event, ui ) {
                                $(this).val(ui.item.value);
                                return false;
                            }',
                        ),
                        'htmlOptions'=>array(
                            'placeholder' => 'Ketik No. Pengiriman',
                            'class' => 'span3 custom-only',
                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                            
                        ),
                        'tombolDialog'=>array('idDialog'=>'dialogDistribusiDarah'),
                    )); 
                            }else{
                                $modDistribusi = DistribusidarahT::model()->findByPk($distribusidarah_id);
                                $modPegawaiDistribusi = PegawaiM::model()->findByPk($modDistribusi->petugasdistribusi_id);
                                $modPegawaiKoordinator = PegawaiM::model()->findByPk($modDistribusi->petugaskoordinator_id);
                                $modInstalasi = InstalasiM::model()->findByPk($modDistribusi->instalasi_id);
                                $modRuangan = RuanganM::model()->findByPk($modDistribusi->ruangan_id);
                                echo CHtml::textField('nomor_pengiriman',isset($modDistribusi) ? $modDistribusi->nomor_pengiriman : " ",array('readonly'=>true));
                            }
                        ?>
                            </div>   
                            </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Tanggal Distribusi','',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::textField('tanggal_distribusi',isset($modDistribusi) ? MyFormatter::formatDateTimeForUser($modDistribusi->tgl_distribusi) : " ",array('readonly'=>true)); ?>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <?php echo CHtml::label('Shift Distribusi','',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::textField('shift_distribusi',isset($modDistribusi) ? $modDistribusi->shift_distribusi : " ",array('readonly'=>true)); ?>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <?php echo CHtml::label('Petugas Distribusi Pelayanan Donor','',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::textField('petugas_distribusi',isset($modPegawaiDistribusi) ? $modPegawaiDistribusi->nama_pegawai : " ",array('readonly'=>true)); ?>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <?php echo CHtml::label('Koordinator Pelayanan Donor','',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::textField('petugas_kordinator',isset($modPegawaiKoordinator) ? $modPegawaiKoordinator->nama_pegawai : " ",array('readonly'=>true)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        
                        <div class="control-group">
                            <?php echo CHtml::label('Instalasi','',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::textField('instalasi',isset($modInstalasi) ? $modInstalasi->instalasi_nama : " ",array('readonly'=>true)); ?>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <?php echo CHtml::label('Ruangan','',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::textField('ruangan',isset($modRuangan) ? $modRuangan->ruangan_nama : " ",array('readonly'=>true)); ?>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <?php echo CHtml::label('Keterangan Distribusi','',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::textField('keterangan_distribusi',isset($modDistribusi) ? $modDistribusi->ketrangan_distribusi : " ",array('readonly'=>true)); ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
</div>

<div class="panel panel-primary panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Data Penerimaan Darah</div>
                    </div>
                    <div class="panel-body">
			<div class="panel-body table-responsive">
				<?php 
                                if(empty($model->terimadistribusidarah_id)) {
                                $this->renderPartial($this->path_view.'_tableDetail', array(
                                            'model'=>$model,
                                            'format'=>$format,
                                            'form'=>$form,
                                        )); 
                                
                                }else{
                                $this->renderPartial($this->path_view.'_tableDetailPenerimaan', array(
                                            'model'=>$model,
                                            'format'=>$format,
                                            'form'=>$form,
                                            'modDetail'=>$modDetail,
                                        ));  
                                }
                                ?>
			</div>
                    </div>
</div>
<div class="panel-body">
        <div class="col-sm-6">
              <div class="control-group">
                    <?php echo CHtml::label('Tanggal Penerimaan','',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php $model->tgl_terima = $format->formatDateTimeForUser($model->tgl_terima); ?>
                    <?php
                        $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_terima',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                           
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                        ));
                    ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('No. Penerimaan','',array('class'=>'control-label')); ?>
                    <div class="controls">
                         <?php echo $form->textField($model,'nomor_terima',array('class'=>'span3','readonly'=>true)); ?>
                    </div>
                </div>
        </div>
        <div class="col-sm-6">
                            <div class="control-group">
                            <?php echo CHtml::label('Petugas Distribusi Pelayanan Darah','',array('class'=>'control-label')); ?>
                            <div class="controls">
                            <?php echo $form->hiddenField($model,'petugasdistribusi_pelayanandarah',array('class'=>'petugasdistribusi_pelayanandarah')); ?>
                            <?php echo $form->textField($model,'petugas_nama',array('class'=>'span3', 'readonly' => true)); ?>
                            
                            
                            </div>   
                            </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Keterangan','',array('class'=>'control-label')); ?>
                        <div class="controls">
                         <?php echo $form->textArea($model,'keterangan_terima',array('class'=>'span3','readonly'=>false,'placeholder'=>'keterangan penerimaan')); ?>
                        </div>
                    </div>
        </div>
</div>

<div class="form-actions">
	<?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' =>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'button', 'onclick' => 'cekForm();','id'=>'btn_submit','disabled'=>(isset($_GET['sukses']))? true : false));
?>   <?php if(empty($distribusidarah_id)) { ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 		               
                $this->createUrl($this->module->id.'/Index'),   
		array('class'=>'btn btn-danger',
			'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;'));  ?>
	<?php }else{
              echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),                
                $this->createUrl($this->module->id.'/Index',array('distribusidarah_id'=>$distribusidarah_id)),                 
		array('class'=>'btn btn-danger',
			'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index',array('distribusidarah_id'=>$distribusidarah_id)).'";} ); return false;'));
              echo "&nbsp;";
              echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-left-bold"></i>')), Yii::app()->createUrl('bankDarah/InformasiDistribusiDarah/index'), array('class' => 'btn btn-success'));
            echo "&nbsp;";
             }
		
	?>
</div>
<?php $this->endWidget(); ?>

<!-- dialog untuk pencarian data distibusi darah-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDistribusiDarah',
    'options' => array(
        'title' => 'Daftar Pengiriman Distribusi Darah',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 600,
        'resizable' => false,
    ),
));

$modKirimDistribusi = new DistribusidarahT('searchDialog');
$modKirimDistribusi->unsetAttributes();
if (isset($_GET['DistribusidarahT'])){
    $modKirimDistribusi->attributes = $_GET['DistribusidarahT'];
    $modKirimDistribusi->nama_pegawai = isset($_GET['DistribusidarahT']['nama_pegawai']) ? $_GET['DistribusidarahT']['nama_pegawai'] : " ";
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'distribusi-darah-m-grid',
    'dataProvider'=>$modKirimDistribusi->searchDialog(),
    'filter'=>$modKirimDistribusi,
    'template'=>"{summary}\n{items}{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectBarang",
				"onClick" => "
                                        $(\'#distribusidarah_id\').val(\'$data->distribusidarah_id\'); 
                                        $(\'#nomor_pengiriman\').val(\'$data->nomor_pengiriman\'); 
                                        getDataDistibusi(\'$data->distribusidarah_id\');
                                        getDetailKirim();
					$(\'#dialogDistribusiDarah\').dialog(\'close\');
					return false;"))',
        ),
        array(
          'header'=>'No. Pengiriman',
          'name'=>'nomor_pengiriman',
          'value'=>'$data->nomor_pengiriman',
        ),
        array(
          'header'=>'Petugas Distribusi Darah',
          'name'=>'nama_pegawai',
          'value'=>'$data->nama_pegawai'
        ),
        array(
          'header'=>'Waktu Pengiriman',
          'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_distribusi)',
        ),
        array(
          'header'=>'Ruangan Asal',
          'value'=>function($data) {
                $ruangan='';
                $modRuangan = RuanganM::model()->findByPk($data->ruangan_id);
                 if(isset($modRuangan)) {
                     $ruangan = $modRuangan->ruangan_nama;
                 }
                return $ruangan;
          },
        ),
    ),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
$this->endWidget();
?>

<?php
//========= Dialog untuk ....  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPetugas',
    'options' => array(
        'title' => 'Petugas Penerima',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));
    
    
$modPetugasTerima = new PegawairuanganV('search');
$modPetugasTerima->unsetAttributes();
$modPetugasTerima->ruangan_id = Yii::app()->user->getState('ruangan_id');
// $modPetugasTerima->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN;
$modPetugasTerima->pegawai_aktif = true;

if (isset($_GET['PegawairuanganV'])) {
    $modPetugasTerima->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'drafter-grid',
    'dataProvider' => $modPetugasTerima->search(),
    'filter' => $modPetugasTerima,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectItem",
                "onClick" => "
                     $(\'.petugasdistribusi_pelayanandarah\').val(\'$data->pegawai_id\'); 
                     $(\'#petugas_nama\').val(\'$data->namaLengkap\'); 
                     $(\"#dialogPetugas\").dialog(\"close\");
                     return false;"))',
        ),
        'nomorindukpegawai',
        'nama_pegawai',
        array(
            'name'=>'jeniskelamin',
            'type'=>'raw',
            'filter'=>CHtml::activeDropDownList($modPetugasTerima, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array(
                'empty'=>'-- Pilih --',
            )),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
    
$this->endWidget();
?>
<script>
    function cekForm(){
        if (requiredCheck($("#penerimaan-distibusidarah-t-form"))){
            
            var length = $("#table-pengiriman > tbody > tr").length;
            
            if (length == 0){
                toastr.warning("Data Penerimaan Kosong","Perhatian!");
                return false;
            }
            
            var cek = $("#table-pengiriman > tbody > tr").find('input:checkbox:checked').length;
            
            if (cek == 0){
                toastr.warning("Data Penerimaan Belum ada yang Dipilih","Perhatian!");
                return false;
            }
            
            $("#penerimaan-distibusidarah-t-form").submit();
            disableOnSubmit($("#bnt_submit"));
        }
            
        return false;
    }
    
    function checkAll(){
    $("#table-pengiriman > tbody > tr").find('input[type="checkbox"]').each(
    function(){
        if($("#check_semua").is(":checked")){
            $(this).attr('checked','checked');
        }else{
            $(this).removeAttr('checked');
        }
    });
    }
    
    function getDetailKirim() {
        var distribusidarah_id = $('#distribusidarah_id').val();
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('getDetail'); ?>',
            data:{distribusidarah_id:distribusidarah_id},
            dataType:'json',
            success:function(data) {
                $('#table-pengiriman > tbody').html(data);
                $('#table-pengiriman').removeClass("animation-loading");
//                 renameInputRow($("#table-pengiriman")); 
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    
    function renameInputRow(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){		
        $(this).find("#no_urut").val(row+1);
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
            if(old_name_arr.length == 4){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]["+row+"]");
            }
        });
        $(this).find('input[name$="[maininput]"]').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
            if(old_name_arr.length == 4){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]+"_"+row);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]["+row+"]");
            }
        });
        row++;
    });	
    }

    
    function getDataDistibusi(id) {
        var distribusi_id = id;
        $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('getData') ?>',
                data:{distribusi_id:distribusi_id},
                dataType:'json',
                success:function(data){
                    if(data.sukses == true) {
                         $('#tanggal_distribusi').val(data.tgl_distribusi); 
                         $('#shift_distribusi').val(data.shift_distribusi);
                         $('#petugas_distribusi').val(data.petugasdistribusi);
                         $('#petugas_kordinator').val(data.petugaskoordinator);
                         $('#instalasi').val(data.instalasi);
                         $('#ruangan').val(data.ruangan);
                         $('#keterangan_distribusi').val(data.keterangan_distribusi);
                    }
                },
        });
        
    }
    
    $(document).ready(function(){
        <?php 
       if(isset($distribusidarah_id)) { ?>
                getDetailKirim();
      <?php  } ?>
    
    });
</script>