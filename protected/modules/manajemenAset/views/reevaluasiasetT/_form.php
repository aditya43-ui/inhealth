
<?php 
	if(!empty($_GET['sukses'])){        
?>
<?php echo Yii::app()->user->setFlash('success',"Data Re-evaluasi Aset berhasil disimpan !"); ?>
<?php } ?>
<?php
$this->widget('bootstrap.widgets.BootAlert');
?>
    <div class="panel panel-primary panel-success">
        <div class="panel-heading">
            <div class="panel-title"><i class="glyphicon glyphicon-file"></i> Data Barang</div>
        </div>
        <div class="panel-body">
            <?php $this->renderPartial('_search',array(
                'model'=>$model,
            )); ?>
        </div>
    </div>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'mareevaluasiaset-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);','onkeyup'=>(!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '','onclick'=>(!isset($_GET['sukses']))? 'cekDisabled(this);' : ''),
	'focus'=>'#',
)); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Re-Evaluasi Aset</b>
        </div>
    </div>
    <div class="panel-body">

            <div class="row-fluid">
            <?php
                    Yii::app()->clientScript->registerScript('search', "
                    $('.search-button').click(function(){
                                    $('.search-form').toggle();
                                    return false;
                    });
                    $('.search-form form').submit(function(){
                                    $.fn.yiiGridView.update('aset-t-grid', {
                                                    data: $(this).serialize()
                                    });
                                    return false;
                    });
                    ");

            $search = new MAReevaluasiasetT('searchReevaluasiAset');
            $search->unsetAttributes();
            if (isset($_GET['MAReevaluasiasetT'])) {
                    $search->attributes = $_GET['MAReevaluasiasetT'];	
            }

            $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'aset-t-grid',
        'dataProvider'=>$search->searchReevaluasiAset(),
        //'filter'=>$search,
                    'template'=>"{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-condensed',
        'columns'=>array(
                            array(
                                    'header' => 'Pilih',
                                    'type' => 'raw',
                                    'value'=>'CHtml::checkBox("pilih[$data->barang_id]",null,array("value"=>$data->barang_id,"id"=>"pilih"))',					
                            ),
                            array(
                               'header' => 'No. Register',
                               'name' => 'noreg',
                               'type'=>'raw',
                               'value'=>'$data->noreg
                                       .CHtml::hiddenField("invasetlain",$data->invasetlain_id)
                                       .CHtml::hiddenField("invtanah",$data->invtanah_id)
                                       .CHtml::hiddenField("invperalatan",$data->invperalatan_id)
                                       .CHtml::hiddenField("invgedung",$data->invgedung_id)
                                       .CHtml::hiddenField("barang_id",$data->barang_id)
                                       .CHtml::hiddenField("invjalan",$data->invjalan_id)',
                                    ), 
                            array(
                               'header' => 'Nama Aset',
                               'name' => 'barang_nama',
                       ),
                            array(
                               'header' => 'Umur Ekonomis',
                               //'name' => 'umur_ekonomis',
                                    'type'=>'raw',
                               'value'=>'$data->umur_ekonomis.CHtml::hiddenField("ue",$data->umur_ekonomis,array("class"=>"integer","style"=>"width:100px;"))'
                       ),
                            array(
                               'header' => 'Nilai Buku',
                                    'type'=>'raw',
                                    'value'=>'number_format($data->hrg_peroleh - $data->penyusutan).CHtml::hiddenField("nb",$data->hrg_peroleh - $data->penyusutan,array("class"=>"integer","style"=>"width:100px;"))'
                            ),
                            array(
                               'header' => 'Harga Pasar',
                               'name' => 'harga_pasar',
                               'type'=>'raw',
                               'value'=>'CHtml::textField("hargapasar","",array("class"=>"integer","style"=>"width:100px;",
                                       "onkeypress"=>"return $(this).focusNextInputField(event)","onkeyup"=>"harga()"))
                                       .CHtml::hiddenField("penyusutan",$data->penyusutan,array("class"=>"integer","style"=>"width:100px;"))
                                       .CHtml::hiddenField("hrgperolehan",$data->hrg_peroleh,array("class"=>"integer","style"=>"width:100px;"))'

                       ),
                            array(
                               'header' => 'Selisih Re-evaluasi',
                               //'name' => 'selisih',
                               'type'=>'raw',
                               'value'=>'CHtml::textField("selisih","",array("class"=>"integer","style"=>"width:100px;"))'					
                       ),				
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));			
            ?>			
            </div>
        </div>
    </div>

<script type="text/javascript">
	function harga(){
		var hg = document.getElementById("hargapasar").value;
		var nb = document.getElementById("nb").value;
		var selisih = hg.replace(/,/gi,"")-nb;
		document.getElementById("selisih").value = selisih;		
	}
	function print(id)
	{
		var reevaluasiaset_id = '<?php echo (!empty($model->reevaluasiaset_id)) ? $model->reevaluasiaset_id : null; ?>';
		window.open('<?php echo $this->createUrl('print'); ?>&id='+id+'&caraPrint=PRINT','printwin','left=100,top=100,width=1000,height=640');
	}	
</script>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Re-Evalusi Aset</b>
            </div>
    </div>
            <div class="panel-body">

		<div class="row-fluid">
			<div class="col-sm-6">
				<div class="control-group ">
						<?php echo $form->labelEx($model, 'reevaluasiaset_tgl', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php
							$model->reevaluasiaset_tgl = !empty($model->reevaluasiaset_tgl) ? MyFormatter::formatDateTimeForUser($model->reevaluasiaset_tgl) : date('d M Y H:i:s');
							$this->widget('MyDateTimePicker', array(
								'model' => $model,
								'attribute' => 'reevaluasiaset_tgl',
								'mode' => 'date',
								'options' => array(
									'dateFormat' => Params::DATE_FORMAT,
									'maxDate' => 'd',
								),
								'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
							));
							$model->reevaluasiaset_tgl = !empty($model->reevaluasiaset_tgl) ? MyFormatter::formatDateTimeForDb($model->reevaluasiaset_tgl) : date('Y-m-d H:i:s');
						?>
						<?php echo $form->error($model, 'reevaluasiaset_tgl'); ?>
					</div>
				</div>
					<?php echo $form->textFieldRow($model,'reevaluasiaset_no',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>25)); ?>
			</div>
			<div class="col-sm-6">
				
			<?php echo CHtml::hiddenField('pegawai_id'); ?>
                            <div class="control-group">
                                <label class="control-label">Pegawai Mengetahui</label>
                                <div class="controls">
                                        <?php
                                        $this->widget('MyJuiAutoComplete', array(
                                                'name' => 'nama_pegawai',
                                                'source' => 'js: function(request, response) {
                                                                                                                           $.ajax({
                                                                                                                                   url: "' . $this->createUrl('AutocompleteObatReseptur') . '",
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
                                                        'minLength' => 2,
                                                        'select' => 'js:function( event, ui ) {
                                                                                                                   $(this).val( ui.item.label);
                                                                                                                   $("#pegawai_id").val(ui.item.pegawai_id);
                                                                                                                   $("#pegawai_nama").val(ui.item.pegawai_nama);
                                                                                                                        return false;
                                                                                                                }',
                                                ),
                                                'tombolDialog' => array('idDialog' => 'dialogPegawai', 'idTombol' => 'tombolDialogOa'),
                                                'htmlOptions' => array('placeholder'=>'Pegawai yang Mengetahui',"rel" => "tooltip", "title" => "Pencarian Data Pegawai",'class'=>'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                                        ));
                                        ?>				
                                </div>
                            </div>

                            <div class="control-group">
                                <?php echo CHtml::hiddenField('pegawai_id_'); ?>
                                <label class="control-label">Pegawai Menyetujui</label>
                                <div class="controls">
                                        <?php
                                        $this->widget('MyJuiAutoComplete', array(
                                                'name' => 'nama_pegawai_',
                                                'source' => 'js: function(request, response) {
                                                                                                                           $.ajax({
                                                                                                                                   url: "' . $this->createUrl('AutocompleteObatReseptur') . '",
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
                                                        'minLength' => 2,
                                                        'select' => 'js:function( event, ui ) {
                                                                                                                   $(this).val( ui.item.label);
                                                                                                                   $("#pegawai_id_").val(ui.item.pegawai_id_);
                                                                                                                   $("#nama_pegawai_").val(ui.item.nama_pegawai_);
                                                                                                                        return false;
                                                                                                                }',
                                                ),
                                                'tombolDialog' => array('idDialog' => 'dialogPegawai_', 'idTombol' => 'tombolDialogOa'),
                                                'htmlOptions' => array('placeholder'=>'Pegawai yang Menyetujui',"rel" => "tooltip", "title" => "Pencarian Data Pegawai",'class'=>'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                                        ));
                                        ?>				
                                </div>	
                            </div>
				
			</div>
		</div>
            </div>
        </div>
	
        <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title">Penjurnalan</div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_penjurnalan', array('model'=>$model, 'form'=>$form,)); ?>		
            </div>
        </div>

	<div class="row-fluid">
	<div class="form-actions">
<?php 
			$sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
			$disableSave = false;
			$disableSave = ((!empty($_GET['id'])) ? true : (($sukses > 0) ? true : true)); 
		?>
		<?php $disablePrint = ($disableSave) ? false : true; ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>(isset($_GET['sukses']))? 'btn btn-danger' : 'btn btn-danger submit', 'type'=>'button', 'onKeypress'=>'return formSubmit(this,event)','disabled'=>$disableSave,'onclick'=>'cekTabel();')); //formSubmit(this,event) ?>

		<?php
			if(isset($_GET['sukses'])){
				echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('".$_GET['reevaluasiaset_id']."')",'disabled'=>false));
			}else{
				echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>true));
			}
		?>
		
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
				$this->createUrl('index'), 
				array('class'=>'btn btn-default',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial('_jsFunctions',array('model'=>$model)); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAset',
    'options' => array(
        'title' => 'Daftar Data Aset',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 900,
        'minHeight' => 400,
        'resizable' => false,
    ),
));

$modAsetDialog = new MABarangM('searchDialogAsset');
$modAsetDialog->unsetAttributes();
if (isset($_GET['MABarangM'])) {
    $modAsetDialog->attributes = $_GET['MABarangM'];    
}
$modAsetDialog->barang_type = ParamsConst::TYPE_BARANG_INVENTARIS;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'asetDialog-m-grid',
    'dataProvider' => $modAsetDialog->searchDialog(),
    'filter' => $modAsetDialog,
    'template' => "{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'filter'=> CHtml::activeHiddenField($modAsetDialog, 'barang_type'),
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Barang/Aset ","class"=>"btn_small",
                "id"=>"selectAset",
                "onClick"=>"
                            $(\"#barang_id\").val(\"$data->barang_id\");
                            $(\"#barang_kode\").val(\"$data->barang_kode\");
                            $(\"#barang_nama\").val(\"$data->barang_nama\");
                            $(\"#dialogAset\").dialog(\"close\");
                            return false;
                ",
               ))'
        ),

	     array(
            'header' => 'Kode Aset',
            'name' => 'barang_kode',
        ),
		array(
            'header' => 'Jenis Aset',
            'name' => 'barang_type',
                    'filter' => false,
        ),
		array(
            'header' => 'Nama Aset',
            'name' => 'barang_nama',
        ),
		array(
            'header' => 'Nama Aset Lainya',
            'name' => 'barang_namalainnya',
        ),		
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
//$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
//    'id' => 'dialogNoreg',
//    'options' => array(
//        'title' => 'Daftar Data Berdasarkan No. Registrasi',
//        'autoOpen' => false,
//        'modal' => true,
//        'minWidth' => 900,
//        'minHeight' => 400,
//        'resizable' => false,
//    ),
//));
//
//$modNoregDialog = new MABarangV('searchNoreg');
//$modNoregDialog->unsetAttributes();
//if (isset($_GET['MABarangV'])) {
//    $modNoregDialog->attributes = $_GET['MABarangV'];
//    $modNoregDialog->invasetlain_noregister = isset($_GET['MABarangV']['invasetlain_noregister']) ? $_GET['MABarangV']['invasetlain_noregister'] : null;
//    $modNoregDialog->invtanah_noregister = isset($_GET['MABarangV']['invtanah_noregister']) ? $_GET['MABarangV']['invtanah_noregister'] : null;
//    $modNoregDialog->invperalatan_noregister = isset($_GET['MABarangV']['invperalatan_noregister']) ? $_GET['MABarangV']['invperalatan_noregister'] : null;
//    $modNoregDialog->invgedung_noregister = isset($_GET['MABarangV']['invgedung_noregister']) ? $_GET['MABarangV']['invgedung_noregister'] : null;
//    $modNoregDialog->invjalan_noregister = isset($_GET['MABarangV']['invjalan_noregister']) ? $_GET['MABarangV']['invjalan_noregister'] : null;
//    $modNoregDialog->attributes = $_GET['MABarangV'];
//}
//$this->widget('ext.bootstrap.widgets.BootGridView', array(
//    'id' => 'obatAlkesDialog-m-grid',
//    'dataProvider' => $modNoregDialog->searchNoreg(),
//    'filter' => $modNoregDialog,
//    'template' => "{items}\n{pager}",
//    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
//    'columns' => array(
//        array(
//            'header' => 'Pilih',
//            'type' => 'raw',
//            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Barang/Aset ","class"=>"btn_small",
//                "id"=>"selectAset",
//                "onClick"=>"
//                            $(\"#kode_reg\").val(\"$data->barang_id\");
//							$(\"#noreg\").val(\"$data->invasetlain_noregister$data->invtanah_noregister$data->invperalatan_noregister$data->invgedung_noregister$data->invjalan_noregister\");
//                            $(\"#dialogNoreg\").dialog(\"close\");
//                            return false;
//                ",
//               ))'
//        ),
//	     array(
//            'header' => 'Inventarisasi Aset Lain',
//            'name' => 'invasetlain_noregister',
//			 'value'=>'empty($data->invasetlain_noregister) ? "" : "$data->invasetlain_noregister / $data->invasetlain_namabrg" ',
//        ),
//	     array(
//            'header' => 'Inventarisasi Tanah',
//            'name' => 'invtanah_noregister',
//			 'value'=>'empty($data->invtanah_noregister) ? "" : "$data->invtanah_noregister / $data->invtanah_namabrg" ',
//        ),
//	     array(
//            'header' => 'Inventarisasi Peralatan',
//            'name' => 'invperalatan_noregister',
//			 'value'=>'empty($data->invperalatan_noregister) ? "" : "$data->invperalatan_noregister / $data->invperalatan_namabrg" ',
//        ),
//	     array(
//            'header' => 'Inventarisasi Gedung',
//            'name' => 'invgedung_noregister',
//			 'value'=>'empty($data->invgedung_noregister) ? "" : "$data->invgedung_noregister / $data->invgedung_namabrg" ',
//        ),
//	     array(
//            'header' => 'Inventarisasi Jalan',
//            'name' => 'invjalan_noregister',
//			 'value'=>'empty($data->invjalan_noregister) ? "" : "$data->invjalan_noregister / $data->invjalan_namabrg" ',
//        ),		
//    ),
//    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
//));
//
//$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Daftar Data Pegawai Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 900,
        'minHeight' => 400,
        'resizable' => false,
    ),
));

$pegawai = new PegawaiM('search');
$pegawai->unsetAttributes();
if (isset($_GET['PegawaiM'])) {
    $pegawai->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaiDialog-m-grid',
    'dataProvider' => $pegawai->search(),
    'filter' => $pegawai,
    'template' => "{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Barang/Aset ","class"=>"btn_small",
                "id"=>"selectAset",
                "onClick"=>"
                            $(\"#pegawai_id\").val(\"$data->pegawai_id\");
							$(\"#nama_pegawai\").val(\"$data->nama_pegawai\");
                            $(\"#dialogPegawai\").dialog(\"close\");
                            return false;
                ",
               ))'
        ),
		'nama_pegawai',
		'tempatlahir_pegawai',
		'tgl_lahirpegawai',
		'jeniskelamin',
		'statusperkawinan'
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPegawai_',
    'options' => array(
        'title' => 'Daftar Data Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 900,
        'minHeight' => 400,
        'resizable' => false,
    ),
));

$pegawai_ = new PegawaiM('search');
$pegawai_->unsetAttributes();
if (isset($_GET['PegawaiM'])) {
    $pegawai_->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai_Dialog-m-grid',
    'dataProvider' => $pegawai_->search(),
    'filter' => $pegawai_,
    'template' => "{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Barang/Aset ","class"=>"btn_small",
                "id"=>"selectAset",
                "onClick"=>"
                            $(\"#pegawai_id_\").val(\"$data->pegawai_id\");
							$(\"#nama_pegawai_\").val(\"$data->nama_pegawai\");
                            $(\"#dialogPegawai_\").dialog(\"close\");
                            return false;
                ",
               ))'
        ),
		'nama_pegawai',
		'tempatlahir_pegawai',
		'tgl_lahirpegawai',
		'jeniskelamin',
		'statusperkawinan'
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<script>
$( document ).ready(function(){
        cekDisabled('form');
        <?php if(isset($_GET['sukses'])){ ?>
            $("input, select, textarea").attr('disabled', true);
        <?php } ?>
    });
</script>