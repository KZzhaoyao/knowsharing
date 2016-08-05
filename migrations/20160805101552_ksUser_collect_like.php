<?php

use Phpmig\Migration\Migration;

class KsUserCollectLike extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $container = $this->getContainer();
        $table = new Doctrine\DBAL\Schema\Table('user_collect_like');
        $table->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement'=> true));
        $table->addColumn('userId', 'integer', array('unsigned' => true, 'null' => false, 'comment' => '用户id'));
        $table->addColumn('knowledgeId', 'integer', array('unsigned' => true, 'null' => false, 'comment' => '知识id'));
        $table->addColumn('like', 'boolean', array('default' => false, 'comment' => '是否被点赞'));
        $table->addColumn('collect', 'boolean', array('default' => false, 'comment' => '是否被点赞'));
        $table->setPrimaryKey(array('id'));

        $container['db']->getSchemaManager()->createTable($table);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $container = $this->getContainer();
        $container['db']->getSchemaManager()->dropTable('user_collect_like');
    }
}