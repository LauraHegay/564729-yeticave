<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $value): ?>
            <li class="nav__item">
                <a href="all-lots.html"><?=$value['name']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<?php $classname=count($errors)? "form--invalid":""; ?>
<form class="form container <?=$classname; ?>" action="login.php" method="post">
    <h2>Вход</h2>
    <?php $classname=isset($errors['email'])? "form__item--invalid":"";
    $value = isset($form['email']) ? $form['email'] : ""; ?>
    <div class="form__item <?=$classname; ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=$value; ?>">
        <span class="form__error"><?=$errors['email']; ?></span>
    </div>
    <?php $classname=isset($errors['password'])? "form__item--invalid":"";
    $value = isset($form['email']) ? $form['email'] : ""; ?>
    <div class="form__item form__item--last <?=$classname; ?>">
        <label for="password">Пароль*</label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error"><?=$errors['password']; ?></span>
    </div>
    <button type="submit" class="button">Войти</button>
</form>