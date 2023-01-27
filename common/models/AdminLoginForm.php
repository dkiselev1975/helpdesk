<?php

namespace common\models;

/**
 * Login form
 */
class AdminLoginForm extends LoginForm
{
    private $_user;

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = AdminUser::findByUsername($this->username);
        }

        return $this->_user;
    }
}
