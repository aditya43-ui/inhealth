<?php

/**
 * This is the model class for table "paketobat_m".
 *
 * The followings are the available columns in table 'paketobat_m':
 * @property integer $paketobat_id
 * @property string $nama_paket
 * @property integer $pegawai_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawai
 * @property PaketobatdetailM[] $paketobatdetailMs
 */
class PaketobatM extends CActiveRecord
{
        public $nama_pegawai;
        public $default;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PaketobatM the static model class
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
		return 'paketobat_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nama_paket, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('dokter_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('harga_paket', 'numerical'),
			array('nama_paket', 'length', 'max'=>100),
			array('is_aktif, is_paketbmhp, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('paketobat_id, is_aktif, is_paketbmhp, nama_paket, dokter_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'dokter_id'),
			'paketobatdetailMs' => array(self::HAS_MANY, 'PaketobatdetailM', 'paketobat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'paketobat_id' => 'Paket Obat',
			'nama_paket' => 'Nama Paket',
			'dokter_id' => 'Dokter',
			'is_aktif' => 'Aktif',
			'is_paketbmhp' => 'Paket BMHP',
			'harga_paket' => 'Harga Paket',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
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
		$criteria->join = " LEFT JOIN pegawai_m peg ON peg.pegawai_id = t.dokter_id ";
		$kelompokpegawai_id = null;

		if (!empty($kelompokpegawai_id)) {
			$pegawai = PpdsM::model()->findByPk(Yii::app()->user->getState('ppds_id'));
			if ($pegawai !== null) {
				$kelompokpegawai_id = $pegawai->kelompokpegawai_id;
			}
		} else {
			$pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
			if ($pegawai !== null) {
				$kelompokpegawai_id = $pegawai->kelompokpegawai_id;
			}
		}
		$dokter = $kelompokpegawai_id === Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP? true : false;
		// var_dump($kelompokpegawai_id);die;
		// if ($dokter == true) {
		// 	$criteria->compare('dokter_id', LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai_id);
    //     }
		// if (!empty($this->nama_paket)) {
		// 	$ex = explode(" ", $this->nama_paket);
    //         $hitung = count($ex);
    //         $nama_paket = "";
    //         $lastKey = array_key_last($ex);
    //         if (!empty($ex)) {
    //             if ($hitung > 1) {
    //                 foreach($ex as $k => $det) {
    //                     if ($k == $lastKey) {
    //                         $nama_paket .= "nama_paket ilike '%".$det ."%' ";
    //                     } else {
    //                         $nama_paket .= "nama_paket ilike '%".$det ."%' and ";
    //                     }
    //                 }
    //                 $criteria->addCondition($nama_paket);
    //             } else {
		// 			$criteria->compare('LOWER(t.nama_paket)', strtolower($this->nama_paket),true);
    //             }
    //         }
		// }

		// if ($dokter == true) {
		// 	$criteria->compare('dokter_id', LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai_id);
        // }
		$criteria->compare('dokter_id', LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai_id);
		$criteria->compare('LOWER(t.nama_paket)', strtolower($this->nama_paket),true);

		$criteria->compare('LOWER(peg.nama_pegawai)', strtolower($this->nama_pegawai),true);
		$criteria->compare('harga_paket',$this->harga_paket);
		$criteria->compare('is_aktif', isset($this->is_aktif)?$this->is_aktif:true);
		$criteria->compare('is_paketbmhp', isset($this->is_paketbmhp)?$this->is_paketbmhp:false);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->join = " LEFT JOIN pegawai_m peg ON peg.pegawai_id = t.dokter_id ";
		
		$criteria->compare('LOWER(t.nama_paket)', strtolower($this->nama_paket),true);
		$criteria->compare('LOWER(peg.nama_pegawai)', strtolower($this->nama_pegawai),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}
        
        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->join = " LEFT JOIN pegawai_m peg ON peg.pegawai_id = t.dokter_id ";
                
		if (!empty($this->dokter_id)){
			$criteria->addCondition(" t.pegawai_id = ".$this->dokter_id." ");
		}else{
			if ($this->default == 'wajibpegawai'){
			//    $criteria->addCondition(" t.pegawai_id IS NULL ");
			}
		}
		
		$criteria->compare('LOWER(t.nama_paket)', strtolower($this->nama_paket),true);		
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,                        
		));
	}

	public static function getPaketObat($dokter_id='')
    {
        if(!empty($dokter_id))
            return self::model()->findAllByAttributes(array('dokter_id'=>$dokter_id));
        else
            return array();
    }
}