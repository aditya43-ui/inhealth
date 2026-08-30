<div class="row-fluid">
    <div class="span4">
        <div class="control-group ">
            <label class="control-label">
                <?php
                echo CHtml::radioButton('radio_nomorrujukan_fktl', false, array(
                    'value' => 'radio_nomorrujukan_fktl',
                    'onclick' => 'setPencarianFktl(this);',
                    'id' => 'radio_nomorrujukan_fktl',
                    'uncheckValue' => null
                )) . " Nomor Rujukan";
                ?>
            </label>
            <div class="controls">
                <?php echo CHtml::textField('nomorrujukan_fktl', '', array('disabled' => true, 'class' => 'span3')); ?>
                <?php echo CHtml::htmlButton(
                    '<i class="entypo-search"></i>',
                    array(
                        'onclick' => 'cariDataRujukanBpjsFktl();return false;',
                        'class' => 'btn btn-primary btn-nomorrujukan_fktl',
                        'onkeypress' => "cariDataRujukanBpjsFktl(this);return false;",
                        'rel' => "tooltip",
                        'title' => "Klik untuk mencari data Rujukan BPJS berdasarkan Nomor Rujukan",
                    )
                ); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">
                <?php
                echo CHtml::radioButton('radio_nomorkartu_fktl', false, array(
                    'value' => 'radio_nomorkartu_fktl',
                    'onclick' => 'setPencarianFktl(this);',
                    'id' => 'radio_nomorkartu_fktl',
                    'uncheckValue' => null
                )) . " Nomor Kartu Peserta";
                ?>
            </label>
            <div class="controls">
                <?php echo CHtml::textField('nomorkartupeserta_fktl', '', array('disabled' => true, 'class' => 'span3')); ?>
                <?php echo CHtml::htmlButton(
                    '<i class="entypo-search"></i>',
                    array(
                        'onclick' => 'cariDataRujukanBpjsFktl();return false;',
                        'class' => 'btn btn-primary btn-nomorkartu_fktl',
                        'onkeypress' => "cariDataRujukanBpjsFktl(this);return false;",
                        'rel' => "tooltip",
                        'title' => "Klik untuk mencari data Rujukan BPJS berdasarkan Nomor Kartu Peserta",
                    )
                ); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">
                <?php
                echo CHtml::radioButton('radio_tglrujukan_fktl', false, array(
                    'value' => 'radio_tglrujukan_fktl',
                    'onclick' => 'setPencarianFktl(this);',
                    'id' => 'radio_tglrujukan_fktl',
                    'uncheckValue' => null
                )) . " Tanggal Rujukan";
                ?>
            </label>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'name' => 'tglrujukan_fktl',
                    'mode' => 'date',
                    'options' => array(
                        //							'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
                <?php echo CHtml::htmlButton(
                    '<i class="entypo-search"></i>',
                    array(
                        'onclick' => 'cariDataRujukanBpjsFktl();return false;',
                        'class' => 'btn btn-primary btn-tglrujukan_fktl',
                        'onkeypress' => "cariDataRujukanBpjsFktl(this);return false;",
                        'rel' => "tooltip",
                        'title' => "Klik untuk mencari data Rujukan BPJS berdasarkan Tanggal Rujukan",
                    )
                ); ?>
            </div>
        </div>
    </div>
    <div class="span4"></div>
    <div class="span4"></div>
</div>