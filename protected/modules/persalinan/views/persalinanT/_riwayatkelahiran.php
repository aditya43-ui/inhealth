<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Riwayat Kelahiran</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table width="100%" id="riwayatkelahiran" class="table table-bordered table-striped table-condensed">
            <thead>
                <tr>
                    <th style="text-align:center;"> Anak Ke - </th>
                    <th style="text-align:center;"> Keterangan </th>
                    <th style="text-align:center;"> Batal </th>
                </tr>
            </thead>
            <tbody>
                <?php
                //if (!empty($modGinekologi->pemeriksaanginekologi_id)){
                //$modRiwayatKehamilan = PSRiwayatkehamilanT::model()->findAllByAttributes(array('pemeriksaanginekologi_id'=>$modGinekologi->pemeriksaanginekologi));
                if (isset($modRiwayatKehamilan)) {
                    foreach ($modRiwayatKehamilan as $i => $detail) { ?>

                        <tr>
                            <td> <?php echo Chtml::activeHiddenField($detail, '[' . $i . ']anak_ke', array('class' => '', 'readonly' => TRUE));
                                    echo $detail->anak_ke; ?> </td>
                            <td> <?php echo Chtml::activeHiddenField($detail, '[' . $i . ']keterangan', array('class' => '', 'readonly' => TRUE));
                                    echo $detail->keterangan;  ?> </td>
                            <td style="text-align:center;"> <?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick' => 'delRow(this); return false;')) ?> </td>
                        </tr>
                <?php }
                }
                //}
                ?>
            </tbody>
        </table>
    </div>
</div>