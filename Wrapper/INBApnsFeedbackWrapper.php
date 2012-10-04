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
class INBApnsFeedbackWrapper
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
     *
     * Construct object class for message
     *
     * @param string $environment string
     * @param string $certificate string
     */
    public function __construct($environment, $certificate, $root_certificate = false){
        $this->environment = $environment;
        $this->certificate = $certificate;
        return $this;
    }

    /**
     * Set certificate
     *
     * @param $certificate
     * @return bool
     */
    public function setCertificate($certificate){
        if (file_exists($certificate)){
            $this->certificate = $certificate;
            return true;
        }
        return false;
    }

    /**
     * Set environment
     *
     * @param $environment
     * @return bool
     */
    public function setEnvironment($environment){
        $this->environment = $environment;
        return true;
    }

    /**
     *
     * Create feedback object
     *
     * @return \ApnsPHP_Feedback Feedback object
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
        $feedback = new \ApnsPHP_Feedback(
            $env,
            $this->certificate
        );
        return $feedback;
    }

}