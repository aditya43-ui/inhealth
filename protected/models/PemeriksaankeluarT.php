<?php

/**
 * This is the model class for table "pemeriksaankeluar_t".
 *
 * The followings are the available columns in table 'pemeriksaankeluar_t':
 * @property integer $pemeriksaankeluar_id
 * @property string $labklinikrujukan_id
 * @property integer $tindakanpelayanan_id
 * @property string $pemeriksaankeluar_tgl
 * @property string $pemeriksaankeluar_alasan
 * @property string $pemeriksaankeluar_ket
 * @property integer $dokterpengirim_id
 * @property integer $ruanganpengirim_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PemeriksaankeluarT extends CActiveRecord
{
	public $pemeriksaanrad_nama;
	
    public $perawat_id, $supir_id;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaankeluarT the static model class
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
		return 'pemeriksaankeluar_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('labklinikrujukan_id, tindakanpelayanan_id, pemeriksaankeluar_tgl, pemeriksaankeluar_alasan, pemeriksaankeluar_ket, dokterpengirim_id, ruanganpengirim_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('tindakanpelayanan_id, dokterpengirim_id, ruanganpengirim_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('labklinikrujukan_id', 'length', 'max'=>10),
			array('pemeriksaankeluar_alasan', 'length', 'max'=>200),
			array('pasienmasukpenunjang_id, daftartindakan_id, update_time, perawat_id, supir_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaankeluar_id, labklinikrujukan_id, tindakanpelayanan_id, pemeriksaankeluar_tgl, pemeriksaankeluar_alasan, pemeriksaankeluar_ket, dokterpengirim_id, ruanganpengirim_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
		
            array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
            array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
            array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
            array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
            array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
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
                    'tindakanpelayanan' => array(self::BELONGS_TO,'TindakanpelayananT','tindakanpelayanan_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaankeluar_id' => 'ID',
			'labklinikrujukan_id' => 'Klinik Rujukan',
			'tindakanpelayanan_id' => 'Tindakan',
			'pemeriksaankeluar_tgl' => 'Tanggal',
			'pemeriksaankeluar_alasan' => 'Alasan Dirujuk',
			'pemeriksaankeluar_ket' => 'Keterangan',
			'dokterpengirim_id' => 'Dokter Pengirim',
			'ruanganpengirim_id' => 'Ruangan Pengirim',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'daftartindakan_id' => 'Tindakan'
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

		$criteria->compare('pemeriksaankeluar_id',$this->pemeriksaankeluar_id);
		$criteria->compare('labklinikrujukan_id',$this->labklinikrujukan_id,true);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('pemeriksaankeluar_tgl',$this->pemeriksaankeluar_tgl,true);
		$criteria->compare('pemeriksaankeluar_alasan',$this->pemeriksaankeluar_alasan,true);
		$criteria->compare('pemeriksaankeluar_ket',$this->pemeriksaankeluar_ket,true);
		$criteria->compare('dokterpengirim_id',$this->dokterpengirim_id);
		$criteria->compare('ruanganpengirim_id',$this->ruanganpengirim_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
          public function getLabKlinikRujukanItems()
        {
            return LabklinikrujukanM::model()->findAll('labklinikrujukan_aktif=TRUE ORDER BY labklinikrujukan_nama');
        }

		public function getKlinikRujukanItems()
        {
            return RujukankeluarM::model()->findAll('rujukankeluar_aktif=TRUE ORDER BY rumahsakitrujukan');
        }
        
         public function getPeriksaRad($daftartindakan_id){
            $cri = new CDbCriteria();
            $cri->addCondition(" daftartindakan_id = '".$daftartindakan_id."' ");
            
            return PemeriksaanradM::model()->find($cri);
        }
}