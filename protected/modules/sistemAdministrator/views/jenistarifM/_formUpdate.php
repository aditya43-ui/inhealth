<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sajenis-tarif-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#SAJenisTarifM_jenistarif_nama',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jenistarif_nama', array('placeholder' => 'Jenis Tarif', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 25)); ?>
        <?php echo $form->textFieldRow($model, 'jenistarif_namalainnya', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 25)); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label('Penjamin', 'jeniskegiatan_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'penjamin_nama',
                    'source' => 'js: function(request, response) {
										$.ajax({
												url: "' . $this->createUrl('/ActionAutoComplete/AllPenjaminForJenisTarif') . '",
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
														$(this).val( ui.item.value);
														return false;
																			}',
                        'select' => 'js:function( event, ui ) { 											
											setPenjaminPasien(ui.item.penjamin_id,ui.item.penjamin_nama);
									}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Penjamin ',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPejaminPasien'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'jenistarif_aktif', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label for="SAJenisTarifM_jenistarif_aktif">Aktif</label>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Penjamin</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table id="jenistarif-penjamin" class="table  table-bordered ">
            <thead>
                <tr>
                    <th>Nama Penjamin</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count((array)$loadJnsTrfPen) > 0) {
                    $i = 0;
                    foreach ($loadJnsTrfPen as $dt) {
                        $det = new SAJenistarifM;
                        $det->penjamin_nama = $dt->penjamin->penjamin_nama;
                        $det->penjamin_id = $dt->penjamin_id;
                        echo $this->renderPartial($this->path_view . '_formPenjamin', array('det' => $det, 'i' => $i), true);
                        $i++;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jenis Tarif', array('{icon}' => '<i class="icon-file icon-white"></i>')),
        $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
/* ====================================== Widget Dialog Penjamin ====================================== */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPejaminPasien',
    'options' => array(
        'title' => 'Pencarian Penjamin Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => true,
    ),
));

$modPenjamin = new PenjaminpasienM('search');
$modPenjamin->unsetAttributes();
if (isset($_GET['PenjaminpasienM'])) {
    $modPenjamin->attributes = $_GET['PenjaminpasienM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'grouplayanan-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modPenjamin->searchPenjaminForJenisTarif(),
    'filter' => $modPenjamin,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) use ($model) {
                return CHtml::Link(
                    "<i class='icon-form-check'></i>",
                    "javascript:;",
                    array(
                        "class" => "btn-small",
                        "id" => "selectbarang",
                        "onclick" => '
										setPenjaminPasien(' . $data->penjamin_id . ',"' . $data->penjamin_nama . '");	
										$("#dialogPejaminPasien").dialog("close");'

                    )
                );
            },
        ),
        'penjamin_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){
            // $("#kategoritindakan_id").val($("#idKategori").val());
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
/* ====================================== endWidget Dialog Group Layanan ====================================== */
?>

<script>
    function setPenjaminPasien(id, nama) {
        var id = id;
        var nama = nama;

        if (cekData(id) == true) {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('addPenjaminPasien'); ?>',
                data: {
                    id: id,
                    nama: nama
                }, //
                dataType: "json",
                success: function(data) {
                    if (data.sukses != 0) {

                        $("#jenistarif-penjamin").find("tbody").append(data.tr);
                        renameInputRow($("#jenistarif-penjamin"), 'penjamin');
                    } else {
                        myAlert(data.pesan);
                    }
                    $("#SAJenisTarifM_penjamin_nama").val('');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            myAlert("Data Sudah Ditambahkan pada Tabel Penjamin", "Perhatian");
            return false;
        }
    }

    /**
     * rename input grid
     */
    function renameInputRow(obj_table, get) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");

                if (old_name_arr.length == 4) {
                    $(this).attr("id", old_name_arr[0] + "_" + get + "_" + row + "_" + old_name_arr[3]);
                    $(this).attr("name", old_name_arr[0] + "[" + get + "][" + row + "][" + old_name_arr[3] + "]");
                }
            });
            row++;
        });
    }

    function hapusBaris(obj) {

        myConfirm(" Apakah Anda yakin akan menghapus/membatalkan data ini?", " Perhatian ", function(r) {
            if (r) {
                $(obj).parents('tr').detach();
                renameInputRow($("#jenistarif-penjamin"), 'penjamin');
            } else {
                return false;
            }
        })

    }

    function cekData(id) {
        var ok = true;
        $($("#jenistarif-penjamin")).find("tbody > tr").each(function() {
            $(this).find("td").attr("style", "");

            if ($(this).find(".penjaminTarif").val() == id) {
                $(this).find("td").attr("style", "border:1px solid red !important;");
                ok = ok && false;
            } else {
                ok = ok && true;
            }
        });

        if (ok == true) {
            return true;
        } else {
            return false;
        }
    }
</script>