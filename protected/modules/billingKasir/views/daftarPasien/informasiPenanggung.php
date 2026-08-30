<fieldset>
        <table style="width: 100%; border: none;">
            <tbody>
                <tr>
                    <td width="20%">
                        <?php echo CHtml::label($model->getAttributeLabel('nama_pj'),$model->getAttributeLabel('nama_pj'));?>
                    </td>
                    <td width="30%">:&nbsp;
                        <?php echo CHtml::label($model->nama_pj, $model->nama_pj);?>
                    </td>
                </tr>
                <tr>
                    <td width="20%">
                        <?php echo CHtml::label($model->getAttributeLabel('pengantar'),$model->getAttributeLabel('pengantar'));?>
                    </td>
                    <td width="30%">:&nbsp;
                        <?php echo CHtml::label($model->pengantar, $model->pengantar);?>
                    </td>
                </tr>
                <tr>
                    <td width="20%">
                        <?php echo CHtml::label($model->getAttributeLabel('hubungankeluarga'),$model->getAttributeLabel('hubungankeluarga'));?>
                    </td>
                    <td width="30%">:&nbsp;
                        <?php echo CHtml::label($model->hubungankeluarga, $model->hubungankeluarga);?>
                    </td>
                </tr>
                <tr>
                    <td width="20%">
                        <?php echo CHtml::label($model->getAttributeLabel('alamat_pj'),$model->getAttributeLabel('alamat_pj'));?>
                    </td>
                    <td width="30%">:&nbsp;
                        <?php echo CHtml::label($model->alamat_pj, $model->alamat_pj);?>
                    </td>
                </tr>
                <tr>
                    <td width="20%">
                        <?php echo CHtml::label($model->getAttributeLabel('no_teleponpj'),$model->getAttributeLabel('no_teleponpj'));?> / 
                        <?php echo CHtml::label($model->getAttributeLabel('no_mobilepj'),$model->getAttributeLabel('no_mobilepj'));?>
                    </td>
                    <td width="30%">:&nbsp;
                        <?php echo CHtml::label($model->no_teleponpj, $model->no_teleponpj);?> / 
                        <?php echo CHtml::label($model->no_mobilepj, $model->no_mobilepj);?>
                    </td>
                </tr>
            </tbody>
        </table>
</fieldset>
<?php
$this->widget('bootstrap.widgets.BootAlert'); ?>