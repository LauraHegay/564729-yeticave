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
<form class="form container <?=$classname; ?>" action="sing-up.php" method="post" enctype="multipart/form-data">
    <h2>Регистрация нового аккаунта</h2>
    <?php $classname=isset($errors['email'])? "form__item--invalid":"";
    $value = isset($user['email']) ? $user['email'] : ""; ?>
    <div class="form__item <?=$classname; ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=$value;?>" required>
        <span class="form__error"><?=$errors['email']; ?></span>
    </div>
    <?php $classname=isset($errors['password'])? "form__item--invalid":"";
    $value = isset($user['password']) ? $user['password'] : ""; ?>
    <div class="form__item <?=$classname; ?>">
        <label for="password">Пароль*</label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?=htmlspecialchars($value);?>" required>
        <span class="form__error">Введите пароль</span>
    </div>
    <?php $classname=isset($errors['name'])? "form__item--invalid":"";
    $value = isset($user['name']) ? $user['name'] : ""; ?>
    <div class="form__item <?=$classname; ?>">
        <label for="name">Имя*</label>
        <input id="name" type="text" name="name" placeholder="Введите имя" value="<?=htmlspecialchars($value);?>"  required>
        <span class="form__error">Введите имя</span>
    </div>
    <?php $classname=isset($errors['message'])? "form__item--invalid":"";
    $value = isset($user['message']) ? $user['message'] : ""; ?>
    <div class="form__item <?=$classname; ?>">
        <label for="message">Контактные данные*</label>
        <textarea id="message" name="message" placeholder="Напишите как с вами связаться" required><?=htmlspecialchars($value);?></textarea>
        <span class="form__error">Напишите как с вами связаться</span>
    </div>
    <?php $classname=isset($errors['user-avatar'])? "form__item--invalid":"form__item--uploaded ";
    $value = isset($user['user-avatar']) ? $user['user-avatar'] : ""; ?>
    <div class="form__item form__item--file form__item--last <?=$classname; ?>">
        <label>Аватар</label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="<?=$value;?>" width="113" height="113" alt="Ваш аватар">
            </div>
        </div>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="photo2" name="user-avatar" value="">
            <label for="photo2">
                <span>+ Добавить</span>
            </label>
            <span class="form__error">Загрузите фотографию</span>
        </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="#">Уже есть аккаунт</a>
</form>