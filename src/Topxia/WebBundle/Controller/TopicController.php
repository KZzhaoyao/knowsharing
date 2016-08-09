<?php

namespace Topxia\WebBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Topxia\WebBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Topxia\Service\User\Impl\UserServiceImpl;
use Symfony\Component\HttpFoundation\JsonResponse;

class TopicController extends BaseController
{
    public function indexAction()
    {
        $topics = $this->getTopicService()->findAll();
        
        return $this->render('TopxiaWebBundle:Topic:topic.html.twig',array(
            'topics' => $topics
        ));
    }

    public function followAction(Request $request, $id)
    {
        $this->getTopicService()->followTopic($id);

        return new JsonResponse(true);
    }

    public function unfollowAction(Request $request, $id)
    {
        $this->getTopicService()->unfollowTopic($id);

        return new JsonResponse(true);
    }

    protected function getTopicService()
    {
        return $this->getServiceKernel('topic_service');
    }
}