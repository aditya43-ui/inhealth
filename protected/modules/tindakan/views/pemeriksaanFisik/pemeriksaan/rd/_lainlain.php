<style>
    .row+.row {
        margin-top: 17px !important;
    }
</style>

<div class="row">
    <div class="col-sm-12" style="margin-top:17px">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Pemeriksaan Penunjang
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modPemeriksaanFisik, 'attribute' => 'periksa_penunjang', 'toolbar' => 'mini', 'height' => '200px')) ?>
                </div>
                <div class="col-sm-6">
                    <table class="table table-bordered table-condensed table-striped" id="detail_penunjang">
                        <thead>
                            <tr>
                                <th width="50"></th>
                                <th>Diagnosis Kerja</th>
                                <th width="50">
                                    <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                                        'class' => 'btn btn-primary',
                                        'onclick' => 'addDetailPenunjang();'
                                    )); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $diagkerja = DiagnosakerjaT::model()->findAllByAttributes(array(
                                'pemeriksaanfisik_id' => $modPemeriksaanFisik->pemeriksaanfisik_id
                            ));


                            if (count((array)$diagkerja) == 0) {
                            ?>
                                <tr class="rows">
                                    <td class="row_num" style="text-align: right;">1</td>
                                    <td><?php echo $form->textField($modPemeriksaanFisik, 'periksa_penunjang_detail[]', array('class' => 'form-control penunjang_detail')); ?></td>
                                    <td style="text-align: center;"><?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick' => 'removeDetailPenunjang(this); return false;')); ?></td>
                                </tr>
                                <?php } else {
                                foreach ($diagkerja as $item) {
                                ?>
                                    <tr class="rows">
                                        <td class="row_num" style="text-align: right;">1</td>
                                        <td><?php echo $form->textField($modPemeriksaanFisik, 'periksa_penunjang_detail[]', array('class' => 'form-control penunjang_detail', 'value' => $item->diagnosakerja_isi)); ?></td>
                                        <td style="text-align: center;"><?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick' => 'removeDetailPenunjang(this); return false;')); ?></td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Terapi IGD</div>
            </div>
            <div class="panel-body">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modPemeriksaanFisik, 'attribute' => 'terapi_igd', 'toolbar' => 'mini', 'height' => '200px')) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Terapi Rawat Inap</div>
            </div>
            <div class="panel-body">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modPemeriksaanFisik, 'attribute' => 'terapi_rawatinap', 'toolbar' => 'mini', 'height' => '200px')) ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Monitoring
                </div>
            </div>
            <div class="panel-body">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modPemeriksaanFisik, 'attribute' => 'monitoring', 'toolbar' => 'mini', 'height' => '200px')) ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Rencana Tindak Lanjut</div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo CHtml::label('Rawat Inap Ruang', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modPemeriksaanFisik,
                            'attribute' => 'tl_rawatinap_ruang',
                            'source' => 'js: function(request, response) {
                                    $.ajax({
                                    url: "' . $this->createUrl('/actionAutoComplete/getRuanganRI') . '",
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
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                    $(this).val( ui.item.label);
                                    return false;
                                }',
                                'select' => 'js:function( event, ui ) {
                                    $(this).val( ui.item.label);
                                    return false;
                                }',
                            ),
                            'htmlOptions' => array(
                                'id' => 'tl_rawatinap_ruang',
                                'class' => 'span3',
                            ),
                            'tombolDialog' => array(
                                'idDialog' => 'dialogRuanganRI',
                            ),
                        ));
                        ?>

                        <?php // echo $form->textField($modPemeriksaanFisik, 'tl_rawatinap_ruang', array('class'=>'form-control')); 
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Rawat Inap DPJP', '', array('class' => 'control-label')); ?>
                    <div class="controls">

                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modPemeriksaanFisik,
                            'attribute' => 'tl_rawatinap_dpjp',
                            'source' => 'js: function(request, response) {
                                    $.ajax({
                                    url: "' . $this->createUrl('/actionAutoComplete/getDokterDPJP') . '",
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
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                     $(this).val( ui.item.label);
                                     return false;
                                 }',
                            ),
                            'htmlOptions' => array(
                                'id' => 'dpjp',
                                'class' => 'span3',
                            ),
                            'tombolDialog' => array(
                                'idDialog' => 'dialogDokterDPJP',
                            ),
                        ));
                        ?>
                        <?php // echo $form->textField($modPemeriksaanFisik, 'tl_rawatinap_dpjp', array('class'=>'form-control')); 
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Indikasi', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanFisik, 'tl_indikasi', array('class' => 'form-control')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Pengantar Pasien', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->checkBox($modPemeriksaanFisik, 'tl_pengantar_pasien', array('class' => 'form-control')); ?>
                        <label>(Bila tidak, rujuk ke Pekerja Sosial)</label>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Rujuk Ke', '', array('class' => 'control-label')); ?>
                    <div class="controls">

                        <?php
                        echo $form->hiddenField($modPemeriksaanFisik, 'tl_rujuk_ke', array('id' => 'tl_rujuk_ke'));
                        echo $form->dropDownList(
                            $modPemeriksaanFisik,
                            'tl_asalrujukan_id',
                            CHtml::listData(AsalrujukanM::model()->findAll(array(
                                'condition' => 'asalrujukan_aktif = true',
                                'order' => 'asalrujukan_nama asc',
                            )), 'asalrujukan_id', 'asalrujukan_nama'),
                            array(
                                'empty' => '--- Pilih ---', 'class' => 'span2',
                                'id' => 'tl_asalrujukan_id',
                                'onchange' => 'cekHomecare(); setDataRujukan();',
                            )
                        ); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">

                        <?php

                        echo $form->hiddenField($modPemeriksaanFisik, 'tl_rujukandari_id', array('id' => 'tl_rujukandari_id'));

                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modPemeriksaanFisik,
                            'attribute' => 'tl_rujuk_nama',
                            'source' => 'js: function(request, response) {
                                    $.ajax({
                                    url: "' . $this->createUrl('/actionAutoComplete/getRujukanDari') . '",
                                    dataType: "json",
                                    data: {
                                        term: request.term,
                                        asalrujukan_id: $("#tl_asalrujukan_id").val(),
                                    },
                                    success: function (data) {
                                        response(data);
                                    }
                                })
                            }',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                    $("#tl_rujukandari_id").val(ui.item.value);
                                    $(this).val( ui.item.label);
                                    return false;
                                 }',
                                'select' => 'js:function( event, ui ) {
                                    $("#tl_rujukandari_id").val(ui.item.value);
                                    $(this).val( ui.item.label);
                                    return false;
                                 }',

                            ),
                            'htmlOptions' => array(
                                'id' => 'tl_rujuk_nama',
                                'class' => 'span3',
                            ),
                            'tombolDialog' => array(
                                'idDialog' => 'dialogRujukan',
                            ),
                        ));
                        ?>

                        <?php //echo $form->dropDownList($modPemeriksaanFisik, 'tl_rujukandari_id', array(), array('empty'=>'--- Pilih ---','class'=>'span3', 'placeholder'=>'Nama Perujuk')); 
                        ?>
                    </div>
                    <div class="controls">
                        <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                            'class' => 'btn btn-primary',
                            'onclick' => 'addRujukanDari();',
                        )); ?>
                    </div>
                </div>
                <div class="control-group homecare">
                    <?php echo CHtml::label('Tgl. Homecare', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php $this->widget('MyDateTimePicker', array(
                            'model' => $modPemeriksaanFisik,
                            'attribute' => 'tl_homecare_tgl',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'class' => 'span3 dtPicker3',
                                'id' => 'tl_homecare_tgl',
                                'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>
                        <?php //echo $form->textField($modPemeriksaanFisik, 'kontrol_tgl', array('class'=>'form-control')); 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Edukasi Pasien
                </div>
            </div>
            <div class="panel-body">
                Edukasi awal, disampaikan tentang Diagnosis, Rencana, dan Tujuan Terapi Kepada :<br>
                <table style="width: 100%; border: none;">
                    <tr>
                        <td nowrap><label><?php echo $form->radioButton($modPemeriksaanFisik, 'edukasi_dituju_ke', array('value' => 'PASIEN', 'uncheckValue' => null)); ?> Pasien</label></td>
                        <td width="100%" style="padding-left: 10px;"></td>
                    </tr>
                    <tr>
                        <td nowrap><label><?php echo $form->radioButton($modPemeriksaanFisik, 'edukasi_dituju_ke', array('value' => 'KELUARGA', 'uncheckValue' => null)); ?> Keluarga Pasien</label></td>
                        <td style="padding-left: 10px;"><?php echo $form->textField($modPemeriksaanFisik, 'edukasi_nama_keluarga', array('class' => 'span3')); ?></td>
                    </tr>
                    <tr>
                        <td nowrap><label><?php echo $form->radioButton($modPemeriksaanFisik, 'edukasi_dituju_ke', array('value' => 'TIDAK BISA', 'uncheckValue' => null)); ?> Tidak dapat, karena</label></td>
                        <td style="padding-left: 10px;"><?php echo $form->textField($modPemeriksaanFisik, 'edukasi_alasan_tidakbisa', array('class' => 'span3')); ?></td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
</div>

<script>
    var penunjang_row = $("#detail_penunjang tbody .rows").eq(0).clone(true, true);

    function addDetailPenunjang() {
        var metarow = penunjang_row.clone(true, true);
        metarow.find(".penunjang_detail").val("");
        $("#detail_penunjang tbody").append(metarow);
        renameRow();
    }

    function removeDetailPenunjang(obj) {
        $(obj).parents("tr").remove();
        renameRow();
    }

    function renameRow() {
        var i = 1;
        $("#detail_penunjang tbody tr").each(function() {
            $(this).find(".row_num").html(i++);
        });
    }

    function cekHomecare() {
        var asalrujukan = $("#tl_asalrujukan_id :selected").html();

        if (asalrujukan.toLowerCase().trim() == 'homecare') {
            $(".homecare").show();
        } else {
            $(".homecare").hide().find("#tl_homecare_tgl").val("");
        }
    }

    function setDataRujukan() {
        var asalrujukan_id = $("#tl_asalrujukan_id").val();
        var asalrujukan = $("#tl_asalrujukan_id :selected").html();

        $("#tl_rujuk_ke").val(asalrujukan);
        $("#tl_rujukandari_id, #tl_rujuk_nama").val("");
        $("#dialog_asalrujukan_id").val(asalrujukan_id);
        $.fn.yiiGridView.update('dialog-rujukan-m-grid', {
            data: $('#dialog-rujukan-m-grid :input').serialize()
        });
    }

    /**
     * menambahkan rujukan dari
     * @returns {Boolean}
     */
    function addRujukanDari() {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/sistemAdministrator/RujukandariM/addRujukanDari'); ?>',
            data: $(this).serialize(),
            dataType: "json",
            success: function(data) {
                if (data.status == 'create_form') {
                    $('#dialogAddRujukanDari').dialog('open');
                    $('#dialogAddRujukanDari div.divForFormRujukanDari').html(data.div);
                    $('#dialogAddRujukanDari div.divForFormRujukanDari form').submit(addRujukanDari);
                } else {
                    $('#dialogAddRujukanDari div.divForFormRujukanDari').html(data.div);
                    $('#PPRujukanT_nama_perujuk').html(data.namarujukan);
                    $('#PPRujukanT_rujukandari_id').html(data.namarujukan);
                    setTimeout(function() {
                        $('#dialogAddRujukanDari').dialog('close');
                        $.fn.yiiGridView.update('dialog-rujukan-m-grid', {
                            data: $('#dialog-rujukan-m-grid :input').serialize()
                        });
                    }, 1000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        return false;
    }

    $(document).ready(function() {
        cekHomecare();
    });
</script>

<?php echo $this->renderPartial($this->path_view . 'pemeriksaan.rd._lainlainDialog', array(), true); ?>