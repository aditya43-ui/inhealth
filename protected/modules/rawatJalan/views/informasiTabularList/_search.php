<table style="width: 100%; border: none;">
        <tr>
            <td>
                <?php echo $form->textFieldRow($modDTDM,'dtd_kode',array('class'=>'span3','maxlength'=>10)); ?>
                <?php echo $form->textFieldRow($modDTDM,'dtd_nama',array('class'=>'span3','maxlength'=>50)); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($modDTDM,'dtd_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>
                <?php echo $form->textFieldRow($modDTDM,'dtd_katakunci',array('class'=>'span3','maxlength'=>50)); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($modDTDM,'dtd_nourut',array('class'=>'span3')); ?>
                <?php echo $form->checkBoxRow($modDTDM,'dtd_menular'); ?>
            </td>
        </tr>
</table>