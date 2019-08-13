/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 50621
 Source Host           : localhost:3306
 Source Schema         : test

 Target Server Type    : MySQL
 Target Server Version : 50621
 File Encoding         : 65001

 Date: 13/08/2019 16:57:30
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for meets
-- ----------------------------
DROP TABLE IF EXISTS `meets`;
CREATE TABLE `meets`  (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Meeting` varchar(255) CHARACTER SET cp1251 COLLATE cp1251_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of meets
-- ----------------------------
INSERT INTO `meets` VALUES (1, 'Завтрак');
INSERT INTO `meets` VALUES (2, 'Обед');
INSERT INTO `meets` VALUES (3, 'Ужин');
INSERT INTO `meets` VALUES (4, 'Все вместе');

-- ----------------------------
-- Table structure for people
-- ----------------------------
DROP TABLE IF EXISTS `people`;
CREATE TABLE `people`  (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) CHARACTER SET cp1251 COLLATE cp1251_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of people
-- ----------------------------
INSERT INTO `people` VALUES (1, 'Иванов');
INSERT INTO `people` VALUES (2, 'Петров');
INSERT INTO `people` VALUES (3, 'Сидоров');
INSERT INTO `people` VALUES (4, 'Секретарша');

-- ----------------------------
-- Table structure for relations
-- ----------------------------
DROP TABLE IF EXISTS `relations`;
CREATE TABLE `relations`  (
  `EID` int(11) NULL DEFAULT NULL,
  `MID` int(11) NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of relations
-- ----------------------------
INSERT INTO `relations` VALUES (1, 1);
INSERT INTO `relations` VALUES (1, 4);
INSERT INTO `relations` VALUES (2, 2);
INSERT INTO `relations` VALUES (2, 4);
INSERT INTO `relations` VALUES (3, 3);
INSERT INTO `relations` VALUES (3, 4);
INSERT INTO `relations` VALUES (4, 1);
INSERT INTO `relations` VALUES (4, 2);
INSERT INTO `relations` VALUES (4, 3);
INSERT INTO `relations` VALUES (4, 4);

SET FOREIGN_KEY_CHECKS = 1;
