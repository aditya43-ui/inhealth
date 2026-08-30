<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', '<b>Berhasil </b> Data berhasil disimpan');
}
$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Hasil dan Pemeriksaan Kesehatan
        </div>
    </div>

    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'pencarian-mcu-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    )); ?>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="control-group">
                            <?php echo CHtml::label('Jenis Checkup', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo Chtml::dropDownList('jenis_checkup', 1, array(1 => 'LAPORAN CHECKUP', 2 => 'LAPORAN CHECKUP STUDY LUAR'), array('class' => 'span3', 'onchange' => 'ubahLaporan(this);'));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>

    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'suratstudi-mcu-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    )); ?>
    <div class="panel-body suratstudi">
        <?php echo $this->renderPartial('_formSuratStudi', array('form' => $form, 'modSuratStudiLuar' => $modSuratStudiLuar)); ?>
    </div>
    <?php $this->endWidget(); ?>

    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'hasilpemeriksaan-mcu-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    )); ?>
    <?php echo $form->errorSummary(array($ModKesimpulanMCU)); ?>
    <div class="panel-body hasilpemeriksaan">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Nomor', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        if (!empty($ModKesimpulanMCU->kesimpulanmcu_id)) {
                            echo $form->textField($ModKesimpulanMCU, 'no_sarandankesimpulan', array());
                        } else {
                            echo $form->textField($ModKesimpulanMCU, 'no_sarandankesimpulan', array('readonly' => true));
                        }
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. Check up', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $ModKesimpulanMCU,
                            'attribute' => 'tgl_kesimpulanmcu',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Keperluan', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($ModKesimpulanMCU, 'keperluan', array('rows' => 4, 'cols' => 4, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Kordinator Check Up', '', array('class' => 'control-label required')); ?>
                    <div class="controls">

                        <?php
                        echo $form->dropDownList($ModKesimpulanMCU, 'kordinator_id', PegawairuanganV::getDropPegawaiTambah(Yii::app()->user->getState('ruangan_id'), array(), array('p.kelompokpegawai_id' => Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK)), array('empty' => '-- Pilih --', 'class' => 'span3'));

                        /*echo CHtml::activeHiddenField($ModKesimpulanMCU,'kordinator_id',array('onkeyup'=>"return $(this).focusNextInputField(event)",));
                                $this->widget('MyJuiAutoComplete', array(
                                                'name'=>'kordinator_nama',
                                                'source'=>'js: function(request, response) {
                                                $.ajax({
                                                        url: "'.$this->createUrl('AutocompletePetugas').'",
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
                                                $("#kordinator_nama").val(ui.item.nama_pegawai);
                                                $("#'.CHtml::activeId($ModKesimpulanMCU,'kordinator_id').'").val(ui.item.pegawai_id);
                                                return false;
                                        }',
                                    ),
                                            'htmlOptions'=>array(
                                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                                            'class' => 'span3'
                                            ),
                                            'tombolDialog'=>array('idDialog'=>'dialogKordinator'),
                                    )); */
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Lain-lain
                </div>
            </div>


            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Tinggi Badan', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($ModKesimpulanMCU, 'periksaumum_tinggibadan', array('placeholder' => 'tinggi badan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'onblur' => 'jumlah()')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Tekanan Darah', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($ModKesimpulanMCU, 'periksaumum_sistolic', array('placeholder' => 'sistolic', 'onblur' => 'genTekananDarah();', 'class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                            <div class="controls">
                                /
                            </div>
                            <div class="controls">
                                <?php echo $form->textField($ModKesimpulanMCU, 'periksaumum_diastolic', array('placeholder' => 'diastolic', 'onblur' => 'genTekananDarah();', 'class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                            <div class="controls" style="padding-top:5px;">
                                <label>mmHg</label>
                            </div>
                        </div>
                        <div class="control-group hide">
                            <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($ModKesimpulanMCU, 'periksaumum_tekanandarah', array('placeholder' => 'tekanan darah', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?> <label>mmHg</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Mata', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($ModKesimpulanMCU, 'mata', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'mata',)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($ModKesimpulanMCU, 'mata_visus_kanan', array('placeholder' => 'Visus Kanan', 'class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                            <div class="controls">
                                <?php echo $form->textField($ModKesimpulanMCU, 'mata_visus_kiri', array('placeholder' => 'Visus Kiri', 'class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($ModKesimpulanMCU, 'mata_presepsi_warna', array('placeholder' => 'Persepsi Warna', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Berat Badan', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($ModKesimpulanMCU, 'periksaumum_beratbadan', array('placeholder' => 'berat badan', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'onblur' => 'jumlah()')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Nadi', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($ModKesimpulanMCU, 'periksaumum_nadi', array('placeholder' => 'Nadi', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>

                        <div class="control-group">
                            <?php echo CHtml::label('BMI', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($ModKesimpulanMCU, 'periksaumum_nilaibmi', array('placeholder' => 'bmi nilai', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                            </div>
                        </div>

                        <div class="control-group">
                            <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($ModKesimpulanMCU, 'periksaumum_bmikategori', array('placeholder' => 'bmi kategori', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Laboratorium
                </div>
            </div>
            <div class="panel-body">
                <?php

                /*
foreach ($data as $dt1){
	?>
		<h6 style="color:#b75858"><?php echo $dt1['jenispemeriksaanlab_nama']; ?></h6>
		<table class="table border paddingtext2">			
			<tr bgcolor="#e5e5e5">
				<th width="25%">Nama Pemeriksaan</th>
				<th width="25%">Detail Pemeriksaan</th>
				<th width="25%" style="text-align:center;">Hasil</th>
				<th width="25%" style="text-align:center;">Normal</th>
			</tr>
			<?php 
				foreach ($dt1['pemeriksaanlab'] as $dt2){ 					
					
					$a = 1;
					$i =1;
					$b = 1;
					foreach ($dt2['kelompokdet'] as $dt3){
						if (count((array)$dt3['nilairujukan']) > 1){
							
			?>
						<tr>
						
							<td style="border-bottom:white 1px solid !important;">
								<?php 									
										if ($i == 1){
											echo $dt2['pemeriksaanlab_nama'];
										}										
								
								?>
							</td>													
							<td colspan="3">
								<?php echo $dt3['kelompokdet'].' :'; ?>
							</td>							
						</tr>
			<?php
						}
						$j = 1;
						foreach ($dt3['nilairujukan'] as $dt4){	
							if (count((array)$dt2['kelompokdet']) == $b){
								if (count((array)$dt3['nilairujukan']) > 1){
									if (count((array)$dt3['nilairujukan']) == $j){										
										$border = 'border-bottom:1px solid #000 !important;';										
									}else{										
										$border = 'border-bottom:1px solid #fff !important;';
									}									
								}else{
									$border = 'border-bottom:1px solid #000 !important;';
								}
							}else{
								$border = 'border-bottom:1px solid #fff !important;';
							}
				?>
						<tr>
						
							<td style="<?php echo $border ; ?>">
								<?php 									
										if ($i == 1){
											
											echo $dt2['pemeriksaanlab_nama'];
										}	else{											
											
										}							
								
								?>
							</td>													
							<td>								
								<?php 
								if (count((array)$dt3['nilairujukan']) > 1){
									echo '<ul><li>'.$dt4['namapemeriksaandet'].'</li><ul>'; 
								}else{
									echo $dt4['namapemeriksaandet']; 
								}
								?>
							</td>
							<td style="text-align:center;">
								<?php 
									$spanclass='';
									$ubahData = '';
									
									if (trim($dt4['nilairujukan']) != '-'){
										
										if ($dt4['nilairujukan'] != ''){
											if ( ($dt4['nilaimin'] != 0 || $dt4['nilaimax'] != 0) ){

												$hasil = str_replace('.','',$dt4['hasilpemeriksaan']);

												$hasil = str_replace(',','.',$hasil);
															//var_dump($hasil);							
												if (($hasil <= $dt4['nilaimin']) || ($hasil >= $dt4['nilaimax'])){											
													$spanclass='boldmerah';
												}else{

												}
											}else{
												$cekNilai = Params::hasilDetLabTextNumber(strtolower($dt4['namapemeriksaandet'])); 
												if (!empty($cekNilai)){
													if($cekNilai == 2){																								
														$nilaiRujuk = $dt4['nilairujukan'];
														$nilaiPecah1 = explode('/',$nilaiRujuk);

														$nilai1= array();
														foreach($nilaiPecah1 as $idx => $p){
															$nilaiPecah2 = explode('-',$p);

															$nilai1[$idx] = array(
																'min' => isset($nilaiPecah2[0])?trim($nilaiPecah2[0]):null,
																'max' => isset($nilaiPecah2[1])?trim($nilaiPecah2[1]):null
															);
														}

														$hsl = $dt4['hasilpemeriksaan'];
														$pecah1 = explode('/',$dt4['hasilpemeriksaan']);

														$nilai2= array();
														foreach($pecah1 as $idx => $p){
															 $nilai2[$idx] = $p;
														}																								

														$g=0;																				
														foreach ($nilai1 as $idx => $sh){
															if (isset($nilai2[$idx])){
																$hasil = str_replace('.','',$nilai2[$idx]);

																$hasil = str_replace(',','.',$hasil);

																if (count((array)$nilai1)>0){
																	if ($g > 0){																																																																										
																		$ubahData .= '/';																														
																	}
																}

																if ( ($hasil <= $sh['min']) || ($hasil >= $sh['max']) ){
																	$spanclass='ubah';
																	$ubahData .= '<span class="boldmerah">'.$hasil.'</span>';
																}else{
																	$ubahData .= '<span class="">'.$hasil.'</span>';
																}

																$g++;
															}
														}
													}
												}else{
													if (strtolower(trim($dt4['hasilpemeriksaan'])) != strtolower(trim($dt4['nilairujukan']))){
														$spanclass='boldmerah';
													}
												}
											}
										}
									}
				
									echo "<span class='".$spanclass."'>";
									if ($spanclass=='ubah'){										
										echo $ubahData;
									}else{
										echo $dt4['hasilpemeriksaan']; 
									}
									echo "</span>"
								?>
							</td>
							<td style="text-align:center;">
								<?php echo $dt4['nilairujukan']; ?>
							</td>
						</tr>
			
						
			<?php		
						$i++;
						$j++;
						}						
						
						$b++;
					}
					
				} ?>
		</table>	
	<?php
		}*/

                if (!empty($data)) {
                    $hasillab = $this->renderPartial('_genTabelLab', array('data' => $data), true);
                    $hasillab .= $modTinLab;
                } else {
                    $hasillab = $modTinLab;
                }

                if (empty($hasillab)) {
                    $hasillab = '';
                }

                //if (!empty($hasillab)){
                if (empty($ModKesimpulanMCU->pemeriksaan_laboratorium)) {
                    $ModKesimpulanMCU->pemeriksaan_laboratorium = $hasillab;
                }
                ?>
                <div class="control-group">
                    <?php echo CHtml::label('Hasil Laboratorium', '', array('class' => 'control-label')); ?>
                    <div class="controls" style="width:75%;">
                        <?php $this->widget('ext.redactorjs.Redactor', array('attribute' => 'pemeriksaan_laboratorium', 'model' => $ModKesimpulanMCU, 'toolbar' => 'mini', 'height' => '300px')); ?>
                    </div>
                </div>
                <?php
                //}
                ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Radiologi
                </div>
            </div>
            <div class="panel-body">
                <?php
                /*$hasil_rad='';
            $kesan_rad='';
            $kesimpulan_rad='';
            if(!empty($modHasilPemeriksaanRad)) {
                
                $hasil_rad = $modHasilPemeriksaanRad->hasilexpertise;
                $kesan_rad  =$modHasilPemeriksaanRad->kesan_hasilrad;
                $kesimpulan_rad  =$modHasilPemeriksaanRad->kesimpulan_hasilrad;

            } */


                ?>

                <?php
                $hasilrad = '';
                if (!empty($modHasilPemeriksaanRad)) {
                    $hasilrad .= '<table border = "0" style="border:none;">';
                    foreach ($modHasilPemeriksaanRad as $rad) {

                        $hasilrad .=  '<tr style="border:none;">
                                <td width="30%" style="border:none;">' . $rad->pemeriksaanrad->pemeriksaanrad_nama . '</td>
                                <td width="1%" style="border:none;">:</td>
                                <td style="border:none;">' . $rad->hasilexpertise . '</td>
                            </tr>';
                    }
                    $hasilrad .= '</table>';
                }

                if (empty($ModKesimpulanMCU->pemeriksaan_radiologi)) {
                    $ModKesimpulanMCU->pemeriksaan_radiologi = $hasilrad;
                }

                //if (!empty($hasilrad)){
                ?>
                <div class="control-group">
                    <?php echo CHtml::label('Hasil Radiologi', '', array('class' => 'control-label')); ?>
                    <div class="controls" style="width:75%;">
                        <?php $this->widget('ext.redactorjs.Redactor', array('attribute' => 'pemeriksaan_radiologi', 'model' => $ModKesimpulanMCU, 'toolbar' => 'mini', 'height' => '200px')); ?>
                    </div>
                </div>
                <?php
                //}
                /*
            <div class="col-sm-12">
                <div class="control-group">
                            <?php echo CHtml::label('Hasil Radiologi','',array('class'=>'control-label')); ?>
                            <div class="controls">
                            <?php $this->widget('ext.redactorjs.Redactor',array('value'=>$hasil_rad,'name'=>'hasil','toolbar'=>'mini','height'=>'100px')); ?>
                            </div>
                </div>
                <div class="control-group">
                            <?php echo CHtml::label('Kesan','',array('class'=>'control-label')); ?>
                            <div class="controls">
                            <?php $this->widget('ext.redactorjs.Redactor',array('value'=>$kesan_rad,'name'=>'kesan','toolbar'=>'mini','height'=>'100px')); ?>
                            </div>
                </div>
                <div class="control-group">
                            <?php echo CHtml::label('Kesimpulan','',array('class'=>'control-label')); ?>
                            <div class="controls">
                            <?php $this->widget('ext.redactorjs.Redactor',array('value'=>$kesimpulan_rad,'name'=>'kesimpulan','toolbar'=>'mini','height'=>'100px')); ?>
                            </div>
                </div>
                
            </div>
            
             * 
             */ ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Pemeriksaan Umum
                </div>
            </div>
            <div class="panel-body">
                <?php

                ?>

                <?php
                $hasilrad = '';
                if (!empty($modHasilPemeriksaanRad)) {
                    $hasilrad .= '<table border = "0" style="border:none;">';
                    foreach ($modHasilPemeriksaanRad as $rad) {

                        $hasilrad .=  '<tr style="border:none;">
                                <td width="30%" style="border:none;">' . $rad->pemeriksaanrad->pemeriksaanrad_nama . '</td>
                                <td width="1%" style="border:none;">:</td>
                                <td style="border:none;">' . $rad->hasilexpertise . '</td>
                            </tr>';
                    }
                    $hasilrad .= '</table>';
                }

                if (empty($ModKesimpulanMCU->pemeriksaan_radiologi)) {
                    $ModKesimpulanMCU->pemeriksaan_radiologi = $hasilrad;
                }

                //if (!empty($hasilrad)){
                ?>
                <div class="control-group">
                    <?php echo CHtml::label('Hasil Pemeriksaan Umum', '', array('class' => 'control-label')); ?>
                    <div class="controls" style="width:75%;">
                        <?php $this->widget('ext.redactorjs.Redactor', array('attribute' => 'pemeriksaan_umum', 'model' => $ModKesimpulanMCU, 'toolbar' => 'mini', 'height' => '200px')); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Jantung
                </div>
            </div>
            <div class="panel-body">
                <?php

                ?>

                <?php
                $hasilJantung = '';
                if (!empty($modPemeriksaanJantung)) {
                    $hasilJantung = $this->renderPartial('_formJantung', array('modPemeriksaanJantung' => $modPemeriksaanJantung), true);
                }

                if (empty($hasilJantung)) {
                    $hasilJantung = '';
                }

                if (empty($ModKesimpulanMCU->jantung)) {
                    $ModKesimpulanMCU->jantung = $hasilJantung;
                }

                //if (!empty($hasilrad)){
                ?>
                <div class="control-group">
                    <?php echo CHtml::label('Hasil Jantung', '', array('class' => 'control-label')); ?>
                    <div class="controls" style="width:75%;">
                        <?php $this->widget('ext.redactorjs.Redactor', array('attribute' => 'jantung', 'model' => $ModKesimpulanMCU, 'toolbar' => 'mini', 'height' => '200px')); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Kandungan
                </div>
            </div>
            <div class="panel-body">
                <?php

                ?>

                <?php
               $hasilKandungan = '';
               if (!empty($modKandungan)) {
                   $hasilKandungan = $this->renderPartial('_formKandungan', array('modKandungan' => $modKandungan), true);
               }

               if (empty($hasilKandungan)) {
                   $hasilKandungan = '';
               }

               if (empty($ModKesimpulanMCU->kandungan)) {
                   $ModKesimpulanMCU->kandungan = $hasilKandungan;
               }

                //if (!empty($hasilrad)){
                ?>
                <div class="control-group">
                    <?php echo CHtml::label('Hasil Kandungan', '', array('class' => 'control-label')); ?>
                    <div class="controls" style="width:75%;">
                        <?php $this->widget('ext.redactorjs.Redactor', array('attribute' => 'kandungan', 'model' => $ModKesimpulanMCU, 'toolbar' => 'mini', 'height' => '200px')); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Fisioterapi
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo CHtml::label('Hasil Fisioterapi', '', array('class' => 'control-label')); ?>
                    <div class="controls" style="width:75%;">
                        <?php $this->widget('ext.redactorjs.Redactor', array('attribute' => 'fisioterapi', 'model' => $ModKesimpulanMCU, 'toolbar' => 'mini', 'height' => '200px')); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Treadmill
                </div>
            </div>
            <div class="panel-body">

                <?php
                // echo CJSON::encode($modTreadmill);
                $hasilTread = '';
                if (!empty($modTreadmill)) {
                    $hasilTread = $this->renderPartial('_formTreadmill', array('modTreadmill' => $modTreadmill), true);
                }
 
                if (empty($hasilTread)) {
                    $hasilTread = '';
                }
 
                if (empty($ModKesimpulanMCU->treadmill)) {
                    $ModKesimpulanMCU->treadmill = $hasilTread;
                }

                //if (!empty($hasilrad)){
                ?>
                <div class="control-group">
                    <?php echo CHtml::label('Hasil Treadmill', '', array('class' => 'control-label')); ?>
                    <div class="controls" style="width:75%;">
                        <?php $this->widget('ext.redactorjs.Redactor', array('attribute' => 'treadmill', 'model' => $ModKesimpulanMCU, 'toolbar' => 'mini', 'height' => '200px')); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Hearing Test
                </div>
            </div>
            <div class="panel-body">
                <?php

                ?>

                <?php
                $hasilHearing = '';
                if (!empty($modHearing)) {
                    $hasilHearing = $this->renderPartial('_formHearing', array('modHearing' => $modHearing), true);
                }
 
                if (empty($hasilHearing)) {
                    $hasilHearing = '';
                }
 
                if (empty($ModKesimpulanMCU->hearing_test)) {
                    $ModKesimpulanMCU->hearing_test = $hasilHearing;
                }

                //if (!empty($hasilrad)){
                ?>
                <div class="control-group">
                    <?php echo CHtml::label('Hasil Hearing Test', '', array('class' => 'control-label')); ?>
                    <div class="controls" style="width:75%;">
                        <?php $this->widget('ext.redactorjs.Redactor', array('attribute' => 'hearing_test', 'model' => $ModKesimpulanMCU, 'toolbar' => 'mini', 'height' => '200px')); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Konsultasi Poliklinik
                </div>
            </div>
            <div class="panel-body">
                <?php

                ?>

                <?php
                // echo CJSON::encode($modKonsul);
                $hasilKonsul = '';
                if (!empty($modKonsul)) {
                    $hasilKonsul = $this->renderPartial('_formKonsul', array('modKonsul' => $modKonsul), true);
                }
 
                if (empty($hasilKonsul)) {
                    $hasilKonsul = '';
                }
 
                if (empty($ModKesimpulanMCU->konsultasi_poliklinik)) {
                    $ModKesimpulanMCU->konsultasi_poliklinik = $hasilKonsul;
                }

                //if (!empty($hasilrad)){
                ?>
                <div class="control-group">
                    <?php echo CHtml::label('Hasil Konsultasi Poliklinik', '', array('class' => 'control-label')); ?>
                    <div class="controls" style="width:75%;">
                        <?php $this->widget('ext.redactorjs.Redactor', array('attribute' => 'konsultasi_poliklinik', 'model' => $ModKesimpulanMCU, 'toolbar' => 'mini', 'height' => '200px')); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Diagnosis
                </div>
            </div>
            <div class="panel-body">
                <?php

                ?>

                <?php
                $hasilDiagnosis = '';
                if (!empty($modDiagnosis)) {
                    $hasilDiagnosis = $this->renderPartial('_formDiagnosis', array('modDiagnosis' => $modDiagnosis), true);
                }
 
                if (empty($hasilDiagnosis)) {
                    $hasilDiagnosis = '';
                }
 
                if (empty($ModKesimpulanMCU->diagnosis)) {
                    $ModKesimpulanMCU->diagnosis = $hasilDiagnosis;
                }

                //if (!empty($hasilrad)){
                ?>
                <div class="control-group">
                    <?php echo CHtml::label('Hasil Diagnosis', '', array('class' => 'control-label')); ?>
                    <div class="controls" style="width:75%;">
                        <?php $this->widget('ext.redactorjs.Redactor', array('attribute' => 'diagnosis', 'model' => $ModKesimpulanMCU, 'toolbar' => 'mini', 'height' => '200px')); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Jantung Koroner
                </div>
            </div>
            <div class="panel-body">
                <?php

                ?>

                <?php
                $hasilKoroner = '';
                if (!empty($modKoroner)) {
                    $hasilKoroner = $this->renderPartial('_formKoroner', array('modKoroner' => $modKoroner), true);
                }
 
                if (empty($hasilKoroner)) {
                    $hasilKoroner = '';
                }
 
                if (empty($ModKesimpulanMCU->jantung_koroner)) {
                    $ModKesimpulanMCU->jantung_koroner = $hasilKoroner;
                }

                //if (!empty($hasilrad)){
                ?>
                <div class="control-group">
                    <?php echo CHtml::label('Hasil Jantung Koroner', '', array('class' => 'control-label')); ?>
                    <div class="controls" style="width:75%;">
                        <?php $this->widget('ext.redactorjs.Redactor', array('attribute' => 'jantung_koroner', 'model' => $ModKesimpulanMCU, 'toolbar' => 'mini', 'height' => '200px')); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Tes Spirometri
                </div>
            </div>
            <div class="panel-body">
                <?php

                ?>

                <?php
                $hasilSpiro = '';
                if (!empty($modSpirometri)) {
                    $hasilSpiro = $this->renderPartial('_formSpiro', array('modSpirometri' => $modSpirometri), true);
                }
 
                if (empty($hasilSpiro)) {
                    $hasilSpiro = '';
                }
 
                if (empty($ModKesimpulanMCU->tes_spirometri)) {
                    $ModKesimpulanMCU->tes_spirometri = $hasilSpiro;
                }

                //if (!empty($hasilrad)){
                ?>
                <div class="control-group">
                    <?php echo CHtml::label('Hasil Tes Spirometri', '', array('class' => 'control-label')); ?>
                    <div class="controls" style="width:75%;">
                        <?php $this->widget('ext.redactorjs.Redactor', array('attribute' => 'tes_spirometri', 'model' => $ModKesimpulanMCU, 'toolbar' => 'mini', 'height' => '200px')); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Surat Keterangan Sehat
                </div>
            </div>
            <div class="panel-body">
                <?php

                ?>

                <?php
                $hasilSurat = '';
                // echo CJSON::encode($modSurat);
                if (!empty($modSurat)) {
                    $hasilSurat = $this->renderPartial('_formSurat', array('modSurat' => $modSurat), true);
                }
 
                if (empty($hasilSurat)) {
                    $hasilSurat = '';
                }
 
                if (empty($ModKesimpulanMCU->suratketerangan_sehat)) {
                    $ModKesimpulanMCU->suratketerangan_sehat = $hasilSurat;
                }

                //if (!empty($hasilrad)){
                ?>
                <div class="control-group">
                    <?php echo CHtml::label('Hasil Surat Keterangan Sehat', '', array('class' => 'control-label')); ?>
                    <div class="controls" style="width:75%;">
                        <?php $this->widget('ext.redactorjs.Redactor', array('attribute' => 'suratketerangan_sehat', 'model' => $ModKesimpulanMCU, 'toolbar' => 'mini', 'height' => '200px')); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Reseptur
                </div>
            </div>
            <div class="panel-body">
                <?php

                ?>

                <?php
                $hasilReseptur = '';
                // echo CJSON::encode($modReseptur);
                if (!empty($modReseptur)) {
                    $hasilReseptur = $this->renderPartial('_formReseptur', array('modReseptur' => $modReseptur), true);
                }
 
                if (empty($hasilReseptur)) {
                    $hasilReseptur = '';
                }
 
                if (empty($ModKesimpulanMCU->reseptur)) {
                    $ModKesimpulanMCU->reseptur = $hasilReseptur;
                }

                //if (!empty($hasilrad)){
                ?>
                <div class="control-group">
                    <?php echo CHtml::label('Hasil Reseptur', '', array('class' => 'control-label')); ?>
                    <div class="controls" style="width:75%;">
                        <?php $this->widget('ext.redactorjs.Redactor', array('attribute' => 'reseptur', 'model' => $ModKesimpulanMCU, 'toolbar' => 'mini', 'height' => '200px')); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Kesimpulan', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($ModKesimpulanMCU, 'kesimpulanperorangan', array('rows' => 4, 'cols' => 15, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Saran', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($ModKesimpulanMCU, 'saranperorangan', array('rows' => 4, 'cols' => 15, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Catatan', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($ModKesimpulanMCU, 'keterangan_kesimpulanmcu', array('rows' => 4, 'cols' => 15, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row" style="margin-left:2px;">
            <div class="span12">
                <div class="form-actions">
                    <?php
                    if (!isset($_GET['sukses']) || $ModKesimpulanMCU->isNewRecord) {
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan')) . '&nbsp;';
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                        //				echo CHtml::link(Yii::t('mds', '{icon} Print Perorangan', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printMcuPerorangan();return false",'disabled'=>TRUE  ));
                    } else {
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan')) . '&nbsp;';
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info mcu_dalam', 'onclick' => "printMcu();return false", 'disabled' => FALSE)) . '&nbsp;';
                        //				echo CHtml::link(Yii::t('mds', '{icon} Print Perorangan', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printMcuPerorangan();return false",'disabled'=>FALSE  ));
                    }
                    ?>
                    <?php
                    $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.transaksi', array(), true);
                    $this->widget('UserTips', array('type' => 'create', 'content' => $content)); ?>
                </div>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKordinator',
    'options' => array(
        'title' => 'Daftar Kordinator',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'resizable' => false,
    ),
));

$modPegawai = new PegawairuanganV('search');
$modPegawai->unsetAttributes();
$modPegawai->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP;
if (isset($_GET['MCPegawaiM'])) {
    $modPegawai->attributes = $_GET['MCPegawaiM'];
    $modPegawai->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kordinator-m-grid',
    'dataProvider' => $modPegawai->searchDialogPegRuangan(),
    'filter' => $modPegawai,
    'template' => "{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'pegawai_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectBahan",
					"onClick" => "
						$(\'#' . Chtml::activeId($ModKesimpulanMCU, 'kordinator_id') . '\').val(\'$data->pegawai_id\');
						$(\'#kordinator_nama\').val(\'$data->NamaLengkap\');
						$(\'#dialogKordinator\').dialog(\'close\');
						return false;"))',
        ),
        'nama_pegawai',
        'nomorindukpegawai',
        'alamat_pegawai',
        'agama',
        array(
            'name' => 'jeniskelamin',
            'filter' => LookupM::getItems('jeniskelamin'),
            'value' => '$data->jeniskelamin',
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<script>
    /**
     * print status
     */
    function printMcu() {
        window.open('<?php echo $this->createUrl('printMcu', array('kesimpulanmcu_id' => $ModKesimpulanMCU->kesimpulanmcu_id)); ?>', 'printwin', 'left=100,top=100,width=793,height=1122');
    }

    function printMcuLuar() {
        window.open('<?php echo $this->createUrl('printMcuLuar', array('suratstudiluarmcu_id' => $modSuratStudiLuar->suratstudiluarmcu_id)); ?>', 'printwin', 'left=100,top=100,width=793,height=1122');
    }

    function printMcuPerorangan() {
        var tidakdisimpan = $('#tidakdisimpan').find("input,select,textarea").serialize();
        window.open('<?php echo $this->createUrl('printMcuPerorangan', array('kesimpulanmcu_id' => $ModKesimpulanMCU->kesimpulanmcu_id)); ?>&' + tidakdisimpan, 'printwin', 'left=100,top=100,width=793,height=1122');
    }

    function jumlah() {
        var beratBadan = $("#<?php echo CHtml::activeId($ModKesimpulanMCU, 'periksaumum_beratbadan') ?>").val();
        var tinggiBadan = $("#<?php echo CHtml::activeId($ModKesimpulanMCU, 'periksaumum_tinggibadan') ?>").val();
        if (tinggiBadan != "") {
            var tinggiBadanMeter = parseFloat(tinggiBadan) / 100;
            var hasil = Math.round(parseFloat(beratBadan) / (tinggiBadanMeter * tinggiBadanMeter));
        } else {
            var tinggiBadanMeter = 0;
            var hasil = 0;
        }
        $("#<?php echo CHtml::activeId($ModKesimpulanMCU, 'periksaumum_nilaibmi') ?>").val(hasil);
        if (jQuery.isNumeric(hasil)) {
            $.post('<?php echo Yii::app()->createUrl('/actionAjax/getBMIText'); ?>', {
                bmi: hasil
            }, function(data) {
                $('#<?php echo CHtml::activeId($ModKesimpulanMCU, 'periksaumum_bmikategori') ?>').val(data.text);
                $('#<?php echo CHtml::activeId($ModKesimpulanMCU, 'bodymassindex_id') ?>').val(data.id);
            }, 'json');
        }
    }

    function genTekananDarah() {
        var sistolik = $("#<?php echo CHtml::activeId($ModKesimpulanMCU, 'periksaumum_sistolic') ?>").val();
        var diastolik = $("#<?php echo CHtml::activeId($ModKesimpulanMCU, 'periksaumum_diastolic') ?>").val();

        if (sistolik != '' && diastolik != '') {
            var tekanandarah = sistolik + '/' + diastolik;
            $("#<?php echo CHtml::activeId($ModKesimpulanMCU, 'periksaumum_tekanandarah') ?>").val(tekanandarah);
        } else {
            $("#<?php echo CHtml::activeId($ModKesimpulanMCU, 'periksaumum_tekanandarah') ?>").val('');
        }
    }
</script>
<?php $this->renderPartial('_jsFunctions', array()); ?>