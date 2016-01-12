<?php
    echo '<div id="messageBox" class="messageRow">Your request has been sent successfully</div>';

    echo '<div>';
    foreach($sumOfGifts as $key => $value) {
        echo '<div class="myGiftsRow"><b>My ' . $key . ':</b> '.$value.'</div>';
    }
    echo '</div>';

    echo '<div id="tabs">';
    echo '<ul>';
    foreach($myGifts as $key => $gifts) {
        echo '<li><a href="#tabs-'.$key.'">'.$key.'</a></li>';
    }
    echo '</ul>';

    foreach($myGifts as $key => $gifts) {
        echo '<div id="tabs-'.$key.'" class="giftContainer '.$key.'">';
        foreach($gifts as $gift) {
            echo '<div class="listGiftsRow">';
            echo '<div class="leftColumn">';
            echo $gift['first_name'].' '.$gift['last_name'];
            echo '<p>'.$gift['gift_count'].' '.$gift['gift_name'].'</p>';
            echo '<p>'.$gift['request_time'].'</p>';
            echo '</div>';

            echo '<div class="rightColumn sendGiftButton">';
            if ( $key == 'waiting' ) {
                echo '<form action="?controller=gifts&action=accept" method="post" name="giftRequestForm'.rand(10000000, 99999999).'">';
                echo '<input type="submit" value="Accept">';
                echo '<input type="hidden" name="request_id" id="request_id" value="'.$gift['id'].'">';
                echo '<input type="hidden" name="is_accepted" id="is_accepted" value="1">';
                echo '</form>';

                echo '<form action="?controller=gifts&action=accept" method="post" name="giftRequestForm'.rand(10000000, 99999999).'">';
                echo '<input type="submit" value="Reject">';
                echo '<input type="hidden" name="request_id" id="request_id" value="'.$gift['id'].'">';
                echo '<input type="hidden" name="is_accepted" id="is_accepted" value="2">';
                echo '</form>';
            }
            echo '</div>';

            echo '</div>';
        }
        echo '</div>';
    }

    echo '</div>';
