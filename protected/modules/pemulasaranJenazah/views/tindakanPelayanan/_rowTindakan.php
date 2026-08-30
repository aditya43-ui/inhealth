<tr>
    <td>
        <?php echo CHtml::textField('no_urut', 0, array('class' => 'un-integer', 'style' => 'width:30px', 'readonly' => true)); ?>
        <?php echo CHtml::hiddenField('row', 0, array('class' => 'span1', 'style' => 'width:30px', 'readonly' => true)); ?>
    </td>
    <td>
        <?php echo $form->dropDownList($modTindakan, '[ii]ruangan_id', (CHtml::listData($modTindakan->getRuangans($modTindakan->instalasi_id), 'ruangan_id', 'ruangan_nama')), array('onchange' => 'setRowReset(this);', 'style' => 'width:185px')); ?>
    </td>
    <td>
        <?php echo $form->textField($modTindakan, '[ii]kategoritindakan_nama', array('class' => 'span2', 'readonly' => true)); ?>
    </td>
    <td>
        <?php echo $form->hiddenField($modTindakan, '[ii]daftartindakan_id', array('readonly' => true)) ?>
        <?php $this->widget('MyJuiAutoComplete', array(
            'model' => $modTindakan,
            'attribute' => '[ii]daftartindakan_nama',
            'tombolDialog' => array('idDialog' => 'dialog_tindakan', 'jsFunction' => "setDialogTindakan(this);"),
            'htmlOptions' => array('placeholder' => 'Uraian Tindakan', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required'),
        )); ?>
    </td>
    <td>
        <?php echo $form->textField($modTindakan, '[ii]tarif_satuan', array('class' => 'un-integer', 'style' => 'width:100px;', 'readonly' => true)); ?>
        <?php echo $form->hiddenField($modTindakan, '[ii]jenistarif_id', array('class' => 'un-integer', 'style' => 'width:100px;', 'readonly' => true)); ?>
    </td>
    <td>
        <?php echo $form->textField($modTindakan, '[ii]qty_tindakan', array('onblur' => 'hitungTarifTindakan();', 'class' => 'un-integer', 'style' => 'width:50px;', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
    </td>
    <td>
        <?php echo $form->dropDownList($modTindakan, '[ii]satuantindakan', (LookupM::getItems('satuantindakan')), array('style' => 'width:100px;', 'readonly' => true)); ?>
    </td>
    <td>
        <?php echo $form->dropDownList($modTindakan, '[ii]cyto_tindakan', array(0 => "Tidak", 1 => "Ya"), array('onchange' => 'hitungTarifTindakan();', 'style' => 'width:50px;', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
    </td>
    <td>
        <?php echo $form->hiddenField($modTindakan, '[ii]persencyto_tindakan', array('class' => 'un-integer', 'style' => 'width:100px;', 'readonly' => true)); ?>
        <?php echo $form->textField($modTindakan, '[ii]tarifcyto_tindakan', array('class' => 'un-integer', 'style' => 'width:100px;', 'readonly' => true)); ?>
    </td>
    <td>
        <?php echo $form->textField($modTindakan, '[ii]subtotal', array('class' => 'un-integer', 'style' => 'width:100px;', 'readonly' => true)); ?>
    </td>
    <td rowspan="2">
        <?php
        $is_adatombolhapus = (isset($is_adatombolhapus) ? $is_adatombolhapus : false);
        echo CHtml::link('<i class="icon-plus"></i>', 'javascript:void(0);', array('onclick' => 'tambahTindakan();return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk menambah tindakan'));
        if ($is_adatombolhapus) {
            echo "<br><br>";
            echo CHtml::link("<i class=\"icon-minus\"></i>", 'javascript:void(0);', array('onclick' => 'batalTindakan(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk membatalkan tindakan'));
        }
        ?>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <div class="input-append"><?php echo CHtml::activeTextField($modTindakan, '[ii]tgl_tindakan', array('class' => 'datetimemask', 'style' => 'float: left; width: 140px;', 'value' => date('d/m/Y H:i:s'), 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?><span class="add-on"><i class="entypo-calendar"></i><i class="icon-time"></i></span></div>
    </td>
    <td style="text-align: right;"><b><?php echo CHtml::link('Lihat Pemeriksa <i class="icon-chevron-down"></i>', 'javascript:void(0);', array('onclick' => 'tampilkanPemeriksaLain(this);', 'rel' => 'tooltip', 'title' => 'Klik untuk menampilkan pemeriksa lain')); ?>:</b></td>
    <td colspan="4">
        <div class="row">
            <div class="col-sm-5">
                <?php $this->widget('MyJuiAutoComplete', array(
                    'model' => $modTindakan,
                    'attribute' => '[ii]dokterpemeriksa1_nama',
                    'tombolDialog' => array('idDialog' => 'dialog_dokter', 'jsFunction' => "setDialogDokter(this,'Dokter Pemeriksa 1 (satu)');"),
                    'htmlOptions' => array(
                        'placeholder' => 'Dokter Pemeriksa 1 (satu)', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 autocomplete-dokter', 'style' => 'float:left;',
                        'onblur' => 'if($(this).val() == ""){$(this).parents("td").find("input[name$=\"[dokterpemeriksa1_id]\"]").val("");}',
                    ),
                )); ?>
                <?php echo CHtml::activeHiddenField($modTindakan, '[ii]dokterpemeriksa1_id', array('readonly' => true)) //<< posisi jangan di ubah
                ?>
                <div class="dokter-lengkap" style="display:none;">
                    <?php $this->widget('MyJuiAutoComplete', array(
                        'model' => $modTindakan,
                        'attribute' => '[ii]dokterpemeriksa2_nama',
                        'tombolDialog' => array('idDialog' => 'dialog_dokter', 'jsFunction' => "setDialogDokter(this,'Dokter Pemeriksa 2 (dua)');"),
                        'htmlOptions' => array(
                            'placeholder' => 'dokter pemeriksa 2 (dua)', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 autocomplete-dokter', 'style' => 'float:left;',
                            'onblur' => 'if($(this).val() == ""){$(this).parents("td").find("input[name$=\"[dokterpemeriksa2_id]\"]").val("");}',
                        ),
                    )); ?>
                    <?php echo CHtml::activeHiddenField($modTindakan, '[ii]dokterpemeriksa2_id', array('readonly' => true)) //<< posisi jangan di ubah
                    ?>
                    <?php $this->widget('MyJuiAutoComplete', array(
                        'model' => $modTindakan,
                        'attribute' => '[ii]dokterpendamping_nama',
                        'tombolDialog' => array('idDialog' => 'dialog_dokter', 'jsFunction' => "setDialogDokter(this,'Dokter Pendamping');"),
                        'htmlOptions' => array(
                            'placeholder' => 'dokter pendamping', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 autocomplete-dokter', 'style' => 'float:left;',
                            'onblur' => 'if($(this).val() == ""){$(this).parents("td").find("input[name$=\"[dokterpendamping_id]\"]").val("");}',
                        ),
                    )); ?>
                    <?php echo CHtml::activeHiddenField($modTindakan, '[ii]dokterpendamping_id', array('readonly' => true)) //<< posisi jangan di ubah
                    ?>
                    <?php $this->widget('MyJuiAutoComplete', array(
                        'model' => $modTindakan,
                        'attribute' => '[ii]dokteranastesi_nama',
                        'tombolDialog' => array('idDialog' => 'dialog_dokter', 'jsFunction' => "setDialogDokter(this,'Dokter Anastesi');"),
                        'htmlOptions' => array(
                            'placeholder' => 'dokter anastesi', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 autocomplete-dokter', 'style' => 'float:left;',
                            'onblur' => 'if($(this).val() == ""){$(this).parents("td").find("input[name$=\"[dokteranastesi_id]\"]").val("");}',
                        ),
                    )); ?>
                    <?php echo CHtml::activeHiddenField($modTindakan, '[ii]dokteranastesi_id', array('readonly' => true)) //<< posisi jangan di ubah
                    ?>
                    <?php $this->widget('MyJuiAutoComplete', array(
                        'model' => $modTindakan,
                        'attribute' => '[ii]dokterdelegasi_nama',
                        'tombolDialog' => array('idDialog' => 'dialog_dokter', 'jsFunction' => "setDialogDokter(this,'Dokter Delegasi');"),
                        'htmlOptions' => array(
                            'placeholder' => 'dokter delegasi', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 autocomplete-dokter', 'style' => 'float:left;',
                            'onblur' => 'if($(this).val() == ""){$(this).parents("td").find("input[name$=\"[dokterdelegasi_id]\"]").val("");}',
                        ),
                    )); ?>
                    <?php echo CHtml::activeHiddenField($modTindakan, '[ii]dokterdelegasi_id', array('readonly' => true)) //<< posisi jangan di ubah
                    ?>
                    
                </div>
                        
            </div>
            <div class="col-sm-3">
            <div class="ppds-lengkap"">
                <?php $this->widget('MyJuiAutoComplete', array(
                    'model' => $modTindakan,
                    'attribute' => '[ii]ppds1_nama',
                    'tombolDialog' => array('idDialog' => 'dialog_ppds', 'jsFunction' => "setDialogPPDS(this,'PPDS 1 (satu)');"),
                    'htmlOptions' => array(
                        'placeholder' => 'PPDS 1 (satu)', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 autocomplete-ppds', 'style' => 'float:left;',
                        'onblur' => 'if($(this).val() == ""){$(this).parents("td").find("input[name$=\"[ppds1_id]\"]").val("");}',
                    ),
                )); ?>
                <?php echo CHtml::activeHiddenField($modTindakan, '[ii]ppds1_id', array('readonly' => true)) //<< posisi jangan di ubah
                ?>
                <?php $this->widget('MyJuiAutoComplete', array(
                    'model' => $modTindakan,
                    'attribute' => '[ii]ppds2_nama',
                    'tombolDialog' => array('idDialog' => 'dialog_ppds', 'jsFunction' => "setDialogPPDS(this,'PPDS 2 (dua)');"),
                    'htmlOptions' => array(
                        'placeholder' => 'PPDS 2 (dua)', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 autocomplete-ppds', 'style' => 'float:left;',
                        'onblur' => 'if($(this).val() == ""){$(this).parents("td").find("input[name$=\"[ppds2_id]\"]").val("");}',
                    ),
                )); ?>
                <?php echo CHtml::activeHiddenField($modTindakan, '[ii]ppds2_id', array('readonly' => true)) //<< posisi jangan di ubah
                ?>
                
                <?php $this->widget('MyJuiAutoComplete', array(
                    'model' => $modTindakan,
                    'attribute' => '[ii]ppds3_nama',
                    'tombolDialog' => array('idDialog' => 'dialog_ppds', 'jsFunction' => "setDialogPPDS(this,'PPDS 3 (tiga)');"),
                    'htmlOptions' => array(
                        'placeholder' => 'PPDS 3 (tiga)', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 autocomplete-ppds', 'style' => 'float:left;',
                        'onblur' => 'if($(this).val() == ""){$(this).parents("td").find("input[name$=\"[ppds3_id]\"]").val("");}',
                    ),
                )); ?>
                <?php echo CHtml::activeHiddenField($modTindakan, '[ii]ppds3_id', array('readonly' => true)) //<< posisi jangan di ubah
                ?>


            <?php $this->widget('MyJuiAutoComplete', array(
                    'model' => $modTindakan,
                    'attribute' => '[ii]ppds4_nama',
                    'tombolDialog' => array('idDialog' => 'dialog_ppds', 'jsFunction' => "setDialogPPDS(this,'PPDS 4 (empat)');"),
                    'htmlOptions' => array(
                        'placeholder' => 'PPDS 4 (empat)', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 autocomplete-ppds', 'style' => 'float:left;',
                        'onblur' => 'if($(this).val() == ""){$(this).parents("td").find("input[name$=\"[ppds4_id]\"]").val("");}',
                    ),
                )); ?>
                <?php echo CHtml::activeHiddenField($modTindakan, '[ii]ppds4_id', array('readonly' => true)) //<< posisi jangan di ubah
                ?>


            <?php $this->widget('MyJuiAutoComplete', array(
                    'model' => $modTindakan,
                    'attribute' => '[ii]ppds5_nama',
                    'tombolDialog' => array('idDialog' => 'dialog_ppds', 'jsFunction' => "setDialogPPDS(this,'PPDS 5 (lima)');"),
                    'htmlOptions' => array(
                        'placeholder' => 'PPDS 5 (lima)', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 autocomplete-ppds', 'style' => 'float:left;',
                        'onblur' => 'if($(this).val() == ""){$(this).parents("td").find("input[name$=\"[ppds5_id]\"]").val("");}',
                    ),
                )); ?>
                <?php echo CHtml::activeHiddenField($modTindakan, '[ii]ppds5_id', array('readonly' => true)) //<< posisi jangan di ubah
                ?>
                    </div>  
                    
                </div>       
                
            <div class="col-sm-6">
                <?php $this->widget('MyJuiAutoComplete', array(
                    'model' => $modTindakan,
                    'attribute' => '[ii]perawat_nama',
                    'tombolDialog' => array('idDialog' => 'dialog_perawat', 'jsFunction' => "setDialogPerawat(this,'Perawat');"),
                    'htmlOptions' => array(
                        'placeholder' => 'perawat 1 (satu)', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 autocomplete-dokter', 'style' => 'float:left;',
                        'onblur' => 'if($(this).val() == ""){$(this).parents("td").find("input[name$=\"[perawat_id]\"]").val("");}',
                    ),
                )); ?>
                <?php echo CHtml::activeHiddenField($modTindakan, '[ii]perawat_id', array('readonly' => true)) //<< posisi jangan di ubah
                ?>
                <div class="dokter-lengkap" style="display:none;">
                    <?php $this->widget('MyJuiAutoComplete', array(
                        'model' => $modTindakan,
                        'attribute' => '[ii]bidan_nama',
                        'tombolDialog' => array('idDialog' => 'dialog_dokter', 'jsFunction' => "setDialogDokter(this,'Bidan');"),
                        'htmlOptions' => array(
                            'placeholder' => 'perawat 2 (dua)', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 autocomplete-dokter', 'style' => 'float:left;',
                            'onblur' => 'if($(this).val() == ""){$(this).parents("td").find("input[name$=\"[bidan_id]\"]").val("");}',
                        ),
                    )); ?>
                    <?php echo CHtml::activeHiddenField($modTindakan, '[ii]bidan_id', array('readonly' => true)) //<< posisi jangan di ubah 
                    ?>
                    <?php $this->widget('MyJuiAutoComplete', array(
                        'model' => $modTindakan,
                        'attribute' => '[ii]suster_nama',
                        'tombolDialog' => array('idDialog' => 'dialog_dokter', 'jsFunction' => "setDialogDokter(this,'Suster');"),
                        'htmlOptions' => array(
                            'placeholder' => 'perawat 3 (tiga)', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 autocomplete-dokter', 'style' => 'float:left;',
                            'onblur' => 'if($(this).val() == ""){$(this).parents("td").find("input[name$=\"[suster_id]\"]").val("");}',
                        ),
                    )); ?>
                    <?php echo CHtml::activeHiddenField($modTindakan, '[ii]dokteranastesi_id', array('readonly' => true)) //<< posisi jangan di ubah
                    ?>

                </div>
            </div>
        </div>
    </td>
    <td colspan="3"><b>Keterangan :</b>
        <?php echo $form->textField($modTindakan, '[ii]keterangantindakan', array('placeholder' => 'Keterangan Tindakan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
    </td>
</tr>