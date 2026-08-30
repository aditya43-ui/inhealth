<?php

/**
 * This is the model class for table "kelengkapan_alat_hd_t".
 *
 * The followings are the available columns in table 'kelengkapan_alat_hd_t':
 * @property integer $kelengkapan_alat_hd_id
 * @property integer $monitoring_post_hd_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $resephd_id
 * @property integer $resephd_det_id
 * @property integer $jumlah
 *
 * The followings are the available model relations:
 * @property ResephdDetM $resephdDet
 * @property ResephdM $resephd
 * @property PendaftaranT $pendaftaran
 * @property PasienM $pasien
 * @property MonitoringPostHdT $monitoringPostHd
 */
class KelengkapanAlatHdT extends CActiveRecord
{
    public $obatalkes_nama, $qty_reseptur;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelengkapanAlatHdT the static model class
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
		return 'kelengkapan_alat_hd_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('', 'required'),
			array('kelengkapan_alat_hd_id, monitoring_post_hd_id, pasien_id, pendaftaran_id, resephd_id, resephd_det_id, jumlah, obatalkes_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelengkapan_alat_hd_id, monitoring_post_hd_id, pasien_id, pendaftaran_id, resephd_id, resephd_det_id, jumlah, obatalkes_id', 'safe', 'on'=>'search'),
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
			'resephdDet' => array(self::BELONGS_TO, 'ResephdDetM', 'resephd_det_id'),
			'resephd' => array(self::BELONGS_TO, 'ResephdM', 'resephd_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'monitoringPostHd' => array(self::BELONGS_TO, 'MonitoringPostHdT', 'monitoring_post_hd_id'),
                        'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kelengkapan_alat_hd_id' => 'Kelengkapan Alat Hd',
			'monitoring_post_hd_id' => 'Monitoring Post Hd',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'resephd_id' => 'Resephd',
			'resephd_det_id' => 'Resephd Det',
			'jumlah' => 'Jumlah',
			'obatalkes_id' => 'Obat Alkes',
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

		$criteria->compare('kelengkapan_alat_hd_id',$this->kelengkapan_alat_hd_id);
		$criteria->compare('monitoring_post_hd_id',$this->monitoring_post_hd_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('resephd_id',$this->resephd_id);
		$criteria->compare('resephd_det_id',$this->resephd_det_id);
		$criteria->compare('jumlah',$this->jumlah);
                $criteria->compare('obatalkes_id',$this->obatalkes_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}