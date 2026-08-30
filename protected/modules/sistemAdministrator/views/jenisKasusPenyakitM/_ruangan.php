<?php
$modKasusPenyakitRuangan=KasuspenyakitruanganM::model()->with('ruangan')->findAll('jeniskasuspenyakit_id='.$jeniskasuspenyakit_id.'');
if(count((array)$modKasusPenyakitRuangan)>0)
    {
        echo "<ul>";
        foreach($modKasusPenyakitRuangan as $i=>$ruangan)
        {
            echo '<li>'.$ruangan->ruangan->ruangan_nama.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo "Belum di Set";
    }   
//echo  "ayey"
?>

