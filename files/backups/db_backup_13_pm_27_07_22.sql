-- MySQL dump 10.13  Distrib 5.6.51, for Win64 (x86_64)
--
-- Host: localhost    Database: cms
-- ------------------------------------------------------
-- Server version	5.6.51

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guide_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `text` text COLLATE utf8mb4_unicode_ci,
  `datetime` datetime DEFAULT NULL,
  `liked` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,1,8,'Мусор, 1к помойка','2022-01-20 03:51:39','false'),(3,2,8,'Мезрость','2022-01-20 03:57:20','false'),(4,2,8,'Как можно сделать так плохо\r\n','2022-01-20 03:57:55','false'),(5,5,9,'Найс','2022-07-27 05:03:50','true'),(6,5,9,'Добре є нема страху','2022-07-27 05:04:26','true'),(7,5,9,'Не актуально','2022-07-27 05:04:49','false');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guides`
--

DROP TABLE IF EXISTS `guides`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `guides` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `hero_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `skill_comment_0` text COLLATE utf8mb4_unicode_ci,
  `skill_comment_1` text COLLATE utf8mb4_unicode_ci,
  `skill_comment_2` text COLLATE utf8mb4_unicode_ci,
  `skill_comment_3` text COLLATE utf8mb4_unicode_ci,
  `comment_0` text COLLATE utf8mb4_unicode_ci,
  `comment_1` text COLLATE utf8mb4_unicode_ci,
  `comment_2` text COLLATE utf8mb4_unicode_ci,
  `comment_3` text COLLATE utf8mb4_unicode_ci,
  `comment_4` text COLLATE utf8mb4_unicode_ci,
  `post` text COLLATE utf8mb4_unicode_ci,
  `items` text COLLATE utf8mb4_unicode_ci,
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guides`
--

LOCK TABLES `guides` WRITE;
/*!40000 ALTER TABLE `guides` DISABLE KEYS */;
INSERT INTO `guides` VALUES (2,8,73,'Лучший сап','Может жить в замесе','Хороший хил/урон, можно ластхитить','Сверхполезный скилл, снимает почти все дебаффы','Для саппорта не особо полезно','Ну + жизнь','Билибирда','Раз два и обчелся','Не знамо но надобно','Зе енд','Мб пригодиться','181;180;181;180;181;182;181;180;179;atr;lvl_10_2;182;180;179;179;atr;lvl_15_2;182;179;atr;lvl_20_1;atr;atr;atr;atr;lvl_25_1;lvl_10_1;lvl_15_1;lvl_20_2;lvl_25_2;',';94;94;93;\r\n;94;94;92;92;\r\n;93;93;92;\r\n;94;94;94;93;\r\n;93;92;\r\n','2022-01-20 03:30:58'),(5,8,74,'Кровожадний вбивця','Воно не зна жалю на свому шляху','воно такэ дикэ шо шкодить соби самому','то трекляти пэнтограми шо аж язик зводить','воно чуэ твий страх','пускае кров навить не чипаючи','Лада','Шкода','Бэха','Приора','Тесла','185;184;185;184;185;186;185;184;183;atr;lvl_10_2;186;184;183;atr;lvl_15_2;183;atr;186;183;atr;lvl_20_2;atr;atr;atr;lvl_25_2;lvl_10_1;lvl_15_1;lvl_20_1;lvl_25_1;',';94;94;94;93;92;\r\n;93;92;92;\r\n;92;94;94;93;\r\n;94;94;\r\n;93;93;\r\n','2022-01-20 05:48:32');
/*!40000 ALTER TABLE `guides` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `heroes`
--

DROP TABLE IF EXISTS `heroes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `heroes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attack_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aganim_boost` text COLLATE utf8mb4_unicode_ci,
  `shard_boost` text COLLATE utf8mb4_unicode_ci,
  `story` text COLLATE utf8mb4_unicode_ci,
  `main_attribute` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `power` float DEFAULT NULL,
  `intelligence` float DEFAULT NULL,
  `agility` float DEFAULT NULL,
  `power_up` float DEFAULT NULL,
  `agility_up` float DEFAULT NULL,
  `intelligence_up` float DEFAULT NULL,
  `damage` int(11) DEFAULT NULL,
  `health` int(11) DEFAULT NULL,
  `mana` int(11) DEFAULT NULL,
  `armor` int(11) DEFAULT NULL,
  `hp_regen` float DEFAULT NULL,
  `mp_regen` float DEFAULT NULL,
  `attack_range` int(11) DEFAULT NULL,
  `attack_speed` int(11) DEFAULT NULL,
  `move_speed` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `heroes`
--

LOCK TABLES `heroes` WRITE;
/*!40000 ALTER TABLE `heroes` DISABLE KEYS */;
INSERT INTO `heroes` VALUES (73,'Abaddon','73_61e6bff9c175d','51_61e6bffa57e7e','Ближний','Увеличивает длительность. Во время действия автоматически применяет способность Mist Coil на союзников в радиусе 1600, когда они получают более 525 урона. ','Способность Mist Coil и Aphotic Shield накладывает эффект Curse of Avernus на врагов. Уменьшает время перезарядки способностей на 1 секунду.','Род Аверно питает купель — разлом в земной тверди, который испускает загадочную энергию на протяжении поколений. Каждого новорожденного семьи окунают в этот темный туман, даруя тем самым связь с их землей и ее загадочной силой. Дети растут с непреклонной верой в защиту семейных ценностей и традиций земли, но на самом деле они охраняют саму купель, истинные намерения которой неизвестны. Когда новорожденный Abaddon проходил обряд крещения, что-то пошло не так. В глазах малыша сверкнула искра разума, испугавшая всех присутствовавших и заставившая жрецов шептаться. Его растили, дабы он пошел по пути всех отпрысков рода: война и защита родины во главе армии. Но сам Abaddon уделял этому не так много внимания. Пока другие тренировались в обращении с оружием, он медитировал у купели. Он глубоко вдыхал темный туман, учась быть единым с той силой, что протекала глубоко под землей его дома. В конечном счете он стал порождением черного тумана. Род Аверно неодобрительно отнесся к такому решению, обвиняя его в пренебрежении обязанностями. Но все эти обвинения прекратились, когда Abaddon вступил в свою первую битву и показал ту обретенную власть над жизнью и смертью, о которой другие члены рода не могли и мечтать.','Сила',22,18,23,2.8,1.5,2,55,640,291,3,1,0,150,144,325),(74,'Bloodseeker','74_61e8c9825d82c','52_61e8c9829ed19','Дальний','Перезарядка Rupture заменяется 2 зарядами, восполняющимися каждые 40 секунд.\r\n','Каждая атака под действием Bloodrage лечит героя на 2% от максимального здоровья жертвы и наносит ей столько же чистого урона. Действует только на владельца способности.','Стригвир — ритуально посвященный охотник, гончая Бескожих близнецов, посланный с туманных вершин Ксакатокатля на поиски крови. Бескожим требуются огромнейшие количества крови, чтобы насытиться и удовлетвориться. Если бы не сделка со жрецами народов, живущими на верхних плато, то вскоре все население горных гряд было бы уничтожено. Договор гласил, что в мир будет выходить охотник за кровью — Стригвир. Любая пролитая жизненная энергия крови сразу же передается близнецам через священные знаки на его оружии и экипировке. За долгие годы такой жизни он стал подобен бешеному псу. В бою он свиреп как ненасытный шакал. Говорят, что во время кровопролитного боя за его маской можно разглядеть черты лиц самих Бескожих, лично контролирующих свою гончую.','Сила',24,17,22,2.7,3.1,2,60,680,279,6,0.3,0,150,158,300);
/*!40000 ALTER TABLE `heroes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) DEFAULT NULL,
  `type` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `neutral_type` int(11) DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` text COLLATE utf8mb4_unicode_ci,
  `passive` text COLLATE utf8mb4_unicode_ci,
  `attributes` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (92,'Town Portal Scroll',100,'shop','consumables',NULL,'92_61e73c5924b35','То, что нужно истинному герою.','После 3 сек. произнесения заклинания, телепортирует героя к выбранной союзной постройке. При двойном нажатии телепортирует к фонтану своей команды.','','Дальность применения: глобальная\r\n\r\nМинимальное расстояние прицеливания на строение: 70\r\nМаксимальное расстояние прицеливания на строение: 800\r\nМаксимальное расстояние прицеливания на аванпост: 250\r\nВремя первого произнесения: 3\r\nВремя второго произнесения: 5\r\nУвеличение времени последующих произнесений: 0,5\r\nРадиус проверки недавней телепортации: 1150\r\nДлительность проверки недавней телепортации: 25'),(93,'Iron Branch',50,'shop','equipment',NULL,'93_61e73ce032d7d','Обычная, казалось бы, веточка дарует владельцу полезные качества благодаря свойствам железного дерева, от которого она отрублена.','Сажает в указанное место маленькое счастливое деревце, которое исчезнет через 20 секунд','','Время жизни деревца: 20\r\nДальность применения: 40\r\n\r\n+1 ко всем атрибутам'),(94,'Orchid Malevolence',3475,'shop','magic',NULL,'94_61e73d22f4165','Гранатовый посох, выкованный из сущности огненного демона.','Запрещает выбранной цели использовать способности на 5 сек. По окончании эффекта жертве наносится магический урон в размере 30% от урона, полученного за время действия.','','Дальность применения: 900\r\nУвеличение урона: 30%\r\nДлительность: 5\r\n+20 к интеллекту\r\n+4 к регенерации маны\r\n+30 к урону\r\n+25 к скорости атаки');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `datetime` datetime NOT NULL,
  `datetime_lastedit` datetime DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Новини';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (26,'В Dota 2 вышла сокровищница Collector\'s Cache','В ночь на 19 января разработчики Dota 2 добавили в игру сокровищницу Collector\'s Cache. В нее вошли наборы для восемнадцати героев.','Голоса подсчитаны, величайший маг официально одобрил избранные наборы, а значит сокровищница Collector\'s Cache теперь доступна владельцам боевого пропуска «Лабиринт Аганима 2021». Она содержит 18 лучших наборов, за которые проголосовало само сообщество Dota 2.\r\n\r\nС каждой открытой сокровищницей ваши шансы получить дополнительную редкую награду всё выше. Откройте 15 — и получите сразу 36 уровней пропуска. Любой нераспакованный набор из этих сокровищниц можно обменять на 2000 боевых очков.\r\n\r\nСокровищница «Лабиринт Аганима 2021: Collector\'s Cache» доступна во внутриигровом магазине за 180 рублей ($2,49) до окончания действия боевого пропуска. Все предметы из этой сокровищницы, кроме невероятно редкого набора для Phantom Assassin, нельзя обменять или выставить на продажу.\r\n','2022-01-20 05:15:14','2022-01-20 05:15:15','26_61e8c5b2b0fe0',8,'news'),(27,'Epic Esports Events анонсировал седьмой сезон Dota 2 Champions League','Оператор Epic Esports Events анонсировал следующий сезон серии турниров Dota 2 Champions League.','Организаторы представили приглашенных участников группового этапа и стадии плей-офф Dota 2 Champions League 2022 Season 7.\r\nРаспределение призового фонда:\r\n1-е место — $20 000\r\n2-е место — $10 000\r\n3-е место — $7 000\r\n4-е место — $3 500\r\n5–6 места — $2 500\r\n7–8 места — $1 000\r\n9–12 места — $500\r\nВ общей сложности команды разыграют $50 000. Все матчи группового этапа и плей-офф пройдут в формате bo3, гранд-финал — в bo5. Турнир пройдет с 24 января по 17 февраля в онлайне.\r\n\r\nДля русскоязычной аудитории трансляцию будет проводить RuHub, для англоязычной — Beyond the Summit.','2022-01-20 05:17:21','2022-01-20 05:18:30','27_61e8c632014a8',8,'news'),(28,'В «Лабиринте Аганима» ослабили броню многих боссов','В ночь на 19 января Valve выпустила балансный патч для режима «Лабиринт Аганима» в Dota 2. С обновлением многим боссам снизили базовую броню.','Общие изменения\r\nВ первом акте на уровнях сложности Magician и выше теперь будут появляться новые противники.\r\nБонус к скорости передвижения от Surge за уровень сложности понижен с 50% до 40%. Теперь также позволяет замедлять противников.\r\nПонижена базовая броня многих боссов и капитанов.\r\nУменьшены здоровье и чувствительность к урону у противников в комнате Toothy Toothums.\r\nУменьшено восстановление здоровья вражеского Alchemist от Chemical Rage.\r\nУменьшен урон от Brain Sap иFiend\'s Grip в комнате Demonic Woods.\r\nGlarf\'s Bloodlust усилена с 2 противников, 50 к скорости атаки, 12% к скорости передвижения на 3 противника, 60 к скорости атаки и 15% к скорости передвижения.\r\nИсправлена ошибка, из-за которой Carrie не усиливалась с уровнем сложности в комнате Bug Bait.\r\nИсправлены Bogdugg\'s Cudgel и Femur.\r\nИсправлена ошибка, позволявшая не провоцировать атаками патрулирующих существ.\r\nБоссы теперь не начинают сражаться, пока не увидят игрока.\r\nИсправлена возможность обходить ограничение скорости передвижения в комнатах-ловушках при выкладывании предметов, её увеличивающих.\r\nБазовая скорость передвижения в комнатах-ловушках увеличена с 350 до 360.\r\nСледующие предметы больше нельзя приобрести в основном магазине:\r\nCreature Blade Mail;\r\nOutworld Meteorologist Meteor Hammer;\r\nContinuum Key.\r\nИсправлена ошибка, не позволявшая в комнате с Pudge пройти ему через узкий канал.','2022-01-20 05:21:23','2022-01-20 05:22:31','28_61e8c76786239',8,'update'),(29,'Два игрока Alliance заразились коронавирусом, в матче против Team Liquid команда сыграет с заменой','Два игрока команды Alliance заразились коронавирусной инфекцией. Ондржей \'Supream\' Штарга и Родриго \'Lelis\' Сантос получили положительные тесты на коронавирус. Информация об этом появилась в официальном twitter-аккаунте клуба.','В настоящий момент зараженный киберспортсмены находятся на самоизоляции. Остальные участники команды уже сдали тесты и получили отрицательный результат. Чехия Supream и Бразилия Lelis нормально себя чувствуют и смогут сыграть в матче против Швеция Team Liquid, который стартует 18 января в 17:00 по московскому времени. \r\n\r\nТакже представители Швеция Alliance сообщили, что команда снова сыграет с заменой в противостоянии с Швеция Team Liquid. Вместо Швеция Симона \'Handsken\' Хаага в качестве игрока пятой позиции выступит Болгария Николай \'CTOMAHEH1\' Калчев. В прошлой серии шведского киберспортсмена заменял Беларусь Артём \'fng\' Баршак.\r\n\r\nШвеция Alliance сыграла шесть матчей в рамках DreamLeague Season 16 DPC WEU: Дивизион I и одержала всего одну победу. Таким образом, в следующем цикле соревновательного сезона коллектив будет выступать во втором дивизионе Dota Pro Circuit 2021/2022 для Западной Европы. ','2022-01-20 05:24:15','2022-01-20 05:24:16','29_61e8c7cfdb304',8,'news');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hero_id` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `mana_cost` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cooldown` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skill_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `damage_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `through_immunity` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dispelled_possibility` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `characteristics` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_skill` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=187 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skills`
--

LOCK TABLES `skills` WRITE;
/*!40000 ALTER TABLE `skills` DISABLE KEYS */;
INSERT INTO `skills` VALUES (179,73,'Ценой собственного здоровья выпускает смертельный туман, который наносит урон врагу или лечит союзника.','50','5,5','Направленная на юнита','Магический','Нет',NULL,'Дальность применения: 575\r\nРадиус: 0 (Талант: 500)\r\nУрон по себе: 55/80/105/130 (Талант: 82,5/107,5/132,5/157,5)\r\nУрон: 110/160/210/260 (Талант: 165/215/265/315)\r\nЛечение: 110/160/210/260 (Талант: 165/215/265/315)','179_61e6bffa6539e','Mist Coil'),(180,73,'Окружает союзника щитом из тёмной энергии, который поглощает некоторое количество урона. Если щит пропадёт или его уничтожат, он взорвётся и нанесёт врагам вокруг урон, равный здоровью щита. Применение снимает с цели оглушение и большинство отрицательных эффектов.','100/110/120/130','12/10/8/6','Направленная на юнита','Магический','Нет','Да','Дальность применения: 550\r\nРадиус взрыва: 675\r\nПоглощение урона: 110/140/170/200 (Талант: 210/240/270/300)\r\nУрон по области: 110/140/170/200 (Талант: 210/240/270/300)\r\nДлительность: 15','180_61e6bffa7841e','Aphotic Shield'),(181,73,'Атаки героя замедляют передвижение жертвы. Если атаковать врага 4 раза, на него сработает замораживающее проклятие: оно накладывает безмолвие и замедление, а все атакующие этого врага существа получают дополнительную скорость атаки.','','','Пасивная',NULL,'Нет','Да','Ударов нужно: 4 (Талант: 3)\r\nБазовое замедление скорости передвижения: 10/15/20/25% (Aghanim\'s Shard: 20/25/30/35%)\r\nЗамедление скорости передвижения: 15/30/45/60%\r\nДоп. скорость атаки: 40/60/80/100\r\nБазовая длительность: 5\r\nДлительность проклятья: 4,5\r\nДлительность ускорения: 4','181_61e6bffa8b2eb','Curse of Avernus'),(182,73,'Обращает весь получаемый урон в лечение. Применение снимает большинство отрицательных эффектов. Если способность готова, то она сработает автоматически, как только здоровье владельца упадёт ниже 400.','','60/50/40 ','Ненаправленная',NULL,NULL,'Нет','Порог здоровья: 400\r\nДлительность: 4/5/6','182_61e6bffa98bd1','Borrowed Time'),(183,74,'Разрывает кожу врага, нанося жертве начальный урон, зависящий от её текущего здоровья. Если цель передвигается, то она получает урон, зависящий от преодолённого расстояния и проходящий сквозь невосприимчивость к магии.','100/150/200','70','Направленная на юнита','Чистый','Да','Нет','Длительность: 10/11/12,\r\nУрон при передвижении: 33/44/55%\r\nУрон от текущего здоровья при применении: 10% (Талант: 20%)\r\nДальность применения: 800 (Талант: 1275)','183_61e8cb4853e5d','Rupture'),(184,74,'Разрывает кожу врага, нанося жертве начальный урон, зависящий от её текущего здоровья. Если цель передвигается, то она получает урон, зависящий от преодолённого расстояния и проходящий сквозь невосприимчивость к магии.','100/150/200','70','Направленная на юнита','Чистый','Да','Нет','Длительность: 10/11/12,\r\nУрон при передвижении: 33/44/55%\r\nУрон от текущего здоровья при применении: 10% (Талант: 20%)\r\nДальность применения: 800 (Талант: 1275)','184_61e8cb4869330','Rupture'),(185,74,'Разрывает кожу врага, нанося жертве начальный урон, зависящий от её текущего здоровья. Если цель передвигается, то она получает урон, зависящий от преодолённого расстояния и проходящий сквозь невосприимчивость к магии.','100/150/200','70','Направленная на юнита','Чистый','Да','Нет','Длительность: 10/11/12,\r\nУрон при передвижении: 33/44/55%\r\nУрон от текущего здоровья при применении: 10% (Талант: 20%)\r\nДальность применения: 800 (Талант: 1275)','185_61e8cb4876c47','Rupture'),(186,74,'Разрывает кожу врага, нанося жертве начальный урон, зависящий от её текущего здоровья. Если цель передвигается, то она получает урон, зависящий от преодолённого расстояния и проходящий сквозь невосприимчивость к магии.','100/150/200','70','Направленная на юнита','Чистый','Да','Нет','Длительность: 10/11/12,\r\nУрон при передвижении: 33/44/55%\r\nУрон от текущего здоровья при применении: 10% (Талант: 20%)\r\nДальность применения: 800 (Талант: 1275)','186_61e8cb488456c','Rupture');
/*!40000 ALTER TABLE `skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `talents`
--

DROP TABLE IF EXISTS `talents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `talents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lvl_10_1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lvl_10_2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lvl_15_1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lvl_15_2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lvl_20_1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lvl_20_2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lvl_25_1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lvl_25_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hero_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `talents`
--

LOCK TABLES `talents` WRITE;
/*!40000 ALTER TABLE `talents` DISABLE KEYS */;
INSERT INTO `talents` VALUES (51,'+8 к силе','+15 к скорости передвижения','+55 к урону/лечению от Mist Coil','+65 к урону','-8 сек. перезарядки Borrowed Time','+100 к здоровью щита от Aphotic Shield','Mist Coil применяется по области радиусом 500','-1 атака для срабатывания Curse of Avernus',73),(52,'+8% к урону от заклинаний от Bloodrage','+30 к скорости атаки от Bloodrage','+85 к урону от Blood Rite','+10% от здоровья к начальному урону от Rupture','+400 к здоровью','+475 к дальности применения Rupture','+14% к макс. скорости передвижения от Thirst','-4 сек. перезарядки Blood Rite',74);
/*!40000 ALTER TABLE `talents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `login` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Логін',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Пароль',
  `access` int(11) NOT NULL DEFAULT '0' COMMENT 'Рівень доступу',
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Прізвище',
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Ім''я',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (5,'ipz204_nvv@student','05b8825669ae9dee519349e4a9edafca',0,'fasdfadf','aafdad'),(7,'ipz204_nvv@student.ztu.edu.ua','827ccb0eea8a706c4c34a16891f84e7b',0,'dasdaf','aafdad'),(8,'ipz204_nvv1@student.ztu.edu.ua','827ccb0eea8a706c4c34a16891f84e7b',2,'dasdaf','aafdad'),(9,'admin@admin','81dc9bdb52d04dc20036dbd8313ed055',2,'Nahornyi','Vadym');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-07-27 13:26:48
