<ul>
<?php
$criteria=new CDbCriteria;
$criteria->select = 'obatalkes.*,t.*,jeniskasuspenyakit.*';
if(!empty($formulariumobat_id)){
	$criteria->addCondition("t.formulariumobat_id = ".$formulariumobat_id);						
}
$criteria->join = 'LEFT JOIN obatalkes_m obatalkes ON t.obatalkes_id = obatalkes.obatalkes_id '
                    . '  LEFT JOIN jeniskasuspenyakit_m jeniskasuspenyakit ON t.formulariumobat_id = jeniskasuspenyakit.formulariumobat_id';
$modKasuspenyakitobat = FAFormulariumobatM::model()->findAll($criteria);
foreach ($modKasuspenyakitobat as $row){
    echo '<li>'.$row->obatalkes_nama.'</li>';
}
?>
</ul>
