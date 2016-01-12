<?php
/**
 * Created by PhpStorm.
 * User: nurettin
 * Date: 01.01.2016
 * Time: 10:38
 */

namespace Application\Controller;

use Application\Helper\Session;
use Application\Model\Gift;
use Application\Model\GiftRequest;
use Application\Model\User;
use Framework\Controller;
use Application\GiftRequestService;

class GiftsController extends Controller
{
    public function home()
    {
        $giftRequestService = new GiftRequestService();
        $myGifts = $giftRequestService->getMyGifts(Session::getUserId());

        $sumOfGifts = array();
        foreach($myGifts as $key => $gifts) {
            if ( strtolower($key) == 'accepted' ) {
                foreach($gifts as $gift) {
                    $sumOfGifts[$gift['gift_name']] += (int) $gift['gift_count'];
                }
            }
        }

        require_once('../Views/gifts/home.php');
    }

    public function send()
    {
        if ( isset($_POST['username']) && isset($_POST['gift_id']) && isset($_POST['gift_count']) ) {
            try {
                $userModel = new User();

                $giftRequestType = $_POST['gift_request_type'];
                $giftId = $_POST['gift_id'];
                $giftCount = $_POST['gift_count'];
                $userId = $giftRequestType == '1' ? $userModel->getIdByUsername($_POST['username'])
                    : Session::getUserId();
                $giftSenderUserId = $giftRequestType == '2' ? $userModel->getIdByUsername($_POST['username'])
                    : Session::getUserId();
                if ( false !== $userId ) {
                    $giftRequestService = new GiftRequestService();
                    $maxId = $giftRequestService->getMaxId();
                    $maxId += 1;

                    $giftRequest = new GiftRequest(
                        $maxId,
                        $giftId,
                        $giftRequestType,
                        $giftCount,
                        $userId,
                        $giftSenderUserId
                    );

                    $giftRequestService->sendGift($giftRequest);
                    return true;
                } else {
                    return call('pages', 'error');
                }
            } catch(\Exception $e) {
                return call('pages', 'error');
            }
        } else {
            return call('pages', 'error');
        }
    }

    public function listusers()
    {
        $userModel = new User();
        $users = $userModel->findAll();

        $giftRequestService = new GiftRequestService();
        $userGifts = $giftRequestService->getUsersGifts();

        foreach($users as $key => $user) {
            if ($user->id == Session::getUserId()) {
                unset($users[$key]);
            }
        }

        $giftModel = new Gift();
        $gifts = $giftModel->findAll();

        require_once('../Views/gifts/listusers.php');
    }

    public function accept()
    {
        if ( isset($_POST['request_id']) && isset($_POST['is_accepted']) ) {
            try {
                $giftRequestService = new GiftRequestService();
                $giftRequestService->acceptGift($_POST['request_id'], $_POST['is_accepted']);
                return true;
            } catch(\Exception $e) {
                return call('pages', 'error');
            }
        }
    }

}