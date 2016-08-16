<?php

namespace Biz\User;

interface UserService
{
    public function getUser($id);

    public function findUsersByIds($ids);

    public function getUserByUsername($username);

    public function register($user);
    
    public function findTopUsers($type);

    public function addScore($userId, $score);

    public function minusScore($userId, $score);
}