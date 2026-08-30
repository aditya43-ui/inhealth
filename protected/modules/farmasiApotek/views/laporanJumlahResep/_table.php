<?php
$itemCssClass = 'table table-bordered table-striped table-condensed';
if (isset($caraPrint)) {
    echo "
        <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing: 0;
                padding: 0;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
    $itemCssClass = 'table border';
}
?>
<div class="grid-view" id="laporan-grid">
    <table class="<?php echo $itemCssClass ?>">
        <thead>
            <tr>
                <th style="text-align: center; ">No</th>
                <?php foreach ($lookup_m as $value) { ?>
                    <th><?php echo $value; ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($resultLaporanJumlahResep as $data) {
            ?>
                <tr>
                    <td style="text-align: center; "><?php echo $no++ . '.'; ?></td>
                    <?php foreach ($lookup_m as $key => $value) { ?>
                        <td><?php echo $data->$key; ?></td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
        <!-- <tfoot>
            <tr>
                <th>Total</th>
                <?php //echo FALaporanlembarresepV::model()->getCaraBayarTotal($tgl_awal, $tgl_akhir); 
                ?>
            </tr>
        </tfoot> -->
    </table>
</div>