<?php
/**
 * Created by PhpStorm.
 * User: nurettin
 * Date: 01.01.2016
 * Time: 00:09
 */

namespace Application;

use Application\Model\Gift;
use Application\Model\GiftRequest;

class GiftRequestService
{
    public function __construct()
    {

    }

    /**
     * @param $userId
     * @return GiftRequest
     */
    public function getMyGifts($userId)
    {
        $giftRequest = new GiftRequest();
        $giftRequests = $giftRequest->findByUser($userId);

        $return = array();
        foreach($giftRequests as $gift) {
            switch($gift['is_accepted']) {
                case 0:
                    $return['waiting'][] = $gift;
                    break;
                case 1:
                    $return['accepted'][] = $gift;
                    break;
                case 2:
                    $return['rejected'][] = $gift;
            }
        }

        return $return;
    }

    public function sendGift(GiftRequest $giftRequest)
    {
        $giftRequestModel = new GiftRequest();
        if ($giftRequestModel->createGiftRequest($giftRequest)) {
            return true;
        }
        return false;
    }

    public function acceptGift($giftRequestId, $isAccepted)
    {
        $giftRequestModel = new GiftRequest();
        if ($giftRequestModel->updateGiftRequest($giftRequestId, $isAccepted)) {
            return true;
        }
        return false;
    }

    public function getMaxId()
    {
        $giftRequestModel = new GiftRequest();
        if ($giftRequestModel->getMaxId()) {
            return $giftRequestModel->getMaxId();
        }
        return false;
    }

    public function isSentToday(GiftRequest $giftRequest)
    {
        $giftRequestModel = new GiftRequest();
        if ($giftRequestModel->isSentToday($giftRequest)) {
            return $giftRequestModel->isSentToday($giftRequest);
        }
        return false;
    }

    public function getUsersGifts()
    {
        $giftRequestModel = new GiftRequest();
        if ($giftRequestModel->getUserGifts()) {
            $userGifts = $giftRequestModel->getUserGifts();

            $gifts = array();
            foreach($userGifts as $userGift) {
                $gifts[$userGift['user_id']] = $gifts[$userGift['user_id']] .'_'. $userGift['gift_sum'] .' '. $userGift['gift_name'];
            }

            return $gifts;
        }
        return false;
    }
}