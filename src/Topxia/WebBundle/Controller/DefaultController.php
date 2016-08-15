<?php

namespace Topxia\WebBundle\Controller;

use Topxia\WebBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Topxia\Common\ArrayToolKit;
use Topxia\Common\Paginator;

class DefaultController extends BaseController
{
    public function indexAction(Request $request)
    {
        $conditions = array();
        $orderBy = array('createdTime', 'DESC');
        $paginator = new Paginator(
            $this->get('request'),
            $this->getKnowledgeService()->getKnowledgesCount($conditions),
            20
        );
        $knowledges = $this->getKnowledgeService()->searchKnowledges(
            $conditions,
            $orderBy,
            $paginator->getOffsetCount(),
            $paginator->getPerPageCount()
        );

        $users = $this->getUserService()->findUsersByIds(ArrayToolKit::column($knowledges, 'userId'));
        $users = ArrayToolKit::index($users, 'id');
        
        return $this->render('TopxiaWebBundle:Default:index.html.twig', array(
            'knowledges' => $knowledges,
            'users' => $users,
            'paginator' => $paginator,
        ));
    }

    public function listTopKnowledgesAction(Request $request)
    {
        $post = $request->request->all();
        if (empty($post['type'])) {
            $type = 'like';
        } else {
            $type = $post['type'];
        }
        $topKnowledges = $this->getKnowledgeService()->findTopKnowledges($type);

        return $this->render('TopxiaWebBundle:TopList:top-knowledge.html.twig',array(
            'topKnowledges' => $topKnowledges,
            'type' => $type
        ));
    }

    public function listTopTopicsAction(Request $request)
    {
        $post = $request->request->all();
        if (empty($post['type'])) {
            $type = 'follow';
        } else {
            $type = $post['type'];
        }
        $topTopics = $this->getTopicService()->findTopTopics($type);

        return $this->render('TopxiaWebBundle:TopList:top-topic.html.twig',array(
            'topTopics' => $topTopics,
            'type' => $type
        ));
    }

    public function listTopUsersAction(Request $request)
    {
        $post = $request->request->all();
        if (empty($post['type'])) {
            $type = 'score';
        } else {
            $type = $post['type'];
        }
        $topUsers = $this->getUserService()->findTopUsers($type);

        return $this->render('TopxiaWebBundle:TopList:top-user.html.twig',array(
            'topUsers' => $topUsers,
            'type' => $type
        ));
    }

    public function docModalAction(Request $request)
    {
        return $this->render('TopxiaWebBundle::add-file.html.twig');
    }

    public function linkModalAction(Request $request)
    {
        return $this->render('TopxiaWebBundle::add-link.html.twig');
    }

    protected function getKnowledgeService()
    {
        return $this->biz['knowledge_service'];
    }

    protected function getUserService()
    {
        return $this->biz['user_service'];
    }

    protected function getFavoriteService()
    {
        return $this->biz['favorite_service'];
    }

    protected function getLikeService()
    {
        return $this->biz['like_service'];
    }

    protected function getTopicService()
    {
        return $this->biz['topic_service'];
    }
}