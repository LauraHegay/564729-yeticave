    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $value): ?>
              <li class="nav__item">
                <a href="all-lots.html"><?=$value['name']; ?></a>
              </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <section class="lot-item container">
        <h2><?=$lot['title']; ?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?=$lot['image_path']; ?>" width="730" height="548" alt="<?=$lot['title']; ?>">
                </div>
                <p class="lot-item__category">Категория: <span><?=$lot['category']; ?></span></p>
                <p class="lot-item__description"><?=htmlspecialchars($lot['description']); ?></p>
            </div>
            <div class="lot-item__right">

                  <div class="lot-item__state">
                    <div class="lot-item__timer timer">
                      10:54
                    </div>
                    <div class="lot-item__cost-state">
                      <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?=$sum_price['sum_price']; ?></span>
                      </div>
                      <div class="lot-item__min-cost">
                        Мин. ставка <span><?=$lot['step_rate']; ?> р</span>
                      </div>
                    </div>
                      <?php if ($show_form==1): ?>
                      <?php $classname=(isset($_GET['errors']))? "form__item--invalid":""; ?>
                    <form class="lot-item__form" action="lot.php" method="post">
                      <p class="lot-item__form-item form__item <?=$classname; ?>">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="text" name="cost" placeholder="<?=$lot['step_rate']; ?>">
                        <input class="visually-hidden" id="id_lot" type="text" name="id" value="<?=$id_lot; ?>">
                        <input class="visually-hidden" id="user_id_lot" type="text" name="user_id" value="<?=$lot['user_id']; ?>">
                        <input class="visually-hidden" id="date_end_lot" type="text" name="date_end" value="<?=$lot['date_end']; ?>">
                        <input class="visually-hidden" id="sum_price_lot" type="text" name="sum_price" value="<?=$sum_price['sum_price']; ?>">
                        <input class="visually-hidden" id="step_rate_lot" type="text" name="step_rate" value="<?=$lot['step_rate']; ?>">
                        <span class="form__error"><?=$_GET['errors']; ?></span>
                      </p>
                      <button type="submit" class="button">Сделать ставку</button>
                    </form>
                      <?php endif; ?>
                  </div>

                <div class="history">
                    <h3>История ставок (<span><?=$rates_count; ?></span>)</h3>
                    <table class="history__list">
                        <?php foreach ($rates as $key => $value): ?>
                          <tr class="history__item">
                            <td class="history__name"><?=$value['name']; ?></td>
                            <td class="history__price"><?=$value['sum_price']; ?> р</td>
                            <td class="history__time"><?=$value['date_registered']; ?></td>
                          </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
