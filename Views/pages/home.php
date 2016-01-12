<?php if (\Application\Helper\Session::isLoggedIn()) {
    $session = \Application\Helper\Session::getSession();
    echo '<p>Welcome to gift world <b>'.$session['name'].' '. $session['surname'].'</b></b></p>';

} else { ?>
    <p>Welcome to gift world ! Please <a href='?controller=users&action=login'>Login</a> to play.</p>
<?php } ?>