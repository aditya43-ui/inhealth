<?php

$criteria = new CDbCriteria();
$criteria->select = 't.jeniskasuspenyakit_id, t.jeniskasuspenyakit_nama, kasuspenyakitruangan_m.ruangan_id, kasuspenyakitruangan_m.jeniskasuspenyakit_id,
                    ruangan_m.ruangan_id';
$criteria->group = 't.jeniskasuspenyakit_id, t.jeniskasuspenyakit_nama, kasuspenyakitruangan_m.ruangan_id, kasuspenyakitruangan_m.jeniskasuspenyakit_id,
                    ruangan_m.ruangan_id';
$criteria->compare('ruangan_m.ruangan_id',$ruangan_id);
$criteria->join = 'LEFT JOIN kasuspenyakitruangan_m on t.jeniskasuspenyakit_id = kasuspenyakitruangan_m.jeniskasuspenyakit_id
                   LEFT JOIN ruangan_m on kasuspenyakitruangan_m.ruangan_id = ruangan_m.ruangan_id
                    ';

$modKasusPenyakit = JeniskasuspenyakitM::model()->findAll($criteria);

if(count((array)$modKasusPenyakit)>0)
{   
    foreach($modKasusPenyakit as $i=>$data)
    {
            echo "<ul><li>";
            echo $data->jeniskasuspenyakit_nama;
            echo "</li>";
            echo "</ul>";

    }
}
else
{
    echo Yii::t('zii','Not set'); 
}  

?>
