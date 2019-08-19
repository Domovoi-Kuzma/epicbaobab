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

 Date: 19/08/2019 17:56:49
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for department
-- ----------------------------
DROP TABLE IF EXISTS `department`;
CREATE TABLE `department`  (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Caption` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of department
-- ----------------------------
INSERT INTO `department` VALUES (1, 'IT');
INSERT INTO `department` VALUES (2, 'HQ');

-- ----------------------------
-- Table structure for meets
-- ----------------------------
DROP TABLE IF EXISTS `meets`;
CREATE TABLE `meets`  (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Meeting` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Place` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`ID`) USING BTREE,
  INDEX `Place`(`Place`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 57 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of meets
-- ----------------------------
INSERT INTO `meets` VALUES (1, 'Meeting1', 3);
INSERT INTO `meets` VALUES (2, 'Meeting2', 5);
INSERT INTO `meets` VALUES (3, 'Meeting3', 4);
INSERT INTO `meets` VALUES (4, 'Meeting4', 5);
INSERT INTO `meets` VALUES (56, 'Meeting SERGMAX', 5);

-- ----------------------------
-- Table structure for people
-- ----------------------------
DROP TABLE IF EXISTS `people`;
CREATE TABLE `people`  (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) CHARACTER SET cp1251 COLLATE cp1251_general_ci NULL DEFAULT NULL,
  `Dept_ID` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`ID`) USING BTREE,
  INDEX `Dept_ID`(`Dept_ID`) USING BTREE,
  CONSTRAINT `people_ibfk_1` FOREIGN KEY (`Dept_ID`) REFERENCES `department` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of people
-- ----------------------------
INSERT INTO `people` VALUES (1, 'AlexanderSasha', 1);
INSERT INTO `people` VALUES (2, 'Maxim', 1);
INSERT INTO `people` VALUES (3, 'Sergey', 2);
INSERT INTO `people` VALUES (37, 'Bill Gates', 1);

-- ----------------------------
-- Table structure for relations
-- ----------------------------
DROP TABLE IF EXISTS `relations`;
CREATE TABLE `relations`  (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `EID` int(11) NULL DEFAULT NULL,
  `MID` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`ID`) USING BTREE,
  INDEX `relations_ibfk_1`(`EID`) USING BTREE,
  INDEX `relations_ibfk_2`(`MID`) USING BTREE,
  CONSTRAINT `relations_ibfk_1` FOREIGN KEY (`EID`) REFERENCES `people` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `relations_ibfk_2` FOREIGN KEY (`MID`) REFERENCES `meets` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of relations
-- ----------------------------
INSERT INTO `relations` VALUES (1, 1, 1);
INSERT INTO `relations` VALUES (2, 2, 1);
INSERT INTO `relations` VALUES (3, 1, 2);
INSERT INTO `relations` VALUES (4, 3, 2);
INSERT INTO `relations` VALUES (5, 2, 3);
INSERT INTO `relations` VALUES (6, 3, 3);
INSERT INTO `relations` VALUES (7, 1, 4);
INSERT INTO `relations` VALUES (8, 2, 4);
INSERT INTO `relations` VALUES (9, 3, 4);

-- ----------------------------
-- Table structure for room
-- ----------------------------
DROP TABLE IF EXISTS `room`;
CREATE TABLE `room`  (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Number` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of room
-- ----------------------------
INSERT INTO `room` VALUES (3, '301');
INSERT INTO `room` VALUES (4, '302');
INSERT INTO `room` VALUES (5, '303');

SET FOREIGN_KEY_CHECKS = 1;
