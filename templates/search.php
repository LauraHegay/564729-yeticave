<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $value): ?>
            <li class="nav__item">
                <a href="all-lots.html"><?=$value['name']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<div class="container">
    <section class="lots">
        <h2>Результаты поиска по запросу «<span><?=htmlspecialchars($search);?></span>»</h2>
        <span><?=$message; ?></span>
            <ul class="lots__list">
                <?php foreach ($advertisements as $key => $value): ?>
                    <?=include_template('card.php',['value'=>$value]); ?>
                <?php endforeach; ?>
            </ul>

    </section>
  <?php if($page_count>1):?>
    <ul class="pagination-list">
        <?php if($cur_page !== 1) : ?>
      <li class="pagination-item pagination-item-prev"><a href="search.php/?search=<?=$search; ?>&page=<?=($cur_page-1); ?>">Назад</a></li>
        <?php else: ?>
          <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <?php endif; ?>
      <?php foreach ($pages as $page): ?>
        <li class="pagination-item <?php if ($page==$cur_page): ?>pagination-item-active<?php endif; ?>">
          <a href="/search.php/?search=<?=$search; ?>&page=<?=$page; ?>"><?=$page; ?></a>
        </li>
      <?php endforeach; ?>
        <?php if($cur_page !== $page_count) : ?>
          <li class="pagination-item pagination-item-next"><a href="search.php/?search=<?=$search; ?>&page=<?=($cur_page+1); ?>">Вперед</a></li>
        <?php else: ?>
          <li class="pagination-item pagination-item-next"><a>Вперед</a></li>
        <?php endif; ?>
    </ul>
  <?php endif; ?>
</div>