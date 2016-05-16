<?php

namespace Helper;

use Codeception\Module\REST;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Api extends \Codeception\Module
{

    protected $storageFile = 'storage.json';

    protected function __loadStorage()
    {
        $storage = array();
        if (file_exists($this->storageFile)) {
            $dataJson = file_get_contents($this->storageFile);
            if (strlen($dataJson) > 0) {
                $storage = json_decode($dataJson, true);
            }
        }
        if (!is_array($storage)) {
            $this->fail("Storage file has undefined format. Expected JSON.");
        }
        return $storage;
    }

    protected function __saveStorage(array $storage)
    {
        if (!file_put_contents($this->storageFile, json_encode($storage))) {
            $this->fail("Storage file cannot be written.");
        }
    }

    protected function __destroyStorage()
    {
        if (!unlink($this->storageFile)){
            $this->fail("Storage file cannot be destroyed.");
        }
    }

    protected function _saveData($group, $name, $value)
    {
        $storage = $this->__loadStorage();
        if (!array_key_exists($group, $storage) || !is_array($storage[$group])) {
            $storage[$group] = array();
        }
        $storage[$group][$name] = $value;
        $this->__saveStorage($storage);
    }

    protected function _loadData($group, $name)
    {
        $storage = $this->__loadStorage();
        if (!array_key_exists($group, $storage)) {
            $this->fail(sprintf('Storage file do not contains the "%s" group.', $group));
        }
        if (array_key_exists($name, $storage[$group])) {
            return $storage[$group][$name];
        }
        return null;
    }

    public function saveCookie($cookieName)
    {
        $this->_saveData('cookies', $cookieName, $this->getModule('PhpBrowser')->grabCookie($cookieName));
    }

    public function useSavedCookie($cookieName)
    {
        $value = $this->_loadData('cookies', $cookieName);
        if (!is_null($value)) {
            $this->getModule('PhpBrowser')->setCookie($cookieName, $value);
        }
    }

    public function forgotCookie($cookieName)
    {
        $this->_saveData('cookies', $cookieName, null);
    }

    public function forgotAll()
    {
        $this->__destroyStorage();
    }

    public function amHttpAuthenticatedAs($account)
    {
        $accounts = $this->getModule('REST')->_getConfig('accounts');
        if (!array_key_exists($account, $accounts)) {
            $this->fail(sprintf('Account "%s" is undefined.', $account));
        }
        if (!array_key_exists('username', $accounts[$account])) {
            $this->fail(sprintf('Missing username for account "%s".', $account));
        }
        if (!array_key_exists('password', $accounts[$account])) {
            $this->fail(sprintf('Missing password for account "%s".', $account));
        }
        $this->getModule('PhpBrowser')->amHttpAuthenticated($accounts[$account]['username'], $accounts[$account]['password']);
    }

}
