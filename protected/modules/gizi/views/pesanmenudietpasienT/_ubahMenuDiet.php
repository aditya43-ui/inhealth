
<div class="col-sm-12" id="form-ubah-diet">
    <div class="control-group ">
        <label class='control-label'>Jenis Diet</label> <!-- RSWB-3933 sebelumnya berlabel jenis diet utama -->
        <div class="controls">
            <?php echo CHtml::hiddenField('dlg[pendaftaran_id]', $arr['pendaftaran_id'], array('readonly' => true)); ?>
            <?php echo CHtml::hiddenField('dlg[kelaspelayanan_id]', $arr['kelaspelayanan_id'], array('readonly' => true)); ?>
            <?php echo CHtml::hiddenField('dlg[pasien_id]', $arr['pasien_id'], array('readonly' => true)); ?>
            <?php echo CHtml::hiddenField('dlg[pasienadmisi_id]', $arr['pasienadmisi_id'], array('readonly' => true)); ?>
            <?php echo CHtml::hiddenField('dlg[jenisdiet_id]', '', array('readonly' => true)); ?>
            <?php echo CHtml::hiddenField('dlg[menudiet_id]', '', array('readonly' => true)); ?>
            <?php echo CHtml::hiddenField('dlg[pesanmenudetail_id]', $arr_pesanmenudetail_id, array('readonly' => true)); ?>
            <?php 

                $jenisdiet_nama = "";
                if (!empty($arr['jenisdiet_id'])) {
                    $jenis = JenisdietM::model()->findByPk($arr['jenisdiet_id']);
                    $jenisdiet_nama = $jenis->jenisdiet_nama ?? null;
                }

                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'dialog[jenisdiet_nama]',
                    'value' => $jenisdiet_nama,
                    'source' => 'js: function(request, response) {
                                                            $.ajax({
                                                                url: "' . $this->createUrl('JenisDiet') . '",
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
                                                        $(\'#dlg_jenisdiet_id\').val(ui.item.jenisdiet_id);
                                                        $(\'#dlg_jenisdiet_nama\').val(ui.item.jenisdiet_nama);
                                                        refreshDialogMenuDiet1();
                                                        return false;
                                                    }',
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3',
                        'placeholder' => 'Jenis Diet',
                    ),
                    'tombolDialog' => array('idDialog' => 'jenisDietNama'),
                ));
                ?>
        </div>
    </div>
    <div class="control-group ">
        <label class='control-label'>Menu Diet <span class="required">*</span></label><!-- RSWB-3933 sebelumnya berlabel menu diet -->
        <div class="controls">

            <?php
                $menudiet_nama = '';
                if (!empty($arr['menudiet_id'])) {
                    $menu = MenudietM::model()->findByPk($arr['menudiet_id']);
                    $menudiet_nama = $menu->menudiet_nama ?? null;
                }
                

                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'dlg[menudiet_nama]',
                    'value' => $menudiet_nama,
                    'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('menuDiet') . '",
                                    dataType: "json",
                                    data: {
                                        term: request.term,
                                        jenisdiet_id:$("#dlg_jenisdiet_id").val(),
                                        kelaspelayanan_id:$("#dlg_kelaspelayanan_id").val(),
                                        penjamin_id:$("#penjamin_id").val(),
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
                                    $("#dlg_menudiet_id").val(ui.item.menudiet_id); 
                                    $("#dlg_menudiet_nama").val(ui.item.menudiet_nama); 
                                    $("#URT").val(ui.item.ukuranrumahtangga); 
                                    return false;
                                }',
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3 custom-only menudiet_id',
                        'placeholder' => 'Menu Diet',
                    ),
                    'tombolDialog' => array('idDialog' => 'menuDietNama'),
                ));
            ?>

        </div>
    </div>
   
    <div class="control-group">
        <label class='control-label'>Jenis Waktu<span class="required">*</span></label>
        <?php
        $modJenisWaktu = JeniswaktuM::model()->findAll('jeniswaktu_aktif = true order by jeniswaktu_jam asc, jeniswaktu_nama asc');
        $myData = CHtml::encodeArray(CHtml::listData($modJenisWaktu, 'jeniswaktu_id', 'jeniswaktu_id'));
        $myData = empty($myData) ? array() : $myData;

        $selected = $jeniswaktu;
        ?>
        
        <?php 
            echo Chtml::checkBoxList('jeniswaktu', $selected, CHtml::listData($modJenisWaktu, 'jeniswaktu_id', 'jeniswaktu_nama'), array('template' => '<label class="checkbox inline">{input}{label}</label>', 'separator' => '', 'style' => 'margin-left:2px;max-width:20px;', 'class' => 'span2 jeniswaktuUbah', 'onkeypress' => "return $(this).focusNextInputField(event)"))
        
        ?>
                            
    </div>
   
    <div class="table-jenis-diet">
        <table class="table table-striped table-bordered table-condensed">
            <thead>
                <th>Jenis Diet</th>
                <th>Waktu</th>
            </thead>
            <tbody></tbody>
        </table>
    </div>
   
    <div class="form-actions">
        <div class="control-group ">
            <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo CHtml::htmlButton('Simpan', array(
                    'onclick' => 'simpanUbahMenuDiet();',
                    'class' => 'btn btn-primary',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'rel' => "",
                    'title' => "Klik untuk Mengubah Menu Diet"
                ));
                ?>
                <?php
                echo "  ";
                echo CHtml::htmlButton('Batal', array(
                    'onclick' => '$("#dialogTambahMenu").dialog("close");$("#tambah-menu-diet").html("")',
                    'class' => 'btn btn-danger',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'rel' => "",
                    'title' => "Klik untuk Mengubah Menu Diet"
                ));
                ?>
            </div>
        </div>
    </div>
</div>



<script>

    $(document).ready(function () {

        var jenisdiet_id = $('#dlg_jenisdiet_id').val();
        var menudiet_id = $('#dlg_jenisdiet_id').val();
    });
</script>

