<DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <script src="../Public/assets/js/jquery-2.2.0.min.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <link href="../Public/assets/css/main.css"  type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script>
            $(function() {
                $( "#tabs" ).tabs();
            });
        </script>
    </head>
    <body>
    <div class="container">
        <header>
            <a href='./'>Home</a>
            <?php if ( !empty($_SESSION['is_logged_in']) && true === $_SESSION['is_logged_in']  ) { ?>
                <a href='?controller=gifts&action=home'>My Gifts</a>
                <a href='?controller=gifts&action=listusers'>Send/Claim Gift</a>
                <a href='?controller=users&action=logout'>Logout</a>
            <?php } ?>
        </header>

        <?php require_once('../Config/Routes.php'); ?>

        <footer>
            Copyright Nurettin Bakkal
        </footer>
    </div>
    <body>
<html>

<script>

    $(document).ready(function() {

        $("form[name^='giftRequestForm']").submit(function(e)
        {
            var postData = $(this).serializeArray();
            var formURL = $(this).attr("action");
            $.ajax(
                {
                    url : formURL,
                    type: "POST",
                    data : postData,
                    success:function(data, textStatus, jqXHR)
                    {
                        if (data == 'isSentToday') {
                            var tId;
                            $("#messageBoxFailure").hide().slideDown();
                            clearTimeout(tId);
                            tId = setTimeout(function () {
                                $("#messageBoxFailure").hide();
                            }, 3000);
                        } else {
                            var tId;
                            $("#messageBox").hide().slideDown();
                            clearTimeout(tId);
                            tId = setTimeout(function () {
                                $("#messageBox").hide();
                            }, 3000);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        //if fails
                    }
                });
            e.preventDefault(); //STOP default action
        });

        $("#ajaxform").submit();

    });

</script>