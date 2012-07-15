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
class INBApnsMessageCustomWrapper
{
    /**
     * @param string $device_token
     * @return \ApnsPHP_Message_Custom|bool Message object or false
     */
    public function create($device_token = null){
        if ($device_token){
            if (is_array($device_token)){
                $apns_message = new \ApnsPHP_Message_Custom();
                foreach($device_token as $token){
                    $apns_message->addRecipient($token);
                }
                return $apns_message;
            }
            else{
                return new \ApnsPHP_Message_Custom($device_token);
            }
        }
        else{
            return false;
        }
    }

}




