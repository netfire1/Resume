<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Test</title>
        <link rel="stylesheet" type="text/css" href="css.css">        
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>      
    </head>
    <body>
        <div id="main-wrapper">
            <?php
            session_start();
            include 'Template.php';

            $template = new Template("templates/");

            $menu = array('index', 'contacts', 'log_in_out');
            $mes = (isset($_SESSION['success_message']) && $_SESSION['success_message'] != '') ? 'success' : 'err';

            if (isset($_SESSION['is_registered']) && $_SESSION['is_registered'] == 1)
            {
                $menu[] = 'personal';
                $menu['avatar'] = isset($_SESSION['avatar']) ? $_SESSION['avatar'] : 'images/default.png';
                $menu['name_surname'] = isset($_SESSION['name_surname']) ? $_SESSION['name_surname'] : '';
            }

            if (isset($_GET['r']))
            {
                $content = $_GET['r'];
            } else
            {
                $content = 'index';
            }

            $template->set("menu", $menu);

            $template->display("header");
            ?>       

            <div id="<?= $mes; ?>">
                <?= isset($_SESSION['success_message']) ? $_SESSION['success_message'] : ''; ?>
                <?= isset($_SESSION['err_message']) ? $_SESSION['err_message'] : ''; ?>
            </div>

            <?php
            $template->display($content);

            $template->display("footer");
            $_SESSION['err_message'] = '';
            $_SESSION['success_message'] = '';
            ?>
        </div>

    </body>
</html>
