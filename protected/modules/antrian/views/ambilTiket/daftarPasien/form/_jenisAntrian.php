<?php
if (!empty($jenisAntrian)){
    foreach($jenisAntrian as $key => $val){
        echo $this->renderPartial('daftarPasien/form/baris/_listJenisAntrian',['model'=>$val],true);
    }
    
    echo $this->renderPartial('daftarPasien/form/baris/_checkin',['model'=>$val],true);
}

