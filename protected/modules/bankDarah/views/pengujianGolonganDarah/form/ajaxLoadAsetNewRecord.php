<tr data-row="0">
    <td>
          <?php 
              echo CHtml::activehiddenField($modUjiKompatibilitas,'[0]stokkantongdarah_id',array('class'=>'span2 stokkantongdarah_id required'));
              echo CHtml::activehiddenField($modUjiKompatibilitas,'[0]permintaandarahdet_id',array('class'=>'span2 permintaandarahdet_id'));

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
                            'class' => 'span3 custom-only required',
                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                            
                        ),
                        'tombolDialog'=>array('idDialog'=>'dialogKantongDarah','jsFunction'=>"setDialog(this);"),
                    )); 
                ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modUjiKompatibilitas,'[0]singkatan_komp',array('readonly'=>true,'class'=>'span2 singkatan_komp')); ?>
        <?php echo CHtml::activehiddenField($modUjiKompatibilitas,'[0]nomorbarcode',array('readonly'=>true,'class'=>'span2 nomorbarcode')); ?>

    </td>
    <td>   
       <?php echo CHtml::activeDropDownList($modUjiKompatibilitas, '[0]ujikomp_mayor1',LookupM::getItems('ujikompabilitasmayor'),array('onchange'=>'ujiSilang(this);','class'=>'ujikomp_mayor span1 required','empty'=>'-- Pilih --')) ?>
    </td>
    <td>   
       <?php echo CHtml::activeDropDownList($modUjiKompatibilitas, '[0]ujikomp_mayor2',LookupM::getItems('ujikompabilitasmayor'),array('onchange'=>'ujiSilang(this);','class'=>'ujikomp_mayor span1 required','empty'=>'-- Pilih --')) ?>
    </td>
    <td>   
       <?php echo CHtml::activeDropDownList($modUjiKompatibilitas, '[0]ujikomp_mayor3',LookupM::getItems('ujikompabilitasmayor'),array('onchange'=>'ujiSilang(this);','class'=>'ujikomp_mayor span1 required','empty'=>'-- Pilih --')) ?>
    </td>
    <td>   
       <?php echo CHtml::activeDropDownList($modUjiKompatibilitas, '[0]ujikomp_mayor4',LookupM::getItems('ujikompabilitasmayor'),array('onchange'=>'ujiSilang(this);','class'=>'ujikomp_mayor span1 required','empty'=>'-- Pilih --')) ?>
    </td>
    <td>
       <?php echo CHtml::activeDropDownList($modUjiKompatibilitas, '[0]ujikomp_minor1',LookupM::getItems('ujikompabilitasmayor'),array('onchange'=>'ujiSilang(this);','class'=>'ujikomp_minor span1 required','empty'=>'-- Pilih --')) ?>

    </td>
    <td>
       <?php echo CHtml::activeDropDownList($modUjiKompatibilitas, '[0]ujikomp_minor2',LookupM::getItems('ujikompabilitasmayor'),array('onchange'=>'ujiSilang(this);','class'=>'ujikomp_minor span1 required','empty'=>'-- Pilih --')) ?>

    </td>
    <td>
       <?php echo CHtml::activeDropDownList($modUjiKompatibilitas, '[0]ujikomp_minor3',LookupM::getItems('ujikompabilitasmayor'),array('onchange'=>'ujiSilang(this);','class'=>'ujikomp_minor span1 required','empty'=>'-- Pilih --')) ?>

    </td>
    <td>
       <?php echo CHtml::activeDropDownList($modUjiKompatibilitas, '[0]ujikomp_minor4',LookupM::getItems('ujikompabilitasmayor'),array('onchange'=>'ujiSilang(this);','class'=>'ujikomp_minor span1 required','empty'=>'-- Pilih --')) ?>

    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modUjiKompatibilitas, '[0]ujikomp_autokontrol',LookupM::getItems('ujikompabilitasmayor'),array('onchange'=>'ujiSilang(this);setAutoKontrol($("#autoKontrol"),this);','class'=>'ujikomp_autokontrol span2 required','empty'=>'-- Pilih --')) ?>

    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modUjiKompatibilitas, '[0]ujikomp_dct',LookupM::getItems('ujikompabilitasmayor'),array('onchange'=>'ujiSilang(this);','class'=>'ujikomp_dct span2','empty'=>'-- Pilih --')) ?>

    </td>
    <td>
        <?php echo CHtml::activetextArea($modUjiKompatibilitas,'[0]ujikomp_kesimpulan', array('class'=>'ujikomp_kesimpulan span3','readonly'=>false)) ?>

    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modUjiKompatibilitas, '[0]rilis',LookupM::getItems('rilis'),array('class'=>'rilis span2 required','empty'=>'-- Pilih --')) ?>

    </td>
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