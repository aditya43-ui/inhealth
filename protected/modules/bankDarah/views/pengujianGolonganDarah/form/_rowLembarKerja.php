<tr data-row="0">
    <td>
        <?php 
            echo CHtml::activehiddenField($modPemeriksaanGolDar,'[0]stokkantongdarah_id',array('class'=>'span2 stokkantongdarah_id required'));

            $this->widget('MyJuiAutoComplete', array(
                'name'=>'no_kantongdarah',
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
                    
                ),
                'tombolDialog'=>array('idDialog'=>'dialogKantongDarah','jsFunction'=>"setDialog(this);"),
            )); 
        ?>
       <?php echo CHtml::activehiddenField($modPemeriksaanGolDar,'[0]singkatan_komp',array('readonly'=>true,'class'=>'span2 singkatan_komp')); ?>
        <?php echo CHtml::activehiddenField($modPemeriksaanGolDar,'[0]nomorbarcode',array('readonly'=>true,'class'=>'span2 nomorbarcode')); ?>
        <?php echo CHtml::activehiddenField($modPemeriksaanGolDar,'[0]no_kantongpabrik',array('readonly'=>true,'class'=>'span2 no_kantongpabrik')); ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPemeriksaanGolDar, '[0]anti_a',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'anti_a span1','empty'=>'-- Pilih --')) ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPemeriksaanGolDar, '[0]anti_b',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'anti_b span1','empty'=>'-- Pilih --')) ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPemeriksaanGolDar, '[0]tessel_a',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'tessel_a span1','empty'=>'-- Pilih --')) ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPemeriksaanGolDar, '[0]tessel_b',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'tessel_b span1','empty'=>'-- Pilih --')) ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPemeriksaanGolDar, '[0]tessel_o',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'tessel_o span1','empty'=>'-- Pilih --')) ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPemeriksaanGolDar, '[0]autocontrol',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'autocontrol span1','empty'=>'-- Pilih --')) ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPemeriksaanGolDar, '[0]antid',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'antid span1','empty'=>'-- Pilih --')) ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPemeriksaanGolDar, '[0]bvalbumin',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'bvalbumin span1','empty'=>'-- Pilih --')) ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPemeriksaanGolDar, '[0]kesimpulan',LookupM::getItems('kesimpulan_goldar'),array('class'=>'kesimpulan span1','empty'=>'-- Pilih --')) ?>
    </td>
    <td></td>
    <td width="100" style="width: 100px; text-align: center !important;">
        <?php echo CHtml::link('<i class="icon-plus"></i>', 'javascript:;', array(
            'onclick'=>'tambahRowBarang(this); return false;',
            'title'=>'Klik untuk menambahkan Kantong',
        )); ?>
        <?php echo CHtml::link('<i class="icon-minus"></i>', 'javascript:;', array(
            'onclick'=>'batalRowBarang(this); return false;',
            'title'=>'Klik untuk membatalkan Kantong',
        )); ?>
    </td>
</tr>



