<html>
    <head>
        <title><?php echo (!empty($page_title))?$page_title : 'Home' ?></title>
        <meta charset="utf-8">
        <link type="text/css" rel="stylesheet" href="<?php echo WEB_ROOT; ?>/public/assets/clients/css/style.css">
    </head>
    <body>
        <?php $this->render('blocks/header'); ?>
        <?php $this->render($content, $sub_content); ?>
        <?php $this->render('blocks/footer'); ?>

        <script type="text/javascript" src="<?php echo WEB_ROOT; ?>/public/assets/clients/js/script.js"></script>
    </body>
</html>