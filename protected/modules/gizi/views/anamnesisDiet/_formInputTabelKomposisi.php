<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Komposisi Makanan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table class="items table table-bordered table-condensed" id="tblInputKomposisi">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Waktu Makan</th>
                    <th>Menu Diet</th>
                    <th>Nama Makanan</th>
                    <th>Satuan</th>
                    <th>Berat Bahan<br>(gr)</th>
                    <th>Energi Kalori <br> (Kal)</th>
                    <th>Protein <br> (g)</th>
                    <th>Lemak <br> (g)</th>
                    <th>Hidrat Arang <br> (g) </th>
                    <th>Ket. Pekerjaan</th>
                    <th>URT</th>
                    <th>Keterangan</th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
                <tr class="trfooter">
                    <td colspan="5">Total</td>
                    <td>
                        <?php echo CHtml::textField("totBeratBahan", 0, array('readonly' => false, 'class' => 'inputFormTabel numbersOnly lebar3 totberatbahan float2', 'style' => 'width:80px; text-align: right',)); ?>
                    </td>
                    <td>
                        <?php echo CHtml::textField("totEnergiKalori", 0, array('readonly' => false, 'class' => 'inputFormTabel numbersOnly lebar3 totenergikalori float2', 'style' => 'width:80px; text-align: right',)); ?>
                    </td>
                    <td>
                        <?php echo CHtml::textField("totProtein", 0, array('readonly' => false, 'class' => 'inputFormTabel numbersOnly lebar3 totprotein float2', 'style' => 'width:80px; text-align: right',)); ?>
                    </td>
                    <td>
                        <?php echo CHtml::textField("totLemak", 0, array('readonly' => false, 'class' => 'inputFormTabel numbersOnly lebar3 totlemak float2', 'style' => 'width:80px; text-align: right',)); ?>
                    </td>
                    <td>
                        <?php echo CHtml::textField("totHidratArang", 0, array('readonly' => false, 'class' => 'inputFormTabel numbersOnly lebar3 tothidratarang float2', 'style' => 'width:80px; text-align: right',)); ?>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>