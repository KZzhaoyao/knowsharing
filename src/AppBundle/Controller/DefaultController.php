<?php

namespace AppBundle\Controller;

use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Common\ArrayToolKit;
use AppBundle\Common\Paginator;
use AppBundle\Common\Setting;

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

        return $this->render('AppBundle:Default:index.html.twig', array(
            'knowledges' => $knowledges,
            'users' => $users,
            'paginator' => $paginator,
            'type' => 'newKnowledge'
        ));
    }

    public function listTopKnowledgesAction(Request $request)
    {
        $likeKnowledges = $this->getKnowledgeService()->findTopKnowledges('like');
        $favoriteKnowledges = $this->getKnowledgeService()->findTopKnowledges('favorite');
        $viewKnowledges = $this->getKnowledgeService()->findTopKnowledges('view');

        return $this->render('AppBundle:TopList:top-knowledge.html.twig',array(
            'likeKnowledges' => $likeKnowledges,
            'viewKnowledges' => $viewKnowledges,
            'favoriteKnowledges' => $favoriteKnowledges,
        ));
    }

    public function listTopTopicsAction(Request $request)
    {
        $followTopics = $this->getTopicService()->findTopTopics('follow');
        $knowledgeTopics = $this->getTopicService()->findTopTopics('knowledge');

        return $this->render('AppBundle:TopList:top-topic.html.twig',array(
            'followTopics' => $followTopics,
            'knowledgeTopics' => $knowledgeTopics,
        ));
    }

    public function listTopUsersAction(Request $request)
    {
        $scoreUsers = $this->getUserService()->findTopUsers('score');
        $browseUsers = $this->getUserService()->findTopUsers('browse');
        $knowledgeUsers = $this->getUserService()->findTopUsers('knowledge');

        return $this->render('AppBundle:TopList:top-user.html.twig',array(
            'scoreUsers' => $scoreUsers,
            'browseUsers' => $browseUsers,
            'knowledgeUsers' => $knowledgeUsers,
        ));
    }
    
    public function noticeToDoListAction(Request $request)
    {
        $currentUser = $this->getCurrentUser();
        if ($currentUser->isLogin()) {
            $conditions = array(
                'userId' => $currentUser['id'],
            );
            $toReadListNum = $this->getToreadService()->getToreadlistCount($conditions);
            
            return $this->render('AppBundle::notice-todolist.html.twig', array(
                'toReadListNum' => $toReadListNum,
            ));
        }
        
        return $this->render('AppBundle::notice-todolist.html.twig', array());
    }

    public function searchRelatedInAction(Request $request)
    {
        $conditions = $request->query->all();
        $orderBy = array('createdTime', 'DESC');
        if ($conditions['SearchType'] == 'topic') {
            $currentUser = $this->getCurrentUser();
            $condition = array('name' => $conditions['query']);
            $paginator = new Paginator(
                $request,
                $this->getTopicService()->getTopicsCount($condition),
                20
            );
            $topics = $this->getTopicService()->searchTopics(
                $condition,
                $orderBy,
                $paginator->getOffsetCount(),
                $paginator->getPerPageCount()
            );

            $topics = $this->getFollowService()->hasFollowTopics($topics,$currentUser['id']);
            return $this->render('AppBundle:Default:searchRelatedIn.html.twig',array(
                'SearchType' => $conditions['SearchType'],
                'query' => $conditions['query'],
                'paginator'=> $paginator,
                'topics' => $topics,
            ));
        } else if ($conditions['SearchType'] == 'user') {
            $condition = array('username' => $conditions['query']);
            $paginator = new Paginator(
                $request,
                $this->getUserService()->getUsersCount($condition),
                20
            );

            $users = $this->getUserService()->findUsers(
                $condition,
                array('created', 'DESC'),
                $paginator->getOffsetCount(),
                $paginator->getPerPageCount()
            );
            return $this->render('AppBundle:Default:searchRelatedIn.html.twig',array(
                'SearchType' => $conditions['SearchType'],
                'query' => $conditions['query'],
                'paginator'=> $paginator,
                'users' => $users
            ));
        } else {
            $condition = array('title' => $conditions['query']);
            $paginator = new Paginator(
                $request,
                $this->getKnowledgeService()->getKnowledgesCount($condition),
                20
            );
            $knowledges = $this->getKnowledgeService()->searchKnowledges(
                $condition,
                $orderBy,
                $paginator->getOffsetCount(),
                $paginator->getPerPageCount()
            );

            $users = $this->getUserService()->findUsersByIds(ArrayToolKit::column($knowledges, 'userId'));
            $users = ArrayToolKit::index($users, 'id');

            return $this->render('AppBundle:Default:searchRelatedIn.html.twig',array(
                'SearchType' => $conditions['SearchType'],
                'query' => $conditions['query'],
                'paginator'=> $paginator,
                'knowledges' => $knowledges,
                'users' => $users
            ));
        }

    }

    public function docModalAction(Request $request)
    {
        return $this->render('AppBundle::add-file.html.twig');
    }

    public function linkModalAction(Request $request)
    {
        return $this->render('AppBundle::add-link.html.twig');
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

    protected function getToreadService()
    {
        return $this->biz['toread_service'];
    }

    protected function getKnowledgeSearchService()
    {
        return $this->biz['knowledge_search'];
    }

    protected function getFollowService()
    {
        return $this->biz['follow_service'];
    }

}