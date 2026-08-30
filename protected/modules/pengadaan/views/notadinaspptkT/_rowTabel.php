<tr>
    <td><?php
        echo $i;
        echo CHtml::activeHiddenField($modDet, '[' . $i . ']dokumenpelaksanaananggarandet_id', array('readonly' => true, 'class' => 'dokumenpelaksanaananggarandet_id'));
        echo CHtml::activeHiddenField($modDet, '[' . $i . ']barang_id', array('readonly' => true, 'class' => 'barang_id'));
        echo CHtml::activeHiddenField($modDet, '[' . $i . ']notadinaspptkdet_jenisbarang', array('readonly' => true, 'class' => 'barang_id'));
        ?>
    </td>
    <td>
        <?php
        echo $this->widget('MyDateTimePicker', array(
            'model' => $modDet,
            'attribute' => '[' . $i . ']notadinaspptkdet_tanggal',
            'mode' => 'date',
            'htmlOptions' => array(
                'size' => '10',
                'style' => 'width:150px',
                'class' => 'notadinaspptkdet_tanggal'
            ),
            'options' => array(// (#3)                    
                'dateFormat' => Params::DATE_FORMAT,
            ),
                ), true);
        ?>
    </td>
    <td><?php
        echo CHtml::activeHiddenField($modDet, '[' . $i . ']notadinaspptkdet_uraian', array('readonly' => true, 'class' => 'span3 notadinaspptkdet_uraian'));
        echo $modDet->notadinaspptkdet_uraian;
        ?></td>
    <td style="text-align: right"><?php
        echo CHtml::activeHiddenField($modDet, '[' . $i . ']barang_volume', array('readonly' => true, 'class' => 'span1 barang_volume numbers-only'));
        echo $modDet->barang_volume;
        ?></td>
    <td style="text-align: right"><?php
        echo CHtml::activeHiddenField($modDet, '[' . $i . ']barang_satuan', array('readonly' => true, 'class' => 'span1 barang_volume'));
        echo $modDet->barang_satuan;
        ?></td>
    <td style="text-align: right"><?php
        echo CHtml::activeHiddenField($modDet, '[' . $i . ']pajak_persen', array('readonly' => true, 'class' => 'span1 pajak_persen integer-decimal'));
        echo $modDet->pajak_persen;
        ?></td>
    <td style="text-align: right"><?php
        echo CHtml::activeHiddenField($modDet, '[' . $i . ']harga_satuan', array('readonly' => true, 'class' => 'span2 harga_satuan integer-decimal'));
        echo "Rp. " . $modDet->harga_satuan;
        ?></td>
    <td style="text-align: right"><?php
        echo CHtml::activeHiddenField($modDet, '[' . $i . ']jumlah_harga', array('readonly' => true, 'class' => 'span2 jumlah_harga integer-decimal'));
        echo "Rp. " . $modDet->jumlah_harga;
        ?></td>
    <td style="text-align: right"><?php
        echo CHtml::activeHiddenField($modDet, '[' . $i . ']jumlah_diterima', array('readonly' => true, 'class' => 'span2 jumlah_diterima integer-decimal' ));
        echo "Rp. " . $modDet->jumlah_diterima;
        ?></td>
    <td style="text-align: right"><?php
        echo CHtml::activeHiddenField($modDet, '[' . $i . ']pagu', array('readonly' => true, 'class' => 'span2 pagu integer-decimal' ));
        echo "Rp. " . number_format($modDet->pagu, 2, ",", ".");
        ?></td>
    <td style="text-align: right"><?php
        echo CHtml::activeHiddenField($modDet, '[' . $i . ']serapan', array('readonly' => true, 'class' => 'span2 serapan integer-decimal' ));
        echo "Rp. " . number_format($modDet->serapan, 2, ",", ".");
        ?></td>
    <td style="text-align: right"><?php
        echo CHtml::activeHiddenField($modDet, '[' . $i . ']sisa', array('readonly' => true, 'class' => 'span2 sisa integer-decimal' ));
        echo "Rp. " . number_format($modDet->sisa, 2, ",", ".");
        ?></td>
    <td><?php echo CHtml::activeTextArea($modDet, '[' . $i . ']notadinaspptkdet_ket', array('class' => 'span3 notadinaspptkdet_ket', 'rows' => 3)); ?></td>
    <td>
        <?php
        echo CHtml::link('<span style="color:red;font-size:15px;"><i class="glyphicon glyphicon-minus"></i></span>', "javascript:;", array('class' => 'btnhapus hide', 'onclick' => 'hapusBaris(this); return false;',));
        echo CHtml::link('<span style="font-size:15px;"><i class="glyphicon glyphicon-plus"></i></span>', "javascript:;", array('class' => 'btntambah ', 'onclick' => 'tambahBaris(this); return false;',));
        ?>
    </td>
</tr>