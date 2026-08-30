<div class="det-pa">
    <div class="row row-fluid">
        <div class="col-sm-12">
            <div class="control-group">
                <label class="control-label">Dokter DPJP</label>
                <div class="controls">
                    <?php
                echo $form->hiddenField($modKirimKeUnitLain,'pegawai_id',array('class'=>'required','readonly'=>true));

               $this->widget('MyJuiAutoComplete', array(    
                   'model'=>$modKirimKeUnitLain,
                   'attribute' => 'dpjp_nama',
                   'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "' . $this->createUrl('AutocompleteDokter') . '",
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
                                $(this).val(ui.item.label);
                                $("#RIAsesmenAwalKeperawatanT_dpjp_id").val(ui.item.value);
                                $("#RIAsesmenAwalKeperawatanT_dpjp_nama").val(ui.item.label);
                                return false;
                            }',
                    ),
               'htmlOptions'=>array(
                   'readonly'=>false,
                   'placeholder'=>'Ketikkan nama DPJP',
                   'size'=>20,
                   'class'=>'span3 pegawai_nama',
                   'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modKirimKeUnitLain, 'pegawai_id') . '").val(""); ',
                   'onkeypress'=>"return $(this).focusNextInputField(event);",
               ),
               'tombolDialog'=>array('idDialog'=>'dialogDokter','idTombol'=>'tombolDokter'),
               ));
               ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("PPDS", 'ppds_id', array('class' => 'control-label')) ?>
                <div class="controls field-ppds">
                    <?php echo CHtml::activeHiddenField($modKirimKeUnitLain, 'ppds_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $modKirimKeUnitLain,
                                    'attribute' => 'ppds_nama',
                                    'source' => 'js: function(request, response) {
                                            $.ajax({
                                                url: "' . $this->createUrl('autoCompletePegawai') . '",
                                                dataType: "json",
                                                data: {
                                                    term: request.term,
                                                },
                                                success: function (data) {
                                                    response(data);
                                                }
                                            })
                                        }',
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 3,
                                        'select' => 'js:function( event, ui ) {
                                                $(this).val( ui.item.nama_pegawai );
                                                $("#' . CHtml::activeId($modKirimKeUnitLain, 'ppds_id') . '").val( ui.item.ppdsd_id );
                                                return false;
                                            }',
                                    ),
                                    'htmlOptions' => array(
                                        'onblur' => 'if(this.value==""){}',
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'class' => 'ppds_nama span3',
                                        'placeholder' => 'Ketikkan Nama PPDS'),
                                    'tombolDialog' => array('idDialog' => 'dialogPpds',),
                                ));
                                ?>
                </div>
            </div>
        </div>
    </div>
    <?php echo CHtml::label("Bahan", '', array('class' => '')) ?>
    <br>
    <table style="margin-left: 20px; width: 400px;">
        <tr>
            <td><?php echo $form->checkBox($modKirimKeUnitLain, 'biopsi', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '')) . ' <label for="RIPasienKirimKeUnitLainT_biopsi">Biopsi</label>'; ?>
            </td>
            <td><?php echo $form->checkBox($modKirimKeUnitLain, 'operasi', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '')) . ' <label for="RIPasienKirimKeUnitLainT_operasi">Operasi</label>'; ?>
            </td>
            <td><?php echo $form->checkBox($modKirimKeUnitLain, 'kerokan', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '')) . ' <label for="RIPasienKirimKeUnitLainT_kerokan">Kerokan</label>'; ?>
            </td>
            <td><?php echo $form->checkBox($modKirimKeUnitLain, 'sitologi', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '')) . ' <label for="RIPasienKirimKeUnitLainT_sitologi">Sitologi</label>'; ?>
            </td>
            <td><?php echo $form->checkBox($modKirimKeUnitLain, 'fnab', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '')) . ' <label for="RIPasienKirimKeUnitLainT_fnab">FNAB</label>'; ?>
            </td>
        </tr>
    </table>
    <?php echo CHtml::label("Fiksasi", '', array('class' => '')) ?>
    <br>
    <table style="margin-left: 20px; width: 600px;">
        <tr>
            <td><?php echo $form->checkBox($modKirimKeUnitLain, 'paformmaline', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '')) . ' <label for="RIPasienKirimKeUnitLainT_paformmaline">p.A Formmaline 10%</label>'; ?>
            </td>
            <td><?php echo $form->checkBox($modKirimKeUnitLain, 'sputumalkohol', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '')) . ' <label for="RIPasienKirimKeUnitLainT_sputumalkohol">Sputum Alkohol 70%</label>'; ?>
            </td>
            <td><?php echo $form->checkBox($modKirimKeUnitLain, 'urinealkohol', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '')) . ' <label for="RIPasienKirimKeUnitLainT_urinealkohol">Urine Alkohol 50%</label>'; ?>
            </td>
            <td><?php echo $form->checkBox($modKirimKeUnitLain, 'vaginasmear', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '')) . ' <label for="RIPasienKirimKeUnitLainT_vaginasmear">Vagina Smear Alkohol 95%</label>'; ?>
            </td>
        </tr>
    </table>
    <div class="row row-fluid">
        <div class="col-sm-12">
            <div class="control-group">
                <label class="control-label">Lokalisasi</label>
                <div class="controls">
                    <?php echo $form->textArea($modKirimKeUnitLain,'lokalisasi',array('rows'=>5, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Diagnosa Klinik</label>
                <div class="controls">
                    <?php echo $form->textArea($modKirimKeUnitLain,'diagnosaklinik',array('rows'=>5, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Stadium T</label>
                <div class="controls">
                    <?php echo $form->textField($modKirimKeUnitLain,'stadiumt',array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Stadium N</label>
                <div class="controls">
                    <?php echo $form->textField($modKirimKeUnitLain,'stadiumn',array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Stadium M</label>
                <div class="controls">
                    <?php echo $form->textField($modKirimKeUnitLain,'stadiumm',array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Keterangan Klinik</label>
                <div class="controls">
                    <?php echo $form->textArea($modKirimKeUnitLain,'ketklinik',array('rows'=>5, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Riwayat Dulu</label>
                <div class="controls">
                    <?php echo $form->textArea($modKirimKeUnitLain,'riwayatdulu',array('rows'=>5, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
        </div>
    </div>
    <?php echo CHtml::label("1. Ada Pemeriksaan PA Sebelumnya? (Ya/Tidak)", '', array('class' => '')) ?>
    <br>
    <table style="margin-left: 20px; width: 300px;">
        <tr>
            <td>
                <?php echo $form->radioButton($modKirimKeUnitLain, 'ispasebelumnyaya', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '', 'class' => 'periksa-sblm')) . ' <label for="RIPasienKirimKeUnitLainT_ispasebelumnyaya">Ya</label>'; ?>
            </td>
            <td>
                <?php echo $form->radioButton($modKirimKeUnitLain, 'ispasebelumnyatidak', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '', 'class' => 'periksa-sblm')) . ' <label for="RIPasienKirimKeUnitLainT_ispasebelumnyatidak">Tidak</label>'; ?>
            </td>
        </tr>
    </table>
    <?php echo CHtml::label("2. Bila Ya Dengan Cara (Klinik/RO/Path. Klinik/Operasi/Nekrosi)", '', array('class' => '')) ?>
    <br>
    <table style="margin-left: 20px; width: 500px;">
        <tr>
            <td style="width: 20%;">
                <?php echo $form->radioButton($modKirimKeUnitLain, 'iscaraklinik', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '', 'class' => 'cara')) . ' <label for="RIPasienKirimKeUnitLainT_iscaraklinik">Klinik</label>'; ?>
            </td>
            <td>
                <?php echo $form->radioButton($modKirimKeUnitLain, 'iscararo', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '', 'class' => 'cara')) . ' <label for="RIPasienKirimKeUnitLainT_iscararo">RO</label>'; ?>
            </td>
            <td>
                <?php echo $form->radioButton($modKirimKeUnitLain, 'iscarapk', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '', 'class' => 'cara')) . ' <label for="RIPasienKirimKeUnitLainT_iscarapk">Path. Klinik</label>'; ?>
            </td>
            <td>
                <?php echo $form->radioButton($modKirimKeUnitLain, 'iscaraop', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '', 'class' => 'cara')) . ' <label for="RIPasienKirimKeUnitLainT_iscaraop">Operasi</label>'; ?>
            </td>
            <td>
                <?php echo $form->radioButton($modKirimKeUnitLain, 'iscaraekrosi', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '', 'class' => 'cara')) . ' <label for="RIPasienKirimKeUnitLainT_iscaraekrosi">Nekropsi</label>'; ?>
            </td>
        </tr>
    </table>
    <div class="row row-fluid">
        <div class="col-sm-12">
            <div class="control-group">
                <label class="control-label">Keterangan PA Sebelumnya</label>
                <div class="controls">
                    <?php echo $form->textArea($modKirimKeUnitLain,'ketpasebelumnya',array('rows'=>5, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Riwayat Sekarang</label>
                <div class="controls">
                    <?php echo $form->textArea($modKirimKeUnitLain,'riwayatsebelumnya',array('rows'=>5, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Pemeriksaan Penunjang</label>
                <div class="controls">
                    <?php echo $form->textArea($modKirimKeUnitLain,'pemeriksaanpenunjang',array('rows'=>5, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(".periksa-sblm").click(function() {
    $(".periksa-sblm").prop('checked', false);
    $(this).prop('checked', true);
});

$(".cara").click(function() {
    $(".cara").prop('checked', false);
    $(this).prop('checked', true);
});

$(document).ready(function () {
    $('.det-pa').find('input, select, textarea').attr('readonly', true);
    $('.det-pa').find('input, select, textarea').attr('disabled', true);

});

</script>