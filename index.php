<?php 

// We need to use sessions, so you should always start sessions using the below code.
session_start();

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
  header('Location:login.php');
  exit;
}

require_once ("Class/DB.class.php");
require_once ("Class/IncomeStatement.class.php");
require_once ("DB.php");
require_once ("Class/Account.class.php");
require_once ("Class/FinancialYear.class.php");
require_once ("Class/ExpenseType.class.php");
require_once ("DB.php");


$check=mysqli_query($con,"SELECT username FROM users") or die(mysqli_error());
if(mysqli_num_rows($check)==0){
    $username='admin';
    $password=sha1('Pass=123');
    @mysqli_query($con,"INSERT INTO users(username,password) VALUES('$username','$password')") OR die(mysqli_error());
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>PT Finance &mdash; </title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  

   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="../node_modules/jqvmap/dist/jqvmap.min.css">
  <link rel="stylesheet" href="../node_modules/summernote/dist/summernote-bs4.css">
  <link rel="stylesheet" href="assets/owl.carousel.min.css">
  <link rel="stylesheet" href="assets/owl.theme.default.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
<!--   <link rel="stylesheet" href="assets/css/bootstrap.css"> -->
   <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/css/components.css">


  <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Expense', 'Amount'],
          <?php 
            $expense = new ExpenseType();
            $result = $expense->getExp_Type_GraphDisplay($con);
          ?>
        ]);

        var options = {
          title: 'Expenses',
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
        </form>
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.php"><img src="assets/img/logo.png" style="width: 70px;margin-top: 20px;margin-bottom: 20px;margin-left: -50px;"></a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.php">PTF</a>
          </div>
          <ul class="sidebar-menu" style="margin-top: 20px;">
              <li class="menu-header" style="font-weight: bold !important; "></li>
                    <li><a class="nav-link" href="incomestatement.php"><i class="fas fa-bars"></i> <span>Income Statement</span></a></li>
                      <li><a class="nav-link" href="financialYear.php"><i class="fas fa-bars"></i> <span>Financial Year</span></a></li>
              <li class="menu-header" style="font-weight: bold;">Accounts</li>
                    <li><a class="nav-link" href="organisation.php"><i class="far fa-user"></i> <span>Organisation</span></a></li>
                    <li><a class="nav-link" href="accountType.php"><i class="fas fa-bars"></i> <span>Account Type</span></a></li>
                    <li><a class="nav-link" href="account.php"><i class="far fa-user"></i> <span>Account</span></a></li>
              <li class="menu-header" style="font-weight: bold;">Deposits</li>
                    <li><a class="nav-link" href="deposit.php"><i class="fas fa-dollar-sign"></i> <span>Deposit</span></a></li>
              <li class="menu-header" style="font-weight: bold;">Expenses</li>
                    <li><a class="nav-link" href="expenseType.php"><i class="fas fa-bars"></i> <span>Expense Category</span></a></li>
                    <li><a class="nav-link" href="expense.php"><i class="fas fa-dollar-sign"></i> <span>Expense</span></a></li>
            </ul>
        </aside>
      </div>

         <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Dashboard</h1>
          </div>
          
          <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
              <div class="card">
                <div class="card-header">
                  <h4>Statistics</h4>
                  <div class="card-header-action">
                    <div class="btn-group">
                      <a href="#" class="btn btn-primary">Current Month</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                
                     <div id="donutchart" style="width: 1000px; height: 400px;"></div>
                 
                </div>
              </div>
            </div>
          </div>

        </section>
      </div>
     
      <footer class="main-footer">
        <div class="footer-left footer-color">
          Copyright &copy; 2020 <div class="bullet"></div> Design By Godfrey Asiimwe</a>
        </div>
        <div class="footer-right footer-color">
          Vr 1.0
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
 <!--  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script> -->
  <script src="assets/js/jquery-3.5.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>

  <!-- JS Libraies -->
  <script src="node_modules/jquery-sparkline/jquery.sparkline.min.js"></script>
  <script src="node_modules/chart.js/dist/Chart.min.js"></script>
  <script src="node_modules/owl.carousel/dist/owl.carousel.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/chocolat/1.0.1/js/chocolat.min.js" integrity="sha256-+NOBtGTwk1dGgV+C4AY7c57MNivcv8LVxoZ8ge1uO3Y=" crossorigin="anonymous"></script>

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
  <script src="assets/js/jquery.dataTables.min.js"></script>
  <script src="assets/js/dataTables.bootstrap4.min.js"></script>

  <!-- Page Specific JS File -->
  <script src="assets/js/page/index.js"></script>
</body>
</html>
