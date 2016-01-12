<?php
    echo '<div id="messageBox" class="messageRow">Your request has been sent successfully</div>';
    echo '<div id="messageBoxFailure" class="messageRow rejected">You had sent gift to this user today</div>';

    foreach($users as $user) {

    echo '<div class="listUsersRow">';
        echo '<div class="leftColumn">';
            echo $user->first_name.' '.$user->last_name;
            echo '<p>' . str_replace('_', '<br>', $userGifts[$user->id]) . '</p>';
    echo '</div>';
    echo '<div id="formContainer" class="rightColumn sendGiftButton">';

        foreach($gifts as $gift) {
            echo '<form action="?controller=gifts&action=send" method="post" name="giftRequestForm'.rand(10000000, 99999999).'">';
            echo '<select name="gift_count"><option value="50">50</option><option value="100">100</option><option value="500">500</option></select>';
            echo ' ';
            echo '<input type="submit" value="Send '.$gift->gift_name.'">';
            echo '<input type="hidden" name="username" id="username" value="'.$user->username.'">';
            echo '<input type="hidden" name="gift_id" id="gift_id" value="'.$gift->id.'">';
            echo '<input type="hidden" name="gift_request_type" id="gift_request_type" value="1">';
            echo '</form>';

            echo '<form action="?controller=gifts&action=send" method="post" name="giftRequestForm'.rand(10000000, 99999999).'">';
            echo '<select name="gift_count"><option value="50">50</option><option value="100">100</option><option value="500">500</option></select>';
            echo ' ';
            echo '<input type="submit" value="Claim '.$gift->gift_name.'">';
            echo '<input type="hidden" name="username" id="username" value="'.$user->username.'">';
            echo '<input type="hidden" name="gift_id" id="gift_id" value="'.$gift->id.'">';
            echo '<input type="hidden" name="gift_request_type" id="gift_request_type" value="2">';
            echo '</form>';
        }

        echo '</div>';
    echo '</div>';

}
