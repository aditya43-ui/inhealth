<?php

/**
 * This is the model class for table "verifikasikeluar_ruangpulih_t".
 *
 * The followings are the available columns in table 'verifikasikeluar_ruangpulih_t':
 * @property integer $verifikasikeluar_ruangpulih_id
 * @property integer $pasienruangpulih_id
 * @property string $isjaringan
 * @property string $jenisjaringan
 * @property string $isformulir_pa
 * @property string $islembar_ro
 * @property string $islembar_ro_jumlah
 * @property string $verifikasiserahterima_lainlain
 * @property integer $petugasruangpulih_id
 * @property integer $dokteranastesi_id
 * @property string $verifikasidokteranastesi_isjaringan_dan_jenis
 * @property string $verifikasidokteranastesi_isformulirpa_danjumlah
 * @property string $verifikasidokteranastesi_islembarro_danjumlah
 * @property string $verifikasidokteranastesi_islainlain
 * @property string $verifikasidokteranastesi_jam
 * @property boolean $verifikasidokteranastesi_status
 * @property boolean $verifikasidokteranastesi_catatan
 * @property integer $perawatanastesi_id
 * @property string $verifikasiperawatanastesi_isjaringan_dan_jenis
 * @property string $verifikasiperawatanastesi_isformulirpa_danjumlah
 * @property string $verifikasiperawatanastesi_islembarro_danjumlah
 * @property string $verifikasiperawatanastesi_islainlain
 * @property string $verifikasiperawatanastesi_jam
 * @property boolean $verifikasiperawatanastesi_status
 * @property boolean $verifikasiperawatanastesi_catatan
 * @property integer $perawatruanganpenerima_id
 * @property string $serahterima_isjaringan_dan_jenis
 * @property string $serahterima_isformulirpa_danjumlah
 * @property string $serahterima_islembarro_danjumlah
 * @property string $serahterima_islainlain
 * @property string $serahterima_jam
 * @property boolean $serahterima_status
 * @property boolean $serahterima_catatan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienruangpulihT $pasienruangpulih
 * @property PegawaiM $petugasruangpulih
 * @property PegawaiM $dokteranastesi
 * @property PegawaiM $perawatanastesi
 * @property PegawaiM $perawatruanganpenerima
 */
class VerifikasikeluarRuangpulihT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VerifikasikeluarRuangpulihT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'verifikasikeluar_ruangpulih_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienruangpulih_id, petugasruangpulih_id', 'required'),
			array('pasienruangpulih_id, petugasruangpulih_id, dokteranastesi_id, perawatanastesi_id, perawatruanganpenerima_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('isjaringan, isformulir_pa, islembar_ro, verifikasidokteranastesi_isjaringan_dan_jenis, verifikasidokteranastesi_isformulirpa_danjumlah, verifikasidokteranastesi_islembarro_danjumlah, verifikasidokteranastesi_islainlain, verifikasiperawatanastesi_isjaringan_dan_jenis, verifikasiperawatanastesi_isformulirpa_danjumlah, verifikasiperawatanastesi_islembarro_danjumlah, verifikasiperawatanastesi_islainlain, serahterima_isjaringan_dan_jenis, serahterima_isformulirpa_danjumlah, serahterima_islembarro_danjumlah, serahterima_islainlain', 'length', 'max'=>20),
			array('jenisjaringan', 'length', 'max'=>200),
			array('islembar_ro_jumlah, verifikasiserahterima_lainlain', 'length', 'max'=>50),
			array('verifikasidokteranastesi_jam, verifikasidokteranastesi_status, verifikasidokteranastesi_catatan, verifikasiperawatanastesi_jam, verifikasiperawatanastesi_status, verifikasiperawatanastesi_catatan, serahterima_jam, serahterima_status, serahterima_catatan, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('verifikasikeluar_ruangpulih_id, pasienruangpulih_id, isjaringan, jenisjaringan, isformulir_pa, islembar_ro, islembar_ro_jumlah, verifikasiserahterima_lainlain, petugasruangpulih_id, dokteranastesi_id, verifikasidokteranastesi_isjaringan_dan_jenis, verifikasidokteranastesi_isformulirpa_danjumlah, verifikasidokteranastesi_islembarro_danjumlah, verifikasidokteranastesi_islainlain, verifikasidokteranastesi_jam, verifikasidokteranastesi_status, verifikasidokteranastesi_catatan, perawatanastesi_id, verifikasiperawatanastesi_isjaringan_dan_jenis, verifikasiperawatanastesi_isformulirpa_danjumlah, verifikasiperawatanastesi_islembarro_danjumlah, verifikasiperawatanastesi_islainlain, verifikasiperawatanastesi_jam, verifikasiperawatanastesi_status, verifikasiperawatanastesi_catatan, perawatruanganpenerima_id, serahterima_isjaringan_dan_jenis, serahterima_isformulirpa_danjumlah, serahterima_islembarro_danjumlah, serahterima_islainlain, serahterima_jam, serahterima_status, serahterima_catatan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'pasienruangpulih' => array(self::BELONGS_TO, 'PasienruangpulihT', 'pasienruangpulih_id'),
			'petugasruangpulih' => array(self::BELONGS_TO, 'PegawaiM', 'petugasruangpulih_id'),
			'dokteranastesi' => array(self::BELONGS_TO, 'PegawaiM', 'dokteranastesi_id'),
			'perawatanastesi' => array(self::BELONGS_TO, 'PegawaiM', 'perawatanastesi_id'),
			'perawatruanganpenerima' => array(self::BELONGS_TO, 'PegawaiM', 'perawatruanganpenerima_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'verifikasikeluar_ruangpulih_id' => 'Verifikasikeluar Ruangpulih',
			'pasienruangpulih_id' => 'Pasienruangpulih',
			'isjaringan' => 'Jaringan',
			'jenisjaringan' => 'Jenis Jaringan',
			'isformulir_pa' => 'Form PA',
			'islembar_ro' => 'RO',
			'islembar_ro_jumlah' => 'RO, Jumlah',
			'verifikasiserahterima_lainlain' => 'Lain-lain',
			'petugasruangpulih_id' => 'Petugasruangpulih',
			'dokteranastesi_id' => 'Dokteranastesi',
			'verifikasidokteranastesi_isjaringan_dan_jenis' => 'Verifikasidokteranastesi Isjaringan Dan Jenis',
			'verifikasidokteranastesi_isformulirpa_danjumlah' => 'Verifikasidokteranastesi Isformulirpa Danjumlah',
			'verifikasidokteranastesi_islembarro_danjumlah' => 'Verifikasidokteranastesi Islembarro Danjumlah',
			'verifikasidokteranastesi_islainlain' => 'Verifikasidokteranastesi Islainlain',
			'verifikasidokteranastesi_jam' => 'Verifikasidokteranastesi Jam',
			'verifikasidokteranastesi_status' => 'Verifikasidokteranastesi Status',
			'verifikasidokteranastesi_catatan' => 'Verifikasidokteranastesi Catatan',
			'perawatanastesi_id' => 'Perawatanastesi',
			'verifikasiperawatanastesi_isjaringan_dan_jenis' => 'Verifikasiperawatanastesi Isjaringan Dan Jenis',
			'verifikasiperawatanastesi_isformulirpa_danjumlah' => 'Verifikasiperawatanastesi Isformulirpa Danjumlah',
			'verifikasiperawatanastesi_islembarro_danjumlah' => 'Verifikasiperawatanastesi Islembarro Danjumlah',
			'verifikasiperawatanastesi_islainlain' => 'Verifikasiperawatanastesi Islainlain',
			'verifikasiperawatanastesi_jam' => 'Verifikasiperawatanastesi Jam',
			'verifikasiperawatanastesi_status' => 'Verifikasiperawatanastesi Status',
			'verifikasiperawatanastesi_catatan' => 'Verifikasiperawatanastesi Catatan',
			'perawatruanganpenerima_id' => 'Perawatruanganpenerima',
			'serahterima_isjaringan_dan_jenis' => 'Serahterima Isjaringan Dan Jenis',
			'serahterima_isformulirpa_danjumlah' => 'Serahterima Isformulirpa Danjumlah',
			'serahterima_islembarro_danjumlah' => 'Serahterima Islembarro Danjumlah',
			'serahterima_islainlain' => 'Serahterima Islainlain',
			'serahterima_jam' => 'Serahterima Jam',
			'serahterima_status' => 'Serahterima Status',
			'serahterima_catatan' => 'Serahterima Catatan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->verifikasikeluar_ruangpulih_id)){
			$criteria->addCondition('verifikasikeluar_ruangpulih_id = '.$this->verifikasikeluar_ruangpulih_id);
		}
		if(!empty($this->pasienruangpulih_id)){
			$criteria->addCondition('pasienruangpulih_id = '.$this->pasienruangpulih_id);
		}
		$criteria->compare('LOWER(isjaringan)',strtolower($this->isjaringan),true);
		$criteria->compare('LOWER(jenisjaringan)',strtolower($this->jenisjaringan),true);
		$criteria->compare('LOWER(isformulir_pa)',strtolower($this->isformulir_pa),true);
		$criteria->compare('LOWER(islembar_ro)',strtolower($this->islembar_ro),true);
		$criteria->compare('LOWER(islembar_ro_jumlah)',strtolower($this->islembar_ro_jumlah),true);
		$criteria->compare('LOWER(verifikasiserahterima_lainlain)',strtolower($this->verifikasiserahterima_lainlain),true);
		if(!empty($this->petugasruangpulih_id)){
			$criteria->addCondition('petugasruangpulih_id = '.$this->petugasruangpulih_id);
		}
		if(!empty($this->dokteranastesi_id)){
			$criteria->addCondition('dokteranastesi_id = '.$this->dokteranastesi_id);
		}
		$criteria->compare('LOWER(verifikasidokteranastesi_isjaringan_dan_jenis)',strtolower($this->verifikasidokteranastesi_isjaringan_dan_jenis),true);
		$criteria->compare('LOWER(verifikasidokteranastesi_isformulirpa_danjumlah)',strtolower($this->verifikasidokteranastesi_isformulirpa_danjumlah),true);
		$criteria->compare('LOWER(verifikasidokteranastesi_islembarro_danjumlah)',strtolower($this->verifikasidokteranastesi_islembarro_danjumlah),true);
		$criteria->compare('LOWER(verifikasidokteranastesi_islainlain)',strtolower($this->verifikasidokteranastesi_islainlain),true);
		$criteria->compare('LOWER(verifikasidokteranastesi_jam)',strtolower($this->verifikasidokteranastesi_jam),true);
		$criteria->compare('verifikasidokteranastesi_status',$this->verifikasidokteranastesi_status);
		$criteria->compare('verifikasidokteranastesi_catatan',$this->verifikasidokteranastesi_catatan);
		if(!empty($this->perawatanastesi_id)){
			$criteria->addCondition('perawatanastesi_id = '.$this->perawatanastesi_id);
		}
		$criteria->compare('LOWER(verifikasiperawatanastesi_isjaringan_dan_jenis)',strtolower($this->verifikasiperawatanastesi_isjaringan_dan_jenis),true);
		$criteria->compare('LOWER(verifikasiperawatanastesi_isformulirpa_danjumlah)',strtolower($this->verifikasiperawatanastesi_isformulirpa_danjumlah),true);
		$criteria->compare('LOWER(verifikasiperawatanastesi_islembarro_danjumlah)',strtolower($this->verifikasiperawatanastesi_islembarro_danjumlah),true);
		$criteria->compare('LOWER(verifikasiperawatanastesi_islainlain)',strtolower($this->verifikasiperawatanastesi_islainlain),true);
		$criteria->compare('LOWER(verifikasiperawatanastesi_jam)',strtolower($this->verifikasiperawatanastesi_jam),true);
		$criteria->compare('verifikasiperawatanastesi_status',$this->verifikasiperawatanastesi_status);
		$criteria->compare('verifikasiperawatanastesi_catatan',$this->verifikasiperawatanastesi_catatan);
		if(!empty($this->perawatruanganpenerima_id)){
			$criteria->addCondition('perawatruanganpenerima_id = '.$this->perawatruanganpenerima_id);
		}
		$criteria->compare('LOWER(serahterima_isjaringan_dan_jenis)',strtolower($this->serahterima_isjaringan_dan_jenis),true);
		$criteria->compare('LOWER(serahterima_isformulirpa_danjumlah)',strtolower($this->serahterima_isformulirpa_danjumlah),true);
		$criteria->compare('LOWER(serahterima_islembarro_danjumlah)',strtolower($this->serahterima_islembarro_danjumlah),true);
		$criteria->compare('LOWER(serahterima_islainlain)',strtolower($this->serahterima_islainlain),true);
		$criteria->compare('LOWER(serahterima_jam)',strtolower($this->serahterima_jam),true);
		$criteria->compare('serahterima_status',$this->serahterima_status);
		$criteria->compare('serahterima_catatan',$this->serahterima_catatan);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}