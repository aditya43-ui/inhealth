<ul>
<?php
$modDiagnosaobat = DiagnosaobatM::model()->findAllByAttributes(array('diagnosa_id'=>$diagnosa_id));
foreach ($modDiagnosaobat as $row){
    echo '<li>'.$row->obatalkes->obatalkes_nama.'</li>';
}
?>

    </ul>