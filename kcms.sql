CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `guestbook` (
  `id` int(11) NOT NULL,
  `detail` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `create_date` datetime NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `guestbook` (`id`, `detail`, `create_date`, `name`, `ip`) VALUES
(1, '&lt;script&gt;alert(\'555\');&lt;/script&gt;\r\n&lt;?php\r\necho \'555\';\r\n?&gt;', '2016-09-05 10:17:09', 'goragod', '127.0.0.1'),
(2, 'ทดสอบการเขียนสมุดเยี่ยม\r\nทดสอบการเขียนสมุดเยี่ยม', '2016-09-05 14:01:12', 'ทดสอบ', '127.0.0.1');

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `module` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `text` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `target` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order` tinyint(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `menu` (`id`, `module`, `text`, `url`, `target`, `order`) VALUES
(1, 'home', 'Home', '', '', 1),
(2, 'about', 'About', '', '', 2),
(3, 'guestbook', 'สมุดเยี่ยม', '', '', 3),
(4, 'chat', 'Chat', '', '', 4),
(5, 'download', 'Download', 'https://github.com/goragod/kotchasan-kcms', '_blank', 5);

CREATE TABLE `site` (
  `id` int(11) NOT NULL,
  `module` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `topic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `detail` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `site` (`id`, `module`, `topic`, `detail`) VALUES
(1, 'home', 'สวัสดี นี่คือ หน้า Home', '<p>ตัวอย่างนี้แสดงให้เห็นถึงวิธีการสร้างเว็บไซต์แบบ CMS อย่างง่ายๆ โดยใช้ คชสาร เว็บเฟรมเวอร์ค โดยไม่ต้องเขียนโค้ดมากมาย แค่ใช้คุณสมบัติที่มีอยู่ของ คชสาร เท่านั้น</p>\r\n\r\n<div class="message">ตัวอย่างนี้เป็นตัวอย่างที่สมบูรณ์ของเวอร์คช้อปในชุดนี้ สามารถดาวน์โหลดโค้ดได้จากเมนู Download</div>\r\n\r\n<div class="ggrid">\r\n<section class="block3 float-left">\r\n<h2>Section 1</h2>\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</section>\r\n\r\n<section class="block3 float-left">\r\n<h2>Section 2</h2>\r\nCurabitur pretium tincidunt lacus. Nulla gravida orci a odio. Nullam varius, turpis et commodo pharetra, est eros bibendum elit, nec luctus magna felis sollicitudin mauris. Integer in mauris eu nibh euismod gravida. Duis ac tellus et risus vulputate vehicula. Donec lobortis risus a elit. Etiam tempor. Ut ullamcorper, ligula eu tempor congue, eros est euismod turpis, id tincidunt sapien risus a quam. Maecenas fermentum consequat mi. Donec fermentum. Pellentesque malesuada nulla a mi. Duis sapien sem, aliquet nec, commodo eget, consequat quis, neque. Aliquam faucibus, elit ut dictum aliquet, felis nisl adipiscing sapien, sed malesuada diam lacus eget erat. Cras mollis scelerisque nunc. Nullam arcu. Aliquam consequat. Curabitur augue lorem, dapibus quis, laoreet et, pretium ac, nisi. Aenean magna nisl, mollis quis, molestie eu, feugiat in, orci. In hac habitasse platea dictumst.</section>\r\n\r\n<section class="block3 float-left">\r\n<h2>Section 3</h2>\r\nFusce convallis, mauris imperdiet gravida bibendum, nisl turpis suscipit mauris, sed placerat ipsum urna sed risus. In convallis tellus a mauris. Curabitur non elit ut libero tristique sodales. Mauris a lacus. Donec mattis semper leo. In hac habitasse platea dictumst. Vivamus facilisis diam at odio. Mauris dictum, nisi eget consequat elementum, lacus ligula molestie metus, non feugiat orci magna ac sem. Donec turpis. Donec vitae metus. Morbi tristique neque eu mauris. Quisque gravida ipsum non sapien. Proin turpis lacus, scelerisque vitae, elementum at, lobortis ac, quam. Aliquam dictum eleifend risus. In hac habitasse platea dictumst. Etiam sit amet diam. Suspendisse odio. Suspendisse nunc. In semper bibendum libero.</section>\r\n\r\n<section class="block3 float-left">\r\n<h2>Section 4</h2>\r\nProin nonummy, lacus eget pulvinar lacinia, pede felis dignissim leo, vitae tristique magna lacus sit amet eros. Nullam ornare. Praesent odio ligula, dapibus sed, tincidunt eget, dictum ac, nibh. Nam quis lacus. Nunc eleifend molestie velit. Morbi lobortis quam eu velit. Donec euismod vestibulum massa. Donec non lectus. Aliquam commodo lacus sit amet nulla. Cras dignissim elit et augue. Nullam non diam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In hac habitasse platea dictumst. Aenean vestibulum. Sed lobortis elit quis lectus. Nunc sed lacus at augue bibendum dapibus.</section>\r\n</div>\r\n'),
(2, 'about', 'เขียนข้อความ เกี่ยวกับ เว็บไซต์ ได้ที่หน้านี้', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n\r\n<p>Curabitur pretium tincidunt lacus. Nulla gravida orci a odio. Nullam varius, turpis et commodo pharetra, est eros bibendum elit, nec luctus magna felis sollicitudin mauris. Integer in mauris eu nibh euismod gravida. Duis ac tellus et risus vulputate vehicula. Donec lobortis risus a elit. Etiam tempor. Ut ullamcorper, ligula eu tempor congue, eros est euismod turpis, id tincidunt sapien risus a quam. Maecenas fermentum consequat mi. Donec fermentum. Pellentesque malesuada nulla a mi. Duis sapien sem, aliquet nec, commodo eget, consequat quis, neque. Aliquam faucibus, elit ut dictum aliquet, felis nisl adipiscing sapien, sed malesuada diam lacus eget erat. Cras mollis scelerisque nunc. Nullam arcu. Aliquam consequat. Curabitur augue lorem, dapibus quis, laoreet et, pretium ac, nisi. Aenean magna nisl, mollis quis, molestie eu, feugiat in, orci. In hac habitasse platea dictumst.</p>\r\n');

ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `guestbook`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `site`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `guestbook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `site`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
