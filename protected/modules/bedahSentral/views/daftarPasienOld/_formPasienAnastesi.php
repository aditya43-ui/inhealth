<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <?php echo CHtml::checkBox('pakeAnastesi', $modAnastesi->pakeAnastesi, array('onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
            Pasien Anastesi
        </div>
    </div>
    <div class="panel-body">
        <div id="divAnastesi" class="control-group <?php echo ($modAnastesi->pakeAnastesi) ? '':''; ?>">

            <?php echo $form->dropDownListRow($modAnastesi,'jenisanastesi_id', CHtml::listData(JenisAnastesiM::model()->findAll('jenisanastesi_aktif = true order by jenisanastesi_id '), 'jenisanastesi_id', 'jenisanastesi_nama') ,
                                 array('disabled'=>true,
                                        'empty'=>'-- Pilih --',
                                        'onkeypress'=>"return $(this).focusNextInputField(event)",
                                        'ajax'=>array(
                                             'type'=>'POST',
                                             'url'=>Yii::app()->createUrl('ActionDynamic/GetAnastesi',array('encode'=>false,'namaModel'=>'PasienanastesiT','attr'=>'')),
                                             'update'=>'#PasienanastesiT_anastesi_id',),
                                         'onchange'=>'$("#PasienanastesiT_typeanastesi_id").html("")',
										 'class' => 'span3'
                                     )); ?>

             <?php 
     //        echo $form->dropDownListRow($modAnastesi,'anastesi_id', array() ,
     //                            array('disabled'=>true,
     //                                   'empty'=>'-- Pilih --',
     //                                   'onkeypress'=>"return $(this).focusNextInputField(event)",
     //                                   'ajax'=>array(
     //                                        'type'=>'POST',
     //                                        'url'=>Yii::app()->createUrl('ActionDynamic/GetTypeAnastesi',array('encode'=>false,'namaModel'=>'PasienanastesiT','attr'=>'')),
     //                                        'update'=>'#PasienanastesiT_typeanastesi_id',)
     //                                )); ?>
             <?php 
             echo $form->dropDownListRow($modAnastesi,'anastesi_id', array() ,
                                 array('disabled'=>true,
                                         'empty'=>'-- Pilih --',
                                         'onkeypress'=>"return $(this).focusNextInputField(event)",
                                         'onchange'=>'js:getRowsTypeAnastesiDropdown()',
										 'class'=>'span3'
                                        )); ?>

             <?php 
     //        DIPINDAHKAN KE TABEL GRID BAWAH
     //        echo $form->dropDownListRow($modAnastesi,'typeanastesi_id', array() ,array('disabled'=>true,'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>

			<span id="urut-<?php echo str_replace(' ','-',strtolower(Params::KRUBEDAH_DOKTER_ANESTESI)); ?>">
				<div class="control-group pelaksanaoperasi awal">
					<?php echo CHtml::label('Dokter Anestesi','dokteranastesi_id',array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->dropDownList($modAnastesi,'dokteranastesi_id', CHtml::listData($modPenunjang->getDokterItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'value'=>$modRencanaOperasiAttrib->dokteranastesi_id,
								'class' => 'span3 krubedah_id')); ?>
					</div>
				</div>

					<?php  
					if (!empty($modRencanaOperasiAttrib->rencanaoperasi_id)){
						$look = $modRencanaOperasiAttrib->getKruBedahByLookup(Params::KRUBEDAH_DOKTER_ANESTESI, $modRencanaOperasiAttrib->rencanaoperasi_id);

						if (count((array)$look) > 0){		
							$length = 1;
							foreach ($look as $det){				
								$det->pegawai_nama = $det->pegawai->namaLengkap;
								echo $this->renderPartial($this->path_view.'_rowKruBedah',array('length'=>$length,'model' => $det, 'i'=>$i),true);
								$i++;
								$length++;
							}
						}
					}
					?>
			</span>
			
			<span id="urut-<?php echo str_replace(' ','-',strtolower(Params::KRUBEDAH_ASISTEN_ANESTESI)); ?>">
				<?php  
				if (!empty($modRencanaOperasiAttrib->rencanaoperasi_id)){
					$look = $modRencanaOperasiAttrib->getKruBedahByLookup(Params::KRUBEDAH_ASISTEN_ANESTESI, $modRencanaOperasiAttrib->rencanaoperasi_id);

					if (count((array)$look) > 0){		
						$length = 0;
						foreach ($look as $det){				
							$det->pegawai_nama = $det->pegawai->namaLengkap;
							echo $this->renderPartial($this->path_view.'_rowKruBedah',array('length'=>$length,'model' => $det, 'i'=>$i),true);
							$i++;
							$length++;
						}
					}
				}
				?>
			</span>
			
			<span id="urut-<?php echo str_replace(' ','-',strtolower(Params::KRUBEDAH_PENATA_ANESTESI)); ?>">
				<div class="control-group pelaksanaoperasi awal">
					<?php echo CHtml::label('Penata Anestesi','paramedis_id',array('class'=>'control-label')) ?>
				<div class="controls">										
				<?php
					echo $form->dropDownList($modRencanaOperasiAttrib,'paramedis_id',
						CHtml::listData($modRencanaOperasiAttrib->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai'),
						array(
							'empty'=>'-- Pilih --',
							'onkeypress'=>"return $(this).focusNextInputField(event)",
							'class' => 'span3 krubedah_id'
						)
					);
				?>
				</div>
				</div>
				
				<?php  
					if (!empty($modRencanaOperasiAttrib->rencanaoperasi_id)){
						$look = $modRencanaOperasiAttrib->getKruBedahByLookup(Params::KRUBEDAH_PENATA_ANESTESI, $modRencanaOperasiAttrib->rencanaoperasi_id);

						if (count((array)$look) > 0){		
							$length = 1;
							foreach ($look as $det){				
								$det->pegawai_nama = $det->pegawai->namaLengkap;
								echo $this->renderPartial($this->path_view.'_rowKruBedah',array('length'=>$length,'model' => $det, 'i'=>$i),true);
								$i++;
								$length++;
							}
						}
					}
					?>
			</span>

			<span id="urut-<?php echo str_replace(' ','-',strtolower(Params::KRUBEDAH_PERAWAT_ANESTESI)); ?>">
				<div class="control-group pelaksanaoperasi awal">
					<?php echo CHtml::label('Perawat Anestesi','paramedis_id',array('class'=>'control-label')) ?>
					<div class="controls">			
						<?php echo $form->dropDownList($modAnastesi,'perawatanastesi_id', CHtml::listData($modPenunjang->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'value'=>$modRencanaOperasiAttrib->perawat_id,'class' => 'span3 krubedah_id')); ?>
					</div>
				</div>
				
				<?php  
					if (!empty($modRencanaOperasiAttrib->rencanaoperasi_id)){
						$look = $modRencanaOperasiAttrib->getKruBedahByLookup(Params::KRUBEDAH_PERAWAT_ANESTESI, $modRencanaOperasiAttrib->rencanaoperasi_id);

						if (count((array)$look) > 0){		
							$length = 1;
							foreach ($look as $det){				
								$det->pegawai_nama = $det->pegawai->namaLengkap;
								echo $this->renderPartial($this->path_view.'_rowKruBedah',array('length'=>$length,'model' => $det, 'i'=>$i),true);
								$i++;
								$length++;
							}
						}
					}
					?>
			</span>
			<span class="lookupkrubedah-anestesi">
			</span>
			<?php 
				$cri = new CDbCriteria();
				$cri->addNotInCondition("lookup_value", Params::getKruBedahLookup());
				$cri->addCondition(" lookup_value ILIKE '%anestesi%' ");
				$cri->addCondition(" lookup_type = '".Params::LOOKUPTYPE_KRU_BEDAH."' AND lookup_aktif = TRUE ");
				$cri->order = " lookup_urutan ASC ";
				$lookKru = LookupM::model()->findAll($cri);

				foreach ($lookKru as $l){			
			?>
			<span id="urut-<?php echo str_replace(' ','-',strtolower($l->lookup_value)); ?>" class="lookupkrubedah-anestesi">
				<?php  
				if (!empty($modRencanaOperasiAttrib->rencanaoperasi_id)){
					$look = $modRencanaOperasiAttrib->getKruBedahByLookup($l->lookup_value, $modRencanaOperasiAttrib->rencanaoperasi_id);					
					if (count((array)$look) > 0){
						$length = 0;
						foreach ($look as $det){				
							$det->pegawai_nama = $det->pegawai->namaLengkap;
							echo $this->renderPartial($this->path_view.'_rowKruBedah',array('length'=>$length,'model' => $det, 'i'=>$i),true);
							$i++;
							$length++;
						}
					}
				}
				?>
			</span>
			<?php
				}
			?>
         </div>
    </div>
</div>


<?php
$enableInputAnastesi = ($modAnastesi->pakeAnastesi) ? 1 : 0;
$js = <<< JS
if(${enableInputAnastesi}) {
    $('#divAnastesi input').removeAttr('disabled');
    $('#divAnastesi select').removeAttr('disabled');
}
else {
    $('#divAnastesi input').attr('disabled','true');
    $('#divAnastesi select').attr('disabled','true');
}

$('#pakeAnastesi').change(function(){
        if ($(this).is(':checked')){
                $('#divAnastesi input').removeAttr('disabled');
                $('#divAnastesi select').removeAttr('disabled');
                $('#PasienanastesiT_dokteranastesi_id').val($('#BSRencanaOperasiT_dokteranastesi_id').val());
        }else{
                $('#divAnastesi input').attr('disabled','true');
                $('#divAnastesi select').attr('disabled','true');
                $('#divAnastesi input').attr('value','');
                $('#divAnastesi select').attr('value','');
        }
//        $('#divAnastesi').slideToggle(500);
    });
JS;
Yii::app()->clientScript->registerScript('anastesi',$js,CClientScript::POS_READY);
?>
<script type="text/javascript">
function getRowsTypeAnastesiDropdown(){
    $.ajax({
        url:"<?php echo $this->createUrl('GetTypeAnastesi', array('encode'=>false,'namaModel'=>'PasienanastesiT','attr'=>'' ))?>",
        type:'POST',
        data: {
            "PasienanastesiT[anastesi_id]":$("#PasienanastesiT_anastesi_id").val(),
        },
    }).done(
        function(data){
            $("#tblFormRencanaOperasi tbody").find("tr").each(function(){
                $(this).find(".typeanastesi").empty();
                $(this).find(".typeanastesi").append(data);
            });
        }
    );
}
</script>

<?php 
//KHUSUS UNTUK JENIS ANASTESINYA ADA
if (isset($modAnastesi->jenisanastesi_id)){ ?>
<script type="text/javascript">
function getAnastesiDropdown()
{
    $.ajax({
        url:"<?php echo Yii::app()->createUrl('ActionDynamic/GetAnastesi', array('encode'=>false,'namaModel'=>'PasienanastesiT','attr'=>'' ))?>",
        type:'POST',
        data: {
            "PasienanastesiT[jenisanastesi_id]":<?php echo $modAnastesi->jenisanastesi_id?>,
        },
    }).done(
        function(data){
            $("#PasienanastesiT_anastesi_id").empty();
            $("#PasienanastesiT_anastesi_id").append(data);
        }
    );
}
getAnastesiDropdown();

</script>
<?php }?>

<?php 
//KHUSUS UNTUK ANASTESINYA ADA
if(!empty($modAnastesi->pasienanastesi_id) && !empty($modAnastesi->anastesi_id)){
    ?>
<script type="text/javascript">
function getTypeAnastesiDropdown(){
    $.ajax({
        url:"<?php echo $this->createUrl('GetTypeAnastesi', array('encode'=>false,'namaModel'=>'PasienanastesiT','attr'=>'' ))?>",
        type:'POST',
        data: {
            "PasienanastesiT[anastesi_id]":<?php echo $modAnastesi->anastesi_id?>,
        },
    }).done(
        function(data){
            $("#PasienanastesiT_typeanastesi_id").empty();
            $("#PasienanastesiT_typeanastesi_id").append(data);
        }
    );
}
 
function getRowsTypeAnastesiDropdownDefault(){
    $.ajax({
        url:"<?php echo $this->createUrl('GetTypeAnastesi', array('encode'=>false,'namaModel'=>'PasienanastesiT','attr'=>'' ))?>",
        type:'POST',
        data: {
            "PasienanastesiT[anastesi_id]":<?php echo $modAnastesi->anastesi_id?>,
        },
    }).done(
        function(data){
            $("#tblFormRencanaOperasi tbody").find("tr").each(function(){
                $(this).find(".typeanastesi").empty();
                $(this).find(".typeanastesi").append(data);
            });
        }
    );
}
 

setTimeout(function(){
    $("#PasienanastesiT_anastesi_id").val(<?php echo $modAnastesi->anastesi_id ?>);
    getTypeAnastesiDropdown();
    getRowsTypeAnastesiDropdownDefault();
},2500);
//setTimeout(function(){$("#PasienanastesiT_typeanastesi_id").val(<?php // echo $modAnastesi->typeanastesi_id ?>)},2000);
setTimeout(function(){
        $("#tblFormRencanaOperasi tbody").find("tr").each(function(){
            var typeAnastesiSebelum = $(this).find("input[name$='[typeanastesi_id_sebelum]']").val();
            $(this).find(".typeanastesi").val(typeAnastesiSebelum);
        });
},3000);

</script>
<?php } ?>