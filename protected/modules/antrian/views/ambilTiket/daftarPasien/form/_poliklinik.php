<?php
if (!empty($polilinik)){
    foreach($polilinik as $key => $val){
        echo $this->renderPartial('daftarPasien/form/baris/_listPolik',['model'=>$val],true);
    }   
}

