<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta charset="utf-8">
        <meta name="generator" content="Bootply" />
        <link rel="shortcut icon" type="images/x-icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/tempo.png"/>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <!-- blueprint CSS framework -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" rel="stylesheet">
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles.css" />
    </head>
    <body>
        <div class="page-containercontainer">
            <!-- top navbar -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="offcanvas" data-target=".sidebar-nav">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#" style="color:greenyellow"><i class="fa fa-clock-o fa-lg"></i><?php echo ' ' . CHtml::encode(Yii::app()->name); ?></a>
                </div>

                                    <?php echo $logged = !Yii::app()->user->isGuest ? "<div class='col-sm-6'><div class='text-center' style='color:greenyellow'><i class='fa fa-bell-o'></i><a href='#'><span class='badge'>3</span></a></div></div><div class='col-md-4'><span class='btn btn-success pull-right'>" . Yii::app()->user->getState('profile')->cn . "</span></div>" : ""; ?>
            </nav>
            <!-- header -->
            <div class="container-fluid">
                <div class="row row-offcanvas row-offcanvas-left">
                    <!--sidebar-->
                    <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
                        <div data-spy="affix" data-offset-top="45" data-offset-bottom="90">
                            <ul class="nav" id="sidebar-nav">
                                <?php
                                $this->widget('zii.widgets.CMenu', array(
                                    'items' => array(
                                        array('label' => '<i class="fa fa-home fa-3x"></i> Home', 'url' => array('/site/index'),),
                                        array('label' => '<i class="fa fa-calendar fa-3x"></i> Mie Timesheets', 'url' => array('/timesheet/admin'), 'visible' => !Yii::app()->user->isGuest),
                                        array('label' => '<i class="fa fa-dashboard fa-3x"></i> Reports', 'url' => array('/reports'), 'visible' => !Yii::app()->user->isGuest),
                                        array('label' => Yii::t('model', '<i class="fa fa-gear fa-3x"></i> Gestione', array('{model}' => Yii::t('gestione', 'Gestione'))), 'url' => array('/gestione'), 'visible' => Yii::app()->user->checkAccess('ADMIN')),
                                        //array('label' => Yii::t('model', '<i class="fa fa-gear fa-3x"></i> {model} Management', array('{model}' => Yii::t('lookup', 'Lookups'))), 'url' => array('/lookup'), 'visible' => Yii::app()->user->checkAccess('ADMIN')),
                                        array('label' => Yii::t('model', '<i class="fa fa-users fa-3x"></i> Attività utenti', array('{model}' => Yii::t('user', 'User Activity'))), 'url' => array('/userActivity/admin'), 'visible' => Yii::app()->user->checkAccess('LOG_CONSULTAZIONE')),
                                        array('label' => Yii::t('model', '<i class="fa fa-cogs fa-3x"></i> Back End'), 'url' => array('/srbac'), 'visible' => Yii::app()->user->checkAccess('Authority')),
                                        array('label' => Yii::t('site', '<i class="fa fa-sign-in fa-3x"></i> Login'), 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                                        array('label' => Yii::t('site', '<i class="fa fa-sign-out fa-3x" style="color:red">&nbsp;</i> Logout'), 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
                                    ),
                                    'htmlOptions' => array('class' => 'nav', 'id' => 'sidebar-nav'),
                                    'encodeLabel' => false,
                                ));
                                ?>
                            </ul>
                        </div>
                    </div><!--/sidebar-->
                    <div class="col-xs-12 col-sm-9" data-spy="scroll" data-target="#sidebar-nav">
                        <div class="row">
                            <?php echo $content; ?>
                        </div>
                    </div>
                </div>
            </div><!--/.container-->
        </div><!-- page -->
        <footer><!--footer-->
            <div class="container">
                <div class="row">
                    <ul class="list-unstyled text-right">
                        <li class="col-sm-4 col-xs-6">
                            <p><?php echo Yii::t('site', 'Copyright &copy; {year} by {company}.', array('{year}' => date('Y'), '{company}' => Yii::app()->params['company'])); ?></p>
                            <p><?php echo Yii::t('site', 'All Rights Reserved.'); ?></p>
                        </li>
                        <li class="col-sm-4 col-xs-6">
                            <p style="color:greenyellow">Supporto:</p>
                            <a href="mailto:<?php
                            $supportEmail = Yii::app()->params['supportEmail'];
                            echo $supportEmail;
                            ?>"><i class="fa fa-life-ring fa-3x"></i></a>
                        </li>
                        <li class="col-sm-4 col-xs-6">
                            <p style="color:greenyellow">Seguici:</p>
                            <a href="https://www.facebook.com/NAD.srl" target="_blank"><i class="fa fa-facebook-official fa-3x"></i></a>
                            <a href="https://www.linkedin.com/company/nad-s.r.l." target="_blank"><i class="fa fa-linkedin fa-3x"></i></a>
                        </li>
                    </ul>
                </div><!--/row-->
            </div><!--/container-->
        </footer>

        <!-- script references -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/scripts.js"></script>
    </body>
</html>
