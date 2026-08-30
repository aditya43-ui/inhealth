<div class="row-fluid">
    <div class="span6">
        <div class="control-group ">
            <label class="control-label">Tanggal</label>
            <div class="controls">
                <?php
                    $this->widget('MyDateTimePicker', array(
                        'name' => 'tgl_sep',
                        'value' => MyFormatter::formatDateTimeForUser(date('Y-m-d')),
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'showOn' => false,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('class' => 'dtPicker2 span3', 'onkeyup' => "return $(this).focusNextInputField(event)",),
                    )); 
                ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">
                <?php
                echo CHtml::radioButton('radio_nomorkartu', false, array(
                    'value' => 'radio_nomorkartu',
                    'onclick' => 'setPencarian(this);',
                    'id' => 'radio_nomorkartu',
                    'uncheckValue' => null
                )) . " Nomor Kartu Peserta";
                ?>
            </label>
            <div class="controls">
                <?php echo CHtml::textField('nomorkartupeserta', '', array('placeholder' => 'Nomor Kartu Peserta', 'disabled' => true, 'class' => 'span3')); ?>
                <?php echo CHtml::htmlButton(
                    '<i class="entypo-search"></i>',
                    array(
                        'onclick' => 'cariPesertaBpjsNoKartu();return false;',
                        'class' => 'btn btn-primary btn-nomorkartu',
                        'onkeypress' => "cariPesertaBpjsNoKartu(this);return false;",
                        'rel' => "tooltip",
                        'title' => "Klik untuk mencari data peserta BPJS berdasarkan Nomor Kartu Peserta BPJS",
                    )
                ); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">
                <?php
                echo CHtml::radioButton('radio_nik', false, array(
                    'value' => 'radio_nik',
                    'onclick' => 'setPencarian(this);',
                    'id' => 'radio_nik',
                    'uncheckValue' => null
                )) . " NIK";
                ?>
            </label>
            <div class="controls">
                <?php echo CHtml::textField('nik', '', array('placeholder' => 'NIK', 'disabled' => true, 'class' => 'span3')); ?>
                <?php echo CHtml::htmlButton(
                    '<i class="entypo-search"></i>',
                    array(
                        'onclick' => 'cariPesertaBpjsNIK();return false;',
                        'class' => 'btn btn-primary btn-nik',
                        'onkeypress' => "cariPesertaBpjsNIK(this);return false;",
                        'rel' => "tooltip",
                        'title' => "Klik untuk mencari data peserta BPJS berdasarkan Nomor Induk Kependudukan (NIK)",
                    )
                ); ?>
            </div>
        </div>
    </div>

</div>