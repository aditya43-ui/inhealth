<?php

/**
 * This is the model class for table "skriningimltd_t".
 * @package application.models
 * The followings are the available columns in table 'skriningimltd_t':
 * @property integer $skriningimltd_id
 * @property string $tglskrining
 * @property integer $petugasskrining_id
 * @property integer $shift_id
 * @property integer $asalruangan_id
 * @property integer $terimakantongdet_id
 * @property boolean $hbsag
 * @property boolean $antihiv
 * @property boolean $antihvc
 * @property boolean $sifilis
 * @property string $ket_skrining
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * 
 * @package  application.models
 * @version  2.0.0
 */
class SkriningimltdT extends CActiveRecord
{
    public $hasil_skrining,$tgl_awal,$tgl_akhir,$is_jenis,$data,$jumlah,$type,$title, $petugasskrining_nama, $verifikator1_nama, $verifikator2_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SkriningimltdT the static model class
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
		return 'skriningimltd_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglskrining, petugasskrining_id, asalruangan_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('petugasskrining_id, shift_id, asalruangan_id, terimakantongdet_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('lot_antihbsag, lot_antihiv, lot_antihcv, lot_sifilis, verifikator1_id, verifikator2_id, tgl_kadaluarsa, 
                                hasil_skrining, hbsag, antihiv, antihvc, sifilis, ket_skrining, update_time,kantongdarahdet_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hasil_skrining, skriningimltd_id, tglskrining, petugasskrining_id, shift_id,kantongdarahdet_id, asalruangan_id, terimakantongdet_id, hbsag, antihiv, antihvc, sifilis, ket_skrining, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'petugasskrining'=>array(self::BELONGS_TO, 'PegawaiM', 'petugasskrining_id'),
                    'verifikator1'=>array(self::BELONGS_TO, 'PegawaiM', 'verifikator1_id'),
                    'verifikator2'=>array(self::BELONGS_TO, 'PegawaiM', 'verifikator2_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'skriningimltd_id' => 'Skriningimltd',
			'tglskrining' => 'Tgl. Penyaringan',
			'tgl_kadaluarsa' => 'Tgl. Kadaluarsa',
			'petugasskrining_id' => 'Petugas Seleksi',
			'shift_id' => 'Shift',
			'asalruangan_id' => 'Asalruangan',
			'terimakantongdet_id' => 'Terimakantongdet',
			'hbsag' => 'HBsAg',
			'antihiv' => 'Anti HIV',
			'antihvc' => 'Anti HCV',
			'sifilis' => 'Sifilis',
			'ket_skrining' => 'Keterangan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
                        'hasil_skrining' => 'Hasil Skrining',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('skriningimltd_id',$this->skriningimltd_id);
		$criteria->compare('tglskrining',$this->tglskrining,true);
		$criteria->compare('petugasskrining_id',$this->petugasskrining_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('asalruangan_id',$this->asalruangan_id);
		$criteria->compare('terimakantongdet_id',$this->terimakantongdet_id);
		$criteria->compare('hbsag',$this->hbsag);
		$criteria->compare('antihiv',$this->antihiv);
		$criteria->compare('antihvc',$this->antihvc);
		$criteria->compare('sifilis',$this->sifilis);
		$criteria->compare('ket_skrining',$this->ket_skrining,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchGrafik() {
            $criteria = new CDbCriteria();
            if($this->is_jenis == 1){
                $criteria->select = "count(hbsag) as jumlah , CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))  as data";
                $criteria->group = " CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))";
                $criteria->addCondition("hbsag = true");
                $criteria->addBetweenCondition("tglskrining", $this->tgl_awal, $this->tgl_akhir);
            }
            if($this->is_jenis == 2){
                $criteria->select = "count(antihiv) as jumlah , CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))  as data";
                $criteria->group = " CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))";
                $criteria->addCondition("antihiv = true");
                $criteria->addBetweenCondition("tglskrining", $this->tgl_awal, $this->tgl_akhir);
            }
            if($this->is_jenis == 3){
                $criteria->select = "count(antihvc) as jumlah , CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))  as data";
                $criteria->group = " CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))";
                $criteria->addCondition("antihvc = true");
                $criteria->addBetweenCondition("tglskrining", $this->tgl_awal, $this->tgl_akhir);
            }
            if($this->is_jenis == 4){
                $criteria->select = "count(sifilis) as jumlah , CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))  as data";
                $criteria->group = " CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))";
                $criteria->addCondition("sifilis = true");
                $criteria->addBetweenCondition("tglskrining", $this->tgl_awal, $this->tgl_akhir);
            }
            if($this->is_jenis == 5){
                $criteria->select = "SUM(COALESCE(CASE WHEN hbsag THEN 1 ELSE 0 END,0) + COALESCE(CASE WHEN antihiv THEN 1 ELSE 0 END,0) + COALESCE(CASE WHEN antihvc THEN 1 ELSE 0 END,0) + COALESCE(CASE WHEN sifilis THEN 1 ELSE 0 END,0)) as jumlah , CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))  as data";
                $criteria->group = " CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))";
                $criteria->addBetweenCondition("tglskrining", $this->tgl_awal, $this->tgl_akhir);
            }
            if($this->is_jenis == 6){
                //$criteria->select = "COUNT(*) as jumlah , CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))  as data";
                $criteria->select = "COUNT(*) as jumlah , CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))  as data";
                $criteria->group = " CONCAT(date_part('month', tglskrining) ,'   ',date_part('year', tglskrining))";
                $criteria->condition = '(hbsag = true OR antihiv = true OR antihvc = true OR sifilis = true)';
                $criteria->addBetweenCondition("tglskrining", $this->tgl_awal, $this->tgl_akhir);
            }
            
            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
        }
}