<?php
/**
* - digunakan untuk untuk generate data CGS
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
?>

	<tr>
		<td colspan="4">
			<div class="control-group">
					<?php echo $form->labelEx($modAsesTriase,'gcs_nilai', array('class'=>'control-label','style'=>'text-align:left;width:70px;')) ?>
				<div class="controls">
					<?php echo$modAsesTriase->gcs_nilai; ?>
				</div>
			</div>
			
			<table class="table noborder paddingtext">
				<tr>
					<td>Mata</td>
					<td>Verbal</td>
					<td>Motorik</td>
				</tr>
				<tr>
					<td>
						<table class="table noborder paddingtext">
							
							<?php
								$crit = new CDbCriteria();
								$crit->compare('LOWER(metodegcs_singkatan)',"e");
								$crit->addCondition('metodegcs_nilai is not null');
								$crit->order = 'metodegcs_nilai ASC';
								
								$eye = RJMetodeGCSM::model()->findAll($crit);
							
								foreach ($eye as $dt){
									$st = false;
									if ($dt->metodegcs_nilai == $modAsesTriase->gcs_eye){
										$st = true;
									}
							?>
							<tr>
								<td style="vertical-align: top;"><?php echo CHtml::radioButton("eye",$st); ?> <label></label></td>
								<td><?php echo $dt->textMetodeGCSM; ?></td>
							</tr>
							<?php																		
								}
							?>
							
						</table>
					</td>					
					<td>
						<table class="table noborder paddingtext">
						<?php
								$crit3 = new CDbCriteria();
								$crit3->compare('LOWER(metodegcs_singkatan)',"v");
								$crit3->addCondition('metodegcs_nilai is not null');
								$crit3->order = 'metodegcs_nilai ASC';
								
								$verbal = RJMetodeGCSM::model()->findAll($crit3);
							
								foreach ($verbal as $dt2){
									$st2 = false;
									if ($dt2->metodegcs_nilai == $modAsesTriase->gcs_verbal){
										$st2 = true;
									}
							?>
							<tr>
								<td style="vertical-align: top;"><?php echo CHtml::radioButton("verbal",$st2); ?><label></label></td>
								<td><?php echo $dt2->textMetodeGCSM; ?></td>
							</tr>
							<?php																		
								}
							?>
						</table>						
					</td>
					<td>
						<table class="table noborder paddingtext">
						<?php
								$crit2 = new CDbCriteria();
								$crit2->compare('LOWER(metodegcs_singkatan)',"m");
								$crit2->addCondition('metodegcs_nilai is not null');
								$crit2->order = 'metodegcs_nilai ASC';
								
								$motorik = RJMetodeGCSM::model()->findAll($crit2);
							
								foreach ($motorik as $dt3){
									$st3 = false;
									if ($dt3->metodegcs_nilai == $modAsesTriase->gcs_motorik){
										$st3 = true;
									}
							?>
							<tr>
								<td style="vertical-align: top;"><?php echo CHtml::radioButton("motorik",$st3); ?> <label></label></td>
								<td><?php echo $dt3->textMetodeGCSM; ?></td>
							</tr>
							<?php																		
								}
							?>
						</table>								
					</td>
				</tr>
			</table>
	</tr>

