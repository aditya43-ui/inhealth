<?php

/**
 * This is the model class for table "lpj_t".
 *
 * The followings are the available columns in table 'lpj_t':
 * @property integer $lpj_id
 * @property string $perincian_pembayaran_lpj
 * @property string $kategori_lpj
 * @property integer $harga_satuan
 * @property integer $pengajuankasbon_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PengajuankasbonT $pengajuankasbon
 */
class LpjT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lpj_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('harga_satuan, jumlah, perincian_pembayaran_lpj, create_time, create_loginpemakai_id', 'required'),
			array('pengajuankasbon_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, jumlah, sub_total', 'numerical', 'integerOnly'=>true),
			array('perincian_pembayaran_lpj, kategori_lpj', 'length', 'max'=>45),
			array('harga_satuan, keterangan_lpj, no_lpj, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lpj_id, perincian_pembayaran_lpj, kategori_lpj, harga_satuan, pengajuankasbon_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pengajuankasbon' => array(self::BELONGS_TO, 'PengajuankasbonT', 'pengajuankasbon_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'lpj_id' => 'Lpj',
			'perincian_pembayaran_lpj' => 'Pembayaran Lpj',
			'kategori_lpj' => 'Kategori Lpj',
			'harga_satuan' => 'Harga Satuan',
			'pengajuankasbon_id' => 'Pengajuankasbon',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lpj_id',$this->lpj_id);
		$criteria->compare('perincian_pembayaran_lpj',$this->perincian_pembayaran_lpj,true);
		$criteria->compare('kategori_lpj',$this->kategori_lpj,true);
		$criteria->compare('harga_satuan',$this->harga_satuan);
		$criteria->compare('pengajuankasbon_id',$this->pengajuankasbon_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LpjT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
     * 
     * @param type $model
     * @param type $post
     * @return type
     */
    public static function simpan_data($model, $post) {
        $ok = true;
        $format = new MyFormatter();
        $pesan = '';
		
        foreach ($post as $det) {
            if (!empty($det['lpj_id'])) {
                $modDetail = self::model()->findByPk($det['lpj_id']);
            } else {
                $modDetail = new LpjT();
            }

            $modDetail->attributes = $det;
            $modDetail->pengajuankasbon_id = $model->pengajuankasbon_id;            
            
			if (empty($modDetail->lpj_id)) {
				$modDetail->create_time = date('Y-m-d H:i:s');
				$modDetail->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
				$modDetail->create_ruangan = Yii::app()->user->getState('ruangan_id');
			} else {
				$modDetail->update_time = date('Y-m-d H:i:s');
				$modDetail->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
			}
            
            if ($modDetail->validate()) {
                $ok &= $modDetail->save();
            }

            if (!$ok) {
				var_dump(MyExceptionMessage::getErrorMessage($modDetail));
                $pesan .= MyExceptionMessage::getErrorMessage($modDetail);
            }
        }

        $data['sukses'] = $ok;
        $data['model'] = $model;
        $data['pesan'] = $pesan; 
        return $data;
    }
}
