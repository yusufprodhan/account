<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title><?= (isset($title) ? $title : 'B-Fast IT' ); ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?= site_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= site_url(); ?>assets/vendors/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">
  </head>
<body>
	
	<?= $contents; ?>

    
    <!-- Jquery js version 3.1.1 -->
    <script src="<?= site_url(); ?>assets/js/jquery-3.1.1.slim.min.js" type="text/javascript"></script>
    <script src="<?= site_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>    
</body>
</html>


