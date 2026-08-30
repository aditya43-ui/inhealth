<table width="100%" id ="riwayatrestrain" class = "table table-bordered table-striped table-condensed">
<thead>
    <tr>
        <th>Tipe Restrain</th>
        <th>Lamanya Restrain</th>
        <th>Frekuensi Evaluasi Penggunaan Restrain (Minimal setiap 24 Jam)</th>
    </tr>
</thead>
<tbody>

    <?php 
    if (!empty($model->observasirestrain_id)){
    $modDetail = ObservasirestraindetT::model()->findAllByAttributes(array('observasirestrain_id'=>$model->observasirestrain_id));
    if (count($modDetail) > 0){
        foreach ($modDetail as $i=>$data){?>
            <tr>
                <td> <?php echo $data->tiperestrain; ?> </td>       
                <td> <?php echo $data->lamarestrain; ?> </td>       
                <td> <?php  echo $data->frekuensirestrain; ?> </td>       
                
            </tr>
        <?php }
    }}?>

</tbody>
</table>