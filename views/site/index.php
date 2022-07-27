<?php
$guideModel = new \models\Guides();
$newsModel = new \models\News();
$heroModel = new \models\Heroes();
$userModel = new \models\Users();
$guides = $guideModel->GetBestGuides();
$lastNews = $newsModel->GetLastNews(10);
?>
<?php ?>
    <div style="display: flex; justify-content: space-around" class="adapt">
        <div style="width: 60%">
            <h3>Последние новости</h3>
            <?php if (!empty($lastNews)) : ?>
                <?php foreach ($lastNews as $news) : ?>
                    <div class="news-record">
                        <h3><?= $news['title'] ?></h3>
                        <span style="color: #868E96"><?= $news['type'] ?></span>
                        <div class="photo">
                            <? if (is_file('files/news/' . $news['photo'] . '_s.jpg')) : ?>
                                <img class="bd-placeholder-img rounded float-start"
                                     src="/files/news/<?= $news['photo'] ?>_s.jpg">
                            <? else: ?>
                                <svg class="bd-placeholder-img rounded float-start" width="200" height="200"
                                     xmlns="http://www.w3.org/2000/svg" role="img" preserveAspectRatio="xMidYMid slice"
                                     focusable="false">
                                    <rect width="100%" height="100%" fill="#868e96"></rect>
                                </svg>
                            <? endif; ?>
                        </div>
                        <div>
                            <?= $news['short_text'] ?>
                        </div>
                        <div>
                            <a href="/news/view?id=<?= $news['id'] ?>" class="btn btn-primary">Просмотреть</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div>
            <h3>Лучшие гайды</h3>
            <?php if (!empty($guides)) : ?>
                <?php foreach ($guides as $guide) : ?>
                    <div class="news-record">
                        <h3><?= $guide['name'] ?></h3>
                        <div class="photo">
                            <a href="/guides/view?id=<?= $guide['id'] ?>">
                                <? if (is_file('files/heroes/' . $heroModel->GetHeroById($guide['hero_id'])['photo_icon'] . '_icon.jpg')) : ?>
                                    <img class="bd-placeholder-img rounded float-start"
                                         src="/files/heroes/<?= $heroModel->GetHeroById($guide['hero_id'])['photo_icon'] ?>_icon.jpg">
                                <? else: ?>
                                    <svg class="bd-placeholder-img rounded float-start" width="200" height="200"
                                         xmlns="http://www.w3.org/2000/svg" role="img"
                                         preserveAspectRatio="xMidYMid slice"
                                         focusable="false">
                                        <rect width="100%" height="100%" fill="#868e96"></rect>
                                    </svg>
                                <? endif; ?>
                            </a>
                        </div>
                        <div>
                            <?= $userModel->GetUserById($guide['user_id'])['login'] ?>
                        </div>
                        <div>
                            <?= $guide['description'] ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <? endif; ?>
        </div>

    </div>
<?php



