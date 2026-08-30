<div class="row-fluid">
    <div class="span6">
        <div class="control-group ">
            <label class="control-label">
                <?php
                echo CHtml::radioButton('radio_nomorkartu_fktl_1', false, array(
                    'value' => 'radio_nomorkartu_fktl_1',
                    'onclick' => 'setPencarianFktl_1(this);',
                    'id' => 'radio_nomorkartu_fktl_1',
                    'uncheckValue' => null
                )) . " Nomor Kartu Peserta";
                ?>
            </label>
            <div class="controls">
                <?php echo CHtml::textField('nomorkartupeserta_fktl_1', '', array('placeholder' => 'Nomor Kartu Peserta', 'disabled' => true, 'class' => 'span3')); ?>
                <?php echo CHtml::htmlButton(
                    '<i class="entypo-search"></i>',
                    array(
                        'onclick' => 'cariDataRujukanBpjsFktl_1(7);return false;',
                        'class' => 'btn btn-primary btn-nomorkartu_fktl_1',
                        'onkeypress' => "cariDataRujukanBpjsFktl_1(7);return false;",
                        'rel' => "tooltip",
                        'title' => "Klik untuk mencari data Rujukan BPJS berdasarkan Nomor Kartu Peserta",
                    )
                ); ?>
            </div>
        </div>
    </div>
</div>