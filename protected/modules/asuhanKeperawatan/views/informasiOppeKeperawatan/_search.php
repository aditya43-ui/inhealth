<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'oppekeperawatan-info-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'indikatoroppekeperawatan_id'),
));
?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'pegawai_id', array('class' => 'control-label', 'label' => 'Nama Perawat')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true, 'class' => 'span3 pegawai_id')); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'attribute' => 'nama_perawat',
                    'model' => $model,
                    'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('AutoCompleteGetPerawat') . '",
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
                        'select' => "js:function( event, ui ) {
                                $(this).val(ui.item.nama_pegawai);
                                $('#LaporanoppekeperawatanV_pegawai_id').val(ui.item.pegawai_id);
                                $('#LaporanoppekeperawatanV_nama_perawat').val(ui.item.nama_pegawai);
                                return false;
                            }",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Nama Perawat',
                        'class' => 'span3 custom-only',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPerawat', 'jsFunction' => '$("#dialogPerawat").dialog("open");'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Indikator OPPE', 'indikatoroppekeperawatan_id', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'indikatoroppekeperawatan_id', IndikatoroppekeperawatanM::model()->getIndikatorOPPE(), array(
                    'empty' => '-- Pilih --',
                    'class' => 'span3',
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group" id="perilaku">
            <?php echo $form->labelEx($model, 'bulan_pilih_periode', array('class' => 'control-label', 'label' => 'Periode Laporan')) ?>
            <div class="controls">
                <div class="input-append">
                    <input value="<?php echo MyFormatter::formatMonthForUser($model->bulan_pilih_awal) ?>" type="text" name="LaporanoppekeperawatanV[bulan_pilih_awal]" id="LaporanoppekeperawatanV_bulan_pilih_awal" onkeypress="return $(this).focusNextInputField(event);" class="span2 hasDatepicker">
                    <span class="add-on" onclick="$('#LaporanoppekeperawatanV_bulan_pilih_awal').focus();"><i class="entypo-calendar"></i></span>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Hingga Bulan :</label>
            <div class="controls">
                <div class="input-append">
                    <input value="<?php echo MyFormatter::formatMonthForUser($model->bulan_pilih_akhir) ?>" type="text" name="LaporanoppekeperawatanV[bulan_pilih_akhir]" id="LaporanoppekeperawatanV_bulan_pilih_akhir" onkeypress="return $(this).focusNextInputField(event);" class="span2 hasDatepicker">
                    <span class="add-on" onclick="$('#LaporanoppekeperawatanV_bulan_pilih_akhir').focus();"><i class="entypo-calendar"></i></span>
                </div>
            </div>
        </div>
        <div class="control-group" id="awal" hidden>
            <?php echo $form->labelEx($model, 'bulan_pilih', array('class' => 'control-label', 'label' => 'Bulan Pencatatan')) ?>
            <div class="controls">
                <div class="input-append">
                    <input value="<?php echo MyFormatter::formatMonthForUser($model->bulan_pilih) ?>" type="text" name="LaporanoppekeperawatanV[bulan_pilih]" id="LaporanoppekeperawatanV_bulan_pilih" onkeypress="return $(this).focusNextInputField(event);" class="span3 hasDatepicker">
                    <span class="add-on" onclick="$('#LaporanoppekeperawatanV_bulan_pilih').focus();"><i class="entypo-calendar"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array(
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    ));
    ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips.informasi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<?php
/* ========= Dialog buat cari Kantong Darah ========================= */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPerawat',
    'options' => array(
        'title' => 'Daftar Perawat',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'resizable' => false,
    ),
));
$modPegawai = new ASPegawaiM('searchDialog');
$modPegawai->unsetAttributes();
if (isset($_GET['ASPegawaiM'])) {
    $modPegawai->attributes = $_GET['ASPegawaiM'];
    $modPegawai->jabatan_nama = !empty($_GET['ASPegawaiM']['jabatan_nama']) ? $_GET['ASPegawaiM']['jabatan_nama'] : "";
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'barang-m-grid',
    'dataProvider' => $modPegawai->searchDialogPerawat(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::Link("<span style='font-size:20px;'><i class='icon-plus'></i></span>", "javascript:void(0)", array(
                    "class" => "btn-small",
                    "id" => "selectBarang",
                    "onClick" => "$('#LaporanoppekeperawatanV_pegawai_id').val('" . $data['pegawai_id'] . "');  
                                          $('#LaporanoppekeperawatanV_nama_perawat').val('" . $data['nama_pegawai'] . "');                                                        
                                          $('#dialogPerawat').dialog('close');
                                          return false;"
                ));
            },
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai'
        ),
        array(
            'header' => 'Nama Perawat',
            'name' => 'nama_pegawai'
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_nama'
        )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<script>
    function setKejadian(obj) {
        var indikator = $('#LaporanoppekeperawatanV_indikatoroppekeperawatan_id').val();
        if (indikator == 0 || indikator == 3 || indikator == 4 || indikator == 6) {
            $('#awal').show();
            $('#perilaku').hide();
            $('#LaporanoppekeperawatanV_bulan_pilih_awal').val('');
            $('#LaporanoppekeperawatanV_bulan_pilih_akhir').val('');
        } else if (indikator == 1 || indikator == 2 || indikator == 5 || indikator == 7) {
            $('#awal').hide();
            $('#perilaku').show();
            $('#LaporanoppekeperawatanV_bulan_pilih').val('');
        }
    }
</script>