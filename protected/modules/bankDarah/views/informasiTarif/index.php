<div class="white-container">
    <legend class="rim2">Infomasi <b>Tarif Bank Darah</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="block-tabel">
        <h6>Tabel <b>Tarif Bank Darah</b></h6>
        <?php $format = new MyFormatter();
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'daftarTindakan-grid',
            'dataProvider' => $modTarifLab->searchTarif(),
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                ),
                'jenispemeriksaanlab_nama',
                'pemeriksaanlab_nama',
                'kelaspelayanan_nama',
                //            'harga_tariftindakan',
                array(
                    'header' => 'Tarif Pemeriksaan (Rp)',
                    'name' => 'harga_tariftindakan',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'value' => 'number_format($data->harga_tariftindakan,0,",",",")',
                ),
                //            array(
                //                'header'=>'Cyto (%)',
                //                'name'=>'persencyto_tind',
                //                'value'=>'$data->persencyto_tind',
                //            ),
                //            array(
                //                'name'=>'persendiskon_tind',
                //                'value'=>'$data->persendiskon_tind." %"',
                //            ),
                //            array(
                //                'name'=>'hargadiskon_tind',
                //                'value'=>'number_format($data->hargadiskon_tind)',
                //            ),
                array(
                    'header' => 'Periksa',
                    'type' => 'raw',
                    //                'value'=>'CHtml::checkBox("pilihPemeriksaan","", array("value"=>"$data->pemeriksaanlab_id"))',
                    'value' => 'CHtml::link("<i class=\'icon-form-periksa\'></i> ","javascript:void(0);" ,array("title"=>"Klik untuk Menambahkan Ke Daftar Pemeriksaan Total","onclick"=>"tambahDaftar(this);", "rel"=>"tooltip"))', 'htmlOptions' => array('style' => 'text-align: center; width:40px')
                ),
                //            array(
                //                'header'=>'',
                //                'type'=>'raw',
                //                'value'=>'number_format($data->harga_tariftindakan)',
                //                'htmlOptions'=>array('style'=>'width:0px')
                //            )

            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )); ?>
    </div>
    <div class="block-tabel">
        <h6>Daftar <b>Pemeriksaan Total</b></h6>
        <table class="table table-striped table-condensed">
            <thead>
                <th>Jenis Pemeriksaan</th>
                <th>Nama Pemeriksaan</th>
                <th>Kelas Pelayanan</th>
                <th>Tarif Pemeriksaan (Rp)</th>
                <th>Cyto (%)</th>
                <th colspan='2'>Tarif Cyto</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th width='50px'>Periksa</th>
            </thead>
            <tbody id="tabelDaftarPemeriksaanTotal">
                <tr>
                    <td colspan="8">
                        <p style="margin: 0; text-align: center;"><b>Total Pemeriksaan</b></p>
                    </td>
                    <td id="totalPemeriksaan"></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    <fieldset class="box">
        <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
        <?php
        Yii::app()->clientScript->registerScript('search', "

        $('#formCari').submit(function(){
                $.fn.yiiGridView.update('daftarTindakan-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ", CClientScript::POS_READY);
        ?>

        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'formCari',
            'type' => 'horizontal',
        )); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php
                echo $form->dropDownListRow(
                    $modTarifLab,
                    'instalasi_id',
                    CHtml::listData($modTarifLab->getInstalasiItems(), 'instalasi_id', 'instalasi_nama'),
                    array(
                        'class' => 'span3',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($modTarifLab))),
                            'update' => '#' . CHtml::activeId($modTarifLab, 'ruangan_id')
                        )
                    )
                );
                ?>
                <?php
                echo $form->dropDownListRow(
                    $modTarifLab,
                    'ruangan_id',
                    CHtml::listData($modTarifLab->getRuanganItems($modTarifLab->instalasi_id), 'ruangan_id', 'ruangan_nama'),
                    array(
                        'class' => 'span3',
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    )
                );
                ?>
                <?php echo $form->dropDownListRow($modTarifLab, 'jenistarif_id', CHtml::listData(JenistarifM::model()->findAllByAttributes(array('jenistarif_aktif' => true)), 'jenistarif_id', 'jenistarif_nama'), array('class' => 'span3')); ?>
                <?php
                echo $form->dropDownListRow(
                    $modTarifLab,
                    'kategoritindakan_id',
                    CHtml::listData(
                        $modTarifLab->getKategoritindakanItems(),
                        'kategoritindakan_id',
                        'kategoritindakan_nama'
                    ),
                    array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')
                );
                ?>
            </div>
            <div class="col-sm-6">
                <?php
                echo $form->dropDownListRow(
                    $modTarifLab,
                    'kelaspelayanan_id',
                    CHtml::listData(
                        $modTarifLab->getKelasPelayananItems(),
                        'kelaspelayanan_id',
                        'kelaspelayanan_nama'
                    ),
                    array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')
                );
                ?>
                <?php echo $form->textFieldRow($modTarifLab, 'pemeriksaanlab_nama', array('onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30, 'autofocus' => TRUE)); ?>
                <div class="control-group">
                    <div class="control-label">Jenis Penjamin</div>
                    <div class="controls">
                        <?php echo $form->dropDownList($modTarifLab, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll(), 'carabayar_id', 'carabayar_nama'), array(
                            'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('SetDropdownPenjaminPasien', array('encode' => false, 'namaModel' => get_class($modTarifLab))),
                                'update' => '#' . CHtml::activeId($modTarifLab, 'penjamin_id')
                            ),
                        )); ?>
                    </div>
                </div>
                <?php echo CHtml::label('Penjamin', ' Penjamin', array('class' => 'control-label')) ?>
                <?php echo $form->dropDownList($modTarifLab, 'penjamin_id', CHtml::listData(PenjaminpasienM::model()->findAll(), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                array('class' => 'btn btn-default', 'type' => 'reset')
            ); ?>
        </div>
        <?php $this->endWidget(); ?>
    </fieldset>
</div>
<script>
    $("#totalPemeriksaan").append('0');

    function resetPencarian() {
        $('#formCari').trigger("reset");
        $(".icon-search").trigger("click");
    }

    function tambahDaftar(obj) {
        //        myAlert('Dipilih!');
        //        var data = $(obj).parent().parent().html(); JIKA PER BARIS
        var jenisPemeriksaan = $(obj).parent().parent().find("td").eq(1).html();
        var namaPemeriksaan = $(obj).parent().parent().find("td").eq(2).html();
        var kelasPelayanan = $(obj).parent().parent().find("td").eq(3).html();
        var tarifTindakan = $(obj).parent().parent().find("td").eq(4).html();
        //        var persenCyto = $(obj).parent().parent().find("td").eq(5).html();
        var appendTxt = "<tr><td>" + jenisPemeriksaan + "</td><td>" + namaPemeriksaan + "</td><td>" + kelasPelayanan + "</td><td class='tarif'>" + tarifTindakan + "</td><td><input title='Ceklist untuk menambahkan tarif cyto' type='checkbox' class='isCyto' onclick='hitungSubtotal(this);'></td><td class='tarifCyto'></td><td><input class='span1 qty' type='text' maxlength='3' value='1' onkeyup='inputNumber(this); hitungSubtotal(this);'></td><td class='subtotal'>" + tarifTindakan + "</td><td><p style="
        margin: 0;
        text - align: center;
        "><a href='javascript:void(0);' onclick='hapusDaftar(this);'><i class='icon-minus' title='Klik untuk menghapus tindakan dari daftar ini'></i></a></p></td></tr>";
        $("#tabelDaftarPemeriksaanTotal").after(appendTxt);

        hitungTotalPemeriksaan();
    }

    function hapusDaftar(obj) {
        myConfirm("Apakah Anda akan menghapus pemeriksaan ini dari daftar?", "Perhatian!", function(r) {
            if (r) {
                var tarifTindakan = $(obj).parent().parent().parent().find("td").eq(3).html();
                tarifTindakan = 0 - unformatNumber(tarifTindakan); //untuk menghasilkan nilai minus
                $(obj).parent().parent().parent().detach();

                hitungTotalPemeriksaan();
            }
        });
    }

    function hitungSubtotal(obj) {
        var tarifCyto = 0;
        var subtotal = 0;
        var tarifTindakan = 0;
        var persenCyto = 0;
        var qty = 0;
        tarifTindakan = unformatNumber($(obj).parent().parent().find(".tarif").html());
        persenCyto = unformatNumber($(obj).parent().parent().find(".persenCyto").html());
        qty = unformatNumber($(obj).parent().parent().find(".qty").val());

        if ($(obj).parent().parent().find('.isCyto').is(':checked')) {
            tarifCyto = tarifTindakan * persenCyto / 100;
            $(obj).parent().parent().find(".tarifCyto").empty();
            $(obj).parent().parent().find(".tarifCyto").append(formatInteger(tarifCyto));
        } else {
            $(obj).parent().parent().find(".tarifCyto").empty();
        }
        subtotal = (tarifTindakan + tarifCyto) * qty;
        $(obj).parent().parent().find(".subtotal").empty();
        $(obj).parent().parent().find(".subtotal").append(formatInteger(subtotal));

        hitungTotalPemeriksaan();
    }

    function hitungTotalPemeriksaan() {
        var total = 0;
        $('.subtotal').each(
            function() {
                total += unformatNumber(($(this).html()));
            }
        );
        $("#totalPemeriksaan").empty();
        $("#totalPemeriksaan").append(formatInteger(total));
    }

    function inputNumber(obj) {
        var d = $(obj).attr('numeric');
        var value = $(obj).val();
        var orignalValue = value;
        value = value.replace(/[0-9]*/g, "");
        var msg = "Only Integer Values allowed.";

        if (d == 'decimal') {
            value = value.replace(/\./, "");
            msg = "Only Numeric Values allowed.";
        }

        if (value != '') {
            orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
            $(obj).val(orignalValue);
        }
    }
</script>