<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "coupon".
 *
 * @property int $id
 * @property string $alias
 * @property string $title
 * @property string $description
 * @property double $value
 * @property string $type
 * @property int $company
 * @property string $icon
 *
 * @property Company $company0
 */
class Coupon extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'coupon';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['value'], 'number'],
            [['company'], 'integer'],
            [['alias'], 'string', 'max' => 50],
            [['title', 'icon'], 'string', 'max' => 250],
            [['type'], 'string', 'max' => 10],
            [['company'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'alias' => 'Alias',
            'title' => 'Title',
            'description' => 'Description',
            'value' => 'Value',
            'type' => 'Type',
            'company' => 'Company',
            'icon' => 'Icon',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany0()
    {
        return $this->hasOne(Company::className(), ['id' => 'company']);
    }
}
