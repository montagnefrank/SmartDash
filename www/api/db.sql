/*
 Navicat Premium Data Transfer

 Source Server         : spapi
 Source Server Type    : MariaDB
 Source Server Version : 100023
 Source Host           : spapi.des:3306
 Source Schema         : rms

 Target Server Type    : MariaDB
 Target Server Version : 100023
 File Encoding         : 65001

 Date: 18/11/2019 17:19:39
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tb_usuario
-- ----------------------------
DROP TABLE IF EXISTS `tb_usuario`;
CREATE TABLE `tb_usuario`  (
  `idUsuario` int(255) NOT NULL AUTO_INCREMENT,
  `userUsuario` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `passUsuario` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nombreUsuario` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `loginUsuario` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `rolUsuario` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `temaUsuario` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `panelUsuario` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idUsuario`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_usuario
-- ----------------------------
INSERT INTO `tb_usuario` VALUES (5, 'frank', '047b572c713a7891234925b9ef8bf7bec4e637a9a2b748554d0e47c1e113b6f8c3a747227e751ec24ea13e4b3d25f75c3bece91f8e6e8ca027b6449fa835ca45', 'Frank Montagne', '2019-11-18 20:45:44', 'Administrador', '1', 'home');

SET FOREIGN_KEY_CHECKS = 1;
