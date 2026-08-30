<?php 

if (!empty($model->photopegawai) && file_exists(Params::pathPegawaiDirectory().$model->photopegawai)) {
    echo CHtml::image(Params::urlPegawaiDirectory().$model->photopegawai, $model->nama_pegawai, array(
        'style' => 'height: 150px',
    ));
    echo CHtml::hiddenField('KPRegistrasifingerprint[register_foto]['.$model->pegawai_id.'][gambar]', $model->photopegawai);
} else {
    echo "Foto tidak ditemukan";
}

?>