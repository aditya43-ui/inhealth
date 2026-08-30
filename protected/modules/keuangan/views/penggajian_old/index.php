<div id="input-pengeluaran" class="white-container">
    <legend class="rim2">Transaksi Pembayaran <b>Gaji Pegawai</b></legend>
    <?php
    $this->widget('application.extensions.moneymask.MMask', array(
        'element' => '.currency',
        'currency' => 'PHP',
        'config' => array(
            'symbol' => 'Rp ',
            'defaultZero' => true,
            'allowZero' => true,
            'precision' => 0,
        )
    ));
    ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'akpengeluaran-umum-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array(
            'onKeyPress' => 'return disableKeyPress(event)',
            'onsubmit' => 'return cekInput(); requiredCheck(this);'
        ),
        'focus' => '#',
    ));
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->

    <?php
    //echo $form->errorSummary(array($modPengUmum,$modBuktiKeluar)); 
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success', "Data pembayaran gaji berhasil disimpan!");
    }
    ?>
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <?php echo $form->labelEx($modPengUmum, 'periode gaji <span class="required">*</span>', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modPengUmum,
                        'attribute' => 'periodegaji',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => 'MM yy',
                            'changeYear' => true,
                            'changeMonth' => true,
                            'changeDate' => false,
                            'showSecond' => false,
                            'showDate' => false,
                            'showMonth' => false,
                            // 'timeFormat' => 'hh:mm:ss',
                        ),
                        'htmlOptions' => array(
                            'readonly' => true,
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'class' => 'span3 dtPicker3',
                            //                            'onChange'=>'ambilDataGaji()',
                        ),
                    ));
                    ?>
                </div>
                <div class="control-group">
                    <?php $modPengUmum->tglpengeluaran = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPengUmum->tglpengeluaran, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                    <?php echo $form->labelEx($modPengUmum, 'tglpengeluaran', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modPengUmum,
                            'attribute' => 'tglpengeluaran',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'class' => 'dtPicker2-5 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>

                    </div>
                </div>

            </td>
            <td>
                <?php echo $form->textFieldRow($modPengUmum, 'nopengeluaran', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <?php echo $form->dropDownListRow($modPengUmum, 'kelompoktransaksi', LookupM::getItems('kelompoktransaksi'), array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->hiddenField($modPengUmum, 'jenispengeluaran_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <div class="control-group">
                    <?php //echo $form->labelEx($modPengUmum,'jenispengeluaran_id', array('class'=>'control-label')) 
                    ?>
                    <div class="controls">
                        <?php
                        //                            $this->widget('MyJuiAutoComplete', array(
                        //                                    'model'=>$modPengUmum,
                        //                                    'attribute'=>'jenisKodeNama',
                        //                                    'source'=>'js: function(request, response) {
                        //                                                   $.ajax({
                        //                                                       url: "'.Yii::app()->createUrl('billingKasir/ActionAutoComplete/jenisPengeluaran').'",
                        //                                                       dataType: "json",
                        //                                                       data: {
                        //                                                           term: request.term,
                        //                                                       },
                        //                                                       success: function (data) {
                        //                                                               response(data);
                        //                                                       }
                        //                                                   })
                        //                                                }',
                        //                                     'options'=>array(
                        //                                           'showAnim'=>'fold',
                        //                                           'minLength' => 2,
                        //                                           'focus'=> 'js:function( event, ui ) {
                        //                                               $(this).val(ui.item.value);
                        //                                                return false;
                        //                                            }',
                        //                                           'select'=>'js:function( event, ui ) {
                        //                                                $("#KUPengeluaranumumT_jenispengeluaran_id").val(ui.item.jenispengeluaran_id);
                        //                                                getDataRekeningPengeluaran(ui.item.jenispenerimaan_id);
                        //                                                return false;
                        //                                            }',
                        //                                    ),
                        //                                    'htmlOptions'=>array('placeholder'=>'Nama Jenis Pengeluaran','class'=>'reqForm', 'readonly'=>true),
                        //                                    // 'tombolDialog' => array('idDialog' => 'dialogJenisPengeluaran',),
                        //                            )); 
                        ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($modPengUmum,'volume',array('onblur'=>'hitungTotalHarga()','class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <?php //echo $form->dropDownListRow($modPengUmum,'satuanvol', LookupM::getItems('satuanumum'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
                ?>
                <div class="control-group">
                    <?php echo $form->hiddenField($modPengUmum, 'volume', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($modPengUmum, 'volume', array('onblur' => 'hitungTotalHarga()', 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php // echo $form->hiddenField($modPengUmum,'satuanvol', LookupM::getItems('satuanumum'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50));  
                        ?>
                    </div>
                </div>
                <?php echo $form->hiddenField($modPengUmum, 'hargasatuan', array('onblur' => 'hitungTotalHarga()', 'class' => 'inputFormTabel currency reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->hiddenField($modPengUmum, 'totalharga', array('readonly' => true, 'class' => 'inputFormTabel currency', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                <?php echo $form->textAreaRow($modPengUmum, 'keterangankeluar', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Jumlah Gaji', 'jmlgaji', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::TextField('jmlgaji', number_format($modPengUmum->jmlgaji), array('readonly' => true, 'class' => 'span2',)); ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($modPengUmum,'namapenandatangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100));  
                ?>
                <?php //echo $form->textFieldRow($modPengUmum,'nippenandatangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100));  
                ?>
                <?php //echo $form->textFieldRow($modPengUmum,'jabatanpenandatangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100));  
                ?>
                <?php //echo $form->dropDownListRow($modPengUmum,'penjamin_id', CHtml::listData($modPengUmum->getPenjaminItems(1), 'penjamin_id', 'penjamin_nama'), array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  
                ?>

            </td>
        </tr>
    </table>
    <div class="block-tabel">
        <h6>
            <?php echo $form->checkBox($modPengUmum, 'isurainkeluarumum', array('checked' => true, 'onchange' => 'bukaUraian(this)', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            Pilih Jika <b>Transaksi Ada Uraiannya</b>
        </h6>
        <div id="div_tblInputUraian">
            <table id="tblInputUraian" class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <th>
                            Uraian <span class="required">*</span>
                        </th>
                        <th>Volume</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $this->renderPartial('_rowUraian', array('form' => $form, 'modUraian' => $modUraian, 'removeButton' => true)); ?>
                </tbody>
            </table>
        </div>
    </div>

    <!--<legend class="rim">Jurnal Rekening</legend>-->
    <table style="width: 100%; border: none;">
        <tr>
            <!--<td width="70%">-->
            <!--<div>-->
            <?php
            //                        $this->renderPartial('akuntansi.views.penerimaanUmum._rowListRekening',
            //                            array(
            //                                'form'=>$form,
            //                            )
            //                        );
            ?>
            <!--</div>-->
            <!--</td>-->
            <td width="15%">
                <div class="control-group">
                    <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                    <?php echo $form->labelEx($modBuktiKeluar, 'tglkaskeluar', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modBuktiKeluar,
                            'attribute' => 'tglkaskeluar',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'class' => 'dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>

                    </div>
                </div>
                <?php // echo $form->dropDownListRow($modBuktiKeluar,'tahun', Params::tahun(),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>4));  
                ?>
                <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                <?php echo $form->textFieldRow($modBuktiKeluar, 'nokaskeluar', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true)); ?>
                <?php echo $form->hiddenField($modBuktiKeluar, 'biayaadministrasi', array('onkeyup' => 'hitungJmlBayar();', 'class' => 'inputFormTabel currency span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modBuktiKeluar, 'jmlkaskeluar', array('readonly' => true, 'class' => 'inputFormTabel currency span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->dropDownListRow($modBuktiKeluar, 'carabayarkeluar', LookupM::getItems('carabayarkeluar'), array('onchange' => 'formCarabayar(this.value)', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <div id="divCaraBayarTransfer" class="hide">
                    <?php echo $form->textFieldRow($modBuktiKeluar, 'melalubank', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($modBuktiKeluar, 'denganrekening', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($modBuktiKeluar, 'atasnamarekening', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                </div>

            </td>
            <td width="15%">
                <?php echo $form->textFieldRow($modBuktiKeluar, 'namapenerima', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textAreaRow($modBuktiKeluar, 'alamatpenerima', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modBuktiKeluar, 'untukpembayaran', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </td>
        </tr>
    </table>

    <div class="form-actions">
        <!--<div style="float:left;margin-right:6px;">-->
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
        $urlSave = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/index');
        if (!isset($_GET['sukses'])) {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'simpanPengeluaran(\'jurnal\');return false;', 'onKeypress' => 'return simpanPengeluaran(\'jurnal\');'));
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-default', 'onclick' => 'return refreshForm(this);'));
            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
        } else {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-default', 'onclick' => 'return refreshForm(this);'));
            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onClick' => 'print("PRINT")'));
        }
        //                $this->widget('bootstrap.widgets.BootButtonGroup', array(
        //                    'type'=>'primary',
        //                    'buttons'=>array(
        //                        array(
        //                            'label'=>'Simpan',
        //                            'icon'=>'entypo-check',
        //                            'url'=>"#",
        //                            'htmlOptions'=>
        //                                array(
        //                                    'onclick'=>'simpanPengeluaran(\'jurnal\');return false;',
        //                                )
        //                       ),
        //                        array(
        //                            'label'=>'',
        //                            'items'=>array(
        //                                array(
        //                                    'label'=>'Posting',
        //                                    'icon'=>'icon-ok',
        //                                    'url'=>"#",
        //                                    'itemOptions' => array(
        //                                        'onclick'=>'simpanPengeluaran(\'posting\');return false;'
        //                                    )
        //                                ),
        //                            )
        //                        ),
        //                    ),
        //                ));
        //                echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), array('style'=>'display:none','id' => 'reseter', 'class' => 'btn btn-default', 'type'=>'reset'));
        ?>
        <!--</div>-->
        <?php
        //			echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
        //                Yii::app()->createUrl($this->module->id.'/pembayaranJasa/create'), 
        //                array('class' => 'btn btn-default',
        //                      'onclick'=>'return refreshForm(this);'));
        ?>
        <?php // echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"printKasir($('#FAPendaftaranT_pendaftaran_id').val());return false",'disabled'=>false)); 
        ?>
        <?php
        $content = $this->renderPartial('../tips/transaksi', array(), true);
        //    $this->widget('TipsMasterData',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
    <?php $this->endWidget(); ?>
    </fieldset>
    <?php
    $urlPrint = $this->createUrl('Print&tandabuktikeluar_id=' . $modBuktiKeluar->tandabuktikeluar_id);
    $js = <<< JSCRIPT
function print(caraPrint){
	window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=890px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>
    <script type="text/javascript">
        var trUraian = new String(<?php echo CJSON::encode($this->renderPartial('_rowUraian', array('form' => $form, 'modUraian' => array(0 => $modUraian[0]), 'removeButton' => true), true)); ?>);

        $('.currency').each(function() {
            this.value = formatNumber(this.value)
        });

        function simpanPengeluaran(params) {
            if (requiredCheck($("form"))) {
                var periode = $('#KUPengeluaranumumT_periodegaji').val();
                var namauraian_val = true;
                var uraiantransaksi = '';
                if (periode == null || periode == '') {
                    myAlert('Periode Gaji Belum Dipilih!');
                    $('#KUPengeluaranumumT_periodegaji').focus();
                } else {
                    jenis_simpan = params;
                    //    var kosong = "" ;
                    //    var dataKosong = $("#input-pengeluaran").find(".reqForm[value="+ kosong +"]");
                    //    if(dataKosong.length > 0){
                    //        alert('Bagian dengan tanda * harus diisi ');
                    //    }else{
                    var detail = 0;
                    $('#tblInputUraian tbody tr').each(
                        function() {
                            detail++;
                        }
                    );

                    if (detail > 0) {

                        $('#tblInputUraian tbody tr').each(function() {
                            $(this).find("input[name$='[uraiantransaksi]']").val();
                            uraiantransaksi = $(this).find("input[name$='[uraiantransaksi]']").val();
                            if (uraiantransaksi != '') {
                                namauraian_val = true;
                            } else {
                                namauraian_val = false
                            }
                        });
                        if ($("#KUPengeluaranumumT_isurainkeluarumum").is(':checked')) {
                            if (namauraian_val) {
                                $('.currency').each(
                                    function() {
                                        this.value = unformatNumber(this.value)
                                    }
                                );
                                $('#akpengeluaran-umum-t-form').submit();
                            } else {
                                myAlert('Nama Uraian tidak boleh Kosong');
                            }
                        } else {
                            $('.currency').each(
                                function() {
                                    this.value = unformatNumber(this.value)
                                }
                            );
                            $('#akpengeluaran-umum-t-form').submit();
                        }

                        /*MENGGUNAKAN METHOD POST PHP
                         $.post('<?php // echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/SimpanPengeluaran'); 
                                    ?>', {jenis_simpan:jenis_simpan, data:$('#akpengeluaran-umum-t-form').serialize()},
                         function(data){
                         if(data.status == 'ok')
                         {
                         if(data.action == 'insert')
                         {
                         alert("Simpan data berhasil");
                         $("#tblInputUraian").find('tr[class$="child"]').detach();
                         $("#reseter").click();
                         $("#input-pengeluaran").find("input[name$='[nopengeluaran]']").val(data.pesan.nopengeluaran);
                         $("#input-pengeluaran").find("input[name$='[nokaskeluar]']").val(data.pesan.nokaskeluar);
                         $("#tblInputRekening > tbody").find('tr').detach();
                         }else{
                         alert("Update data berhasil");
                         }
                         }
                         }, "json");
                         */
                    } else {
                        alert('Detail uraian masih kosong');
                    }
                }
            }

            //    }

        }

        function cekInput() {
            var harga = 0;
            var totharga = 0;
            if ($('#KUPengeluaranumumT_isuraintransaksi').is(':checked')) {
                $('#tblInputUraian').find('input[name$="[hargasatuan]"]').each(function() {
                    harga = harga + unformatNumber(this.value);
                });
                $('#tblInputUraian').find('input[name$="[totalharga]"]').each(function() {
                    totharga = totharga + unformatNumber(this.value);
                });

                //if(harga != unformatNumber($('#KUPengeluaranumumT_hargasatuan').val())){
                //    alert('Harga tidak sesuai');return false;
                //}
                if (totharga != unformatNumber($('#KUPengeluaranumumT_totalharga').val())) {
                    alert('Harga Uraian tidak sesuai');
                    return false;
                }
            }
            $('.currency').each(function() {
                this.value = unformatNumber(this.value)
            });

            return true;
        }

        function hitungTotalUraian(obj) {
            var volume = unformatNumber($(obj).parents('tr').find('input[name$="[volume]"]').val());
            var hargasatuan = unformatNumber($(obj).parents('tr').find('input[name$="[hargasatuan]"]').val());

            $(obj).parents('tr').find('input[name$="[totalharga]"]').val(formatNumber(volume * hargasatuan));
        }

        function hitungTotalHarga() {
            var biayaAdministrasi = unformatNumber($('#KUTandabuktikeluarT_biayaadministrasi').val());
            var vol = unformatNumber($('#KUPengeluaranumumT_volume').val());
            var harga = unformatNumber($('#KUPengeluaranumumT_hargasatuan').val());

            $('#KUPengeluaranumumT_totalharga').val(formatNumber(vol * harga));
            $('#KUTandabuktikeluarT_jmlkaskeluar').val(formatNumber(vol * harga + biayaAdministrasi));
        }

        function totalHarga() {
            var totalharga = 0;
            $('#tblInputUraian tr').each(function() {
                totalharga += unformatNumber($(this).find('input[name$="[totalharga]"]').val());
            });
            $('#KUTandabuktikeluarT_jmlkaskeluar').val(formatNumber(totalharga));
        }

        function hitungJmlBayar() {
            var biayaAdministrasi = unformatNumber($('#KUTandabuktikeluarT_biayaadministrasi').val());
            var totBayar = 0;
            var totHarga = unformatNumber($('#total_uraian').val());

            totBayar = totHarga + biayaAdministrasi;

            $('#KUTandabuktikeluarT_jmlkaskeluar').val(formatNumber(totBayar));
        }

        function bukaUraian(obj) {
            if ($(obj).is(':checked')) {
                $('#div_tblInputUraian').slideDown();
            } else {
                $('#div_tblInputUraian').slideUp();
            }
        }
        /*
         function bukaUraian(obj)
         {
         if($(obj).is(':checked')){
         $('#tblInputUraian').children('tbody').slideDown();
         } else {
         $('#tblInputUraian').children('tbody').slideUp();
         }
         }
         */
        function addRowUraian(obj) {
            $(obj).parents('table').children('tbody').append(trUraian.replace());

            renameInput('KUUraiankeluarumumT', 'uraiantransaksi');
            renameInput('KUUraiankeluarumumT', 'volume');
            renameInput('KUUraiankeluarumumT', 'satuanvol');
            renameInput('KUUraiankeluarumumT', 'hargasatuan');
            renameInput('KUUraiankeluarumumT', 'totalharga');
            jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({
                "placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"
            });
            maskMoneyInput($('#tblInputUraian > tbody > tr:last'));
        }

        function batalUraian(obj) {
            if (confirm('Apakah Anda yakin akan membatalkan Uraian?')) {
                // $(obj).parents('tr').next('tr').detach();
                $(obj).parents('tr').detach();

                renameInput('KUUraiankeluarumumT', 'uraiantransaksi');
                renameInput('KUUraiankeluarumumT', 'volume');
                renameInput('KUUraiankeluarumumT', 'satuanvol');
                renameInput('KUUraiankeluarumumT', 'hargasatuan');
                renameInput('KUUraiankeluarumumT', 'totalharga');

            }
        }

        function renameInput(modelName, attributeName) {
            var trLength = $('#tblInputUraian tr').length;
            var i = -1;
            var total = 0;
            var j = 0;
            $('#tblInputUraian tr').each(function() {
                if ($(this).has('input[name$="[uraiantransaksi]"]').length) {
                    i++;
                }
                $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
                $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
                $(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
                $(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');

                if (attributeName == 'totalharga') {
                    var totalharga = unformatNumber($('#' + modelName + '_' + i + '_totalharga').val());
                    if (totalharga == 'undefined' || totalharga == null || totalharga == '') {
                        totalharga = 0;
                    }
                    if (i != j) {
                        total += parseFloat(totalharga);
                    }
                    j = i;
                }
            });
            if (attributeName == 'totalharga') {
                $('#total_uraian').val(formatNumber(total));
                $('#KUTandabuktikeluarT_jmlkaskeluar').val(formatNumber(total));
                $('#RekeningakuntansiV_0_saldokredit').val(formatNumber(total));
                // $('#RekeningakuntansiV_1_saldokredit').val(total);
            }
            // alert(total);
        }

        function formCarabayar(carabayar) {
            //alert(carabayar);
            if (carabayar == 'TRANSFER') {
                $('#divCaraBayarTransfer').slideDown();
            } else {
                $('#divCaraBayarTransfer').slideUp();
            }
        }

        function unMaskMoneyInput(tr) {
            $(tr).find('input.currency:text').unmaskMoney();
        }

        function maskMoneyInput(tr) {
            $(tr).find('input.currency:text').maskMoney({
                "symbol": "Rp ",
                "defaultZero": true,
                "allowZero": true,
                "decimal": ".",
                "thousands": ",",
                "precision": 0
            });
        }

        function ambilDataGaji() {
            var periode = $('#KUPengeluaranumumT_periodegaji').val();
            $.post('<?php echo Yii::app()->createUrl('akuntansi/actionAjax/ambilDataGaji'); ?>', {
                periode: periode
            }, function(data) {
                // alert(data);
                $("#tblInputUraian > tbody").empty();
                // $('#tabledetailpinjaman').find('tbody').empty();
                $("#tblInputUraian > tbody").append(data.replace());
                // $('#PenggajiankompT_komponengaji_id_10').val(formatDesimal(data.jmltunjangan));
                var totaluraian = $('#total_uraian').val();
                $('#KUTandabuktikeluarT_jmlkaskeluar').val(totaluraian);
                $('#RekeningakuntansiV_0_saldokredit').val(totaluraian);
                // $('#RekeningakuntansiV_1_saldokredit').val(totaluraian);
                // maskMoneyAll();
                // $('#harikerja').val(data.jmlhadir);
                // $('#jmlefektifharikerja').val(data.jml_hari); 
                // $('#tunjharian').val(data.tunjanganharian);
            }, 'json');
            tampilRekening();
        }

        function tampilRekening() {
            var periode = $('#KUPengeluaranumumT_periodegaji').val();
            $.post('<?php echo Yii::app()->createUrl('akuntansi/actionAjax/tampilRekening'); ?>', {
                periode: periode
            }, function(data) {
                $("#tblInputRekening > tbody").empty();
                $("#tblInputRekening > tbody").append(data.replace());
                // maskMoneyAll();
            }, 'json');
        }
    </script>

    <?php
    //========= Dialog buat cari data Rek Kredit =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogJenisPengeluaran',
        'options' => array(
            'title' => 'Daftar Jenis Pengeluaran',
            'autoOpen' => false,
            'modal' => true,
            'width' => 600,
            'height' => 400,
            'resizable' => false,
        ),
    ));

    $modJenisPengeluaran = new JenispengeluaranM('search');
    $modJenisPengeluaran->unsetAttributes();
    if (isset($_GET['JenispengeluaranM'])) {
        $modJenisPengeluaran->attributes = $_GET['JenispengeluaranM'];
    }
    $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
        'id' => 'jenispengeluaran-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
        'dataProvider' => $modJenisPengeluaran->searchJnsPengeluaranInRek(),
        'filter' => $modJenisPengeluaran,
        'template' => "{pager}{summary}\n{items}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'No.',
                'value' => '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
            ),
            array(
                'header' => 'Jenis Pengeluaran',
                'name' => 'jenispengeluaran_nama',
                'value' => '$data->jenispengeluaran_nama',
            ),
            array(
                'header' => 'Nama Lain',
                'name' => 'jenispengeluaran_namalain',
                'value' => '$data->jenispengeluaran_namalain',
            ),
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectRekDebit",
                                    "onClick" =>"
                                        getDataRekeningPengeluaranGaji($data->jenispengeluaran_id);
                                        $(\"#KUPengeluaranumumT_jenispengeluaran_id\").val(\"$data->jenispengeluaran_id\");
                                        $(\"#KUPengeluaranumumT_jenisKodeNama\").val(\"$data->jenispengeluaran_nama\");
                                        $(\"#dialogJenisPengeluaran\").dialog(\"close\");    
                                        return false;
                            "))',
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
    //========= end Rek Kredit dialog =============================
    ?>