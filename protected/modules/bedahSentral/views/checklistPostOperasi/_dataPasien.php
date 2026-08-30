<?php
$modPasien->nama_pasien = $modPasien->namadepan.$modPasien->nama_pasien;
$modPasien->tanggal_lahir = MyFormatter::formatDateTImeForUser($modPasien->tanggal_lahir);

?>
<?php
if(!empty($modPasien)){
?>

    <div class="panel panel-primary panel-success">
        <div class="panel-heading">
            <div class="panel-title">Data Pasien</div>
        </div>
        <div class="panel-body">
            <table width="100%">
              <tr>
                <td width="50%" valign="top">
                  <table width="100%">
                    <tr>
                      <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien',array('class'=>'control-label')); ?></td>
                      <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly'=>true)); ?></td>
                    </tr>
                    <tr>
                      <td><?php echo CHtml::activeLabel($modPasien, 'tanggal_lahir',array('class'=>'control-label')); ?></td>
                      <td><?php echo CHtml::activeTextField($modPasien, 'tanggal_lahir', array('readonly'=>true)); ?></td>
                    </tr>
                    <tr>
                      <td  valign="top"><?php echo CHtml::activeLabel($modPasien, 'alamat_pasien',array('class'=>'control-label')); ?></td>
                      <td><?php echo CHtml::activeTextarea($modPasien, 'alamat_pasien', array('readonly'=>true,'cols'=>100,'rows'=>6)); ?></td>
                    </tr>
                  </table>
                </td>
                <td width="50%" valign="top">
                  <table width="100%">
                    <tr>
                      <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik',array('class'=>'control-label')); ?></td>
                      <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly'=>true)); ?></td>
                    </tr>
                    <tr>
                      <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin',array('class'=>'control-label')); ?></td>
                      <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly'=>true)); ?></td>
                    </tr>
                    <tr>
                      <td valign="top"><?php echo CHtml::activeLabel($modPendaftaran, 'umur',array('class'=>'control-label')); ?></td>
                      <td valign="top"><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly'=>true)); ?></td>
                    </tr>
                    <tr>
                      <td  valign="top"><?php echo CHtml::label('Diagnosa', '',array('class'=>'control-label')); ?></td>
                      <td><?php echo CHtml::activeTextarea($model, 'diagnosa', array('readonly'=>true,'cols'=>100,'rows'=>6)); ?></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
        </div>
    </div>
<?php
} else {
    Yii::app()->user->setFlash('error',"Tidak ada pasien");
    $this->widget('bootstrap.widgets.BootAlert');
}
?>
