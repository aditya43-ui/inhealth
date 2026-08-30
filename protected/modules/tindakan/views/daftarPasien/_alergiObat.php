<fieldset class="box">
    <legend class="rim">Data Pasien</legend>
    <table style="width: 100%; border: none;">
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran',array('class'=>'control-label')); ?>
                <?php echo CHtml::activeHiddenField($modPendaftaran, 'pendaftaran_id',array('class'=>'control-label')); ?>
                <?php
                    if (!empty($modPasienPulang)){
                        echo CHtml::activeHiddenField($modPasienPulang,'tglpasienpulang',array('class'=>'span3 realtime', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true));
                        echo CHtml::activeHiddenField($modPasienPulang,'pendaftaran_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true));
                        echo CHtml::activeHiddenField($modPasienPulang,'pasien_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true));
                        echo CHtml::activeHiddenField($modPasienPulang,'carakeluar_id',array('value'=>Params::CARAKELUAR_ID_RAWATINAP, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true));
                        echo CHtml::activeHiddenField($modPasienPulang,'kondisikeluar_id',array('value'=>Params::KONDISIKELUAR_ID_RAWATINAP, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true));
                        echo CHtml::activeHiddenField($modPasienPulang,'lamarawat',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true));
                    }
                ?>
            </td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly'=>true)); ?></td>
            <td rowspan="4">
                <?php 
                    if(!empty($modPasien->photopasien)){
                        echo CHtml::image(Params::urlPhotoPasienDirectory().$modPasien->photopasien, 'Foto pasien', array('width'=>120));
                    } else {
                        echo CHtml::image(Params::urlPhotoPasienDirectory().'no_photo.jpeg', 'Foto pasien', array('width'=>120));
                    }
                ?> 
            </td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id',array('class'=>'control-label')); ?></td>
            <td>
                <?php echo CHtml::activeTextField($modPendaftaran->jeniskasuspenyakit, 'jeniskasuspenyakit_nama', array('readonly'=>true)); ?>
                <?php echo CHtml::activeHiddenField($modPendaftaran, 'kelaspelayanan_id', array('readonly'=>true)); ?>
                <?php echo CHtml::activeHiddenField($modPendaftaran, 'carabayar_id', array('readonly'=>true)); ?>
            </td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_bin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'nama_bin', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran->dokter, 'dokter_pemeriksa', array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran->dokter, 'nama_pegawai', array('readonly'=>true)); ?></td>

            <td><?php echo CHtml::activeLabel($modPendaftaran->kelaspelayanan, 'kelaspelayanan_nama', array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran->kelaspelayanan, 'kelaspelayanan_nama', array('readonly'=>true)); ?></td>
        </tr>        
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>

            <td><?php echo CHtml::activeLabel($modPasien, 'alamat_pasien', array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'alamat_pasien', array('readonly'=>true)); ?></td>
        </tr>        
    </table>
</fieldset>

<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'rjpasienadmisi-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);','onsubmit'=>'return requiredCheck(this);'),
)); 
?>
<div class="block-tabel">
    <h6>Riwayat <b>Alergi Obat</b></h6>
    <div class="row">
	<table class="items table table-striped table-condensed">
		<thead>
			<tr>
				<th> No. </th>
				<th> Nama Obat </th>
			</tr>
		</thead>
		<tbody>
			<?php
				if(!empty($modAnamnesa)){
					foreach($datatable as $key => $value){
						echo 
						'<tr>
							<td width="5%"><p style="margin: 0; text-align: center;">'.($key+1).'</p></td>
							<td>'.$value.'</td>
						</tr>';
						
					}
				}else{
					echo '<tr><td colspan="4"> Data tidak ditemukan </td></tr>';
				}
			?>
		</tbody>
	</table>
    </div>
</div>
<div class="form-actions">
	<?php 
//	echo CHtml::link(Yii::t('mds','Tutup',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 'javascript:void(0);' ,
//                                array('class' => 'btn btn-default',
//                                    'onclick'=>'closeDialog(); return false;'));  
	?>
</div>

<?php $this->endWidget(); ?>

<script>
function closeDialog(){
	$('#dialogAlergiObat').dialog('close');
}

$(document).ready(function(){
    
});
</script>