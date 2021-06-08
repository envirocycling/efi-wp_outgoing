
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Datetime Picker -->
    <link href="<?= base_url(); ?>assets/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= base_url(); ?>assets/custom.css" rel="stylesheet">
  </head>

  <body>

    <div class="container">

      <!-- Static navbar -->
      <?php include_once(APPPATH.'views/inc/navbar.php'); ?>
      <!-- content-->

      <?php include_once(APPPATH.$content_view); ?>
      
    </div> 
    <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="<?= base_url(); ?>assets/jquery.min.js"></script>
    <script src="<?= base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>

    <!-- Load moment for date time formatting -->
    <script src="<?= base_url(); ?>assets/moment.min.js"></script>

    <script src="<?= base_url(); ?>assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

    <script>

    window.base_url = '<?= getenv('BASE_URL') ?>';

    $('.datepicker').datepicker({
      format: 'YYYY-MM-DD'
    });
    </script>

    <!-- Load axios for data fetching -->
    <script src="<?= base_url(); ?>assets/axios.min.js"></script>

    <!-- Load Vue-->
    <script src="<?= base_url(); ?>assets/vue/vue.min.js"></script>
    <script src="<?= base_url(); ?>assets/vue/<?=$vue?>"></script>
  
  </body>
</html>
