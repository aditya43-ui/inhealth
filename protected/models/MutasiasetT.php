<?php

/**
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * 
 * 
 * This is the model class for table "mutasiaset_t".
 *
 * The followings are the available columns in table 'mutasiaset_t':
 * @property integer $mutasiaset_id
 * @property string $nomutasiaset
 * @property string $tglmutasiaset
 * @property integer $ruangantujuan_id
 * @property integer $pegpenerima_id
 * @property integer $ruanganasal_id
 * @property integer $pegmenyerahkan_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $pegpenerima_tgl
 * @property string $mutasiaset_status
 *
 * The followings are the available model relations:
 * @property MutasiasetperalatanT[] $mutasiasetperalatanTs
 */
class MutasiasetT extends CActiveRecord
{
    public $instalasiasal_id;
    public $instalasitujuan_id;
    public $ruangantujuan_nama, $jumlah_aset;
    public $ruanganasal_nama, $lokasiasal_nama, $lokasitujuan_nama;
    
    public $pegmenyerahkan_nama;
    public $pegpenerima_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MutasiasetT the static model class
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
		return 'mutasiaset_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lokasiasal_id, lokasitujuan_id, nomutasiaset, tglmutasiaset, ruangantujuan_id, ruanganasal_id, pegmenyerahkan_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('ruangantujuan_id, pegpenerima_id, ruanganasal_id, pegmenyerahkan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nomutasiaset', 'length', 'max'=>100),
			array('mutasiaset_status', 'length', 'max'=>25),
			array('is_disetujui, pegverifikasi_id, tanggal_verifikasi, lokasitujuan_id, lokasiasal_id, update_time, pegpenerima_tgl', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('mutasiaset_id, nomutasiaset, tglmutasiaset, ruangantujuan_id, pegpenerima_id, ruanganasal_id, pegmenyerahkan_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pegpenerima_tgl, mutasiaset_status', 'safe', 'on'=>'search'),
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
                    'mutasiasetperalatanTs' => array(self::HAS_MANY, 'MutasiasetperalatanT', 'mutasiaset_id'),
                    'ruanganasal' => array(self::BELONGS_TO, 'RuanganM', 'ruanganasal_id'),
                    'ruangantujuan' => array(self::BELONGS_TO, 'RuanganM', 'ruangantujuan_id'),
                    'pegmenyerahkan' => array(self::BELONGS_TO, 'PegawaiM', 'pegmenyerahkan_id'),
                    'pegpenerima' => array(self::BELONGS_TO, 'PegawaiM', 'pegpenerima_id'),
                    'lokasiasal' => array(self::BELONGS_TO, 'LokasiasetM', 'lokasiasal_id'),
                    'lokasitujuan' => array(self::BELONGS_TO, 'LokasiasetM', 'lokasitujuan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mutasiaset_id' => 'Mutasiaset',
			'nomutasiaset' => 'Nomor Mutasi',
			'tglmutasiaset' => 'Tanggal Mutasi',
			'ruangantujuan_id' => 'Ruangan Tujuan',
			'pegpenerima_id' => 'Pegawai Penerima',
			'ruanganasal_id' => 'Ruangan Asal',
			'pegmenyerahkan_id' => 'Pegawai yang Menyerahkan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'pegpenerima_tgl' => 'Tgl Penerima',
			'mutasiaset_status' => 'Status',
                        'lokasitujuan_id' => 'Lokasi Aset Tujuan',
                        'lokasitujuan_nama' => 'Lokasi Aset Tujuan',
                        'lokasiasal_id' => 'Lokasi Aset Asal',
                        'lokasiasal_nama' => 'Lokasi Aset Asal',
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

		$criteria->compare('mutasiaset_id',$this->mutasiaset_id);
		$criteria->compare('nomutasiaset',$this->nomutasiaset,true);
		$criteria->compare('tglmutasiaset',$this->tglmutasiaset,true);
		$criteria->compare('ruangantujuan_id',$this->ruangantujuan_id);
		$criteria->compare('pegpenerima_id',$this->pegpenerima_id);
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
		$criteria->compare('pegmenyerahkan_id',$this->pegmenyerahkan_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('pegpenerima_tgl',$this->pegpenerima_tgl,true);
		$criteria->compare('mutasiaset_status',$this->mutasiaset_status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchMutasiTerakhir()
	{		

		$criteria=new CDbCriteria;
                $criteria->select = [
                    'COUNT(mp.invperalatan_id) as jumlah_aset',
                    'r.ruangan_nama as ruangantujuan_nama',
                    't.mutasiaset_id'
                ];
                $criteria->group = "r.ruangan_nama, t.mutasiaset_id";
                $criteria->join = " JOIN ruangan_m r ON r.ruangan_id = t.ruangantujuan_id 
                                    JOIN mutasiasetperalatan_t mp ON mp.mutasiaset_id = t.mutasiaset_id 
                    ";
                $criteria->order = "tglmutasiaset DESC";
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination' => false
		));
	}
}