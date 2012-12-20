<? date_default_timezone_set('America/New_York'); ?>

<!DOCTYPE html>
<html>
  <head>
    <title>Project YOU</title>
    <base href="<?=$this->registry->server[$_SERVER['HTTP_HOST']]['root']?>" target="_self">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    
    <link href="media/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
    <link href="media/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet" media="screen" /> 

  </head>
  <body>
  	<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Project YOU</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="places">Places</a></li>
              <li><a href="projects">Projects</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    
    <div class="container">