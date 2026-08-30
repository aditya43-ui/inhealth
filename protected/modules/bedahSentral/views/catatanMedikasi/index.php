<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Riwayat Medikasi</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Obat</th>
                    <th>Dosis</th>
                    <th>Cara Pemberian</th>
                    <th>Tanggal/Jam</th>
                    <th>Nama Petugas</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $det = ObatalkespasienT::model()->findAllByAttributes(array(
                    'pasienruangpulih_id' => $ruangpulih->pasienruangpulih_id,
                ));

                foreach ($det as $idx => $item) :

                ?>
                    <tr>
                        <td><?php echo $idx + 1; ?></td>
                        <td><?php echo $item->obatalkes->obatalkes_nama; ?></td>
                        <td><?php echo $item->dosis_jml; ?></td>
                        <td><?php echo $item->carapemberian; ?></td>
                        <td><?php echo MyFormatter::formatDateTimeForUser($item->tglpelayanan); ?></td>
                        <td><?php echo empty($item->pegawai) ? "-" : $item->pegawai->namaLengkap; ?></td>
                        <td><?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array(
                                'onclick' => 'hapusMedikasi(' . $item->obatalkespasien_id . '); return false;',
                                'rel' => 'tooltip',
                                'title' => 'Hapus Medikasi'
                            )); ?></td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Medikasi
        </div>
    </div>
    <div class="panel-body">
        <?php
        $obatalkes = new ObatalkespasienT();
        $obatalkes->tglpelayanan = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));

        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'medikasi-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#',
        ));
        ?>

        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Obat Alkes</label>
                <div class="controls">
                    <?php echo $form->hiddenField($obatalkes, 'obatalkes_id', array('class' => 'medikasi_obatalkes_id')); ?>
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'medikasi_obatalkes_nama',
                        'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('AutocompleteObatAlkes') . '",
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
                                $(this).val("");
                                return false;
                            }',
                            'select' => 'js:function( event, ui ) {
                                $(this).val(ui.item.value);
                                $(".medikasi_obatalkes_id").val(ui.item.obatalkes_id);
                                $("#medikasi_obatalkes_nama").val(ui.item.obatalkes_nama);
                                return false;
                            }',
                        ),
                        'htmlOptions' => array(
                            'class' => 'medikasi_obatalkes_nama span3',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogObatAlkesMedikasi'),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->label($obatalkes, 'dosis_jml', array('class' => 'control-label', 'label' => 'Dosis')); ?>
                <div class="controls">
                    <?php echo $form->textField($obatalkes, 'dosis_jml', array('class' => 'span3')); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->label($obatalkes, 'carapemberian', array('class' => 'control-label', 'label' => 'Cara Pemberian')); ?>
                <div class="controls">
                    <?php echo $form->textField($obatalkes, 'carapemberian', array('class' => 'span3')); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->label($obatalkes, 'tglpelayanan', array('class' => 'control-label', 'label' => 'Tanggal/Jam Pemberian')); ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $obatalkes,
                        'attribute' => 'tglpelayanan',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array(
                            'readonly' => true,
                            'class' => 'span3',
                            'onclick' => "return $(this).focusNextInputField(event)",
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->label($obatalkes, 'pegawai_id', array('class' => 'control-label', 'label' => 'Nama Petugas Pemberi')); ?>
                <div class="controls">
                    <?php
                    $data_peg = PegawairuanganV::model()->findAllByAttributes(array(
                        'ruangan_id' => Yii::app()->user->getState('ruangan_id')
                    ), array(
                        'order' => 'nama_pegawai',
                    ));

                    $list_peg = CHtml::listData($data_peg, 'pegawai_id', 'namaLengkap');
                    $opt_peg = array();
                    foreach ($data_peg as $item) {
                        $opt_peg[$item->pegawai_id] = array(
                            'data-nama' => $item->namaLengkap
                        );
                    }

                    echo $form->dropDownList($obatalkes, 'pegawai_id', $list_peg, array('empty' => '-- Pilih --', 'class' => 'span3', 'options' => $opt_peg));
                    ?>

                </div>
            </div>
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls">
                    <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                        'class' => 'btn btn-danger',
                        'onclick' => 'tambahOAMedikasi();'
                    )); ?>
                </div>
            </div>

        </div>
        <div class="clear"></div>

        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Obat</th>
                    <th>Dosis</th>
                    <th>Cara Pemberian</th>
                    <th>Tanggal/Jam Pemberian</th>
                    <th>Nama Petugas Pemberi</th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody class="tab_medikasi">

            </tbody>
        </table>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('index', array('pasienmasukpenunjang_id' => $ruangpulih->pasienmasukpenunjang_id)),
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            );
            ?>
            <?php // echo CHtml::link(Yii::t('mds', '{icon} Pengaturan PasienruangpulihT', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
            ?>
            <?php $this->widget('UserTips', array('content' => '')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<script>
    var row = <?php echo CJSON::encode(array('html' => $this->renderPartial('_rowMedikasi', array(), true))); ?>;

    function tambahOAMedikasi() {
        var obatalkes_id = $(".medikasi_obatalkes_id").val();
        var obatalkes_nama = $("#medikasi_obatalkes_nama").val();
        var dosis = $("#ObatalkespasienT_dosis_jml").val();
        var pemberian = $("#ObatalkespasienT_carapemberian").val();
        var tglpelayanan = $("#ObatalkespasienT_tglpelayanan").val();
        var pegawai_id = $("#ObatalkespasienT_pegawai_id").val();
        var pegawai_nama = $("#ObatalkespasienT_pegawai_id :selected").html();

        if (obatalkes_id.trim() == "" || pegawai_id.trim() == "") {
            myAlert("Obat dan Petugas Pemberi harus diisi");
            return false;
        }

        $(".tab_medikasi").append(row.html);
        var last = $(".tab_medikasi tr:last-child");

        $(last).find(".row_obatalkes_id").val(obatalkes_id);
        $(last).find(".row_tglpelayanan").val(tglpelayanan);
        $(last).find(".row_pegawai_id").val(pegawai_id);
        $(last).find(".row_dosis_jml").val(dosis);
        $(last).find(".row_carapemberian").val(pemberian);

        $(last).find(".label_obatalkes_nama").html(obatalkes_nama);
        $(last).find(".label_tglpelayanan").html(tglpelayanan);
        $(last).find(".label_nama_pegawai").html(pegawai_nama);

        renameInputTabMedikasi();
        resetFormMedikasi();
    }

    function resetFormMedikasi() {
        $(".medikasi_obatalkes_id").val("");
        $("#medikasi_obatalkes_nama").val("");
        $("#ObatalkespasienT_dosis_jml").val("");
        $("#ObatalkespasienT_carapemberian").val("");
        $("#ObatalkespasienT_pegawai_id").val("");
    }

    function renameInputTabMedikasi() {
        var idx = 0;
        $(".tab_medikasi tr").each(function() {
            $(this).find(".label_no").html(idx + 1);
            $(this).find(".row_obatalkes_id").attr("name", "ObatalkespasienT[detail][" + idx + "][obatalkes_id]");
            $(this).find(".row_tglpelayanan").attr("name", "ObatalkespasienT[detail][" + idx + "][tglpelayanan]");
            $(this).find(".row_pegawai_id").attr("name", "ObatalkespasienT[detail][" + idx + "][pegawai_id]");
            $(this).find(".row_dosis_jml").attr("name", "ObatalkespasienT[detail][" + idx + "][dosis_jml]");
            $(this).find(".row_carapemberian").attr("name", "ObatalkespasienT[detail][" + idx + "][carapemberian]");
            idx++;
        });
    }

    function hapusMedikasi(id) {
        myConfirm("Anda yakin untuk menghapus data medikasi ini?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('delete'); ?>', {
                    id: id
                }, function(data) {
                    if (data.ok == 1) {
                        location.reload();
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }

    function hapusItemMedikasi(obj) {
        $(obj).parents("tr").remove();
    }
</script>



<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogObatAlkesMedikasi',
    'options' => array(
        'title' => 'Obat Alkes Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'resizable' => false,
    ),
));
$modObatAlkes = new BSObatalkesM('search');
$modObatAlkes->unsetAttributes();
// $modObatAlkes->pendaftaran_id = $model->pendaftaran_id;
$modObatAlkes->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['BSObatalkesM'])) {
    $modObatAlkes->attributes = $_GET['BSObatalkesM'];
    //$modObatAlkes->jenisobatalkes_nama = $_GET['InfostokobatalkesruanganV']['jenisobatalkes_nama'];
    // $modObatAlkes->satuankecil_nama = $_GET['InfostokobatalkesruanganV']['satuankecil_nama'];
    //    $modObatAlkes->sumberdana_nama = $_GET['LBObatalkesM']['sumberdana_nama'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-premedikasi-grid',
    'dataProvider' => $modObatAlkes->searchObatPasienRuangan(),
    'filter' => $modObatAlkes,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                        $(\'.medikasi_obatalkes_id\').val($data->obatalkes_id);
                                        $(\'#medikasi_obatalkes_nama\').val(\'$data->obatalkes_nama\');
                                        $(\'#dialogObatAlkesMedikasi\').dialog(\'close\');
                                        return false;"
                                        ))',
        ),
        array(
            'name' => 'jenisobatalkes_id',
            'type' => 'raw',
            'value' => '(!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes_nama : "")',
            'filter' =>  CHtml::activeDropDownList($modObatAlkes, 'jenisobatalkes_id', CHtml::listData(
                JenisobatalkesM::model()->findAll(array(
                    'condition' => 'jenisobatalkes_aktif = true',
                    'order' => 'jenisobatalkes_nama',
                )),
                'jenisobatalkes_id',
                'jenisobatalkes_nama'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'name' => 'obatalkes_kategori',
            'filter' =>  CHtml::activeDropDownList($modObatAlkes, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array(
                'empty' => '-- Pilih --'
            ))
        ),
        array(
            'name' => 'obatalkes_golongan',
            'filter' =>  CHtml::activeDropDownList($modObatAlkes, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array(
                'empty' => '-- Pilih --'
            ))
        ),
        'obatalkes_nama',
        //                array(
        //                    'name'=>'sumberdana_id',
        //                    'type'=>'raw',
        //                    'value'=>'$data->sumberdana->sumberdana_nama',
        //                    'filter'=>  CHtml::activeTextField($modObatAlkes, 'sumberdana_nama'),
        //                ),
        array(
            'header' => 'Jumlah Stok',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'value' => 'StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState("ruangan_id"))." ".$data->satuankecil_nama',
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>