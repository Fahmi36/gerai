<!DOCTYPE html>
<html lang="en">
   <head>
      <title><?=$title;?></title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="description" content="#">
      <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
      <meta name="author" content="#">
      <link rel="manifest" href="<?=base_url('/');?>manifest.json">
      <!-- Favicon icon -->
      <link rel="icon" type="image/png" sizes="32x32" href="<?=base_url('/')?>assets/img/favicon/favicon-32x32.png">
      <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url('/')?>assets/img/favicon/favicon-16x16.png">
      <link rel="manifest" href="<?=base_url('/')?>assets/img/favicon/site.webmanifest">
      <!-- Google font-->
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
      <!-- Required Fremwork -->
      <link rel="stylesheet" type="text/css" href="<?=base_url('/')?>assets/css/bootstrap.min.css">
      <!-- feather Awesome -->
      <link rel="stylesheet" type="text/css" href="<?=base_url('/')?>assets/css/style.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" type="text/css" href="<?=base_url('/')?>assets/css/datatables.css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
   </head>
   <body>
      <?php $this->load->view($link_view); ?>
      <script type="text/javascript" src="<?=base_url('/')?>assets/js/bootstrap.bundle.min.js"></script> 
      <script type="text/javascript" src="<?=base_url('/')?>assets/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
      <script src="<?=base_url('/')?>assets/js/datatables.min.js"></script>
   </body>
</html>