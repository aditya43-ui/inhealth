<div>
    <div class="control-group">
        <?php echo CHtml::label('Bentuk Diet <span class="required">*</span>', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Chtml::dropDownList('dlg[tipediet_id]', $arr['tipediet_id'], Chtml::listData(TipeDietM::model()->findAllByAttributes(array('tipediet_aktif' => true)), 'tipediet_id', 'tipediet_nama'), array('empty' => '-- Pilih --')); ?>
        </div>
    </div>
    <div class="control-group" hidden>
        <?php echo CHtml::label('Jenis Makanan', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Chtml::dropDownList('dlg[jenismakanan_id]', $arr['jenismakanan_id'], Chtml::listData(JenismakananM::model()->findAllByAttributes(array('jenismakanan_aktif' => true)), 'jenismakanan_id', 'jenismakanan_nama'), array('empty' => '-- Pilih --')); ?>
        </div>
    </div>
    <div class="control-group ">
        <label class='control-label'>Jenis Diet</label> <!-- RSWB-3933 sebelumnya berlabel jenis diet utama -->
        <div class="controls">
            <?php echo CHtml::hiddenField('dlg[pendaftaran_id]', $arr['pendaftaran_id'], array('readonly' => true)); ?>
            <?php echo CHtml::hiddenField('dlg[kelaspelayanan_id]', $arr['kelaspelayanan_id'], array('readonly' => true)); ?>
            <?php echo CHtml::hiddenField('dlg[pasien_id]', $arr['pasien_id'], array('readonly' => true)); ?>
            <?php echo CHtml::hiddenField('dlg[pasienadmisi_id]', $arr['pasienadmisi_id'], array('readonly' => true)); ?>
            <?php echo CHtml::hiddenField('dlg[menudiet_id]', $arr['menudiet_id'], array('readonly' => true)); ?>
            <?php echo CHtml::hiddenField('dlg[jenisdiet_id]', $arr['jenisdiet_id'], array('readonly' => true)); ?>
            <?php echo CHtml::hiddenField('dlg[rowdata]', $arr['rowdata'], array('readonly' => true)); ?>

            <?php //echo Chtml::dropDownList('dlg[jenisdiet_id]', $arr['jenisdiet_id'], CHtml::listData(GZJenisdietM::getJenisdietItems(), 'jenisdiet_id', 'jenisdiet_nama'), array('empty' => '-- Pilih --', 'class' => '', 'onchange' => 'loadMenuDiet(this);', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            <?php //echo Chtml::hiddenField('dlg[jenisdiet_id]', $arr['jenisdiet_id'], array('empty' => '-- Pilih --','class'=>'permanent' )); ?>
            <?php //echo Chtml::textField('dlg[jenisdiet_nama]', $arr['jenisdiet_nama'],  array('disabled'=>true,'class'=>'permanent')); ?>
            <?php 

                $jenisdiet_nama = "";
                if (!empty($arr['jenisdiet_id'])) {
                    $jenis = JenisdietM::model()->findByPk($arr['jenisdiet_id']);
                    $jenisdiet_nama = $jenis->jenisdiet_nama ?? null;
                }

                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'dlg[jenisdiet_nama]',
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
                    'tombolDialog' => array('idDialog' => 'dialogJenisDiet1',  "onclick" => "$('#dialogJenisDiet1').dialog('open');"),
                ));
                ?>
        </div>
    </div>
    <div class="control-group ">
        <label class='control-label'>Menu Diet <span class="required">*</span></label><!-- RSWB-3933 sebelumnya berlabel menu diet -->
        <div class="controls">

<?php
                $menudiet_nama;
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
                    'tombolDialog' => array('idDialog' => 'dialogMenuDiet1'),
                ));
                ?>

        </div>
    </div>
    <div class="control-group" hidden>
        <?php echo CHtml::label('Alat Makanan', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Chtml::dropDownList('dlg[alatmakanan_id]', $arr['alatmakanan_id'], $dropAlatByKelas, array('empty' => '-- Pilih --')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Jenis Waktu <span class="required">*</span>', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            echo CHtml::hiddenField('dlg[jeniswaktutemp_id]', $arr['jeniswaktu_id']);
            echo CHtml::hiddenField('dlg[jenis]', $arr['jenis']);
            echo Chtml::dropDownList('dlg[jeniswaktu_id]', $arr['jeniswaktu_id'], $dropJenisWaktuByAlat, array('value' => $arr['jeniswaktu_id']));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Alergi', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('dlg[adaalergimakanan]', $arr['alergi'], array('class' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Keterangan', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textArea('dlg[keterangan]', $arr['keterangan'], array('class' => true, 'rows' => 3, 'maxlength' => 50)); ?>
        </div>
    </div>
    <div class="form-actions">
        <div class="control-group ">
            <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo CHtml::htmlButton('Simpan', array(
                    'onclick' => 'ubahMenuDietByDialog();',
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
