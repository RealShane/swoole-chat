-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2021-06-21 09:58:07
-- 服务器版本： 8.0.24
-- PHP 版本： 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `apptest_huihuago`
--

-- --------------------------------------------------------

--
-- 表的结构 `api_chat`
--

CREATE TABLE `api_chat` (
  `id` int UNSIGNED NOT NULL COMMENT '自增id',
  `uid` int UNSIGNED NOT NULL COMMENT '用户uid',
  `fid` int UNSIGNED NOT NULL COMMENT '好友uid',
  `message` text NOT NULL COMMENT '聊天',
  `create_time` int UNSIGNED NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 表的结构 `api_friend`
--

CREATE TABLE `api_friend` (
  `id` int UNSIGNED NOT NULL COMMENT '自增id',
  `uid` int UNSIGNED NOT NULL COMMENT '用户uid',
  `fid` int UNSIGNED NOT NULL COMMENT '好友uid',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 表的结构 `api_user`
--

CREATE TABLE `api_user` (
  `id` int UNSIGNED NOT NULL COMMENT '自增id',
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `password_salt` varchar(5) NOT NULL COMMENT '密码盐',
  `last_login_token` text COMMENT '上次登录Token',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='用户';

--
-- 转储表的索引
--

--
-- 表的索引 `api_chat`
--
ALTER TABLE `api_chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `fid` (`fid`),
  ADD KEY `create_time` (`create_time`);

--
-- 表的索引 `api_friend`
--
ALTER TABLE `api_friend`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `fid` (`fid`);

--
-- 表的索引 `api_user`
--
ALTER TABLE `api_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`username`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `api_chat`
--
ALTER TABLE `api_chat`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id';

--
-- 使用表AUTO_INCREMENT `api_friend`
--
ALTER TABLE `api_friend`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id';

--
-- 使用表AUTO_INCREMENT `api_user`
--
ALTER TABLE `api_user`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
