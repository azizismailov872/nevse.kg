<?php

namespace common\modules\content\models;

use Yii;

/**
 * This is the model class for table "pages".
 *
 * @property int $id
 * @property string $page
 * @property string $title
 * @property string|null $content
 */
class Pages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['page', 'title'], 'required'],
            [['content'], 'string'],
            [['page', 'title'], 'string', 'max' => 255],
            [['page'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page' => 'Page',
            'title' => 'Title',
            'content' => 'Content',
        ];
    }
}
