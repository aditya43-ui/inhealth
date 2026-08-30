<ul>
<?php
$criteria=new CDbCriteria;
$criteria->select = 'obatalkes.*,t.*,jeniskasuspenyakit.*';
if(!empty($jeniskasuspenyakit_id)){
	$criteria->addCondition("t.jeniskasuspenyakit_id = ".$jeniskasuspenyakit_id);						
}
$criteria->join = 'LEFT JOIN obatalkes_m obatalkes ON t.obatalkes_id = obatalkes.obatalkes_id '
                    . '  LEFT JOIN jeniskasuspenyakit_m jeniskasuspenyakit ON t.jeniskasuspenyakit_id = jeniskasuspenyakit.jeniskasuspenyakit_id';
$modKasuspenyakitobat = FAKasuspenyakitobatM::model()->findAll($criteria);
foreach ($modKasuspenyakitobat as $row){
    echo '<li>'.$row->obatalkes_nama.'</li>';
}
?>
</ul>
