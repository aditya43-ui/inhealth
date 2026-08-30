<div>
    <legend class="rim"> Tabel Diet Pasien </legend>
    <table class="items table table-bordered table-condensed" id="tableDietPasien">
        <thead>
            <tr>
                <th>No.</th>
                <th>Tipe Diet</th>
                <th>Jenis Diet</th>
                <th>Energi Kalori <br> (Kal)</th>
                <th>Protein <br> (g) </th>
                <th>Lemak <br> (g) </th>
                <th>Hidrat Arang <br> (g) </th>
                <th>Diet Kandungan</th>
                <th>Alergi Dengan</th>
                <th>Keterangan</th>
                <th>Batal</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
            <tr class="trfooter">
                <td colspan="3">Total</td>
                <td>
                    <?php echo CHtml::textField("totEnergiKalori", 0, array('readonly' => false, 'class' => 'inputFormTabel numbersOnly lebar3 totenergikalori', 'style' => 'width:80px; text-align: right;',)); ?>
                </td>
                <td>
                    <?php echo CHtml::textField("totProtein", 0, array('readonly' => false, 'class' => 'inputFormTabel numbersOnly lebar3 totprotein', 'style' => 'width:80px; text-align: right;',)); ?>
                </td>
                <td>
                    <?php echo CHtml::textField("totLemak", 0, array('readonly' => false, 'class' => 'inputFormTabel numbersOnly lebar3 totlemak', 'style' => 'width:80px; text-align: right;',)); ?>
                </td>
                <td>
                    <?php echo CHtml::textField("totHidratArang", 0, array('readonly' => false, 'class' => 'inputFormTabel numbersOnly lebar3 tothidratarang', 'style' => 'width:80px; text-align: right;',)); ?>
                </td>
                <td>
                    <?php echo CHtml::textField("totDietKandungan", 0, array('readonly' => false, 'class' => 'inputFormTabel numbersOnly lebar3 tothidratarang', 'style' => 'width:80px; text-align: right;',)); ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>