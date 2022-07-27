<?php
$heroModel = new \models\Heroes();
$itemModel = new \models\Items();
$heroes = $heroModel->GetHeroById($_GET['hero_id']);
$skills = $heroModel->GetSkillsByHeroId($heroes['id']);
$talents = $heroModel->GetTalentsByHeroId($heroes['id']);
$items = $itemModel->GetAllItems();
$heroesFields = ['id', 'name', 'photo_icon'];
$talentsFields = ['lvl_10_1', 'lvl_10_2', 'lvl_15_1', 'lvl_15_2',
    'lvl_20_1', 'lvl_20_2', 'lvl_25_1', 'lvl_25_2'];
$skillFields = ['id', 'name', 'photo_skill'];
$itemsFields = ['id', 'name', 'price', 'photo'];
$readySkills = [];
$readyItems = [];
for ($i = 0; $i < count($items); $i++)
    $readyItems[$i] = \core\Utils::ArrayFilter($items[$i], $itemsFields);
for ($i = 0; $i < count($skills); $i++)
    $readySkills[$i] = \core\Utils::ArrayFilter($skills[$i], $skillFields);
$heroes = \core\Utils::ArrayFilter($heroes, $heroesFields);
$talents = \core\Utils::ArrayFilter($talents, $talentsFields);
$heroesKeys = array_keys($heroes);
$talentsKeys = array_keys($talents);
$itemsKeys = array_keys($readyItems[0]);
$skillsKeys = array_keys($readySkills[0]);
?>
<h3><?= $heroes['name'] ?></h3>
<img src="/files/heroes/<?= $heroes['photo_icon'] ?>_icon.jpg">
<form method="post" action="" enctype="multipart/form-data">
    <div class="mb-3">
        <label style="font-size: 24px" for="name" class="form-label">Название гайда</label>
        <input type="text" name="name" value="<?= $model['name'] ?>" class="form-control" id="name">
    </div>
    <div class="mb-3">
        <label style="font-size: 24px" for="description" class="form-label">Описание гайда</label>
        <textarea name="description" class="form-control" id="description"><?= $model['description'] ?></textarea>
    </div>
    <fieldset id="skill_up" style="margin-bottom: 30px">
        <legend>Порядок улучшение умений</legend>
        <button type="button" class="btn btn-danger" onclick="clear_skill()">Сбросить</button>
        <button type="button" class="btn btn-primary" id="but_start" onclick="start_skill()">Начать</button>
        <div id="story"></div>
    </fieldset>
    <fieldset>
        <legend>Коментарии к способностям</legend>
        <div style="display: flex; flex-direction: column">
            <?php for ($i = 0; $i < count($readySkills); $i++) : ?>
                <div style="display: flex; align-items: center">
                    <img width="120" style="margin: 15px 20px 25px 0"
                         src="/files/heroes/<?= $readySkills[$i]['photo_skill'] ?>_skill.jpg">
                    <textarea style="height: 100px" name="skill_comment_<?= $i ?>"
                              class="form-control"><?= $model['skill_comment_'.$i] ?></textarea>
                </div>
            <?php endfor; ?>
        </div>
    </fieldset>
    <fieldset>
        <legend>Рекомендуемые предметы</legend>

        <div id="basket"></div>
        <div id="shop"></div>
        <button type="button" class="btn btn-danger" onclick="clear_items()">Сбросить</button>
    </fieldset>
    <button type="submit" class="btn btn-primary">Сохранить</button>
    <div class="mb-3" style="display: none">
        <label for="post" class="form-label"></label>
        <textarea name="post" class="form-control" id="post"><?= $model['text'] ?></textarea>
    </div>
    <div class="mb-3" style="display: none">
        <label for="items" class="form-label"></label>
        <textarea name="items" class="form-control" id="items"><?= $model['text'] ?></textarea>
    </div>
</form>
<div
        id="hidden"
    <?php for ($i = 1; $i < count($readySkills) + 1; $i++) : ?>
        <?php foreach ($skillsKeys as $skillsKey) : ?>
            data-<?= $skillsKey . $i ?>='<?= $readySkills[$i - 1][$skillsKey] ?>'
        <?php endforeach; ?>
    <?php endfor; ?>
    <?php foreach ($talentsKeys as $talentsKey) : ?>
        data-<?= $talentsKey ?>='<?= $talents[$talentsKey] ?>'
    <?php endforeach; ?>
></div>
<div id="items-data"
    <?php for ($i = 1; $i < count($readyItems) + 1; $i++) : ?>
        <?php foreach ($itemsKeys as $itemsKey) : ?>
            data-<?= $itemsKey . $i ?>='<?= $readyItems[$i - 1][$itemsKey] ?>'
            data-num='<?= count($readyItems) ?>'
        <?php endforeach; ?>
    <?php endfor; ?>
></div>
<script>
    let skillFields = ['id', 'photo_skill'];
    let talentsFields = ['lvl_10_1', 'lvl_10_2', 'lvl_15_1', 'lvl_15_2',
        'lvl_20_1', 'lvl_20_2', 'lvl_25_1', 'lvl_25_2'];
    let itemsFields = ['id', 'photo', 'name', 'price'];
    let shop_sections = ['Начальный закуп', 'Начало игры',
        'Середина игры', 'Конец игры', 'Другое']
    let limit = 12
    let skills = []
    let talents = []
    let lvl = 0
    let up = ''
    let buy = [';', ';', ';', ';', ';']
    let but_start = document.getElementById('but_start')
    let story = document.getElementById('story')
    let data_tmp = document.getElementById('hidden')
    let skill_post = document.getElementById('post')
    let items_post = document.getElementById('items')
    let data_items = document.getElementById('items-data')
    let num_items = data_items.getAttribute('data-num')
    let items = []
    let basket = document.getElementById('basket')
    let shop = document.getElementById('shop')
    let currentItem = null
    for (let i = 0; i < parseInt(num_items); i++) {
        let tmp
        for (let j = 0; j < itemsFields.length; j++) {
            let search = 'data-' + itemsFields[j] + (i + 1)
            tmp = data_items.getAttribute(search)
            items.push(tmp)
        }
    }

    for (let i = 0; i < items.length; i += 4) {
        let tmp = document.createElement('img')
        tmp.style.margin = '20px 5px 5px 0'
        tmp.style.width = '60px'
        tmp.id = 'item'+items[i]
        tmp.style.height = '60px'
        tmp.src = '/files/items/' + items[i + 1] + '_s.jpg'
        tmp.addEventListener('click', function () {
            if (currentItem !== null)
                document.getElementById('item'+currentItem).style.border = '0px'
            currentItem = items[i]
            tmp.style.border = '2px solid blue'
        })
        shop.appendChild(tmp)
    }
    for (let i = 0; i < shop_sections.length; i++) {
        let field = document.createElement('fieldset')
        field.id = 'buy-' + i
        field.style.display = 'flex'
        field.style.justifyContent = 'space-between'
        let legend = document.createElement('legend')
        legend.innerText = shop_sections[i]
        let div = document.createElement('div')
        div.id = 'limit_check' + i
        let div2 = document.createElement('div')
        div.appendChild(legend)
        let comment = document.createElement('textarea')
        comment.style.width = '300px'
        comment.name = 'comment_' + i
        div2.appendChild(comment)
        let sp = document.createElement('p')
        sp.style.color = 'darkgray'
        sp.style.fontSize = '12px'
        sp.innerText = 'Комментарий к покупке'
        div2.appendChild(sp)
        legend.addEventListener('click', function () {
            if (currentItem !== null) {
                let tmp = document.createElement('img')
                tmp.style.margin = '5px 5px 5px 5px'
                tmp.style.width = '30px'
                tmp.style.height = '30px'
                let index = items.indexOf(currentItem)
                buy[i] += items[index] + ';'
                tmp.src = '/files/items/' + items[index + 1] + '_s.jpg'
                items_post.value = ''
                for (let k = 0; k < buy.length; k++) {
                    items_post.value += buy[k] + '\n'
                }
                //items_post.innerText += res
                console.log(buy)
                div.appendChild(tmp)
                check_item_limit(field)
            }
        })
        field.appendChild(div)
        field.appendChild(div2)
        basket.appendChild(field)
    }

    function check_item_limit(field) {
        for (let i = 0; i < shop_sections.length; i++) {
            let div = document.getElementById('limit_check' + i)
            let divChildren = div.childNodes
            if (divChildren.length > limit)
                div.removeChild(divChildren[1])
        }
    }

    /*for (let i = 0; i < items.length; i++)
        console.log(items[i])*/
    for (let j = 1; j < 5; j++) {
        let tmp
        for (let i = 0; i < skillFields.length; i++) {
            let search = 'data-' + skillFields[i] + j
            tmp = data_tmp.getAttribute(search)
            skills.push(tmp)
        }
    }

    for (let i = 0; i < talentsFields.length; i++) {
        let search = 'data-' + talentsFields[i]
        let tmp = data_tmp.getAttribute(search)
        talents.push(talentsFields[i])
        talents.push(tmp)
    }


    function start_skill() {
        but_start = document.getElementById('but_start')
        story = document.getElementById('story')
        but_start.disabled = true
        let field = document.getElementById('skill_up')
        let cont = document.createElement('div')
        let cont2 = document.createElement('div')
        cont.innerText = lvl + ' lvl: '
        let test = check_skill(skills)
        for (let i = 0; i < test.length; i += 2) {
            let tmp = document.createElement('img')
            if (test[i] === 'atr')
                tmp.src = '/files/heroes/' + test[i + 1] + '.jpg'
            else if (!test[i].includes('lvl'))
                tmp.src = '/files/heroes/' + test[i + 1] + '_skill.jpg'
            else
                continue
            tmp.style.width = '60px'
            tmp.style.height = '60px'
            tmp.style.marginLeft = '10px'
            tmp.addEventListener('click', function () {
                if (lvl < 30) {
                    field.removeChild(cont)
                    field.removeChild(cont2)
                    lvl++
                    up += test[i] + ';'
                    skill_post.innerText = up
                    refresh_story(up)
                    but_start.disabled = false
                    but_start.click()
                }
            })
            cont.appendChild(tmp)
        }
        if (check_talent(test)) {
            for (let i = 10; i <= 25; i += 5) {
                for (let j = 1; j <= 2; j++) {
                    if (test.includes('lvl_' + i + '_' + j)) {
                        let sp = document.createElement('span')
                        let index = test.indexOf('lvl_' + i + '_' + j)
                        sp.innerText = test[index + 1]
                        sp.addEventListener('click', function () {
                            if (lvl < 30) {
                                field.removeChild(cont)
                                field.removeChild(cont2)
                                lvl++
                                up += test[index] + ';'
                                skill_post.value = up
                                refresh_story(up)
                                but_start.disabled = false
                                but_start.click()
                            }
                        })
                        let br = document.createElement('br')
                        cont2.appendChild(sp)
                        cont2.appendChild(br)
                    }
                }
            }

        }
        field.appendChild(cont)
        field.appendChild(cont2)
    }

    function refresh_story(up) {
        let arr = up.split(';')
        arr.pop()
        let storyChildren = story.childNodes
        while (storyChildren.length > 0) {
            story.removeChild(storyChildren[storyChildren.length - 1])
            storyChildren = story.childNodes
        }


        for (let i = 0; i < arr.length; i++) {
            let tmp = document.createElement('img')
            let index = skills.indexOf(arr[i])
            if (arr[i].includes('lvl'))
                tmp.src = '/files/heroes/talent.jpg'
            else if (index === -1)
                tmp.src = '/files/heroes/plus.jpg'
            else
                tmp.src = '/files/heroes/' + skills[index + 1] + '_skill.jpg'
            tmp.style.width = '20px'
            tmp.style.height = '20px'
            tmp.style.marginLeft = '2px'
            story.appendChild(tmp)
        }
    }

    function check_skill(arr) {
        let checked = Array.from(skills)
        checked.unshift('atr', 'plus')
        if (lvl >= 10)
            for (let i = 0; i < talents.length; i += 2) {
                if (talents[i].includes('10')) {
                    checked.unshift(talents[i + 1])
                    checked.unshift(talents[i])
                }
            }
        if (lvl >= 15)
            for (let i = 0; i < talents.length; i += 2) {
                if (talents[i].includes('15')) {
                    checked.unshift(talents[i + 1])
                    checked.unshift(talents[i])
                }
            }
        if (lvl >= 20)
            for (let i = 0; i < talents.length; i += 2) {
                if (talents[i].includes('20')) {
                    checked.unshift(talents[i + 1])
                    checked.unshift(talents[i])
                }
            }
        if (lvl >= 25)
            for (let i = 0; i < talents.length; i += 2) {
                if (talents[i].includes('25')) {
                    checked.unshift(talents[i + 1])
                    checked.unshift(talents[i])
                }
            }
        let upArr = up.split(';')
        upArr.pop()
        if (count(upArr, checked[checked.length - 2]) >= 3) {
            checked.pop()
            checked.pop()
        } else {
            if (lvl < 17 && count(upArr, checked[checked.length - 2]) === 2) {
                checked.pop()
                checked.pop()
            } else {
                if (lvl < 11 && count(upArr, checked[checked.length - 2]) === 1) {
                    checked.pop()
                    checked.pop()
                } else if (lvl < 5) {
                    checked.pop()
                    checked.pop()
                }
            }
        }
        for (let i = 0; i < skills.length; i += 2) {
            if (count(upArr, skills[i]) >= 4) {
                let h = checked.indexOf(skills[i])
                checked.splice(h, 2)
            }
        }
        for (let i = 10; i <= 25; i += 5) {
            for (let j = 1; j <= 2; j++) {
                if (count(upArr, 'lvl_' + i + '_' + j) === 1) {
                    let h = checked.indexOf('lvl_' + i + '_' + j)
                    checked.splice(h, 2)
                    if (lvl < 25 + (i - 5) / 5) {
                        if (j === 1) {
                            let h = checked.indexOf('lvl_' + i + '_' + 2)
                            checked.splice(h, 2)
                        } else {
                            let h = checked.indexOf('lvl_' + i + '_' + 1)
                            checked.splice(h, 2)
                        }
                    }
                }

            }
        }
        if (count(upArr, 'atr') >= 7) {
            let i = checked.indexOf('atr')
            checked.splice(i, 2)
        }
        if (upArr.length === 1) {
            let i = checked.indexOf(upArr[0])
            checked.splice(i, 2)
        } else if (upArr[upArr.length - 1] !== 'atr' && upArr.length > 2 && upArr[upArr.length - 1] === upArr[upArr.length - 2]) {
            let i = checked.indexOf(upArr[upArr.length - 2])
            checked.splice(i, 2)
        } else {
            return checked
        }


        return checked
    }

    function count(arr, str) {
        let res = 0
        for (let i = 0; i < arr.length; i++)
            if (arr[i] === str)
                res += 1
        return res
    }

    function check_talent(arr) {
        for (let i = 0; i < arr.length; i++) {
            if (arr[i].includes('lvl'))
                return true
        }
        return false
    }

    function clear_items() {
        items_post.value = ''
        let buy = [';', ';', ';', ';', ';']
        for (let i = 0; i < shop_sections.length; i++) {
            let div = document.getElementById('limit_check' + i)
            let divChildren = div.childNodes
            while (divChildren.length > 1) {
                div.removeChild(divChildren[divChildren.length - 1])
                divChildren = div.childNodes
            }
        }
    }

    function clear_skill() {
        let field = document.getElementById('skill_up')
        let fieldChildren = field.childNodes

        while (fieldChildren.length > 0) {
            field.removeChild(fieldChildren[fieldChildren.length - 1])
            fieldChildren = field.childNodes
        }
        let tmp = document.createElement('legend')
        tmp.innerText = 'Порядок улучшение умений'
        field.appendChild(tmp)
        tmp = document.createElement('button')
        tmp.type = 'button'
        tmp.addEventListener('click', clear_skill)
        tmp.classList.add('btn')
        tmp.classList.add('btn-danger')
        field.appendChild(tmp)
        tmp.innerText = 'Сбросить'
        tmp = document.createElement('button')
        tmp.type = 'button'
        tmp.addEventListener('click', start_skill)
        tmp.classList.add('btn')
        tmp.classList.add('btn-primary')
        tmp.innerText = 'Начать'
        tmp.id = 'but_start'
        field.appendChild(tmp)
        tmp = document.createElement('div')
        tmp.id = 'story'
        field.appendChild(tmp)

        lvl = 0
        up = ''
        skill_post.innerText = ''
        but_start.disabled = false
        refresh_story(up)
    }
</script>