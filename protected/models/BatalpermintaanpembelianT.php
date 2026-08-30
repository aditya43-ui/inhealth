<?php

/**
 * This is the model class for table "batalpermintaanpembelian_t".
 *
 * The followings are the available columns in table 'batalpermintaanpembelian_t':
 * @property integer $batalpermintaanpembelian_id
 * @property integer $ruangan_id
 * @property integer $permintaanpembelian_id
 * @property string $tglbatalpermintaan
 * @property string $alasanbatalpermintaan
 * @property string $user_name_otoritasi
 * @property integer $user_id_otorisasi
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $tglpermintaanpembelian
 * @property string $nopermintaan
 * @property string $supplier_nama
 * @property string $pegawaipemesan
 *
 * The followings are the available model relations:
 * @property RuanganM $ruangan
 */
class BatalpermintaanpembelianT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BatalpermintaanpembelianT the static model class
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
		return 'batalpermintaanpembelian_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, tglbatalpermintaan, alasanbatalpermintaan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('ruangan_id, permintaanpembelian_id, user_id_otorisasi', 'numerical', 'integerOnly'=>true),
			array('user_name_otoritasi, nopermintaan, pegawaipemesan', 'length', 'max'=>50),
			array('supplier_nama', 'length', 'max'=>100),
			array('update_time, update_loginpemakai_id, tglpermintaanpembelian', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('batalpermintaanpembelian_id, ruangan_id, permintaanpembelian_id, tglbatalpermintaan, alasanbatalpermintaan, user_name_otoritasi, user_id_otorisasi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tglpermintaanpembelian, nopermintaan, supplier_nama, pegawaipemesan', 'safe', 'on'=>'search'),
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
                    'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
                    'userotorisasi' => array(self::BELONGS_TO, 'PegawaiM', 'user_id_otorisasi'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'batalpermintaanpembelian_id' => 'Batalpermintaanpembelian',
			'ruangan_id' => 'Ruangan',
			'permintaanpembelian_id' => 'Permintaanpembelian',
			'tglbatalpermintaan' => 'Tglbatalpermintaan',
			'alasanbatalpermintaan' => 'Alasanbatalpermintaan',
			'user_name_otoritasi' => 'User Name Otoritasi',
			'user_id_otorisasi' => 'User Id Otorisasi',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'tglpermintaanpembelian' => 'Tglpermintaanpembelian',
			'nopermintaan' => 'No Permintaan',
			'supplier_nama' => 'Nama Supplier',
			'pegawaipemesan' => 'Pegawaipemesan',
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

		$criteria->compare('batalpermintaanpembelian_id',$this->batalpermintaanpembelian_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('permintaanpembelian_id',$this->permintaanpembelian_id);
		$criteria->compare('tglbatalpermintaan',$this->tglbatalpermintaan,true);
		$criteria->compare('alasanbatalpermintaan',$this->alasanbatalpermintaan,true);
		$criteria->compare('user_name_otoritasi',$this->user_name_otoritasi,true);
		$criteria->compare('user_id_otorisasi',$this->user_id_otorisasi);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('tglpermintaanpembelian',$this->tglpermintaanpembelian,true);
		$criteria->compare('nopermintaan',$this->nopermintaan,true);
		$criteria->compare('supplier_nama',$this->supplier_nama,true);
		$criteria->compare('pegawaipemesan',$this->pegawaipemesan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}