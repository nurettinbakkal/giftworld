<?php
/**
 * Created by PhpStorm.
 * User: nurettin
 * Date: 01.01.2016
 * Time: 10:45
 */

namespace Application\Model;

use Framework\Model;

class GiftRequest extends Model
{
    /**
     * @var string
     */
    private $schema = 'default';

    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $gift_id;

    /**
     * 1 SEND 2 CLAIM
     *
     * @var integer
     */
    public $gift_request_type;

    /**
     * @var integer
     */
    public $gift_count;

    /**
     * @var integer
     */
    public $user_id;

    /**
     * @var integer
     */
    public $gift_sender_user_id;

    /**
     * 0 WAITING 1 ACCEPTED 2 REJECTED
     *
     * @var integer
     */
    public $is_accepted;

    /**
     * @var string
     */
    public $request_time;

    /**
     * @var string
     */
    public $response_time;

    public function __construct($id = null,
                                $gift_id = null,
                                $gift_request_type = null,
                                $gift_count = null,
                                $user_id = null,
                                $gift_sender_user_id = null,
                                $is_accepted = null,
                                $request_time = null,
                                $response_time = null)
    {
        if ( null !== $id ) {
            $this->id = $id;
            $this->gift_id = $gift_id;
            $this->gift_request_type = $gift_request_type;
            $this->gift_count = $gift_count;
            $this->user_id = $user_id;
            $this->gift_sender_user_id = $gift_sender_user_id;
            $this->is_accepted = $is_accepted;
            $this->request_time = $request_time;
            $this->response_time = $response_time;
        }
        $this->connectSchema($this->schema);
    }

    /**
     * @param $id
     * @return GiftRequest
     */
    public function findByUser($id)
    {
        $id = intval($id);
        $result = $this->getConnection()->prepare('SELECT gr.id, gr.gift_count, u.first_name, u.last_name, g.gift_name, gr.request_time, gr.is_accepted FROM gift_requests gr LEFT JOIN users u on u.id = gr.gift_sender_user_id LEFT JOIN gifts g on g.id = gr.gift_id WHERE gr.user_id = :user_id AND gr.request_time > DATE_SUB(CURDATE(), INTERVAL +1 WEEK)');
        $result->bindParam(':user_id', $id, \PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $response = $result->fetchAll();

        return $response;
    }

    /**
     * @param $id
     * @return GiftRequest
     */
    public function findClaimsByUser($id)
    {
        $id = intval($id);
        $result = $this->getConnection()->prepare('SELECT gr.id, gr.gift_count, u.first_name, u.last_name, g.gift_name, gr.request_time, gr.is_accepted FROM gift_requests gr LEFT JOIN users u on u.id = gr.user_id LEFT JOIN gifts g on g.id = gr.gift_id WHERE gr.gift_sender_user_id = :gift_sender_user_id AND gr.request_time > DATE_SUB(CURDATE(), INTERVAL +1 WEEK)');
        $result->bindParam(':gift_sender_user_id', $id, \PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $response = $result->fetchAll();

        return $response;
    }

    /**
     * @param GiftRequest $giftRequest
     */
    public function createGiftRequest(GiftRequest $giftRequest)
    {
        $result = $this->getConnection()->prepare('INSERT INTO gift_requests (id, gift_id, gift_request_type, gift_count, user_id, gift_sender_user_id, is_accepted, request_time, response_time) VALUES (:id, :gift_id, :gift_request_type, :gift_count, :user_id, :gift_sender_user_id, 0, now(), NULL)');
        $result->bindParam(':id', $giftRequest->id, \PDO::PARAM_INT);
        $result->bindParam(':gift_id', $giftRequest->gift_id, \PDO::PARAM_INT);
        $result->bindParam(':gift_request_type', $giftRequest->gift_request_type, \PDO::PARAM_INT);
        $result->bindParam(':gift_count', $giftRequest->gift_count, \PDO::PARAM_INT);
        $result->bindParam(':user_id', $giftRequest->user_id, \PDO::PARAM_INT);
        $result->bindParam(':gift_sender_user_id', $giftRequest->gift_sender_user_id, \PDO::PARAM_INT);
        $result->execute();
    }

    /**
     * @param GiftRequest $giftRequest
     * @return mixed
     */
    public function isSentToday(GiftRequest $giftRequest)
    {
        $result = $this->getConnection()->prepare('SELECT count(*) as total FROM gift_requests WHERE user_id = :user_id AND gift_request_type = 1 AND gift_sender_user_id = :gift_sender_user_id AND day(request_time) = day(now())');
        $result->bindParam(':user_id', $giftRequest->user_id, \PDO::PARAM_INT);
        $result->bindParam(':gift_sender_user_id', $giftRequest->gift_sender_user_id, \PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $response = $result->fetch();

        return (int) $response['total'];
    }

    /**
     * @return mixed
     */
    public function getMaxId()
    {
        $result = $this->getConnection()->prepare('SELECT max(id) as maxid FROM gift_requests');
        $result->execute();
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $response = $result->fetch();

        return (int) $response['maxid'];
    }

    /**
     * @return array
     */
    public function getUserGifts()
    {
        $result = $this->getConnection()->prepare('SELECT gr.user_id, g.gift_name, sum(gr.gift_count) as gift_sum FROM gift_requests gr LEFT JOIN gifts g on g.id = gr.gift_id WHERE gr.is_accepted = 1 AND gr.request_time > DATE_SUB(CURDATE(), INTERVAL +1 WEEK) GROUP BY gr.user_id, g.gift_name');
        $result->execute();
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $response = $result->fetchAll();

        return $response;
    }

    public function updateGiftRequest($giftRequestId, $isAccepted)
    {
        $result = $this->getConnection()->prepare('UPDATE gift_requests SET is_accepted = :is_accepted WHERE id = :id');
        $result->bindParam(':id', $giftRequestId, \PDO::PARAM_INT);
        $result->bindParam(':is_accepted', $isAccepted, \PDO::PARAM_INT);
        $result->execute();
    }
}