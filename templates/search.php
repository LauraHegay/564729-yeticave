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
      <?php foreach ($pages as $page): ?>
        <li class="pagination-item pagination-item-prev"><a href="search.php/?page<?= --$cur_page; ?>">Назад</a></li>
        <li class="pagination-item <?php if ($page=$cur_page): ?>pagination-item-active<?php endif; ?>">
          <a href="search.php/?page<?=$page; ?>"><?=$page; ?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
<!--    <ul class="pagination-list">-->
<!--        <li class="pagination-item pagination-item-prev"><a>Назад</a></li>-->
<!--        <li class="pagination-item pagination-item-active"><a>1</a></li>-->
<!--        <li class="pagination-item"><a href="#">2</a></li>-->
<!--        <li class="pagination-item"><a href="#">3</a></li>-->
<!--        <li class="pagination-item"><a href="#">4</a></li>-->
<!--        <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>-->
<!--    </ul>-->
</div>