<ul>
<?php
$modKasuspenyakitdiagnosa = SAKasuspenyakitdiagnosaM::model()->findAllByAttributes(array('jeniskasuspenyakit_id'=>$jeniskasuspenyakit_id));
foreach ($modKasuspenyakitdiagnosa as $row){
    echo '<li>'.$row->diagnosa->diagnosa_nama.'</li>';
}
?>

    </ul>