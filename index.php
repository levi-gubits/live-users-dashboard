<?php require_once "PHP/pages.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/index.css?v1">
    <link rel="stylesheet" href="style/login_page.css?v1">
    <script src="js/fetch.js"></script>
    <script src="js/loginAndLogout.js?v3"></script>
    <title>Document</title>
    <style>
        	body{
                background-color: royalblue;
            }
    </style>
</head>
<body>
    <?php
        //Checks which page to display to the user -  login / main
        $pages = new Pages;
        $pages->checkIfUserConnect();
    ?>
</body>

</html>

<?php ?>