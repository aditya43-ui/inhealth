<?php
$this->widget('bootstrap.widgets.BootAlert');
?>

<table style="width: 100%; border: none;">
    <tr>
        <td>
<table style="width: 100%; border: none;">
                <tr>
                    <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly' => true)); ?></td>
                </tr>
            </table>
        </td>
        <td>
            <p style="margin: 0; text-align: center;">
                <?php
                if (!empty($modPasien->photopasien)) {
                    echo CHtml::image(Params::urlPhotoPasienDirectory() . $modPasien->photopasien, 'Foto pasien', array('width' => 120));
                } else {
                    echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'Foto pasien', array('width' => 120));
                }
                ?>
            </p>
        </td>
    </tr>
</table>



<style>
    .table thead tr th {
        vertical-align: middle;
    }
</style>