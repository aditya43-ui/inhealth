<div class="row" style="margin-top: 20px;">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading" style="display: flex;">
                <div class="panel-title">
                    <i></i> Pengambilan Contoh Uji dan Pemeriksaan Mikroskopis
                </div>
                <div class="panel-title" style="text-align: right; margin: 3px;">
                    <i class="entypo-minus row_3" style="cursor: pointer;"></i>
                </div>
            </div>
            <div class="panel-body" id="row_3" style="display: block;">             
                <table class="table" id="tablePengalamanOrganisasi" style="padding-left: 0; padding-right: 0;">
                    <thead>
                        <tr>
                            <th rowspan="2">Tanggal Pengambilan</th>
                            <th rowspan="2">Tanggal Hasil Diperoleh</th>
                            <th rowspan="2">Hasil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $x = 0;
                        ?>
                        <tr>
                            <td>
                                <?php   
                                    $this->widget('MyDateTimePicker',array(
                                        'model'=>$modUjiTerdugaTb,
                                        'attribute'=>'['.$x.']tglpengambilan',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'showOn' => false,
                                            // 'maxDate' => 'd',
                                            // 'yearRange'=> "-150:+0",
                                        ),
                                        'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                        ),
                                    )); 
                                ?>
                            </td>
                            <td>
                                <?php   
                                    $this->widget('MyDateTimePicker',array(
                                        'model'=>$modUjiTerdugaTb,
                                        'attribute'=>'['.$x.']tglhasil',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'showOn' => false,
                                            // 'maxDate' => 'd',
                                            // 'yearRange'=> "-150:+0",
                                        ),
                                        'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                        ),
                                    )); 
                                ?>
                            </td>
                            <td>
                                <?php echo CHtml::activeDropDownList($modUjiTerdugaTb, '['.$x.']hasil', LookupM::getItems('hasiltb'), array('empty' => '-- Pilih --', 'class'=>'form-control hasil')) ?>
                            <td>
                                <?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>','',array('class' => 'btn btn-default', 'title'=>'Tambah data','rel'=>'tooltip','onclick'=>'tambahOrganisasi(this);return false','id'=>'tambah','style'=>'cursor:pointer;')); ?>
                                <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>','#',array('class' => 'btn btn-default', 'style'=>'display:none;','title'=>'Hapus data','rel'=>'tooltip','id'=>'hapus','onclick'=>'hapusOrganisasi(this);return false','style'=>'cursor:pointer;')); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var trPendidikanpegawai = new String(<?php echo CJSON::encode($this->renderPartial('_rowOrganisasi', array('form' => $form, 'model' => $modUjiTerdugaTb,), true)); ?>);

    function tambahOrganisasi(obj) {
        $("#hapus").show();
        $(obj).hide();
        $(obj).parents("table").children("tbody").append(trPendidikanpegawai.replace());
        renameInput();
    }

    function hapusOrganisasi(obj) {
        $("#tambah").show();
        $(obj).hide();
        $(obj).parents("tr").remove();
        renameInput();
    }

    function renameInput() {
        var row = 0;
        var obj_table = '#tablePengalamanOrganisasi';
        $(obj_table).find("tbody > tr").each(function() {

            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                    if (old_name_arr[2] === 'pengalamankerja_nourut') {
                        $(this).attr('name', old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]").val(row + 1);
                    }
                }
            });
            $(this).find('span').each(function() {
                var old_name = $(this).parent('.input-append').find('input').attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                var id_span = '';
                if (old_name_arr.length == 3) {
                    id_span = old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_date";
                    id = old_name_arr[0] + "_" + row + "_" + old_name_arr[2];
                    $(this).attr("id", id_span);
                    registerDateJs(id, id_span);
                }
            });
            row++;
        });
    }

    function registerDateJs(id, id_span) {
        $('#' + id).datepicker(jQuery.extend({
                showMonthAfterYear: false
            },
            jQuery.datepicker.regional['id'], {
                'timeOnlyTitle': 'Pilih Waktu',
                'changeYear': true,
                'changeMonth': true,
                'showAnim': 'fold',
                // 'yearRange': '-80y:+20y'
            }));
        $('#' + id_span).on('click', function() {
            $('#' + id).datepicker('show');
        });
        // $(".datemask").mask("99/99/9999");
    }
</script>