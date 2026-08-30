
<div class="row-fluid"> 
    <table style="width: 100%">
        <?php
        $modDet = LookupM::model()->findAll("lookup_type = 'intervensi_keperawatan_hd' AND lookup_aktif = true ORDER BY lookup_name");
        $i = 0;
        $no = 0;
        $value = '<tr>';
        foreach ($modDet as $item) {
            $i++;
            $value .= '<td>' . CHtml::checkBox('IntervensiKeperawatanPreHdT[' . $no . '][is_ceklis]', 0, array('class' => 'pilihcheck_' . $item->lookup_name)) . ' &nbsp; <label>' . $item->lookup_name . '</label></td>';
            $value .= '<td style="padding:2px;">' .
                    CHtml::hiddenField('IntervensiKeperawatanPreHdT[' . $no . '][nama_intervensi_keperawatan_pre]', $item->lookup_name, array('class' => 'span1')) .
                    '</td>';
            if ($i == 3) {
                $value .= '</tr><tr>';
                $i = 0;
            }
            $no++;
        }
        $value .= '</tr>';

        echo $value;
        ?>
    </table>
    <hr>
    <div class="control-group">
        <?php echo $form->labelEx($modIntervensiKeperawatan, 'nama_intervensi_keperawatan_pre_lainnya', array('class' => 'control-label', 'label' => 'Lainnya')); ?>
        <div class="controls">
            <?php echo $form->textField($modIntervensiKeperawatan, '[lainnya]nama_intervensi_keperawatan_pre_lainnya', array('class' => 'span3')); ?>
        </div>
    </div>  
</div>
