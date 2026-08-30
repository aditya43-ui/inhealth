<?php

/**
 * This is the model class for table "pesanobatalkes_t".
 *
 * The followings are the available columns in table 'pesanobatalkes_t':
 * @property integer $pesanobatalkes_id
 * @property integer $ruangan_id
 * @property integer $mutasioaruangan_id
 * @property string $tglpemesanan
 * @property string $nopemesanan
 * @property string $statuspesan
 * @property string $tglmintadikirim
 * @property string $keterangan_pesan
 * @property integer $ruanganpemesan_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $pegawaipemesan_id
 * @property integer $pegawaimengetahui_id
 *
 * The followings are the available model relations:
 * @property MutasioaruanganT $mutasioaruangan
 * @property RuanganM $ruangan
 * @property RuanganM $ruanganpemesan
 * @property PegawaiM $pegawaipemesan
 * @property PegawaiM $pegawaimengetahui
 * @property PesanoadetailT[] $pesanoadetailTs
 * @property MutasioaruanganT[] $mutasioaruanganTs
 */
class PesanobatalkesT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PesanobatalkesT the static model class
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
		return 'pesanobatalkes_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, tglpemesanan, nopemesanan, statuspesan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('ruangan_id, mutasioaruangan_id, ruanganpemesan_id, pegawaipemesan_id, pegawaimengetahui_id', 'numerical', 'integerOnly'=>true),
			array('nopemesanan', 'length', 'max'=>50),
			array('statuspesan', 'length', 'max'=>30),
			array('statuspengiriman, tglmintadikirim, keterangan_pesan, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pesanobatalkes_id, ruangan_id, mutasioaruangan_id, tglpemesanan, nopemesanan, statuspesan, tglmintadikirim, keterangan_pesan, ruanganpemesan_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pegawaipemesan_id, pegawaimengetahui_id', 'safe', 'on'=>'search'),
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
			'mutasioaruangan' => array(self::BELONGS_TO, 'MutasioaruanganT', 'mutasioaruangan_id'),
			'ruangantujuan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'ruanganpemesan' => array(self::BELONGS_TO, 'RuanganM', 'ruanganpemesan_id'),
			'pegawaipemesan' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaipemesan_id'),
			'pegawaimengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimengetahui_id'),
			'pesanoadetailTs' => array(self::HAS_MANY, 'PesanoadetailT', 'pesanobatalkes_id'),
			'mutasioaruanganTs' => array(self::HAS_MANY, 'MutasioaruanganT', 'pesanobatalkes_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pesanobatalkes_id' => 'ID',
			'mutasioaruangan_id' => 'Ruangan Mutasi',
			'ruangan_id' => 'Pesan Ke',
			'tglpemesanan' => 'Tanggal Pemesanan',
			'nopemesanan' => 'Nomor Pemesanan',
			'statuspesan' => 'Status Pesan',
			'tglmintadikirim' => 'Tanggal Minta Dikirim',
			'keterangan_pesan' => 'Keterangan Pesan',
			'ruanganpemesan_id' => 'Ruangan Pemesan',
			'pegawaipemesan_id' => 'Pegawai Pemesan',
			'pegawaimengetahui_id' => 'Pegawai Mengetahui',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'statuspengiriman' => 'Status Pengiriman'
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

		$criteria->compare('pesanobatalkes_id',$this->pesanobatalkes_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('mutasioaruangan_id',$this->mutasioaruangan_id);
		$criteria->compare('LOWER(tglpemesanan)',strtolower($this->tglpemesanan),true);
		$criteria->compare('LOWER(nopemesanan)',strtolower($this->nopemesanan),true);
		$criteria->compare('LOWER(statuspesan)',strtolower($this->statuspesan),true);
		$criteria->compare('LOWER(tglmintadikirim)',strtolower($this->tglmintadikirim),true);
		$criteria->compare('LOWER(keterangan_pesan)',strtolower($this->keterangan_pesan),true);
		$criteria->compare('ruanganpemesan_id',$this->ruanganpemesan_id);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('pegawaipemesan_id',$this->pegawaipemesan_id);
		$criteria->compare('pegawaimengetahui_id',$this->pegawaimengetahui_id);

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