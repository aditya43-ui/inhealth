<?php

if (empty($is_confirm)) {
    $is_confirm = false;
}

if (!empty($modJenis->jumlahpembayaran)) {
    $modJenis->jumlahpembayaran = MyFormatter::formatNumberForPrint($modJenis->jumlahpembayaran);
}

?>

<tr data-idx="<?php echo $i; ?>" class="row_main <?php echo $is_confirm ? "ada_data" : ""; ?>">
    <td>
        <div class="control-group">
            <label class="control-label"><?php echo $modJenis->getAttributeLabel('pemilikakun_nama'); ?><span class="required">*</span></label>
            <div class="controls">
                <?php echo CHtml::activeHiddenField($modJenis, '[detail]['.$i.']no_order', array('class'=>'no_order')); ?>
                <?php echo CHtml::activeTextField($modJenis, '[detail]['.$i.']pemilikakun_nama', array('class'=>'span3 pemilikakun_nama',
                    'readonly'=>$is_confirm)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><?php echo $modJenis->getAttributeLabel('pemilikakun_notelp'); ?><span class="required">*</span></label>
            <div class="controls">
                <?php echo CHtml::activeTextField($modJenis, '[detail]['.$i.']pemilikakun_notelp', array('class'=>'span3 pemilikakun_notelp',
                    'readonly'=>$is_confirm, 'placeholder'=>'Nomor yang terhubung ke Akun')); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><?php echo $modJenis->getAttributeLabel('pemilikakun_alamatemail'); ?><span class="required">*</span></label>
            <div class="controls">
                <?php echo CHtml::activeTextField($modJenis, '[detail]['.$i.']pemilikakun_alamatemail', array('class'=>'span3 pemilikakun_alamatemail',
                    'readonly'=>$is_confirm, 'placeholder'=>'Email yang terhubung ke Akun')); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><?php echo $modJenis->getAttributeLabel('jumlahpembayaran'); ?><span class="required">*</span></label>
            <div class="controls">
                <?php echo CHtml::activeTextField($modJenis, '[detail]['.$i.']jumlahpembayaran', array('class'=>'span2 integer-decimal_old integer2 main_nominal',
                    'readonly'=>$is_confirm, 'onblur'=>'cekBayarBank(this);')); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="controls">
                <?php echo CHtml::htmlButton('Konfirmasi', array(
                    'class'=>'btn btn-info btn_konfirmasi '.($is_confirm ? "hidden" : ""),
                    'onclick'=>'konfirmasiBayar(this);',
                )); ?>
                <?php echo CHtml::htmlButton('Sudah Dikonfirmasi', array(
                    'class'=>'btn btn-green btn_sudah_konfirmasi '.(!$is_confirm ? "hidden" : ""),
                )); ?>
            </div>
        </div>
    </td>
    <td>
        <?php
        if (!$is_confirm) {
            echo CHtml::link('<i class="entypo-minus"></i>', '#', array(
                'onclick'=>'hapusBayarGateway(this); return false;',
                'class'=>'btn btn-red btn_hapus'
            )); 
        }
        ?>
    </td>
</tr>