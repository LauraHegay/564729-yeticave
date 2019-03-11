    <?=include_template('site-menu.php', ['categories' => $categories]); ?>
    <section class="lot-item container">
        <h2><?=$lot['title']; ?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?=$lot['image_path']; ?>" width="730" height="548" alt="<?=$lot['title']; ?>">
                </div>
                <p class="lot-item__category">Категория: <span><?=$lot['name']; ?></span></p>
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
                        Мин. ставка <span><?=intval($lot['step_rate'])+intval($sum_price['sum_price']); ?> р</span>
                      </div>
                    </div>
                      <?php if ($show_form==1): ?>
                      <?php $classname=(isset($_GET['errors']))? "form__item--invalid":""; ?>
                    <form class="lot-item__form" action="lot.php" method="post">
                      <p class="lot-item__form-item form__item <?=$classname; ?>">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="text" name="cost" placeholder="<?=intval($lot['step_rate'])+intval($sum_price['sum_price']); ?>">
                        <input class="visually-hidden" id="id_lot" type="text" name="id" value="<?=$id_lot; ?>">
                        <span class="form__error"><?=(isset($_GET['errors']))? $_GET['errors']:""; ?></span>
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
                            <td class="history__name"><?=htmlspecialchars($value['name']); ?></td>
                            <td class="history__price"><?=$value['sum_price']; ?> р</td>
                            <td class="history__time"><?=$value['date_registered']; ?></td>
                          </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
