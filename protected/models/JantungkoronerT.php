<?php

/**
 * This is the model class for table "jantungkoroner_t".
 *
 * The followings are the available columns in table 'jantungkoroner_t':
 * @property integer $jantungkoroner_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $tglhitungresiko
 * @property integer $total_kolesterol
 * @property integer $triglycerida
 * @property integer $hdl_kolesterol
 * @property integer $ldl_kolesterol
 * @property integer $tekanandarah
 * @property integer $lingkarpinggang_cm
 * @property integer $fasting_glucose
 * @property boolean $isriwayat_chd_a
 * @property boolean $isresiko_chd_a
 * @property boolean $faktor_perokok_b
 * @property boolean $faktor_hipertensi_b
 * @property boolean $faktor_hdlrendah_b
 * @property boolean $faktor_riwayat_b
 * @property boolean $faktor_umur_b
 * @property boolean $metabolisme_abdominal
 * @property boolean $metabolisme_triglycerida
 * @property boolean $metabolisme_hdl
 * @property boolean $metabolisme_td
 * @property boolean $metabolisme_glucose
 * @property string $triglycerida_level
 * @property string $total_kolesterol_level
 * @property string $hdl_kolesterol_level
 * @property string $ldl_kolesterol_level
 * @property integer $hasil_totalpoint
 * @property integer $hasil_resiko_persen
 * @property string $hasil_review_ab
 * @property string $gangguan_metabolisme
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class JantungkoronerT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JantungkoronerT the static model class
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
		return 'jantungkoroner_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, tglhitungresiko, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, pasien_id, total_kolesterol, triglycerida, hdl_kolesterol, ldl_kolesterol, tekanandarah, lingkarpinggang_cm, fasting_glucose, hasil_totalpoint, hasil_resiko_persen, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('triglycerida_level, total_kolesterol_level, hdl_kolesterol_level, ldl_kolesterol_level', 'length', 'max'=>50),
			array('isriwayat_chd_a, isresiko_chd_a, faktor_perokok_b, faktor_hipertensi_b, faktor_hdlrendah_b, faktor_riwayat_b, faktor_umur_b, metabolisme_abdominal, metabolisme_triglycerida, metabolisme_hdl, metabolisme_td, metabolisme_glucose, hasil_review_ab, gangguan_metabolisme, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jantungkoroner_id, pendaftaran_id, pasien_id, tglhitungresiko, total_kolesterol, triglycerida, hdl_kolesterol, ldl_kolesterol, tekanandarah, lingkarpinggang_cm, fasting_glucose, isriwayat_chd_a, isresiko_chd_a, faktor_perokok_b, faktor_hipertensi_b, faktor_hdlrendah_b, faktor_riwayat_b, faktor_umur_b, metabolisme_abdominal, metabolisme_triglycerida, metabolisme_hdl, metabolisme_td, metabolisme_glucose, triglycerida_level, total_kolesterol_level, hdl_kolesterol_level, ldl_kolesterol_level, hasil_totalpoint, hasil_resiko_persen, hasil_review_ab, gangguan_metabolisme, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jantungkoroner_id' => 'Jantungkoroner',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'tglhitungresiko' => 'Tglhitungresiko',
			'total_kolesterol' => 'Total Kolesterol',
			'triglycerida' => 'Triglycerida',
			'hdl_kolesterol' => 'Hdl Kolesterol',
			'ldl_kolesterol' => 'Ldl Kolesterol',
			'tekanandarah' => 'Tekanandarah',
			'lingkarpinggang_cm' => 'Lingkarpinggang Cm',
			'fasting_glucose' => 'Fasting Glucose',
			'isriwayat_chd_a' => 'Isriwayat Chd A',
			'isresiko_chd_a' => 'Isresiko Chd A',
			'faktor_perokok_b' => 'Faktor Perokok B',
			'faktor_hipertensi_b' => 'Faktor Hipertensi B',
			'faktor_hdlrendah_b' => 'Faktor Hdlrendah B',
			'faktor_riwayat_b' => 'Faktor Riwayat B',
			'faktor_umur_b' => 'Faktor Umur B',
			'metabolisme_abdominal' => 'Metabolisme Abdominal',
			'metabolisme_triglycerida' => 'Metabolisme Triglycerida',
			'metabolisme_hdl' => 'Metabolisme Hdl',
			'metabolisme_td' => 'Metabolisme Td',
			'metabolisme_glucose' => 'Metabolisme Glucose',
			'triglycerida_level' => 'Triglycerida Level',
			'total_kolesterol_level' => 'Total Kolesterol Level',
			'hdl_kolesterol_level' => 'Hdl Kolesterol Level',
			'ldl_kolesterol_level' => 'Ldl Kolesterol Level',
			'hasil_totalpoint' => 'Hasil Totalpoint',
			'hasil_resiko_persen' => 'Hasil Resiko Persen',
			'hasil_review_ab' => 'Hasil Review Ab',
			'gangguan_metabolisme' => 'Gangguan Metabolisme',
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

		if(!empty($this->jantungkoroner_id)){
			$criteria->addCondition('jantungkoroner_id = '.$this->jantungkoroner_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(tglhitungresiko)',strtolower($this->tglhitungresiko),true);
		if(!empty($this->total_kolesterol)){
			$criteria->addCondition('total_kolesterol = '.$this->total_kolesterol);
		}
		if(!empty($this->triglycerida)){
			$criteria->addCondition('triglycerida = '.$this->triglycerida);
		}
		if(!empty($this->hdl_kolesterol)){
			$criteria->addCondition('hdl_kolesterol = '.$this->hdl_kolesterol);
		}
		if(!empty($this->ldl_kolesterol)){
			$criteria->addCondition('ldl_kolesterol = '.$this->ldl_kolesterol);
		}
		if(!empty($this->tekanandarah)){
			$criteria->addCondition('tekanandarah = '.$this->tekanandarah);
		}
		if(!empty($this->lingkarpinggang_cm)){
			$criteria->addCondition('lingkarpinggang_cm = '.$this->lingkarpinggang_cm);
		}
		if(!empty($this->fasting_glucose)){
			$criteria->addCondition('fasting_glucose = '.$this->fasting_glucose);
		}
		$criteria->compare('isriwayat_chd_a',$this->isriwayat_chd_a);
		$criteria->compare('isresiko_chd_a',$this->isresiko_chd_a);
		$criteria->compare('faktor_perokok_b',$this->faktor_perokok_b);
		$criteria->compare('faktor_hipertensi_b',$this->faktor_hipertensi_b);
		$criteria->compare('faktor_hdlrendah_b',$this->faktor_hdlrendah_b);
		$criteria->compare('faktor_riwayat_b',$this->faktor_riwayat_b);
		$criteria->compare('faktor_umur_b',$this->faktor_umur_b);
		$criteria->compare('metabolisme_abdominal',$this->metabolisme_abdominal);
		$criteria->compare('metabolisme_triglycerida',$this->metabolisme_triglycerida);
		$criteria->compare('metabolisme_hdl',$this->metabolisme_hdl);
		$criteria->compare('metabolisme_td',$this->metabolisme_td);
		$criteria->compare('metabolisme_glucose',$this->metabolisme_glucose);
		$criteria->compare('LOWER(triglycerida_level)',strtolower($this->triglycerida_level),true);
		$criteria->compare('LOWER(total_kolesterol_level)',strtolower($this->total_kolesterol_level),true);
		$criteria->compare('LOWER(hdl_kolesterol_level)',strtolower($this->hdl_kolesterol_level),true);
		$criteria->compare('LOWER(ldl_kolesterol_level)',strtolower($this->ldl_kolesterol_level),true);
		if(!empty($this->hasil_totalpoint)){
			$criteria->addCondition('hasil_totalpoint = '.$this->hasil_totalpoint);
		}
		if(!empty($this->hasil_resiko_persen)){
			$criteria->addCondition('hasil_resiko_persen = '.$this->hasil_resiko_persen);
		}
		$criteria->compare('LOWER(hasil_review_ab)',strtolower($this->hasil_review_ab),true);
		$criteria->compare('LOWER(gangguan_metabolisme)',strtolower($this->gangguan_metabolisme),true);
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