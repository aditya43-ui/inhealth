<style>
	.jdl {
		text-align: center;
		font-weight: bold;
		margin: 10px;
	}
	
	.tab_detail th, .tab_detail td {
		border: 1px solid black;
	}
	
	.tab_detail {
		margin-bottom: 20px;
	}
	
	.tab_detail thead, .tab_detail tfoot {
		font-weight: bold;
	}
	
	.tab_head {
		margin-top: 10px;
		margin-bottom: 10px;
	}
</style>

<?php
if (!isset($_GET['frame'])){
    // echo $this->renderPartial($this->path_view.'sub/_headerPrint'); 
}

?>
<div class="jdl">Setoran Kasir ke Bendahara</div>

<table class="tab_head" width="100%">
	<tbody>
		<tr>
			<td nowrap>Tgl. Setoran</td>
			<td>: </td>
			<td width="100%"><?php echo MyFormatter::formatDateTimeForUser($setoran->tglsetorankasir); ?></td>
			<td nowrap>Setoran Tgl.</td>
			<td>: </td>
			<td nowrap><?php echo MyFormatter::formatDateTimeForUser($setoran->setorankasirdari); ?></td>
		</tr>
		<tr>
			<td nowrap>No. Setoran</td>
			<td>: </td>
			<td><?php echo $setoran->nosetorankasir; ?></td>
			<td nowrap>Sampai Tgl.</td>
			<td>: </td>
			<td nowrap><?php echo MyFormatter::formatDateTimeForUser($setoran->sampaidengan); ?></td>
		</tr>
	</tbody>
</table>

<table width="100%" class="tab_detail">
	<thead>
		<tr>
			<th rowspan="2">Ruangan</th>
			<th colspan="2">Jumlah Pasien</th>
			<th colspan="2">Retribusi</th>
			<th colspan="2">Jasa Medis</th>
			<th colspan="2">Jasa Paramedis</th>
			<th colspan="2">Administrasi</th>
			<th colspan="2">Jumlah</th>
			<th rowspan="2">Jumlah Total</th>
		</tr>
		<tr>
			<th>PL</th>
			<th>PB</th>
			<th>PL</th>
			<th>PB</th>
			<th>PL</th>
			<th>PB</th>
			<th>PL</th>
			<th>PB</th>
			<th>PL</th>
			<th>PB</th>
			<th>PL</th>
			<th>PB</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		foreach ($setorandet as $idx=>$item) {
			echo $this->renderPartial('sub/_rowdetail', array('item'=>$item, 'idx'=>$idx), true);
		} 
		?>
	</tbody>
	<tfoot>
		<?php echo $this->renderPartial('sub/_rowtotal', array('item'=>$tot), true); ?>
	</tfoot>
</table>

<?php
/*
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();"));
?>
    <script type='text/javascript'>   
    function print(){
        window.open("<?php echo $this->createUrl('print', array('id'=>$setoran->setorankasir_id)); ?>","",'location=_new, width=1024px');
    }
    </script>
<?php
}else{
 * 
 */
?>  
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'terima-form',
            'enableAjaxValidation'=>false,
                    'type'=>'horizontal',
                    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
    ));
?>

<table width='100%'>
	<tr>
		<td>&nbsp;</td>
		<td width="100%">&nbsp;</td>
		<td align='center' nowrap><?php echo Yii::app()->user->getState('kecamatan_nama').", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></td>
	</tr>
	<tr>
		<td style="text-align: center;" nowrap>Pegawai Bendahara</td>
		<td></td>
		<td style="text-align: center;" nowrap>Pegawai Setoran</td>
	</tr>
	<tr>
		<td style="text-align: center;" nowrap>
			<br><br><br><br><br>
			<?php 
			if (!empty($setoran->bendaharapenerima_id)) {
				$p = PegawaiM::model()->findByPk($setoran->bendaharapenerima_id);
				echo "<u>".$p->namaLengkap."</u><br>".$p->nomorindukpegawai;
			} else {
				echo $form->hiddenField($setoran, 'setorankasir_id');
				echo $form->hiddenField($setoran, 'bendaharapenerima_id');
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$setoran,
					'attribute' => 'bendahara_nama',
					'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('autoCompletePegawai') . '",
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
							$(this).val(ui.item.label);
							return false;
						}',
						'select' => 'js:function( event, ui ) {
							$("#'.CHtml::activeId($setoran, 'bendaharapenerima_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'class' => 'span4',
						'onkeyup' => "return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value.trim() === "") $("#'.CHtml::activeId($setoran, 'bendaharapenerima_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogBendahara'),
				));
			}
			?>
		</td>
		<td></td>
		<td style="text-align: center;" nowrap>
			<br><br><br><br><br>
		<?php 
		$p = PegawaiM::model()->findByPk($setoran->pegawai_id);
		echo "<u>".$p->namaLengkap."</u><br>".$p->nomorindukpegawai;
		?></td>
	</tr>
</table>

<?php 
if (empty($setoran->bendaharapenerima_id)) {
	echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),  array('class' => 'btn btn-danger','type'=>'submit', 'onclick'=>'return cekValidasi()')); 
} ?>

<?php $this->endWidget(); ?>

<?php 
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogBendahara',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modBendahara = new PegawaiV('searchDialogMengetahui');
$modBendahara->unsetAttributes();

if(isset($_GET['GFPegawaiV'])) {
    $modBendahara->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaibendahara-grid',
	'dataProvider'=>$modBendahara->search(),
	'filter'=>$modBendahara,
        //'template'=>"{items}\n{pager}",
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
                                                  $(\"#'.CHtml::activeId($setoran,'bendaharapenerima_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($setoran,'bendahara_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogBendahara\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
					'name'=>'nomorindukpegawai',
                    'filter'=>  CHtml::activeTextField($modBendahara, 'nomorindukpegawai'),
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Nama Pegawai',
					'name'=>'nama_pegawai',
                    'filter'=>  CHtml::activeTextField($modBendahara, 'nama_pegawai'),
                    'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modBendahara, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>

<script>
function cekValidasi() {
	if ($("#BKSetorankasirT_bendaharapenerima_id").val().trim() == "") {
		alert("Bendahara harus diisi.");
		return false;
	}
	
	return confirm("Anda yakin?");
}
</script>
