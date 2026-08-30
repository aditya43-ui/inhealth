<?php
$itemCssClass='table table-bordered table-striped table-condensed';
if (isset($caraPrint)){
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
    $itemCssClass='table border';
}
?>
<?php $modLaporanlembarresep = new FALaporanlembarresepV; ?>
<?php $model = FALaporanlembarresepV::model()->findAll(FALaporanlembarresepV::model()->criteriaLaporan($model)); ?>
<div class="grid-view" id="laporan-grid">    
    <table class="<?php echo $itemCssClass ?>">
        <thead>
            <tr>
                <th>Unit / Ruangan</th>
                <?php echo FALaporanlembarresepV::model()->getKolomCarabayarItems(); ?>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
			//var_dump($tgl_awal);
            $tr='';
                foreach ($model as $value)
                {
                    $tr = '<tr>';
                    $tr .= "<td>$value->instalasiasal_nama / $value->ruanganasal_nama</td>";
                    $tr .= FALaporanlembarresepV::model()->getCaraBayarValue('value', $value->instalasiasal_nama, $value->ruanganasal_nama, $tgl_awal, $tgl_akhir);
                    $tr .= FALaporanlembarresepV::model()->getCaraBayarValue('totalkeseluruhan', $value->instalasiasal_nama, $value->ruanganasal_nama, $tgl_awal, $tgl_akhir);
                    $tr .= '</tr>';
                    echo $tr;
                }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <?php echo FALaporanlembarresepV::model()->getCaraBayarTotal($tgl_awal, $tgl_akhir); ?>
            </tr>
        </tfoot>
    </table>
</div>