<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/global-prinout.css">    

<?php 
    $pasien = $model->pasien;    
    echo $this->renderPartial($this->path_view.'print/_header',[
        'data'=>[
            'nama_lengkap'=>$pasien->nama_pasien,
            'no_rm'=>$pasien->no_rekam_medik,
            'tanggal_lahir'=> MyFormatter::formatDateTimeForUser($pasien->tanggal_lahir)
        ],
        'jenisresume'=>'RESUME MEDIS RAWAT JALAN',
        'tglperiksa'=>MyFormatter::formatDateTimeForUser($model->tglresume),
        'dokter'=>$model->pegawai->namalengkap
    ]);
    echo $this->renderPartial($this->path_view.'print/template',['model'=>$model, 'print'=>1], true);
?>
  

