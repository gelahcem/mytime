<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
    'Login',
);

$isLdap = Yii::app()->params['identityClass'] == 'LdapUserIdentity';
$showRegister = !$isLdap;
$showRemember = Yii::app()->params['loginRememberEnabled'];
?>

<div class="col-sm-6">
    <div class="well">
        <div class="form">
            <h4>Login</h4>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'User',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            ));
            ?>
            <div class="input-group text-center">

                <?php
                echo $form->textField($model, 'username', array(
                    'class' => 'form-control input-lg',
                    'placeholder' => 'Utente',
                    'style' => 'height: 45px;')
                );
                ?>
                <?php echo $form->error($model, 'username'); ?>

                <?php
                echo $form->passwordField($model, 'password', array(
                    'class' => 'form-control input-lg',
                    'placeholder' => 'Password',
                    'style' => 'height: 45px;')
                );
                ?>
                <?php echo $form->error($model, 'password'); ?>

                <span class="input-group-btn">
                    <?php
                    echo CHtml::submitButton('OK', array(
                        'class' => 'btn btn-lg btn-primary',
                        'style' => 'height: 90px;')
                    );
                    ?>
                </span>
            </div><!--/input group-->
        </div><!--/form-->
        <?php $this->endWidget(); ?>
        <?php if ($isLdap) : ?>
            <p><?php echo Yii::t('site', 'Please use your {domain_name} domain account.', array('{domain_name}' => Yii::app()->ldap->domain)); ?></p>
        <?php endif; ?>
        <p><?php echo Yii::t('site', 'Please fill out the following form with your login credentials.'); ?></p>
    </div><!--/well-->
</div>
