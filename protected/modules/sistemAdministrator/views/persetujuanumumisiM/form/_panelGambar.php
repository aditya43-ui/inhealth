
<?php

if (!empty($model->persetujuan_gambar)) {
    $model->persetujuan_gambar = CJSON::decode($model->persetujuan_gambar);
}

$res = array();

if (!empty($model->persetujuan_gambar) && is_array($model->persetujuan_gambar)) {
    foreach ($model->persetujuan_gambar as $idx => $item) {
        
        $item['val64_gambar'] = null;
        $path = Params::pathPersetujuanUmumIsiGambar().$item['path_gambar'];
        
        if (file_exists($path)) {
            
            $base = base64_encode(file_get_contents($path));
            $mime = mime_content_type($path);
            
            $full = "data:".$mime.";base64,".$base;
            
//            var_dump($full); die;
            
            $item['val64_gambar'] = $full;
        }
        
        $res['note_'.$idx] = $item;
        
//        $model->persetujuan_gambar[$i] = $item;
        
        
        
//        var_dump($item); die;
        
//        echo $this->renderPartial("form/_itemGambar", array('i'=>'note_'.$idx, 'model'=>$model));
    }
    
    $model->persetujuan_gambar = $res;
    
    foreach ($res as $idx => $item) {
        echo $this->renderPartial("form/_itemGambar", array('i'=>$idx, 'model'=>$model, true));
    }
}

?>