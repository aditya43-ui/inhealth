<tr data-row="<?= $i ?>">
    <td>
        <?php 
            echo CHtml::activehiddenField($modPemeriksaanGolDar,'['. $i. ']stokkantongdarah_id',array('class'=>'span2 stokkantongdarah_id required'));

            $this->widget('MyJuiAutoComplete', array(
                'name'=>'no_kantongdarah',
                'value' => $modPemeriksaanGolDar->nomorbarcode,
                'source'=>'js: function(request, response) {
                    $.ajax({
                        url: "'.$this->createUrl('AutocompleteBarang').'",
                        dataType: "json",
                        data: {
                            term: request.term,
                        },
                        success: function (data) {
                            response(data);
                        }
                    })
                }',
                'options'=>array(
                    'showAnim'=>'fold',
                    'minLength' => 3,
                    'focus'=> 'js:function( event, ui ) {
                        $(this).val("");
                        return false;
                    }',
                    'select'=>'js:function( event, ui ) {
                        $(this).val(ui.item.value);
                        $("#invperalatan_id").val(ui.item.invperalatan_id);
                        $("#namaBarang").val(ui.item.invperalatan_namabrg);
                        return false;
                    }',
                ),
                'htmlOptions'=>array(
                    'placeholder' => 'Nama Kantong Darah',
                    'class' => 'span3 custom-only',
                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                    'readonly' => true
                ),
                // 'tombolDialog'=>array('idDialog'=>'dialogKantongDarah','jsFunction'=>"setDialog(this);"),
            )); 
        ?>
       <?php echo CHtml::activehiddenField($modPemeriksaanGolDar,'['. $i. ']singkatan_komp',array('readonly'=>true,'class'=>'span2 singkatan_komp')); ?>
        <?php echo CHtml::activehiddenField($modPemeriksaanGolDar,'['. $i. ']nomorbarcode',array('readonly'=>true,'class'=>'span2 nomorbarcode')); ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPemeriksaanGolDar, '['. $i. ']anti_a',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'anti_a span1 required','empty'=>'-- Pilih --')) ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPemeriksaanGolDar, '['. $i. ']anti_b',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'anti_b span1 required','empty'=>'-- Pilih --')) ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPemeriksaanGolDar, '['. $i. ']tessel_a',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'tessel_a span1 required','empty'=>'-- Pilih --')) ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPemeriksaanGolDar, '['. $i. ']tessel_b',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'tessel_b span1 required','empty'=>'-- Pilih --')) ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPemeriksaanGolDar, '['. $i. ']tessel_o',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'tessel_o span1 required','empty'=>'-- Pilih --')) ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPemeriksaanGolDar, '['. $i. ']autocontrol',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'autocontrol span1 required','empty'=>'-- Pilih --')) ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPemeriksaanGolDar, '['. $i. ']antid',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'antid span1 required','empty'=>'-- Pilih --')) ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPemeriksaanGolDar, '['. $i. ']bvalbumin',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'bvalbumin span1 required','empty'=>'-- Pilih --')) ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPemeriksaanGolDar, '['. $i. ']kesimpulan',LookupM::getItems('kesimpulan_goldar'),array('class'=>'kesimpulan span1 required','empty'=>'-- Pilih --')) ?>
    </td>
    <td><?= $modPemeriksaanGolDar->tanggal_keluardarah ?></td>
    
</tr>



