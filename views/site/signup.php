<div class="container">
    <div class="row">

        <div class="col-md-offset-3 col-md-6">
            <form action="" method="POST" class="form-horizontal">
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken(); ?>">
                <span class="heading">Форма регистрации</span>
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Ваше имя">
                    <i class="fas fa-user"></i>
                </div>

                <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="Ваш e-mail">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Пароль">
                    <i class="fa fa-lock"></i>
                </div>
                <div class="form group" style="display: inline-block;">
                    <?= \Himiklab\yii2\recaptcha\ReCaptcha::widget(['name' => 'reCaptcha']) ?>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default">Подтвердить</button>
                </div>
                <?php
                    if($_POST) {
                        foreach ($model->getFirstErrors() as $error) {
                                echo "<div class=\"alert alert-danger\" style=\"\" role=\"alert\">$error</div>";
                        }
                    }
                ?>

            </form>
        </div>

    </div><!-- /.row -->
</div><!-- /.container -->