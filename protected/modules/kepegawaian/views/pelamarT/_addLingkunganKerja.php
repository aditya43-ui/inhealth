<?php
if (isset($modLingkunganKerjas)) {
    foreach ($modLingkunganKerjas as $i => $modLingkunganKerja) {
        $no = $i + 1;

?>
        <tr>
            <td><?php echo $form->textField($modLingkunganKerja, "[$i]nourut", array('class' => 'span1', 'readonly' => true)); ?></td>
            <td><?php echo $form->dropDownList($modLingkunganKerja, "[$i]dgnlingkungan", CHtml::listData($modLingkunganKerja->denganLingkungan, 'lookup_name', 'lookup_name'), array('class' => 'span3 isDetailReq2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'empty' => ' -- Pilih -- ')); ?></td>
            <td><?php echo $form->textArea($modLingkunganKerja, "[$i]keterangan", array('rows' => 2, 'cols' => 30, 'class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?></td>
            <td width="5%">

            </td>
        </tr>
    <?php }
} else {
    ?>

    <tr>
        <td><?php echo $form->textField($modLingkunganKerja, '[0]nourut', array('class' => 'span1', 'readonly' => true)); ?></td>
        <td><?php echo $form->dropDownList($modLingkunganKerja, '[0]dgnlingkungan', CHtml::listData($modLingkunganKerja->denganLingkungan, 'lookup_name', 'lookup_name'), array('class' => 'span3 isDetailReq2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'empty' => ' -- Pilih -- ')); ?></td>
        <td><?php echo $form->textArea($modLingkunganKerja, '[0]keterangan', array('placeholder' => 'Keterangan', 'rows' => 2, 'cols' => 30, 'class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?></td>
        <td width="5%">
            <?php
            echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick' => 'addRowLingkunganKerja(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk menambah tindakan'));
            if ($btnHapus == true) {
                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick' => 'batalLingkunganKerja(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk membatalkan tindakan'));
            }
            ?>
        </td>
    </tr>
<?php } ?>