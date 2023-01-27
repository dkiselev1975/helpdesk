<?php

namespace common\models;

/**
 * Login form
 */
class SiteLoginForm extends LoginForm
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
            $this->_user = SiteUser::findByUsername($this->username);
        }

        return $this->_user;
    }
}
