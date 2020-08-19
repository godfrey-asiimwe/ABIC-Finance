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
            <div class="col-lg-8 col-md-12 col-12 col-sm-12">
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
                
                     <div id="piechart" style="width: 900px; height: 300px;"></div>
                 
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-12 col-12 col-sm-12">
              <div class="card">
                <div class="card-header">
                  <h4>Recent Activities</h4>
                </div>
                <div class="card-body">
                  <ul class="list-unstyled list-unstyled-border">
                    <li class="media">
                      <img class="mr-3 rounded-circle" width="50" src="../assets/img/avatar/avatar-1.png" alt="avatar">
                      <div class="media-body">
                        <div class="float-right text-primary">Now</div>
                        <div class="media-title">Farhan A Mujib</div>
                        <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</span>
                      </div>
                    </li>
                    <li class="media">
                      <img class="mr-3 rounded-circle" width="50" src="../assets/img/avatar/avatar-2.png" alt="avatar">
                      <div class="media-body">
                        <div class="float-right">12m</div>
                        <div class="media-title">Ujang Maman</div>
                        <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</span>
                      </div>
                    </li>
                    <li class="media">
                      <img class="mr-3 rounded-circle" width="50" src="../assets/img/avatar/avatar-3.png" alt="avatar">
                      <div class="media-body">
                        <div class="float-right">17m</div>
                        <div class="media-title">Rizal Fakhri</div>
                        <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</span>
                      </div>
                    </li>
                    <li class="media">
                      <img class="mr-3 rounded-circle" width="50" src="../assets/img/avatar/avatar-4.png" alt="avatar">
                      <div class="media-body">
                        <div class="float-right">21m</div>
                        <div class="media-title">Alfa Zulkarnain</div>
                        <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</span>
                      </div>
                    </li>
                  </ul>
                  <div class="text-center pt-1 pb-1">
                    <a href="#" class="btn btn-primary btn-lg btn-round">
                      View All
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
              <div class="card">
                <div class="card-body pt-2 pb-2">
                  <div id="myWeather">Please wait</div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
              <div class="card">
                <div class="card-header">
                  <h4>Authors</h4>
                </div>
                <div class="card-body">
                  <div class="row pb-2">
                    <div class="col-6 col-sm-3 col-lg-3 mb-4 mb-md-0">
                      <div class="avatar-item mb-0">
                        <img alt="image" src="../assets/img/avatar/avatar-5.png" class="img-fluid" data-toggle="tooltip" title="Alfa Zulkarnain">
                        <div class="avatar-badge" title="Editor" data-toggle="tooltip"><i class="fas fa-wrench"></i></div>
                      </div>
                    </div>
                    <div class="col-6 col-sm-3 col-lg-3 mb-4 mb-md-0">
                      <div class="avatar-item mb-0">
                        <img alt="image" src="../assets/img/avatar/avatar-4.png" class="img-fluid" data-toggle="tooltip" title="Egi Ferdian">
                        <div class="avatar-badge" title="Admin" data-toggle="tooltip"><i class="fas fa-cog"></i></div>
                      </div>
                    </div>
                    <div class="col-6 col-sm-3 col-lg-3 mb-4 mb-md-0">
                      <div class="avatar-item mb-0">
                        <img alt="image" src="../assets/img/avatar/avatar-1.png" class="img-fluid" data-toggle="tooltip" title="Jaka Ramadhan">
                        <div class="avatar-badge" title="Author" data-toggle="tooltip"><i class="fas fa-pencil-alt"></i></div>
                      </div>
                    </div>
                    <div class="col-6 col-sm-3 col-lg-3 mb-4 mb-md-0">
                      <div class="avatar-item mb-0">
                        <img alt="image" src="../assets/img/avatar/avatar-2.png" class="img-fluid" data-toggle="tooltip" title="Ryan">
                        <div class="avatar-badge" title="Admin" data-toggle="tooltip"><i class="fas fa-cog"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-md-6 col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Referral URL</h4>
                </div>
                <div class="card-body">
                  <div class="mb-4">
                    <div class="text-small float-right font-weight-bold text-muted">2,100</div>
                    <div class="font-weight-bold mb-1">Google</div>
                    <div class="progress" data-height="3">
                      <div class="progress-bar" role="progressbar" data-width="80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>

                  <div class="mb-4">
                    <div class="text-small float-right font-weight-bold text-muted">1,880</div>
                    <div class="font-weight-bold mb-1">Facebook</div>
                    <div class="progress" data-height="3">
                      <div class="progress-bar" role="progressbar" data-width="67%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>

                  <div class="mb-4">
                    <div class="text-small float-right font-weight-bold text-muted">1,521</div>
                    <div class="font-weight-bold mb-1">Bing</div>
                    <div class="progress" data-height="3">
                      <div class="progress-bar" role="progressbar" data-width="58%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>

                  <div class="mb-4">
                    <div class="text-small float-right font-weight-bold text-muted">884</div>
                    <div class="font-weight-bold mb-1">Yahoo</div>
                    <div class="progress" data-height="3">
                      <div class="progress-bar" role="progressbar" data-width="36%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>

                  <div class="mb-4">
                    <div class="text-small float-right font-weight-bold text-muted">473</div>
                    <div class="font-weight-bold mb-1">Kodinger</div>
                    <div class="progress" data-height="3">
                      <div class="progress-bar" role="progressbar" data-width="28%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>

                  <div class="mb-4">
                    <div class="text-small float-right font-weight-bold text-muted">418</div>
                    <div class="font-weight-bold mb-1">Multinity</div>
                    <div class="progress" data-height="3">
                      <div class="progress-bar" role="progressbar" data-width="20%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header">
                  <h4>Popular Browser</h4>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col text-center">
                      <div class="browser browser-chrome"></div>
                      <div class="mt-2 font-weight-bold">Chrome</div>
                      <div class="text-muted text-small"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 48%</div>
                    </div>
                    <div class="col text-center">
                      <div class="browser browser-firefox"></div>
                      <div class="mt-2 font-weight-bold">Firefox</div>
                      <div class="text-muted text-small"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 26%</div>
                    </div>
                    <div class="col text-center">
                      <div class="browser browser-safari"></div>
                      <div class="mt-2 font-weight-bold">Safari</div>
                      <div class="text-muted text-small"><span class="text-danger"><i class="fas fa-caret-down"></i></span> 14%</div>
                    </div>
                    <div class="col text-center">
                      <div class="browser browser-opera"></div>
                      <div class="mt-2 font-weight-bold">Opera</div>
                      <div class="text-muted text-small">7%</div>
                    </div>
                    <div class="col text-center">
                      <div class="browser browser-internet-explorer"></div>
                      <div class="mt-2 font-weight-bold">IE</div>
                      <div class="text-muted text-small"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 5%</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card mt-sm-5 mt-md-0">
                <div class="card-header">
                  <h4>Visitors</h4>
                </div>
                <div class="card-body">
                  <div id="visitorMap"></div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
              <div class="card">
                <div class="card-header">
                  <h4>This Week Stats</h4>
                  <div class="card-header-action">
                    <div class="dropdown">
                      <a href="#" class="dropdown-toggle btn btn-primary" data-toggle="dropdown">Filter</a>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item has-icon"><i class="far fa-circle"></i> Electronic</a>
                        <a href="#" class="dropdown-item has-icon"><i class="far fa-circle"></i> T-shirt</a>
                        <a href="#" class="dropdown-item has-icon"><i class="far fa-circle"></i> Hat</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">View All</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="summary">
                    <div class="summary-info">
                      <h4>$1,053</h4>
                      <div class="text-muted">Sold 3 items on 2 customers</div>
                      <div class="d-block mt-2">
                        <a href="#">View All</a>
                      </div>
                    </div>
                    <div class="summary-item">
                      <h6>Item List <span class="text-muted">(3 Items)</span></h6>
                      <ul class="list-unstyled list-unstyled-border">
                        <li class="media">
                          <a href="#">
                            <img class="mr-3 rounded" width="50" src="../assets/img/products/product-1-50.png" alt="product">
                          </a>
                          <div class="media-body">
                            <div class="media-right">$405</div>
                            <div class="media-title"><a href="#">PlayStation 9</a></div>
                            <div class="text-muted text-small">by <a href="#">Hasan Basri</a> <div class="bullet"></div> Sunday</div>
                          </div>
                        </li>
                        <li class="media">
                          <a href="#">
                            <img class="mr-3 rounded" width="50" src="../assets/img/products/product-2-50.png" alt="product">
                          </a>
                          <div class="media-body">
                            <div class="media-right">$499</div>
                            <div class="media-title"><a href="#">RocketZ</a></div>
                            <div class="text-muted text-small">by <a href="#">Hasan Basri</a> <div class="bullet"></div> Sunday
                            </div>
                          </div>
                        </li>
                        <li class="media">
                          <a href="#">
                            <img class="mr-3 rounded" width="50" src="../assets/img/products/product-3-50.png" alt="product">
                          </a>
                          <div class="media-body">
                            <div class="media-right">$149</div>
                            <div class="media-title"><a href="#">Xiaomay Readme 4.0</a></div>
                            <div class="text-muted text-small">by <a href="#">Kusnaedi</a> <div class="bullet"></div> Tuesday
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header">
                  <h4 class="d-inline">Tasks</h4>
                  <div class="card-header-action">
                    <a href="#" class="btn btn-primary">View All</a>
                  </div>
                </div>
                <div class="card-body">
                  <ul class="list-unstyled list-unstyled-border">
                    <li class="media">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="cbx-1">
                        <label class="custom-control-label" for="cbx-1"></label>
                      </div>
                      <img class="mr-3 rounded-circle" width="50" src="../assets/img/avatar/avatar-4.png" alt="avatar">
                      <div class="media-body">
                        <div class="badge badge-pill badge-danger mb-1 float-right">Not Finished</div>
                        <h6 class="media-title"><a href="#">Redesign header</a></h6>
                        <div class="text-small text-muted">Alfa Zulkarnain <div class="bullet"></div> <span class="text-primary">Now</span></div>
                      </div>
                    </li>
                    <li class="media">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="cbx-2" checked="">
                        <label class="custom-control-label" for="cbx-2"></label>
                      </div>
                      <img class="mr-3 rounded-circle" width="50" src="../assets/img/avatar/avatar-5.png" alt="avatar">
                      <div class="media-body">
                        <div class="badge badge-pill badge-primary mb-1 float-right">Completed</div>
                        <h6 class="media-title"><a href="#">Add a new component</a></h6>
                        <div class="text-small text-muted">Serj Tankian <div class="bullet"></div> 4 Min</div>
                      </div>
                    </li>
                    <li class="media">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="cbx-3" >
                        <label class="custom-control-label" for="cbx-3"></label>
                      </div>
                      <img class="mr-3 rounded-circle" width="50" src="../assets/img/avatar/avatar-2.png" alt="avatar">
                      <div class="media-body">
                        <div class="badge badge-pill badge-warning mb-1 float-right">Progress</div>
                        <h6 class="media-title"><a href="#">Fix modal window</a></h6>
                        <div class="text-small text-muted">Ujang Maman <div class="bullet"></div> 8 Min</div>
                      </div>
                    </li>
                    <li class="media">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="cbx-4">
                        <label class="custom-control-label" for="cbx-4"></label>
                      </div>
                      <img class="mr-3 rounded-circle" width="50" src="../assets/img/avatar/avatar-1.png" alt="avatar">
                      <div class="media-body">
                        <div class="badge badge-pill badge-danger mb-1 float-right">Not Finished</div>
                        <h6 class="media-title"><a href="#">Remove unwanted classes</a></h6>
                        <div class="text-small text-muted">Farhan A Mujib <div class="bullet"></div> 21 Min</div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-5 col-md-12 col-12 col-sm-12">
              <form method="post" class="needs-validation" novalidate="">
                <div class="card">
                  <div class="card-header">
                    <h4>Quick Draft</h4>
                  </div>
                  <div class="card-body pb-0">
                    <div class="form-group">
                      <label>Title</label>
                      <input type="text" name="title" class="form-control" required>
                      <div class="invalid-feedback">
                        Please fill in the title
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Content</label>
                      <textarea class="summernote-simple"></textarea>
                    </div>
                  </div>
                  <div class="card-footer pt-0">
                    <button class="btn btn-primary">Save Draft</button>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-lg-7 col-md-12 col-12 col-sm-12">
              <div class="card">
                <div class="card-header">
                  <h4>Latest Posts</h4>
                  <div class="card-header-action">
                    <a href="#" class="btn btn-primary">View All</a>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-striped mb-0">
                      <thead>
                        <tr>
                          <th>Title</th>
                          <th>Author</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            Introduction Laravel 5
                            <div class="table-links">
                              in <a href="#">Web Development</a>
                              <div class="bullet"></div>
                              <a href="#">View</a>
                            </div>
                          </td>
                          <td>
                            <a href="#" class="font-weight-600"><img src="../assets/img/avatar/avatar-1.png" alt="avatar" width="30" class="rounded-circle mr-1"> Bagus Dwi Cahya</a>
                          </td>
                          <td>
                            <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                            <a class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="alert('Deleted')"><i class="fas fa-trash"></i></a>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            Laravel 5 Tutorial - Installation
                            <div class="table-links">
                              in <a href="#">Web Development</a>
                              <div class="bullet"></div>
                              <a href="#">View</a>
                            </div>
                          </td>
                          <td>
                            <a href="#" class="font-weight-600"><img src="../assets/img/avatar/avatar-1.png" alt="avatar" width="30" class="rounded-circle mr-1"> Bagus Dwi Cahya</a>
                          </td>
                          <td>
                            <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                            <a class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="alert('Deleted')"><i class="fas fa-trash"></i></a>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            Laravel 5 Tutorial - MVC
                            <div class="table-links">
                              in <a href="#">Web Development</a>
                              <div class="bullet"></div>
                              <a href="#">View</a>
                            </div>
                          </td>
                          <td>
                            <a href="#" class="font-weight-600"><img src="../assets/img/avatar/avatar-1.png" alt="avatar" width="30" class="rounded-circle mr-1"> Bagus Dwi Cahya</a>
                          </td>
                          <td>
                            <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                            <a class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="alert('Deleted')"><i class="fas fa-trash"></i></a>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            Laravel 5 Tutorial - Migration
                            <div class="table-links">
                              in <a href="#">Web Development</a>
                              <div class="bullet"></div>
                              <a href="#">View</a>
                            </div>
                          </td>
                          <td>
                            <a href="#" class="font-weight-600"><img src="../assets/img/avatar/avatar-1.png" alt="avatar" width="30" class="rounded-circle mr-1"> Bagus Dwi Cahya</a>
                          </td>
                          <td>
                            <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                            <a class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="alert('Deleted')"><i class="fas fa-trash"></i></a>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            Laravel 5 Tutorial - Deploy
                            <div class="table-links">
                              in <a href="#">Web Development</a>
                              <div class="bullet"></div>
                              <a href="#">View</a>
                            </div>
                          </td>
                          <td>
                            <a href="#" class="font-weight-600"><img src="../assets/img/avatar/avatar-1.png" alt="avatar" width="30" class="rounded-circle mr-1"> Bagus Dwi Cahya</a>
                          </td>
                          <td>
                            <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                            <a class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="alert('Deleted')"><i class="fas fa-trash"></i></a>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            Laravel 5 Tutorial - Closing
                            <div class="table-links">
                              in <a href="#">Web Development</a>
                              <div class="bullet"></div>
                              <a href="#">View</a>
                            </div>
                          </td>
                          <td>
                            <a href="#" class="font-weight-600"><img src="../assets/img/avatar/avatar-1.png" alt="avatar" width="30" class="rounded-circle mr-1"> Bagus Dwi Cahya</a>
                          </td>
                          <td>
                            <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                            <a class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="alert('Deleted')"><i class="fas fa-trash"></i></a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
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

  <script type="text/javascript">
    
    $(document).ready(function() {

        $('#example').DataTable();

      } );
  </script>
  <script>  
 $(document).ready(function(){  
      $('#create_excel').click(function(){  
           var excel_data = $('#example').html();  
           var page = "excel.php?data=" + excel_data;  
           window.location = page;  
      });  
 });  
 </script> 

 <script type="text/javascript">
   function exportTableToExcel(example, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(example);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
 </script>

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
