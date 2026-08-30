<?php
$profil = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT);
$konfig = KonfigsystemK::model()->find();
$format = new MyFormatter();

//baris 1
$this->renderPartial('label/print/_listPosisi',[
    'top'=>3,
    'left'=>3,
    'hasil'=>$hasil,
    'data'=>$data,
    'profil'=>$profil,   
    'format'=>$format,
    'posisi'=>'kiri',
    'halaman'=>$halaman,
    'i'=>0
]);

$this->renderPartial('label/print/_listPosisi',[
    'top'=>3,
    'left'=>55,
    'hasil'=>$hasil,
    'data'=>$data,
    'profil'=>$profil,    
    'format'=>$format,
    'posisi'=>'tengah',
    'halaman'=>$halaman,
    'i'=>0
]);

$this->renderPartial('label/print/_listPosisi',[
    'top'=>3,
    'left'=>107,
    'hasil'=>$hasil,
    'data'=>$data,
    'profil'=>$profil,    
    'format'=>$format,
    'posisi'=>'kanan',
    'halaman'=>$halaman,
    'i'=>0
]);


//baris 2
$this->renderPartial('label/print/_listPosisi',[
    'top'=>107,
    'left'=>3,
    'hasil'=>$hasil,
    'data'=>$data,
    'profil'=>$profil,    
    'format'=>$format,
    'posisi'=>'kiri',
    'halaman'=>'',
    'i'=>0
]);

$this->renderPartial('label/print/_listPosisi',[
    'top'=>107,
    'left'=>55,
    'hasil'=>$hasil,
    'data'=>$data,
    'profil'=>$profil,    
    'format'=>$format,
    'posisi'=>'tengah',
    'halaman'=>'',
    'i'=>0
]);

$this->renderPartial('label/print/_listPosisi',[
    'top'=>107,
    'left'=>107,
    'hasil'=>$hasil,
    'data'=>$data,
    'profil'=>$profil,    
    'format'=>$format,
    'posisi'=>'kanan',
    'halaman'=>'',
    'i'=>0
]);
?>