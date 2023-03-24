/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : boen_online_egitim

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2023-03-25 01:17:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `analysis_result`
-- ----------------------------
DROP TABLE IF EXISTS `analysis_result`;
CREATE TABLE `analysis_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `queryCounts` int(11) DEFAULT NULL,
  `time` decimal(10,0) DEFAULT NULL,
  `memory` decimal(10,0) DEFAULT NULL,
  `db` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of analysis_result
-- ----------------------------
