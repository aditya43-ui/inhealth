<tr>
    <td> 
        <label class="no-urut">1</label>   
    </td>
    <td>
        <?php
                echo CHtml::activeHiddenField($modDetail, '[0]notadinaspptkdet_jenisbarang',array('readonly'=>true,'class'=>'barang_id')); 
                echo CHtml::activeHiddenField($modDetail, '[0]notadinaspptkdet_id', array('class' => 'notadinaspptkdet_id span1', 'readonly' => true));
                echo CHtml::activeHiddenField($modDetail, '[0]barang_id', array('class' => 'barang_id span1', 'readonly' => true));
                echo CHtml::activeHiddenField($modDetail, '[0]dokumenpelaksanaananggarandet_id', array('class' => 'dokumenpelaksanaananggarandet_id span1', 'readonly' => true));
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modDetail,
                    'attribute' => '[0]notadinaspptkdet_uraian',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('/actionAutoComplete/getPegawai') . '",
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
                        'minLength' => 3,
                        'focus' => 'js:function(event, ui ) {
                            return false;
                        }',
                        'select' => 'js:function(event, ui ) {
                            $(this).val(ui.item.nomorindukpegawai);
                            $("#KUInvoicemasukT_yang_menyerahkan").val( ui.item.value );
                            return false;
                        }',
                    ),
                    'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'koderekening span2 required', 'placeholder' => 'Pilih Nama Uraian',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogMenyerahkan', 'jsFunction'=>'setCeklisSpesimen(); setDialogRincian("lokasi","dialogKode",this);'),
                ));
                echo CHtml::activeHiddenField($modDetail, '[0]sisapagu_pengadaan', array('readonly' => false, 'class' => 'sisapagu_pengadaan integer-decimal'));
                echo CHtml::activeHiddenField($modDetail, '[0]jumlah_awal', array('readonly' => false, 'class' => 'jumlah_awal integer-decimal'));
                echo CHtml::activeHiddenField($modDetail, '[0]selisih', array('readonly' => false, 'class' => 'selisih integer-decimal'));
                echo CHtml::activeHiddenField($modDetail, '[0]sisapagu_pengadaan_baru', array('readonly' => false, 'class' => 'sisapagu_pengadaan_baru integer-decimal'));
                echo CHtml::activeHiddenField($modDetail, '[0]sisavolume_pengadaan', array('readonly' => false, 'class' => 'sisavolume_pengadaan integer-decimal'));
                echo CHtml::activeHiddenField($modDetail, '[0]volume_awal', array('readonly' => false, 'class' => 'volume_awal integer-decimal'));
                echo CHtml::activeHiddenField($modDetail, '[0]volume_baru', array('readonly' => false, 'class' => 'volume_baru integer-decimal'));
        ?>
    </td>
    <td style="text-align: right"><?php
        echo CHtml::activeTextField($modDetail, '[0]barang_volume', array('readonly' => false, 'onblur' => 'hitungJumlahBaris(this)', 'class' => 'span1 barang_volume integer-decimal'));
        ?></td>
    <td style="text-align: right"><?php
        echo CHtml::activeTextField($modDetail, '[0]barang_satuan', array('readonly' => true, 'class' => 'span1 barang_satuan'));
        ?></td>
    <td style="text-align: right"><?php
        echo CHtml::activeTextField($modDetail, '[0]pajak_persen', array('readonly' => false, 'onblur' => 'hitungJumlahBaris(this)', 'class' => 'span1 pajak_persen integer-decimal'));
        ?></td>
    <td style="text-align: right"><?php
        echo CHtml::activeTextField($modDetail, '[0]harga_satuan', array('readonly' => false, 'onblur' => 'hitungJumlahBaris(this)', 'class' => 'span2 harga_satuan integer-decimal'));
        ?></td>
    <td style="text-align: right"><?php
        echo CHtml::activeTextField($modDetail, '[0]jumlah_harga', array('readonly' => true, 'class' => 'span2 jumlah_harga integer-decimal'));
        ?></td>
    <td style="text-align: right"><?php
        echo CHtml::activeTextField($modDetail, '[0]jumlah_diterima', array('readonly' => false, 'onblur' => 'hitungHargaBaris(this)', 'class' => 'span2 jumlah_diterima integer-decimal'));
        ?></td>
    <td><?php
        echo CHtml::activeTextField($modDetail, '[0]pagu', array('readonly' => true, 'class' => 'span2 pagu integer-decimal' ));
        ?></td>
    <td><?php
        echo CHtml::activeTextField($modDetail, '[0]serapan', array('readonly' => true, 'class' => 'span2 serapan integer-decimal' ));
        ?></td>
    <td><?php
        echo CHtml::activeTextField($modDetail, '[0]sisa', array('readonly' => true, 'class' => 'span2 sisa integer-decimal' ));
        ?></td>
    <td><?php echo CHtml::activeTextArea($modDetail, '[0]notadinaspptkdet_ket', array('class' => 'span3 notadinaspptkdet_ket', 'rows' => 3)); ?></td>
    <td>
        <?php                
            echo CHtml::link('<span style="color:red;font-size:15px;"><i class="glyphicon glyphicon-minus"></i></span>', "javascript:;", array('class'=>'btnhapus hide','onclick'=>'hapusBaris(this); return false;',));                    
            echo CHtml::link('<span style="font-size:15px;"><i class="glyphicon glyphicon-plus"></i></span>', "javascript:;", array('class'=>'btntambah ','onclick'=>'tambahBaris(this); return false;',));                
        ?>
    </td>
</tr>