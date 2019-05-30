/*
 Navicat Premium Data Transfer

 Source Server         : MYSQL
 Source Server Type    : MySQL
 Source Server Version : 80015
 Source Host           : localhost:3306
 Source Schema         : slim_doctrine_db

 Target Server Type    : MySQL
 Target Server Version : 80015
 File Encoding         : 65001

 Date: 04/04/2019 00:46:26
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for t_access
-- ----------------------------
DROP TABLE IF EXISTS `t_access`;
CREATE TABLE `t_access`  (
  `f_user` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `KEY_` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `validation` varchar(2048) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `expiration` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `CREATED_AT_` datetime(0) NOT NULL,
  `UPDATED_AT_` datetime(0) NOT NULL,
  PRIMARY KEY (`KEY_`) USING BTREE,
  INDEX `IDX_2F0E53AA79FB1CAB`(`f_user`) USING BTREE,
  INDEX `key_idx`(`KEY_`) USING BTREE,
  CONSTRAINT `FK_2F0E53AA79FB1CAB` FOREIGN KEY (`f_user`) REFERENCES `t_user` (`ID_`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_access
-- ----------------------------
INSERT INTO `t_access` VALUES (1, 'ded99998-5588-11e9-93e8-3c970ebf4a1e', '127.0.0.1 PostmanRuntime/7.6.1', 1554397331611, '2019-04-03 03:49:55', '2019-04-04 00:02:11');

-- ----------------------------
-- Table structure for t_test
-- ----------------------------
DROP TABLE IF EXISTS `t_test`;
CREATE TABLE `t_test`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_idx`(`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for t_user
-- ----------------------------
DROP TABLE IF EXISTS `t_user`;
CREATE TABLE `t_user`  (
  `username` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT 1,
  `role` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `photo` varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ID_` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `VERSION_` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `CREATED_AT_` datetime(0) NOT NULL,
  `UPDATED_AT_` datetime(0) NOT NULL,
  PRIMARY KEY (`ID_`) USING BTREE,
  UNIQUE INDEX `UNIQ_37E5BF3BF85E0677`(`username`) USING BTREE,
  INDEX `id_idx`(`ID_`) USING BTREE,
  INDEX `login_idx`(`username`, `password`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_user
-- ----------------------------
INSERT INTO `t_user` VALUES ('admin', '41e5653fc7aeb894026d6bb7b2db7f65902b454945fa8fd65a6327047b5277fb', 'Admin', NULL, NULL, NULL, 1, 0, NULL, 1, 1, '2019-03-27 15:12:12', '2019-03-27 15:12:16');
INSERT INTO `t_user` VALUES ('test', '41e5653fc7aeb894026d6bb7b2db7f65902b454945fa8fd65a6327047b5277fb', 'Test', '08123456789xx', NULL, 'alamat ganti lagi', 1, 1, NULL, 2, 1, '2019-03-27 23:47:31', '2019-03-27 23:47:36');

SET FOREIGN_KEY_CHECKS = 1;
