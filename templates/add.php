<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $value): ?>
            <li class="nav__item">
                <a href="all-lots.html"><?=$value['name']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<?php $classname=count($errors)? "form--invalid":"";
?>

<form class="form form--add-lot container <?=$classname;?>" action="add.php" method="post" enctype="multipart/form-data">
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <?php $classname=isset($errors['lot-name'])? "form__item--invalid":"";
        $value = isset($lot['lot-name']) ? $lot['lot-name'] : ""; ?>
        <div class="form__item <?=$classname;?>">
            <label for="lot-name">Наименование</label>
            <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?=htmlspecialchars($value);?>">
            <span class="form__error">Введите наименование лота</span>
        </div>
        <?php $classname=isset($errors['category'])? "form__item--invalid":"";
        $value = isset($lot['category']) ? $lot['category'] : ""; ?>
        <div class="form__item <?=$classname;?>">
            <label for="category">Категория</label>
            <select id="category" name="category">
                <?php foreach ($categories as $value): ?>
                    <option value="<?=$value['id'] ?>"><?=$value['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <span class="form__error">Выберите категорию</span>
        </div>
    </div>
    <?php $classname=isset($errors['message'])? "form__item--invalid":"";
    $value = isset($lot['message']) ? $lot['message'] : ""; ?>
    <div class="form__item form__item--wide <?=$classname;?>">
      <label for="message">Описание</label>
      <textarea id="message" name="message" placeholder="Напишите описание лота"><?=htmlspecialchars($value);?></textarea>
      <span class="form__error">Напишите описание лота</span>
    </div>
    <?php $classname=isset($errors['photo2'])? "form__item--invalid":"form__item--uploaded ";
    $value = isset($lot['photo2']) ? $lot['photo2'] : ""; ?>
    <div class="form__item form__item--file <?=$classname;?>"> <!-- form__item--uploaded -->
      <label>Изображение</label>
      <div class="preview">
        <button class="preview__remove" type="button">x</button>
        <div class="preview__img">
          <img src="<?=$value;?>" width="113" height="113" alt="Изображение лота">
        </div>
      </div>
      <div class="form__input-file <?=$classname;?>">
        <input class="visually-hidden" type="file" id="photo2" name="photo2" value="">
        <label for="photo2">
          <span>+ Добавить</span>
        </label>
        <span class="form__error">Загрузите фотографию</span>
      </div>
    </div>
    <div class="form__container-three">
        <?php $classname=isset($errors['lot-rate'])? "form__item--invalid":"";
        $value = isset($lot['lot-rate'])? $lot['lot-rate'] : ""; ?>
      <div class="form__item form__item--small <?=$classname;?>">
        <label for="lot-rate">Начальная цена</label>
        <input id="lot-rate" type="number" name="lot-rate" placeholder="0" value="<?=$value;?>">
        <span class="form__error">Введите начальную цену</span>
      </div>
        <?php $classname=isset($errors['lot-step'])? "form__item--invalid":"";
        $value = isset($lot['lot-step']) ? $lot['lot-step'] : ""; ?>
      <div class="form__item form__item--small <?=$classname;?>">
        <label for="lot-step">Шаг ставки</label>
        <input id="lot-step" type="number" name="lot-step" placeholder="0" value="<?=$value;?>">
        <span class="form__error">Введите шаг ставки</span>
      </div>
        <?php $classname=isset($errors['lot-date'])? "form__item--invalid":"";
        $value = isset($lot['lot-date']) ? $lot['lot-date'] : ""; ?>
      <div class="form__item <?=$classname;?>">
        <label for="lot-date">Дата окончания торгов</label>
        <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="дд.мм.гггг" value="<?=$value;?>" >
        <span class="form__error">Введите дату завершения торгов</span>
      </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
</form>
