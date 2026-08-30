<?php

/**
 * This is the model class for table "suratpersetujuantm_t".
 *
 * The followings are the available columns in table 'suratpersetujuantm_t':
 * @property integer $suratpersetujuantm_id
 * @property integer $pasienanastesi_id
 * @property integer $ruangan_id
 * @property string $tglpersetujuan
 * @property string $nopersetujuan
 * @property string $nama_menyetujui
 * @property string $umur_menyetujui
 * @property string $jeniskelamin_menyetujui
 * @property string $alamat_menyetujui
 * @property string $noktp_menyetujui
 * @property string $tindakanterhadap
 * @property integer $pegawaisaksi1_id
 * @property string $nama_saksi2
 * @property integer $dokter_id
 * @property string $nama_yangmenyetujui
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienanastesiT $pasienanastesi
 * @property RuanganM $ruangan
 * @property PegawaiM $pegawaisaksi1
 * @property PegawaiM $dokter
 */
class SuratpersetujuantmT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SuratpersetujuantmT the static model class
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
		return 'suratpersetujuantm_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglpersetujuan, nopersetujuan, nama_menyetujui, umur_menyetujui, jeniskelamin_menyetujui, alamat_menyetujui, dokter_id, nama_yangmenyetujui, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pasienanastesi_id, ruangan_id, pegawaisaksi1_id, dokter_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nopersetujuan, jeniskelamin_menyetujui, tindakanterhadap', 'length', 'max'=>20),
			array('nama_menyetujui, nama_saksi2, nama_yangmenyetujui', 'length', 'max'=>50),
			array('umur_menyetujui, noktp_menyetujui', 'length', 'max'=>30),
			array('jenisidentitas_menyetujui, noidentitas_saksi2, bedah_operasi, transfusi_darah, update_time, tindakanmedis, obatalkes, pendaftaran_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bedah_operasi, transfusi_darah, suratpersetujuantm_id, pasienanastesi_id, ruangan_id, tglpersetujuan, nopersetujuan, nama_menyetujui, umur_menyetujui, jeniskelamin_menyetujui, alamat_menyetujui, noktp_menyetujui, tindakanterhadap, pegawaisaksi1_id, nama_saksi2, dokter_id, nama_yangmenyetujui, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pasienanastesi' => array(self::BELONGS_TO, 'PasienanastesiT', 'pasienanastesi_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'pegawaisaksi1' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaisaksi1_id'),
			'dokter' => array(self::BELONGS_TO, 'PegawaiM', 'dokter_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'suratpersetujuantm_id' => 'Suratpersetujuantm',
			'pasienanastesi_id' => 'Pasienanastesi',
			'ruangan_id' => 'Ruangan',
			'tglpersetujuan' => 'Tglpersetujuan',
			'nopersetujuan' => 'Nopersetujuan',
			'nama_menyetujui' => 'Nama Menyetujui',
			'umur_menyetujui' => 'Umur Menyetujui',
			'jeniskelamin_menyetujui' => 'Jenis Kelamin',
			'alamat_menyetujui' => 'Alamat Menyetujui',
			'noktp_menyetujui' => 'Noktp Menyetujui',
			'tindakanterhadap' => 'Tindakanterhadap',
			'pegawaisaksi1_id' => 'Pegawaisaksi1',
			'nama_saksi2' => 'Nama Saksi2',
			'dokter_id' => 'Dokter',
			'nama_yangmenyetujui' => 'Nama Yangmenyetujui',
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

		if(!empty($this->suratpersetujuantm_id)){
			$criteria->addCondition('t.suratpersetujuantm_id = '.$this->suratpersetujuantm_id);
		}
		if(!empty($this->pasienanastesi_id)){
			$criteria->addCondition('t.pasienanastesi_id = '.$this->pasienanastesi_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
        $criteria->compare('t.pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('LOWER(t.tglpersetujuan)',strtolower($this->tglpersetujuan),true);
		$criteria->compare('LOWER(t.nopersetujuan)',strtolower($this->nopersetujuan),true);
		$criteria->compare('LOWER(t.nama_menyetujui)',strtolower($this->nama_menyetujui),true);
		$criteria->compare('LOWER(t.umur_menyetujui)',strtolower($this->umur_menyetujui),true);
		$criteria->compare('LOWER(t.jeniskelamin_menyetujui)',strtolower($this->jeniskelamin_menyetujui),true);
		$criteria->compare('LOWER(t.alamat_menyetujui)',strtolower($this->alamat_menyetujui),true);
		$criteria->compare('LOWER(t.noktp_menyetujui)',strtolower($this->noktp_menyetujui),true);
		$criteria->compare('LOWER(t.tindakanterhadap)',strtolower($this->tindakanterhadap),true);
		if(!empty($this->pegawaisaksi1_id)){
			$criteria->addCondition('t.pegawaisaksi1_id = '.$this->pegawaisaksi1_id);
		}
		$criteria->compare('LOWER(t.nama_saksi2)',strtolower($this->nama_saksi2),true);
		if(!empty($this->dokter_id)){
			$criteria->addCondition('t.dokter_id = '.$this->dokter_id);
		}
        $criteria->compare('lower(t.jenissurat)', strtolower($this->jenissurat));
		$criteria->compare('LOWER(t.nama_yangmenyetujui)',strtolower($this->nama_yangmenyetujui),true);
		$criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(t.update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('t.create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('t.update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('t.create_ruangan = '.$this->create_ruangan);
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
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function searchPerseTujuanTindakan()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            
            $criteria->join = 'left join informconsent_t i on i.suratpersetujuantm_id = t.suratpersetujuantm_id';
            $criteria->addCondition("i.suratpersetujuantm_id is null");

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function searchInformConsent()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            
            $criteria->join = 'left join informconsent_t i on i.suratpersetujuantm_id = t.suratpersetujuantm_id';
            $criteria->addCondition("i.suratpersetujuantm_id is not null");

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