<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); ?>

    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pengeluaranaset-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>

<?php 
if (count($modKirimKantongdetail) <= 0) { ?>
<div class="panel panel-primary panel-success">
        <div class="panel-heading">
            <div class="panel-title">Cari Data Pengiriman Kantong Darah</div>
	</div>
                <div class="panel-body">
                    <div class="control-group">
                        <?php echo CHtml::label('Data Kirim Kantong Darah','',array('class'=>'control-label')); ?>
                        <div class="controls">
                        <?php echo CHtml::hiddenField('kirimkantongdarah_id'); ?>
                        <?php 
                        $this->widget('MyJuiAutoComplete', array(
                        'name'=>'no_kirimkantong',
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
                            'placeholder' => 'Ketik No. Kirim Kantong Darah',
                            'class' => 'span3 custom-only',
                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                            
                        ),
                        'tombolDialog'=>array('idDialog'=>'dialogKirimkantongdarah'),
                    )); 
                ?>
                        </div>   
                </div>
            </div>
</div>
<?php } ?>
        
<div class="panel panel-primary panel-success">
	<div class="panel-heading">
            <div class="panel-title">Data Pengiriman Kantong Darah</div>
	</div>
	<div class="panel-body">
		<?php  $this->renderPartial($this->path_view.'_formDetail', array(
                                            'modTerimaKantong'=>$modTerimaKantong,
                                            'modTerimaKantongDet'=>$modTerimaKantongDet,
                                            'modKirimKantongdetail'=>$modKirimKantongdetail,
                                            'modKirimKantong'=>$modKirimKantong,
                                            'format'=>$format,
                                            'form'=>$form,
                        )); ?>		
		
	</div>
</div>
<div class="panel panel-primary panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Data Penerimaan Kantong Darah</div>
                    </div>
                    <div class="panel-body">
			<div class="panel-body table-responsive">
                                <div class="control-group">
                                    <label class="control-label">No. Barcode</label>
                                    <div class="controls">
                                        <?php echo CHtml::textField("nokantongutama","",array('onblur'=>'cekLisKantongDarah(this);','onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
                                    </div>
                                </div>
                                
				<?php $this->renderPartial($this->path_view.'_tableDetail', array(
                                            'modTerimaKantong'=>$modTerimaKantong,
                                            'modTerimaKantongDet'=>$modTerimaKantongDet,
                                            'modKirimKantongdetail'=>$modKirimKantongdetail,
                                            'modKirimKantong'=>$modKirimKantong,
                                            'format'=>$format,
                                            'form'=>$form,
                                        )); ?>
			</div>
                    </div>
</div>
    <div class="panel-body" id="form-penerimaan-det">
        <div class="col-sm-6">
              <div class="control-group">
                    <?php echo CHtml::label('Waktu Penerimaan','',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php $modTerimaKantong->tglterimakantong = $format->formatDateTimeForUser($modTerimaKantong->tglterimakantong); ?>
                    <?php
                        $this->widget('MyDateTimePicker', array(
                        'model' => $modTerimaKantong,
                        'attribute' => 'tglterimakantong',
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
                    <?php echo CHtml::label('Suhu','',array('class'=>'control-label')); ?>
                    <div class="controls">
                         <?php echo $form->textField($modTerimaKantong,'suhu',array('class'=>'span3 angkacoma-only','readonly'=>false,'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'text-align:right;')); ?> <label>&#8451;</label>
                         <?php echo $form->hiddenField($modTerimaKantong,'kirimkantongdarah_id',array('class'=>'span3 numbers-only','readonly'=>false)); ?>

                    </div>
                </div>
        </div>
        <div class="col-sm-6">
            
            
            <div class="control-group">
                <?php echo $form->labelEx($modTerimaKantong, 'petugasterima_id', array(
                    'class'=>'control-label',
                )); ?>
                <div class="controls">
                    <?php
                        echo $form->hiddenField($modTerimaKantong, 'petugasterima_id', array(
                            'class'=>'petugasterima_id',
                        ));

                        $petugasterima_nama = "";

                        // --- kondisi jika ada data-nya

                        if (!empty($modTerimaKantong->petugasterima_id)) {
                            $peg = PegawaiM::model()->findByPk($modTerimaKantong->petugasterima_id);
                            $petugasterima_nama = $peg->nama_pegawai;
                        }

                        // --- end

                        $this->widget('MyJuiAutoComplete', array(
                                'name'=>'petugasterima_nama',
                                'value'=>$petugasterima_nama,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('autocompletePetugasTerima').'",
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
                                            $(this).val(ui.item.label);
                                            $(this).parents(".controls").find(".petugasterima_id").val(ui.item.value);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array(
                                    'disabled'=>false,
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                    'class'=>'span3 petugasterima_nama',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogPetugasTerima'),
                            ));
                    ?>

                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('No. Terima Kantong','',array('class'=>'control-label')); ?>
                <div class="controls">
                     <?php echo $form->textField($modTerimaKantong,'no_terimakantong',array('class'=>'span3','readonly'=>true)); ?>

                </div>
            </div>
        </div>
        
    </div>

<div class="form-actions">
      <?php $kirimkantong_id = isset($kirimkantongdarah_id) ? $kirimkantongdarah_id : null; ?>
	<?php echo CHtml::htmlButton($modTerimaKantong->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' =>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)','disabled'=>(isset($_GET['sukses']))? true : false));
?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
		
                $this->createUrl($this->module->id.'/Index',array('kirimkantongdarah_id'=>$kirimkantong_id)), 
		array('class'=>'btn btn-danger',
			'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;'));  ?>
	<?php
    /*
		if(isset($_GET['sukses'])){
			echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')",'disabled'=>false));
		}else{
			echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>true));
		}
    */
	?>
</div>
<?php $this->endWidget(); ?>

<!-- dialog untuk pencarimaan dara kirim kantong darah-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogKirimkantongdarah',
    'options' => array(
        'title' => 'Daftar Kirim Kantong Darah',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 600,
        'resizable' => false,
    ),
));

$modKirimKantong = new KirimkantongdarahT('searchDialog');
$modKirimKantong->unsetAttributes();
if (isset($_GET['KirimkantongdarahT'])){
    $modKirimKantong->attributes = $_GET['KirimkantongdarahT'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barang-m-grid',
    'dataProvider'=>$modKirimKantong->searchDialog(),
    'filter'=>$modKirimKantong,
    'template'=>"{summary}\n{items}{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data){
                // if ($data->ruangantujuan_id != Yii::app()->user->getState('ruangan_id')){
                //     $onclick = 'myAlert("Anda harus login ke ruangan <b>'.$data->ruangantujuan_nama.'</b>")';
                // }else{
                   $onclick = "                                        
                                        $('#BDTerimakantongdarahT_kirimkantongdarah_id').val('".$data->kirimkantongdarah_id."'); 
                                        $('#no_kirimkantongform').val('".$data->no_kirimkantong."');
                                        $('#no_kirimkantong').val('".$data->no_kirimkantong."');
                                        $('#kantongdarah_id').val('".$data->kantongdarah_id."');
                                        $('#suhu').val('".$data->suhu."');       
                                        $('#kirimkantongdarah_id').val('".$data->kirimkantongdarah_id."');
                                        $('#jml_coolbox').val('".$data->jml_coolbox."');
                                        $('#jml_icepack').val('".$data->jml_icepack."');
                                        getRuangan('".$data->ruangankirim_id."');
                                        getTanggal('".$data->tglkirimkantongdarah."');
                                        getPegawai('".$data->petugaskirim_id."');
                                        getCoolbox('".$data->coolboxdarah_id."');
                                        getDetailKirim();
					$('#dialogKirimkantongdarah').dialog('close');
					return false;";
                // }
    
                return CHtml::Link("<i class='icon-form-check'></i>","javascript:;",array("class"=>"btn-small", 
				"id" => "selectBarang",
				"onClick" => $onclick));
            },
        ),
        array(
          'header'=>'No. Pengiriman',
          'name'=>'no_kirimkantong',
          'value'=>'$data->no_kirimkantong',
        ),
        array(
          'header'=>'Waktu Pengiriman',
          'name'=>'tglkirimkantongdarah',
          'value'=>'MyFormatter::formatDateTimeForUser($data->tglkirimkantongdarah)',
        ),
        array(
          'header'=>'Ruangan Asal',
          'value'=>function($data) {
                $ruangan='';
                $modRuangan = RuanganM::model()->findByPk($data->ruangankirim_id);
                 if(isset($modRuangan)) {
                     $ruangan = $modRuangan->ruangan_nama;
                 }
                return $ruangan;
          },
        ),
        array(
          'header'=>'Petugas Pengirim',
          'value'=>function($data) {
                $pegawai='';
                $modPegawai = PegawaiM::model()->findByPk($data->petugaskirim_id);
                 if(isset($modPegawai)) {
                     $pegawai = $modPegawai->nama_pegawai;
                 }
                return $pegawai;
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
    'id' => 'dialogPetugasTerima',
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
                    $(\".petugasterima_id\").val(".$data->pegawai_id.");
                    $(\".petugasterima_nama\").val(\"".$data->nama_pegawai."\");
                    $(\"#dialogPetugasTerima\").dialog(\"close\");
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



<!--end-->
<?php   $this->renderPartial($this->path_view.'_jsFunctions',array(
                                            'modTerimaKantong'=>$modTerimaKantong,
                                            'modTerimaKantongDet'=>$modTerimaKantongDet,
                                            'modKirimKantongdetail'=>$modKirimKantongdetail,
                                            'modKirimKantong'=>$modKirimKantong,
                                            'format'=>$format,
                                            'form'=>$form,
                    ));