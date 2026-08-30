<?php
echo CHtml::hiddenField('temp_instalasi_id');
echo CHtml::hiddenField('temp_ruangan_id');
echo CHtml::hiddenField('temp_tipediet_id');
?>
<div class="row-fluid" id="formdetail-pemesananmenu">
    <div class="col-sm-6">
    <?php if(Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RD){ ?>
        <div class="control-group">
            <?php echo CHtml::label("No. Pendaftaran", 'no_pendaftaran', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('pendaftaran_id'); ?>
                <?php 
                    $this->widget('MyJuiAutoComplete', array(
                        'name'=>'no_pendaftaran',
                        'source'=>'js: function(request, response) {
                            $.ajax({
                                url: "'.$this->createUrl('AutocompleteKunjungan').'",
                                dataType: "json",
                                data: {
                                    no_pendaftaran: request.term,
                                    ruangan_id: $("#ruangan_id").val(),
                                },
                                success: function (data) {
                                    response(data);
                                }
                            })
                        }',
                        'options'=>array(
                            'minLength' => 4,
                            'focus'=> 'js:function( event, ui ) {
                                $(this).val( "");
                                return false;
                            }',
                            'select'=>'js:function( event, ui ) {
                                $("#pendaftaran_id").val( ui.item.pendaftaran_id);
                                $("#GZPendaftaranT_nama_pasien").val( ui.item.nama_pasien);
                                $(this).val( ui.item.no_pendaftaran);
                                return false;
                            }',
                        ),
                        'tombolDialog'=>array('idDialog'=>'dialogKunjungan'),
                        'htmlOptions'=>array('placeholder'=>'No. Pendaftaran','class'=>'custom-only span3','rel'=>'tooltip','title'=>'No. Pendaftaran',
                            'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
                            ),
                    )); 
                ?>
            </div>
        </div>
    <?php } ?>
        <div class="control-group hide">
            <?php echo CHtml::label('Kelas Perawatan', 'kelaspelayanan_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('class' => 'span3', 'empty' => '--Pilih--', 'onchange' => 'setKelasKunjungan($(this).val());loadAlatMakan();clearPilihPasien();')); // 
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::hiddenField('jenistarif_id'); ?>
            <?php echo CHtml::hiddenField('kelaspelayanan_id'); ?>
            <?php echo CHtml::hiddenField('penjamin_id'); ?>
            <?php echo CHtml::hiddenField('pasien_id'); ?>
            <?php echo CHtml::activehiddenField($model, 'jenisdiet_id', array('class'=>'form_jenisdiet_id')); ?>
            <?php echo CHtml::hiddenField('pendaftaran_id'); ?>
            <?php echo CHtml::hiddenField('pasienadmisi_id'); ?>
            <?php echo $form->textFieldRow($modPasienPulang, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span3 custom-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly'=>true)); ?>
        </div>
        <div class="control-group">
            <?php echo $form->hiddenField($model, 'totalpesan_org'); ?>
            <?php echo $form->textFieldRow($model, 'adaalergimakanan', array('placeholder' => 'Ket. Alergi Makanan', 'class' => 'span3 custom-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        </div>
        <div class="control-group">
            <?php echo $form->textAreaRow($model, 'keterangan_pesan', array('placeholder' => 'Ket. Pemesanan Menu Diet', 'rows' => 4, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group hide">
            <?php echo CHtml::label('Bentuk Diet', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo Chtml::dropDownList('tipediet_id', '', Chtml::listData(TipeDietM::model()->findAllByAttributes(array('tipediet_aktif' => true), array('condition' => 'tipediet_id <> 5')), 'tipediet_id', 'tipediet_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onchange' => 'cekKelasKunjungan(this);'));?>
            </div>
        </div>
        <div class="control-group" hidden>
            <?php echo CHtml::label('Jenis Makanan', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jenismakanan_id', Chtml::listData(JenismakananM::model()->findAllByAttributes(array('jenismakanan_aktif' => true)), 'jenismakanan_id', 'jenismakanan_nama'), array('empty' => '-- Pilih --', 'onchange' => 'clearTabelWaktu();', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class='control-label'>Jenis Diet <span class="required">*</span></label><!-- RSWB-3933 sebelumnya berlabel jenis diet utama -->
            <div class="controls">
            <?php 
                // var_dump($model->attributes); die;
                $jenisdiet_nama = "";
                if (!empty($model->jenisdiet_id)) {
                    $jenis = JenisdietM::model()->findByPk($model->jenisdiet_id);
                    $jenisdiet_nama = $jenis->jenisdiet_nama ?? "";
                }

                // echo $form->hiddenField($model, 'jenisdiet_id'); ?>
                <!--<div class="input-append" style='display:inline'>-->
                <?php 
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'jenisdiet',
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
                                                        $("#' . Chtml::activeId($model, 'jenisdiet_id') . '").val(ui.item.jenisdiet_id);
                                                        $(\'#GZMenuDietM_jenisdiet_id\').val(ui.item.jenisdiet_id);
                                                        $(\'#jenisdiet\').val(ui.item.jenisdiet_nama);
                                                        refreshDialogMenuDiet();
                                                        return false;
                                                    }',
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3',
                        'placeholder' => 'Jenis Diet',
                        'readonly' => !$model->isNewRecord,
                    ),
                    'tombolDialog' => !$model->isNewRecord ? false : array('idDialog' => 'dialogJenisDiet'),
                ));
                ?>
                <?php 
                /*
                    $jenisdiet = JenisdietM::model()->findByPk(Params::JENIS_DIET_ID_MAKANAN_PASIEN);
                    echo Chtml::hiddenField('jenisdiet_id', (!empty($jenisdiet)?$jenisdiet->jenisdiet_id:null), array( 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",'class'=>'permanent')); 
                    echo CHtml::textField('jenisdiet_nama',(!empty($jenisdiet)?$jenisdiet->jenisdiet_nama:null),['disabled'=>true,'class'=>'permanent'])
                */ ?>

            </div>
        </div>
        <div class="control-group ">
            <label class='control-label'>Menu Diet </label><!-- RSWB-3933 sebelumnya berlabel menu diet -->
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'menuDiet',
                    'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('menuDiet') . '",
                                    dataType: "json",
                                    data: {
                                        term: request.term,
                                        jenisdiet_id:$("#' . CHtml::activeId($model, 'jenisdiet_id') . '").val(),
                                        kelaspelayanan_id:$("#kelaspelayanan_id").val(),
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
                                    $("#menudiet_id").val(ui.item.menudiet_id); 
                                    $("#URT").val(ui.item.ukuranrumahtangga); 
                                    return false;
                                }',
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span4 custom-only',
                        'placeholder' => 'Menu Diet',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogMenuDiet'),
                ));
                ?>
                
                <?php
                
                echo Chtml::hiddenField('menudiet_id', '', array('class' => 'menudiet_id')); 
                //    echo Chtml::dropDownList('menudiet_id', '', CHtml::listData(MenuDietM::getMenuDietItems(),'menudiet_id','menudiet_nama'), array('empty'=>'-- Pilih --', 'class' => 'span3 menudiet_id', 'onkeypress' => "return $(this).focusNextInputField(event)",)); 
                ?>

            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Jumlah Pesanan</label>
            <div class="controls">
                <?php echo Chtml::textField('jumlah', 1, array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'text-align:right;', 'disabled' => 'true')); ?>
                <?php echo Chtml::dropDownList('URT', '', LookupM::getItems('ukuranrumahtangga'), array('empty' => '-- Pilih --', 'class' => 'span2 hide', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            </div>
        </div>
        <div class="control-group" hidden>
            <?php echo CHtml::label('Alat Makanan', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo Chtml::dropDownList('alatmakanan_id', '', array(), array('empty' => '-- Pilih --', 'class' => 'span3')); //CHtml::listData(AlatmakananM::model()->findAll(" alatmakanan_aktif = TRUE ORDER BY alatmakanan_nama ASC "),'alatmakanan_id','alatmakanan_nama')  
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class='control-label'>Jenis Waktu<span class="required">*</span></label>
            <?php
            $modJenisWaktu = JeniswaktuM::model()->findAll('jeniswaktu_aktif = true order by jeniswaktu_jam asc, jeniswaktu_nama asc');
            $myData = CHtml::encodeArray(CHtml::listData($modJenisWaktu, 'jeniswaktu_id', 'jeniswaktu_id'));
            $myData = empty($myData) ? array() : $myData;
            ?>
            <!--fieldset-->
            <?php echo '<table id="tb-jenis-waktu">
                            <tr >
                                <td>
                                    ' . Chtml::checkBoxList('jeniswaktu', false, CHtml::listData($modJenisWaktu, 'jeniswaktu_id', 'jeniswaktu_nama'), array('template' => '<label class="checkbox inline">{input}{label}</label>', 'separator' => '', 'style' => 'margin-left:2px;max-width:10px;', 'class' => 'span2 jeniswaktu', 'onkeypress' => "return $(this).focusNextInputField(event)")) . '
                                </td>
                            </tr>
                        </table>';
            ?>
            <!--</fieldset>-->
        </div>
        <?php /*
        <div class="control-group">
            <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                    'onclick' => 'inputMenuDiet(); return false;',
                    'class' => 'btn btn-primary',
                    'onkeypress' => "inputMenuDiet();return $(this).focusNextInputField(event)",
                    'rel' => "tooltip",
                    'title' => "Klik untuk menambahkan Menu Diet",
                ));
                ?>
            </div>
        </div>
        */ ?>
    </div>
</div>

<script>
    function clearTabelWaktu() {
        $("#table-detailwaktu > tbody").html('');
    }

    function refreshGrid() {
        var jenismakanan_id = $("#GZPesanmenudietT_jenismakanan_id").val();

        var def = '';
        if (jenismakanan_id == '') {
            var def = 'ada';
        }

        setTimeout(function() {
            $.fn.yiiGridView.update('jeniswaktu-m-grid', {
                data: {
                    "GZKelompokjeniswaktuM[jenismakanan_id]": jenismakanan_id,
                    "GZKelompokjeniswaktuM[default]": def,
                }
            });
        }, 200);
    }

    function refreshTipediet() {
        var tipediet_id = $("#tipediet_id").val();
        var jenismakanan_id = $("#GZPesanmenudietT_jenismakanan_id").val();

        setTimeout(function() {
            $.fn.yiiGridView.update('gzmenudiet-m-grid', {
                data: {
                    "GZTarifTindakanPerdaRuanganV[tipediet_id]": tipediet_id,
                    "GZTarifTindakanPerdaRuanganV[jenismakanan_id]": jenismakanan_id,
                }
            });
        }, 200);
    }

    function refreshTipediet2() {
        var tipediet_id = $("#tipediet_id").val();
        var jenismakanan_id = $("#GZPesanmenudietT_jenismakanan_id").val();

        setTimeout(function() {
            $.fn.yiiGridView.update('gzmenudietlain-m-grid', {
                data: {
                    "GZTarifTindakanPerdaRuanganV[tipediet_id]": tipediet_id,
                    "GZTarifTindakanPerdaRuanganV[jenismakanan_id]": jenismakanan_id,
                }
            });
        }, 200);
    }

    function refreshGrid2(id, jenismakanan_id) {
        $("#gzmenudiet-m-grid").addClass('animation-loading-1');

        if (typeof id != 'undefined') {
            var tipediet_id = id;
            var jenismakanan_id = jenismakanan_id;
            $("#cek_tambah_menu").val('dialog');
        } else {
            var tipediet_id = $("#tipediet_id").val();
            var jenismakanan_id = $("#<?php echo CHtml::activeId($model, 'jenismakanan_id') ?>").val();
            $("#cek_tambah_menu").val('');
        }

        var def = '';
        if (tipediet_id == '' || jenismakanan_id == '') {
            var def = 'ada';
        }

        setTimeout(function() {
            $(".dialogmenudiet_tipediet_id").val(tipediet_id);
            $(".dialogmenudiet_jenismakanan_id").val(jenismakanan_id);
            $.fn.yiiGridView.update('gzmenudiet-m-grid', {
                data: {
                    "GZTarifTindakanPerdaRuanganV[tipediet_id]": tipediet_id,
                    "GZTarifTindakanPerdaRuanganV[jenismakanan_id]": jenismakanan_id,
                    "GZTarifTindakanPerdaRuanganV[default]": def,
                }
            });
        }, 200);
    }

    function refreshGrid3(id, jenismakanan_id) {
        $("#gzmenudietlain-m-grid").addClass('animation-loading-1');

        if (typeof id != 'undefined') {
            var tipediet_id = id;
            var jenismakanan_id = jenismakanan_id;
            $("#cek_tambah_menu").val('dialog');
        } else {
            var tipediet_id = $("#tipediet_id").val();
            var jenismakanan_id = $("#<?php echo CHtml::activeId($model, 'jenismakanan_id') ?>").val();
            $("#cek_tambah_menu").val('');
        }

        var def = '';
        if (tipediet_id == '' || jenismakanan_id == '') {
            var def = 'ada';
        }

        setTimeout(function() {
            $(".dialogmenudiet_tipediet_id").val(tipediet_id);
            $(".dialogmenudiet_jenismakanan_id").val(jenismakanan_id);
            $.fn.yiiGridView.update('gzmenudietlain-m-grid', {
                data: {
                    "GZTarifTindakanPerdaRuanganV[tipediet_id]": tipediet_id,
                    "GZTarifTindakanPerdaRuanganV[jenismakanan_id]": jenismakanan_id,
                    "GZTarifTindakanPerdaRuanganV[default]": def,
                }
            });
        }, 200);
    }

    function jeniswaktu(){
        $('#tb-jenis-waktu > tbody > tr > td').find('.checkbox').each(function() {
            var jenis = $(this).find('input[type=checkbox]');
            if(jenis.val() == <?= Params::ID_MAKAN_PAGI ?> || jenis.val() == <?= Params::ID_MAKAN_SIANG ?> || jenis.val() == <?= Params::ID_MAKAN_SORE ?>){
                console.log('jenis', jenis.val());
                jenis.prop("checked", true);
            }
        });
    }
</script>