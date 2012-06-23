<?php

/*
 * This file is part of the INBApnsBundle package.
 *
 * (c) INB Group <http://inbgroup.com> and Sergey Gerdel <http://sergic.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace INB\ApnsBundle\Wrapper;

require_once __DIR__.'/../Apns-php/ApnsPHP/Autoload.php';

/**
 * @author Sergey Gerdel <skif16@ukr.net>
 */
class INBApnsPushWrapper
{
    /**
     * @var string $environment
     */
    protected  $environment;

    /**
     * @var string $certificate
     */
    protected  $certificate;

    /**
     * @var string $roo_certificate
     */
    protected  $root_certificate;

    /**
     *
     * Construct object class for message
     *
     * @param string $environment string
     * @param string $certificate string
     * @param string|bool $root_certificate
     */
    public function __construct($environment, $certificate, $root_certificate = false){
        $this->environment = $environment;
        $this->certificate = $certificate;
        $this->root_certificate = $root_certificate;
        return $this;
    }

    /**
     *
     * Create push object
     *
     * @return \ApnsPHP_Push Push object
     */
    public function create(){
        switch($this->environment){
            case 'prod':
                $env = \ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION;
                break;
            case 'dev';
                $env = \ApnsPHP_Abstract::ENVIRONMENT_SANDBOX;
                break;
            default:
                $env = \ApnsPHP_Abstract::ENVIRONMENT_SANDBOX;
                break;
        }
        $push = new \ApnsPHP_Push($env, $this->certificate);
        if ($this->root_certificate){
            $push->setRootCertificationAuthority($this->root_certificate);
        }
        $push->connect();
        return $push;
    }

    /**
     *
     * Add and send one message
     *
     * @param \ApnsPHP_Message $message
     * @return \ApnsPHP_Push Push object
     */
    public function pushOne(\ApnsPHP_Message $message){
        $push = $this->create();
        $push->add($message);
        $push->send();
        $push->disconnect();
        return $push;
    }

    /**
     *
     * Add and send many messages
     *
     * @param array $messages
     * @return \ApnsPHP_Push|bool Push object or false
     */
    public function pushMany(array $messages){
        if (count($messages) > 0){
            $push = $this->createPush();
            foreach($messages as $message){
                if ($message instanceof \ApnsPHP_Message){
                    $push->add($message);
                }
            }
            $push->send();
            $push->disconnect();
            return $push;
        }
        else{
            return false;
        }
    }
}


