<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace yuncms\article\models;

use yii\db\ActiveQuery;
use yuncms\tag\behaviors\TagQueryBehavior;

/**
 * Class ArticleQuery
 * @package yuncms\article\models
 */
class ArticleQuery extends ActiveQuery
{
    public function behaviors()
    {
        return [
            TagQueryBehavior::className(),
        ];
    }

    /**
     * Apply possible notes order to query
     * @param string $order
     * @return string
     */
    public function applyOrder($order)
    {
        if ($order == 'new') {//按发布时间倒序
            $this->newest();
        } elseif ($order == 'hottest') {//热门文章
            $this->hot();
        }
    }

    /**
     * 审核过的
     * @return $this
     */
    public function active()
    {
        return $this->andWhere(['status' => Article::STATUS_ACTIVE]);
    }

    /**
     * 热门文章
     */
    public function hot()
    {
        return $this->active()->andWhere(['is_hot' => true])->orderBy(['(views / pow((((UNIX_TIMESTAMP(NOW()) - created_at) / 3600) + 2),1.8) )' => SORT_DESC]);
    }

    /**
     * 置顶文章
     */
    public function top()
    {
        return $this->active()->andWhere(['is_top' => true])->orderBy(['(views / pow((((UNIX_TIMESTAMP(NOW()) - created_at) / 3600) + 2),1.8) )' => SORT_DESC]);
    }

    /**
     * 精华文章
     */
    public function best()
    {
        return $this->active()->andWhere(['is_best' => true])->orderBy(['(views / pow((((UNIX_TIMESTAMP(NOW()) - created_at) / 3600) + 2),1.8) )' => SORT_DESC]);
    }

    /**
     * 最新文章
     * @return $this
     */
    public function newest()
    {
        return $this->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * @param $limit
     * @return static
     */
    public function views($limit)
    {
        return $this->active()->andWhere(['>', 'views', $limit]);
    }
}