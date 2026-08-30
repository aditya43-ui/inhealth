<tr>
    <td>
        <?php echo CHtml::activeHiddenField($modDetail, 'resepturdetail_id'); ?>
        <?php echo CHtml::activeHiddenField($modDetail, 'sumberdana_id'); ?>
        <?php echo CHtml::activeHiddenField($modDetail, 'obatalkes_id'); ?>
        <?php echo CHtml::activeHiddenField($modDetail, 'permintaan_reseptur'); ?>
        <?php echo CHtml::activeHiddenField($modDetail, 'jmlkemasan_reseptur'); ?>
        <?php echo CHtml::activeHiddenField($modDetail, 'kekuatan_reseptur'); ?>
        <?php echo CHtml::activeHiddenField($modDetail, 'qty_reseptur'); ?>
        <?php echo CHtml::activeHiddenField($modDetail, 'rke'); ?>
        <?php echo CHtml::activeHiddenField($modDetail, 'signa_reseptur'); ?>
        <?php echo CHtml::activeHiddenField($modDetail, 'etiket'); ?>
        <?php echo "R/"; ?>
    </td>
    <td>
        <?php echo $modDetail->rke; ?>
    </td>
    <td>
        <?php echo $modDetail->obatalkes->obatalkes_kode; ?> / <?php echo $modDetail->obatalkes->obatalkes_nama; ?>
    </td>
    <td>
        <?php echo $modDetail->sumberdana->sumberdana_nama; ?>
    </td>
    <td>
        <?php echo $modDetail->satuankecil->satuankecil_nama; ?>
    </td>
    <td>
        <?php echo $modDetail->qty_reseptur; ?>
    </td>
    <td>
        <?php echo isset($modDetail->permintaan_reseptur)?$modDetail->permintaan_reseptur:'-'; ?>
    </td>
    <td>
        <?php echo isset($modDetail->jmlkemasan_reseptur)?$modDetail->jmlkemasan_reseptur:'-'; ?>
    </td>
    <td>
        <?php echo isset($modDetail->kekuatan_reseptur)?$modDetail->kekuatan_reseptur:'-'; ?>
    </td>
    <td>
        <?php echo isset($modDetail->signa_reseptur)?$modDetail->signa_reseptur:'-'; ?>
    </td>
    <td>
        <?php echo isset($modDetail->etiket)?$modDetail->etiket:'-'; ?>
    </td>


</tr>
