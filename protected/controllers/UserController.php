<?php

class UserController extends Controller
{
    public function actionNewPhoto()
    {
        $this->render('newPhoto');
    }

    public function actionSaveJpg()
    {
            $this->render('saveJpg');
    }

    public function actions()
    {
        $random=$_GET['random'];
        $path=$_GET['path'];
        $pathTumbs=$_GET['pathTumbs'];
        return array(
            'jpegcam.'=> array(
                'class'=>'application.extensions.jpegcam.EJpegcam',
                'saveJpg'=>array(
                    'filepath'=> $pathTumbs.'kecil_'.$random.".jpg", // path Untuk Gambar Aseli
                    'filepath2'=> $path.$random.".jpg" // Path Untu gambar Yang DiRezise
               
                )
                 
            )
        );
      
       
    }

}
