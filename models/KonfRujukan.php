<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "konf_rujukan".
 *
 * @property int $id
 * @property int|null $rujukanAgensi Agency
 * @property string|null $rujukanFlag Flag
 * @property string|null $rujukanNama Name
 * @property int|null $rujukanDefault Default Flag
 * @property int|null $rujukanSusunan Sequence
 * @property int|null $rujukanSso SSO Mapping
 * @property string|null $rujukanCode DDSA Code
 * @property int|null $rujukanCreated Created Date
 * @property int|null $rujukanModified Modified Date
 * @property int|null $rujukanDeleted Deleted Date
 *
 * @property MasterlistPero[] $masterlistPeros
 * @property MasterlistPero[] $masterlistPeros0
 * @property MasterlistPero[] $masterlistPeros1
 * @property MasterlistPero[] $masterlistPeros2
 * @property MasterlistPero[] $masterlistPeros3
 * @property MasterlistPero[] $masterlistPeros4
 * @property MasterlistPero[] $masterlistPeros5
 * @property ProsesPerolehan[] $prosesPerolehans
 */
class KonfRujukan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'konf_rujukan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rujukanAgensi', 'rujukanDefault', 'rujukanSusunan', 'rujukanSso', 'rujukanCreated', 'rujukanModified', 'rujukanDeleted'], 'integer'],
            [['rujukanFlag', 'rujukanNama'], 'string', 'max' => 50],
            [['rujukanCode'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rujukanAgensi' => 'Rujukan Agensi',
            'rujukanFlag' => 'Rujukan Flag',
            'rujukanNama' => 'Rujukan Nama',
            'rujukanDefault' => 'Rujukan Default',
            'rujukanSusunan' => 'Rujukan Susunan',
            'rujukanSso' => 'Rujukan Sso',
            'rujukanCode' => 'Rujukan Code',
            'rujukanCreated' => 'Rujukan Created',
            'rujukanModified' => 'Rujukan Modified',
            'rujukanDeleted' => 'Rujukan Deleted',
        ];
    }

    /**
     * Gets query for [[MasterlistPeros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMasterlistPeros()
    {
        return $this->hasMany(MasterlistPero::className(), ['staff_id' => 'id']);
    }

    /**
     * Gets query for [[MasterlistPeros0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMasterlistPeros0()
    {
        return $this->hasMany(MasterlistPero::className(), ['bahagian_id' => 'id']);
    }

    /**
     * Gets query for [[MasterlistPeros1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMasterlistPeros1()
    {
        return $this->hasMany(MasterlistPero::className(), ['kaedah_id' => 'id']);
    }

    /**
     * Gets query for [[MasterlistPeros2]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMasterlistPeros2()
    {
        return $this->hasMany(MasterlistPero::className(), ['kategori_id' => 'id']);
    }

    /**
     * Gets query for [[MasterlistPeros3]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMasterlistPeros3()
    {
        return $this->hasMany(MasterlistPero::className(), ['jenis_id' => 'id']);
    }

    /**
     * Gets query for [[MasterlistPeros4]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMasterlistPeros4()
    {
        return $this->hasMany(MasterlistPero::className(), ['status_id' => 'id']);
    }

    /**
     * Gets query for [[MasterlistPeros5]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMasterlistPeros5()
    {
        return $this->hasMany(MasterlistPero::className(), ['peringkat_penilaian' => 'id']);
    }

    /**
     * Gets query for [[ProsesPerolehans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProsesPerolehans()
    {
        return $this->hasMany(ProsesPerolehan::className(), ['jenis_id' => 'id']);
    }

    public static function getKonfRujukan()

    {

        return KonfRujukan::find()->select(['id', 'rujukanFlag'])->all();

    }

    public static function getAllRujukanByFlag($flag)
    {
        $model = KonfRujukan::find()
            ->where('rujukanFlag = :rujukanFlag AND rujukanDeleted IS NULL')
            ->params([
                ':rujukanFlag' => $flag
            ])
            ->orderby('rujukanSusunan, rujukanNama')
            ->all();

        foreach($model as $data) {
            $string = Yii::t('app', 'KonfRujukan'.$data->id);
            $data->rujukanNama = ($string == 'KonfRujukan'.$data->id ? $data->rujukanNama : $string);
            #$data->rujukanNama = Yii::t('app', 'KonfRujukan'.$data->id);
        }

        return $model;
    }

}
