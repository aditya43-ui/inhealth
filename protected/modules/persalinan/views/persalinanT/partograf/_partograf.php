<style>
	.colstabel{
		background-color: #dfdfdf;
	}
	
	.label-periksa{
		font-weight: bold;
		color:#333 !important;
	}
</style>
<div class="panel panel-success" id="panel-partograf" hidden>
	<div class="panel-heading">
		<div class="panel-title">
			Data Partograf
		</div>
	</div>
	<div class="panel-body">
		<div class="col-sm-6">
			<div class="control-group">
				<?php echo $form->labelEx($modPartograf, 'tglperiksa', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php
					$this->widget('MyDateTimePicker', array(
						'model' => $modPartograf,
						'attribute' => 'tglperiksa',
						'mode' => 'datetime',
						'options' => array(
							'dateFormat' => Params::DATE_FORMATV3,
							'maxDate' => 'd',
                                                        'onSelect' => 'js:function(){renameDetailPartograf();generateGrafik();}'
						),
						'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:150px;'
						),
					));					
					?>					
				</div>
			</div>
			
			<?php echo $form->textFieldRow($modPartograf,'gravida',array('class' => 'numbers-only col-sm-4', 'style' => 'text-align:right;')); ?>
			<?php echo $form->textFieldRow($modPartograf,'para',array('class' => 'numbers-only col-sm-4', 'style' => 'text-align:right;')); ?>
			<?php echo $form->textFieldRow($modPartograf,'abortus',array('class' => 'numbers-only col-sm-4', 'style' => 'text-align:right;')); ?>
		</div>
		
		<div class="col-sm-6">
			<div class="control-group">
				<?php echo $form->labelEx($modPartograf,'usiakehamilan', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($modPartograf,'usiakehamilan',array('class' => 'numbers-only col-sm-4', 'style' => 'text-align:right;')); ?>  <label> Minggu</label>
				</div>
			</div>
			
			<div class="control-group">
				<?php echo $form->labelEx($modPartograf, 'tglketubanpecah', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php
					$this->widget('MyDateTimePicker', array(
						'model' => $modPartograf,
						'attribute' => 'tglketubanpecah',
						'mode' => 'datetime',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
							'maxDate' => 'd',
						),
						'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:150px;'
						),
					));					
					?>					
				</div>
			</div>
			
			<div class="control-group">
				<?php echo $form->labelEx($modPartograf, 'tglmules', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php
					$this->widget('MyDateTimePicker', array(
						'model' => $modPartograf,
						'attribute' => 'tglmules',
						'mode' => 'datetime',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
							'maxDate' => 'd',
						),
						'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:150px;'
						),
					));					
					?>					
				</div>
			</div>
			
		</div>
	</div>	
    <div class="panel-body">
        <div class="panel panel-success" id="panel-monitoring">
            <div class="panel-heading">
                <div class="panel-title">
                    Monitoring Grafik
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view.'partograf/_monitoringPartograf',array('model'=>$modPartograf)); ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
<div class="panel panel-success" id="panel-partografdet">
	<div class="panel-heading">
		<div class="panel-title">
			Detail 
				<?php
				echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', 
					array('onclick' => 'addPartografDetail();generatePicker();',
						'class' => 'btn btn-danger',
						'onkeypress' => "return $(this).focusNextInputField(event)",
						'rel' => "tooltip",
						'title' => "Klik untuk detail pemeriksaan partoraf",));
				
				if ($modPartograf->ada_detail == true){
					$coun = 2+count((array)$loadDataPartoDet);
				}else{
					$coun = 2;
				}
				
				?>    		
		</div>
	</div>				
	<div class="panel-body table-responsive">
		
		<table class="table table-bordered" id="tabel-partograf-detail">			
			<thead>
				<tr>
					<td class="label-periksa">&nbsp;</td>
					<td class="label-periksa">Pemeriksaan</td>
					<?php
						if ($modPartograf->ada_detail == true){
							$i = 0;
							foreach ($loadDataPartoDet as $det){
								echo '<td><b><span style="color:#333 !important;" class="noperiksa">P'.($i+1).'</span></b></td>';
								$i++;
							}
						}
					?>
				</tr>
			</thead>
			<tbody>
                                <tr class="periksaCatatWaktu" valueid='0'>
					<td class="label-periksa">&nbsp;</td>
					<td class="label-periksa">Catat Waktu</td>
					<?php
						if ($modPartograf->ada_detail == true){
							$i = 0;
							foreach ($loadDataPartoDet as $det){
								echo $this->renderPartial($this->path_view."partograf._detailPartograf",array('data'=>'catatwaktu', 'det'=>$det ,'i'=>$i),true);					
								$i++;
							}
						}
					?>
				</tr>
				<tr class="periksaDjj" valueid='0'>
					<td class="label-periksa">&nbsp;</td>
					<td class="label-periksa">Denyut Jantung Janin (/menit)</td>
					<?php
						if ($modPartograf->ada_detail == true){
							$i = 0;
							foreach ($loadDataPartoDet as $det){
								echo $this->renderPartial($this->path_view."partograf._detailPartograf",array('data'=>'djj', 'det'=>$det ,'i'=>$i),true);					
								$i++;
							}
						}
					?>
				</tr>
				<tr>					
					<td class='colstabel'  colspan='<?php echo $coun; ?>'>&nbsp;</td>										
				</tr>
				<tr class="periksaAirKetuban" valueid='0'>
					<td class="label-periksa">&nbsp;</td>
					<td class="label-periksa">Air Ketuban</td>
					<?php
						if ($modPartograf->ada_detail == true){
							$i = 0;
							foreach ($loadDataPartoDet as $det){
								echo $this->renderPartial($this->path_view."partograf._detailPartograf",array('data'=>'airketuban', 'det'=>$det ,'i'=>$i),true);					
								$i++;
							}
						}
					?>
				</tr>
				<tr class="periksaPenyusupan" valueid='0'>
					<td class="label-periksa">&nbsp;</td>
					<td class="label-periksa">Penyusupan</td>
					<?php
						if ($modPartograf->ada_detail == true){
							$i = 0;
							foreach ($loadDataPartoDet as $det){
								echo $this->renderPartial($this->path_view."partograf._detailPartograf",array('data'=>'penyusupan', 'det'=>$det ,'i'=>$i),true);					
								$i++;
							}
						}
					?>
				</tr>
				<tr>					
					<td class='colstabel'  colspan='<?php echo $coun; ?>'>&nbsp;</td>										
				</tr>
				<tr class="periksaServiks" valueid='0'>
					<td class="label-periksa">&nbsp;</td>
					<td class="label-periksa">Pembukaan Serviks</td>
					<?php
						if ($modPartograf->ada_detail == true){
							$i = 0;
							foreach ($loadDataPartoDet as $det){
								echo $this->renderPartial($this->path_view."partograf._detailPartograf",array('data'=>'serviks', 'det'=>$det ,'i'=>$i),true);					
								$i++;
							}
						}
					?>
				</tr>
				<tr class="periksaKepala" valueid='0'>
					<td class="label-periksa">&nbsp;</td>
					<td class="label-periksa">Turunnya Kepala</td>
					<?php
						if ($modPartograf->ada_detail == true){
							$i = 0;
							foreach ($loadDataPartoDet as $det){
								echo $this->renderPartial($this->path_view."partograf._detailPartograf",array('data'=>'kepala', 'det'=>$det ,'i'=>$i),true);					
								$i++;
							}
						}
					?>
				</tr>
				<tr class="periksaWaktu" valueid='0' hidden>
					<td class="label-periksa">&nbsp;</td>
					<td class="label-periksa">Waktu</td>
					<?php
						if ($modPartograf->ada_detail == true){
							$i = 0;
							foreach ($loadDataPartoDet as $det){
								echo $this->renderPartial($this->path_view."partograf._detailPartograf",array('data'=>'waktu', 'det'=>$det ,'i'=>$i),true);					
								$i++;
							}
						}
					?>
				</tr>
				<tr class="tampilWaktu" valueid='0'>
					<td class="label-periksa">&nbsp;</td>
					<td class="label-periksa">Waktu</td>
					<?php
						if ($modPartograf->ada_detail == true){
							$i = 1;
							foreach ($loadDataPartoDet as $det){
								echo $this->renderPartial($this->path_view."partograf._detailPartograf",array('data'=>'waktulabel', 'det'=>$det ,'row'=>$i, 'labeltime'=>$det->p3_waktu),true);					
								$i++;
							}
						}
					?>
				</tr>
				<tr>					
					<td class='colstabel'  colspan='<?php echo $coun; ?>'>&nbsp;</td>										
				</tr>
				<tr class="periksaKontraksiJumlah" valueid='0'>
					<td class="label-periksa">&nbsp;</td>
					<td class="label-periksa">Jumlah Kontraksi</td>
					<?php
						if ($modPartograf->ada_detail == true){
							$i = 0;
							foreach ($loadDataPartoDet as $det){
								echo $this->renderPartial($this->path_view."partograf._detailPartograf",array('data'=>'kontraksijumlah', 'det'=>$det ,'i'=>$i),true);					
								$i++;
							}
						}
					?>
				</tr>
				<tr class="periksaKontraksiDetik" valueid='0'>
					<td class="label-periksa">&nbsp;</td>
					<td class="label-periksa">Detik</td>
					<?php
						if ($modPartograf->ada_detail == true){
							$i = 0;
							foreach ($loadDataPartoDet as $det){
								echo $this->renderPartial($this->path_view."partograf._detailPartograf",array('data'=>'kontraksidetik', 'det'=>$det ,'i'=>$i),true);					
								$i++;
							}
						}
					?>
				</tr>
				<tr>					
					<td class='colstabel'  colspan='<?php echo $coun; ?>'>&nbsp;</td>										
				</tr>
				<tr class="periksaOksilosin" valueid='0'>
					<td class="label-periksa">&nbsp;</td>
					<td class="label-periksa">Oksilosin U/L</td>
					<?php
						if ($modPartograf->ada_detail == true){
							$i = 0;
							foreach ($loadDataPartoDet as $det){
								echo $this->renderPartial($this->path_view."partograf._detailPartograf",array('data'=>'oksilosin', 'det'=>$det ,'i'=>$i),true);					
								$i++;
							}
						}
					?>
				</tr>
				<tr class="periksaTetes" valueid='0'>
					<td class="label-periksa">&nbsp;</td>
					<td class="label-periksa">tetes/menit</td>
					<?php
						if ($modPartograf->ada_detail == true){
							$i = 0;
							foreach ($loadDataPartoDet as $det){
								echo $this->renderPartial($this->path_view."partograf._detailPartograf",array('data'=>'tetes', 'det'=>$det ,'i'=>$i),true);					
								$i++;
							}
						}
					?>
				</tr>
				<!--Obat & Cariran-->
				<!--Nadi Tekanan & Darah-->
				<tr>					
					<td class='colstabel'  colspan='<?php echo $coun; ?>'>&nbsp;</td>										
				</tr>
				<tr class="periksaObat" valueid='0'>
					<td class="label-periksa">&nbsp;</td>
					<td class="label-periksa">Obat & Cairan IV</td>
					<?php
						if ($modPartograf->ada_detail == true){
							$i = 0;														
							foreach ($loadDataPartoDet as $det){								
								echo "<td>";
								echo $this->renderPartial($this->path_view."partograf._detailPartograf",array('data'=>'obat', 'det'=>new PSPemeriksaanpartografobatT ,'i'=>$i,'showdata'=>true),true);					
								
								$obatDet = PSPemeriksaanpartografobatT::model()->findAllByAttributes(array('pemeriksaanpartografdet_id'=>$det->pemeriksaanpartografdet_id));
								foreach ($obatDet as $oa){				
									$oa->obatalkes_nama = $oa->obatalkes->obatalkes_nama;
									echo $this->renderPartial($this->path_view."partograf._rowObat",array('data'=>'obat', 'det'=>$oa ,'ii'=>$i),true);					
								}
								$i++;
								echo "</td>";
							}
							
						}
					?>
				</tr>
				<tr class="periksaTekananDarah" valueid='0'>
					<td class="label-periksa">&nbsp;</td>
					<td class="label-periksa">Tekanan Darah</td>
					<?php
						if ($modPartograf->ada_detail == true){
							$i = 0;
							foreach ($loadDataPartoDet as $det){
								echo $this->renderPartial($this->path_view."partograf._detailPartograf",array('data'=>'tekanandarah', 'det'=>$det ,'i'=>$i),true);					
								$i++;
							}
						}
					?>
				</tr>
				<tr class="periksaNadi" valueid='0'>
					<td class="label-periksa">&nbsp;</td>
					<td class="label-periksa">Nadi</td>
					<?php
						if ($modPartograf->ada_detail == true){
							$i = 0;
							foreach ($loadDataPartoDet as $det){
								echo $this->renderPartial($this->path_view."partograf._detailPartograf",array('data'=>'nadi', 'det'=>$det ,'i'=>$i),true);					
								$i++;
							}
						}
					?>
				</tr>
				<tr class="periksaPenyulit" valueid='0'>
					<td class="label-periksa">&nbsp;</td>
					<td class="label-periksa">Penyulit</td>
					<?php
						if ($modPartograf->ada_detail == true){
							$i = 0;
							foreach ($loadDataPartoDet as $det){
								$det->p6_penyulit = $this->getRevertPenyulit($det->p6_penyulit);
								echo $this->renderPartial($this->path_view."partograf._detailPartograf",array('data'=>'penyulit', 'det'=>$det ,'i'=>$i),true);					
								$i++;
							}
						}
					?>
				</tr>
				<tr>					
					<td class='colstabel'  colspan='<?php echo $coun; ?>'>&nbsp;</td>										
				</tr>
				<tr class="periksaSuhu" valueid='0'>
					<td class="label-periksa">&nbsp;</td>
					<td class="label-periksa">Suhu <sup>o</sup>C</td>
					<?php
						if ($modPartograf->ada_detail == true){
							$i = 0;
							foreach ($loadDataPartoDet as $det){                                                                
								echo $this->renderPartial($this->path_view."partograf._detailPartograf",array('data'=>'suhu', 'det'=>$det ,'i'=>$i),true);					
								$i++;
							}
						}
					?>
				</tr>
				<tr>					
					<td class='colstabel'  colspan='<?php echo $coun; ?>'>&nbsp;</td>
				</tr>
				<tr class="periksaUrinProtein" valueid='0'>
					<td class="label-periksa" rowspan="3" style="vertical-align: middle;width:5%">Urin</td>
					<td class="label-periksa">Protein</td>
					<?php
						if ($modPartograf->ada_detail == true){
							$i = 0;
							foreach ($loadDataPartoDet as $det){
								echo $this->renderPartial($this->path_view."partograf._detailPartograf",array('data'=>'urinprotein', 'det'=>$det ,'i'=>$i),true);					
								$i++;
							}
						}
					?>
				</tr>
				<tr class="periksaUrinAsolon" valueid='0'>					
					<td class="label-periksa">Asolon</td>
					<?php
						if ($modPartograf->ada_detail == true){
							$i = 0;
							foreach ($loadDataPartoDet as $det){
								echo $this->renderPartial($this->path_view."partograf._detailPartograf",array('data'=>'urinasolon', 'det'=>$det ,'i'=>$i),true);					
								$i++;
							}
						}
					?>
				</tr>
				<tr class="periksaUrinVolume" valueid='0'>					
					<td class="label-periksa">Volume</td>
					<?php
						if ($modPartograf->ada_detail == true){
							$i = 0;
							foreach ($loadDataPartoDet as $det){
								echo $this->renderPartial($this->path_view."partograf._detailPartograf",array('data'=>'urinvolume', 'det'=>$det ,'i'=>$i),true);					
								$i++;
							}
						}
					?>
				</tr>
			</tbody>
		</table>
	</div>
</div>
    </div>
<?php
	echo $this->renderPartial("persalinan.views.persalinanT.partograf._jsFunctions",array('modPartograf' => $modPartograf, 'modPartografDet' => $modPartografDet, 'modPartografObat' => $modPartografObat),true)
?>
</div>

<?php 
//========= Dialog buat cari data Obat =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogObatPersalinan',
    'options'=>array(
        'title'=>'Pencarian Obat',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modObat = new PSObatAlkesM;
$modObat->unsetAttributes();
if(isset($_GET['PSObatAlkesM'])) {
    $modObat->attributes = $_GET['PSObatAlkesM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawai-grid',
	'dataProvider'=>$modObat->searchDialog(),
	'filter'=>$modObat,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                            setObatAuto($data->obatalkes_id);
									"))',
                ),
                array(
                    'header'=>'Kode',
					'name' => 'obatalkes_kode',
                    'value'=>'$data->obatalkes_kode',
                ),
                array(
                    'header'=>'Nama',
					'name' => 'obatalkes_nama',
                    'value'=>'$data->obatalkes_nama',
                ),
				array(
					'header'=>'Satuan Kecil',
					'filter'=>  CHtml::activeDropDownList($modObat, 'satuankecil_id', CHtml::listData(SatuankecilM::model()->findAll(" satuankecil_aktif = TRUE ORDER BY satuankecil_nama ASC "), 'satuankecil_id', 'satuankecil_nama'),array('empty'=>'-- Pilih --')),
					'value'=>'(!empty($data->satuankecil_id)?$data->satuankecil->satuankecil_nama:"")'
				),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end Obat dialog =============================
?> 

<script>
	function setDialog(obj){
		parent = $(obj).parents(".input-append").find("input").attr("id");
		dialog = "#dialogObatPersalinan";
		$(dialog).attr("parent-dialog",parent);
		$(dialog).dialog("open");
	}
	
	function setObatAuto(obat_id){

		dialog = "#dialogObatPersalinan";
		parent = $(dialog).attr("parent-dialog");
		
		var split = parent.split("_");		
		
		obj = $("#"+parent);
		$.get('<?php echo $this->createUrl('/ActionAutoComplete/ObatAlkesPartograf'); ?>',{obatalkes_id:obat_id},function(data){
			$(obj).val(data[0].obatalkes_nama);
			$(obj).val(data[0].obatalkes_kode);
			setObat(obj,data[0],split);
		},"json");
		$(dialog).dialog("close");
	}
	
	function setObat(obj,item,split)
	{
		var cek = true;
		$(obj).parents('td').find('#PSPemeriksaanpartografobatT_'+split[1]+'_obatalkes_nama').val("");
		
		$(obj).parents('td').find('input[name*="[obatalkes_id]"]').each(function(){
		//alert('asdsd');	
			if ($(this).val() == item.obatalkes_id){
				cek = false;
			}
		});
		
		if (cek == false){
			myAlert(" Obat sudah ditambahkan pada pemeriksaan partograf ini ");
			return false;
		}else{
			$(obj).parents('td').append("<div name='"+split[0]+"["+split[1]+"][obat]["+item.obatalkes_id+"][div]'>	<input type='text' readonly=true value='"+item.obatalkes_nama+"' name='"+split[0]+"["+split[1]+"][obat]["+item.obatalkes_id+"][obatalkes_nama]' class='span2 manyinput'>\n\
											<input type='text' value='1' name='"+split[0]+"["+split[1]+"][obat]["+item.obatalkes_id+"][obatalkes_jumlah]' class='span1  numbers-only manyinput' onkeyup='setNumbersOnly(this);' style='text-align:right;'>\n\
											<button type='button' name='"+split[0]+"["+split[1]+"][obat]["+item.obatalkes_id+"][obatalkes_hapus]'  class='btn btn-danger' onclick='delObat(this,"+item.obatalkes_id+","+split[1]+",\""+split[0]+"\");'><i class='<?php echo MyIcon::getIcons('batal') ?>'></i></button>\n\
											<input type='hidden' readonly=true value='"+item.obatalkes_id+"' name='"+split[0]+"["+split[1]+"][obat]["+item.obatalkes_id+"][obatalkes_id]' class='span2 manyinput'>\n\
											<input type='hidden' readonly=true value='' name='"+split[0]+"["+split[1]+"][obat]["+item.obatalkes_id+"][pemeriksaanpartografobat_id]' class='span2 manyinput'><br></div>");		
		}
	}
	
	function delObat(obj,obatalkes_id, ident, model){		
		myConfirm("Apakah Anda yakin akan menghapus obat <b>"+$(obj).parents('td').find('input[name*="['+ident+'][obat]['+obatalkes_id+'][obatalkes_nama]"]').val()+"</b> ini?","Perhatian !",function(r){
			if (r){
				var id = $(obj).parents('td').find('input[name*="['+ident+'][obat]['+obatalkes_id+'][pemeriksaanpartografobat_id]"]').val();
				
				$(obj).parents('td').append("<input type='hidden' readonly=true value='"+id+"' name='"+model+"["+ident+"][hapusobat]["+obatalkes_id+"][pemeriksaanpartografobat_id]' class='span2 manyinput'>");		
				//$(obj).parents('td').find('input[name*="['+ident+'][obat]['+obatalkes_id+']"]').remove();
				$(obj).parents('td').find('div[name*="['+ident+'][obat]['+obatalkes_id+']"]').remove();								

				
			}else{
				return false;
			}
		});
		
	}

</script>