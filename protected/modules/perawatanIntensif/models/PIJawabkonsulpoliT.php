<?php

class PIJawabkonsulpoliT extends JawabkonsulpoliT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public $tglkonsulpoli;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jawabkonsulpoli_id' => 'Jawabkonsulpoli',
			'konsulpoli_id' => 'Konsulpoli',
			'ruangan_id' => 'Ruangan',
			'pegawai_id' => 'Dokter Konsul',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasien_id' => 'Pasien',
			'asalpoliklinikkonsul_id' => 'Asalpoliklinikkonsul',
			'nojawabkonsul' => 'Nojawabkonsul',
			'tgljawabkonsul' => 'Tgl. Jawab Konsul',
			'jawabankonsul' => 'Jawaban Konsul',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}
	
	public function getNamaLengkapDokter($pegawai_id)
    {
        $dokter = DokterV::model()->findByAttributes(array('pegawai_id'=>$pegawai_id));
        if(!empty($dokter->nama_pegawai)){
            return (isset($dokter->gelardepan) ? $dokter->gelardepan." " : "").$dokter->nama_pegawai.", ".(isset($dokter->gelarbelakang_nama) ? $dokter->gelarbelakang_nama : "");
        }else{
            return "-";
        }
    }

}