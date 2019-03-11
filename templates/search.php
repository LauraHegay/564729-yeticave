<?=include_template('site-menu.php', ['categories' => $categories]); ?>
<div class="container">
    <section class="lots">
        <h2>Результаты поиска по запросу «<span><?=htmlspecialchars($search);?></span>»</h2>
        <span><?=(!empty($message)? $message:""); ?></span>
            <ul class="lots__list">
                <?php foreach ($advertisements as $key => $value): ?>
                    <?=include_template('card.php',['value'=>$value]); ?>
                <?php endforeach; ?>
            </ul>

    </section>
    <?php if($page_count>1):?>
    <?=include_template('pagination.php', [
        'pages' => $pages,
        'page_count' => $page_count,
        'cur_page' => $cur_page,
        'search'=>$search
    ]); ?>
    <?php endif; ?>
</div>