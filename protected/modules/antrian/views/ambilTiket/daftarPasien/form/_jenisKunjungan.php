<?php

if (!empty($jenisKunjungan)){
    foreach($jenisKunjungan as $key => $val){
        echo $this->renderPartial('daftarPasien/form/baris/_listJenisKunjungan',['model'=>$key],true);
    }    
}

