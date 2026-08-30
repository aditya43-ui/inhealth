
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class MAInvperizinanT extends InvperizinanT
{
    public $pelaksana;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KabupatenM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    public function attributeLabels() {
		return array(
			'invperizinan_id' => 'Invperizinan',
			'invperalatan_id' => 'Invperalatan',
			'invperizinan_no' => 'No. Perizinan',
			'invperizinan_tgl' => 'Periode Izin',
			'invperizinan_sdtgl' => 'Invperizinan Sdtgl',
			'invperizinan_ket' => 'Keterangan',
			'lampiranfile_1' => 'Dokumen',
			'lampiranfile_2' => 'Dokumen 2',
			'lampiranfile_3' => 'Dokumen 3',
			'pelaksana_id' => 'Pelaksana',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}
}
?>
