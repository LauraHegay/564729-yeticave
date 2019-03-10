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
    <?=include_template('pagination.php', [
        'pages' => $pages,
        'page_count' => $page_count,
        'cur_page' => $cur_page,
        'search'=>$search
    ]); ?>
</div>