<div class="block-tabel" id="frmGridJurnalRek">
    <table id="daftar-jural-rek-grid" class="table table-bordered table-condensed">
        <thead>
            <tr>
                <th rowspan="2">Pilih<br><?php 
                    echo CHtml::checkBox('checkAllObat',true, array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column','onclick'=>'checkAll()','checked'=>'checked')) ?>
                </th>
                <th rowspan="2">Tgl. Jurnal/<br>No. Bukti Jurnal</th>                
                <th rowspan="2">Kode Jurnal</th>
				<th rowspan="2">Tgl. Referensi/<br>No Referensi</th>
                <th rowspan="2">Kode Akun</th>                
                <th rowspan="2">Nama Akun</th>
				<th rowspan="2">Uraian Jurnal</th>
                <!--<th rowspan="2">Saldo Normal</th>-->
                
                <!--<th rowspan="2">Catatan</th>-->
				<th colspan="2"><p style="margin: 0; text-align: center;">Saldo<p style="margin: 0; text-align: center;"></th>
            </tr>
            <tr>
                <th>Debit</th>
                <th>Kredit</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
            <tr>
                <td colspan="7">Total</td>
                <td><?php echo CHtml::textField('total_debit', 0, array('readonly'=>true, 'class'=>'integerFloat span2', 'style'=>'width:100px;')); ?></td>
                <td><?php echo CHtml::textField('total_kredit', 0, array('readonly'=>true, 'class'=>'integerFloat span2', 'style'=>'width:100px')); ?></td>
            </tr>
        </tfoot>
    </table>
</div>