<?php

namespace Biz\Topic\Dao\Impl;

use Biz\Topic\Dao\TopicDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class TopicDaoImpl extends GeneralDaoImpl implements TopicDao
{
    protected $table = 'topic';

    public function find()
    {
        $sql = "SELECT * FROM {$this->table()} ORDER BY createdTime DESC";
        
        return $this->db()->fetchAll($sql);
    }

    public function findTopicsByIds($ids)
    {
        if (empty($ids)) {
            return array();
        }
        
        $marks = str_repeat('?,', count($ids)-1).'?';
        $sql = "SELECT * FROM {$this->table} WHERE id IN ({$marks})";
        return $this->db()->fetchAll($sql,$ids);
    }
    
    public function declares()
    {
        return array(
            'timestamps' => array('createdTime'),
            'serializes' => array(),
            'conditions' => array(
                'name Like :name',
                'topicId = :topicId',
                'userId = :userId'
            ),
        );
    }

}
