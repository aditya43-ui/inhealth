<?php

/**
 * This is the model class for table "asesmenedukasi_det_t".
 *
 * The followings are the available columns in table 'asesmenedukasi_det_t':
 * @property integer $asesmenedukasi_det_id
 * @property string $tglpemeriksaan
 * @property integer $asesmenedukasi_id
 * @property string $materiedukasi
 * @property string $metodeedukasi
 * @property integer $durasi
 * @property string $hasilevaluasi
 * @property integer $pegawai_pemberiedukasi_id
 * @property string $namapenerima_edukasi
 */
class AsesmenedukasiDetT extends CActiveRecord
{
        public $jam_awal;
        public $jam_akhir;
        public $pegawai_pemberiedukasi_nama;
        public $kel_id;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsesmenedukasiDetT the static model class
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
		return 'asesmenedukasi_det_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglpemeriksaan', 'required'),
			array('asesmenedukasi_id, durasi, pegawai_pemberiedukasi_id', 'numerical', 'integerOnly'=>true),
			array('metodeedukasi', 'length', 'max'=>150),
			array('kel_data', 'length', 'max'=>150),
			array('kel_data, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, namapenerima_edukasi, create_ruangan, materiedukasi, hasilevaluasi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('asesmenedukasi_det_id, tglpemeriksaan, asesmenedukasi_id, materiedukasi, metodeedukasi, durasi, hasilevaluasi, pegawai_pemberiedukasi_id, namapenerima_edukasi', 'safe', 'on'=>'search'),
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
                    'pemberiedukasi' => array(self::BELONGS_TO,'PegawaiM','pegawai_pemberiedukasi_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'asesmenedukasi_det_id' => 'Asesmenedukasi Det',
			'tglpemeriksaan' => 'Tglpemeriksaan',
			'asesmenedukasi_id' => 'Asesmenedukasi',
			'materiedukasi' => 'Materiedukasi',
			'metodeedukasi' => 'Metodeedukasi',
			'durasi' => 'Durasi',
			'hasilevaluasi' => 'Hasilevaluasi',
			'pegawai_pemberiedukasi_id' => 'Pegawai Pemberiedukasi',
			'namapenerima_edukasi' => 'Namapenerima Edukasi',
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

		$criteria->compare('asesmenedukasi_det_id',$this->asesmenedukasi_det_id);
		$criteria->compare('tglpemeriksaan',$this->tglpemeriksaan,true);
		$criteria->compare('asesmenedukasi_id',$this->asesmenedukasi_id);
		$criteria->compare('materiedukasi',$this->materiedukasi,true);
		$criteria->compare('metodeedukasi',$this->metodeedukasi,true);
		$criteria->compare('durasi',$this->durasi);
		$criteria->compare('hasilevaluasi',$this->hasilevaluasi,true);
		$criteria->compare('pegawai_pemberiedukasi_id',$this->pegawai_pemberiedukasi_id);
		$criteria->compare('namapenerima_edukasi',$this->namapenerima_edukasi,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getDurasi() {
            $durasi = [
                [
                    'id' => 1,
                    'label' => '< 15 menit'
                ],
                [
                    'id' => 2,
                    'label' => '15 - 30 menit'
                ],
                [
                    'id' => 3,
                    'label' => '> 30 - 60 menit'
                ],
                [
                    'id' => 4,
                    'label' => '> 60 menit'
                ]
            ];
            return $durasi;
        }
}
