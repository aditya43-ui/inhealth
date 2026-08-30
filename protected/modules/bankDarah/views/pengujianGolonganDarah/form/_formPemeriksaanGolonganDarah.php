<style>
    #table-pemeriksaangolongandarah th, td{
        text-align: center;
    }
</style>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i>Tabel Lembar Pemeriksaan <b>Golongan Darah</b>
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered table-condensed" width="100" id="table-pemeriksaangolongandarah">
            <thead>
                <tr>
                    <th colspan="13">LEMBAR PEMERIKSAAN GOLONGAN DARAH</th>
                </tr>
                <tr>
                    <th colspan="4">Mayor</th>
                    <th colspan="4">Minor</th>
                    <th rowspan="2">Auto Kontrol</th>
                    <th rowspan="2">Screening AB</th>
                    <th rowspan="2">Imidiate Spin</th>
                    <th rowspan="2">Kesimpulan</th>
                    <th rowspan="2">Catatan</th>
                </tr>
                <tr>
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                    
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <!-- mayor -->
                    <td>
                        <?php echo CHtml::activeDropDownList($modPemeriksaanDarah, 'mayor1',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'mayor1 span1','empty'=>'-- Pilih --')) ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($modPemeriksaanDarah, 'mayor2',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'mayor2 span1','empty'=>'-- Pilih --')) ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($modPemeriksaanDarah, 'mayor3',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'mayor3 span1','empty'=>'-- Pilih --')) ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($modPemeriksaanDarah, 'mayor4',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'mayor4 span1','empty'=>'-- Pilih --')) ?>
                    </td>

                    <!-- minor -->
                    <td>
                        <?php echo CHtml::activeDropDownList($modPemeriksaanDarah, 'minor1',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'minor1 span1','empty'=>'-- Pilih --')) ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($modPemeriksaanDarah, 'minor2',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'minor2 span1','empty'=>'-- Pilih --')) ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($modPemeriksaanDarah, 'minor3',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'minor3 span1','empty'=>'-- Pilih --')) ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($modPemeriksaanDarah, 'minor4',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'minor4 span1','empty'=>'-- Pilih --')) ?>
                    </td>

                    <!-- auto kontrol -->
                    <td>
                        <?php echo CHtml::activeDropDownList($modPemeriksaanDarah, 'autocontrol_goldar',LookupM::getItems('pemeriksaan_goldar'),array('class'=>'autocontrol_goldar span1','empty'=>'-- Pilih --')) ?>
                    </td>

                    <td>
                        <?php echo CHtml::activeDropDownList($modPemeriksaanDarah, 'screeningab',['Positif' => 'Positif','Negatif' => 'Negatif'],array('class'=>'screeningab span1','empty'=>'-- Pilih --')) ?>
                    </td>

                    <td>
                        <?php echo CHtml::activeDropDownList($modPemeriksaanDarah, 'imediate_spin',['Positif' => 'Positif','Negatif' => 'Negatif'],array('class'=>'imediate_spin span1','empty'=>'-- Pilih --')) ?>
                    </td>

                    <td>
                        <?php echo CHtml::activeDropDownList($modPemeriksaanDarah, 'kesimpulan_goldar',LookupM::getItems('rilis'),array('class'=>'kesimpulan_goldar span1','empty'=>'-- Pilih --')) ?>
                    </td>

                    <td>
                        <?php echo CHtml::activeTextArea($modPemeriksaanDarah, 'catatan', array('class'=>'catatan span1','empty'=>'-- Pilih --')) ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>