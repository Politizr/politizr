SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `politizr_demo`.`fos_user`;
CREATE TABLE `politizr_demo`.`fos_user` LIKE `politizr_beta`.`fos_user`;
INSERT INTO `politizr_demo`.`fos_user` SELECT * FROM `politizr_beta`.`fos_user`;

DROP TABLE IF EXISTS `politizr_demo`.`p_l_city`;
CREATE TABLE `politizr_demo`.`p_l_city` LIKE `politizr_beta`.`p_l_city`;
INSERT INTO `politizr_demo`.`p_l_city` SELECT * FROM `politizr_beta`.`p_l_city`;

DROP TABLE IF EXISTS `politizr_demo`.`p_l_country`;
CREATE TABLE `politizr_demo`.`p_l_country` LIKE `politizr_beta`.`p_l_country`;
INSERT INTO `politizr_demo`.`p_l_country` SELECT * FROM `politizr_beta`.`p_l_country`;

DROP TABLE IF EXISTS `politizr_demo`.`p_l_department`;
CREATE TABLE `politizr_demo`.`p_l_department` LIKE `politizr_beta`.`p_l_department`;
INSERT INTO `politizr_demo`.`p_l_department` SELECT * FROM `politizr_beta`.`p_l_department`;

DROP TABLE IF EXISTS `politizr_demo`.`p_l_region`;
CREATE TABLE `politizr_demo`.`p_l_region` LIKE `politizr_beta`.`p_l_region`;
INSERT INTO `politizr_demo`.`p_l_region` SELECT * FROM `politizr_beta`.`p_l_region`;

DROP TABLE IF EXISTS `politizr_demo`.`p_m_cgu`;
CREATE TABLE `politizr_demo`.`p_m_cgu` LIKE `politizr_beta`.`p_m_cgu`;
INSERT INTO `politizr_demo`.`p_m_cgu` SELECT * FROM `politizr_beta`.`p_m_cgu`;

DROP TABLE IF EXISTS `politizr_demo`.`p_m_cgv`;
CREATE TABLE `politizr_demo`.`p_m_cgv` LIKE `politizr_beta`.`p_m_cgv`;
INSERT INTO `politizr_demo`.`p_m_cgv` SELECT * FROM `politizr_beta`.`p_m_cgv`;

DROP TABLE IF EXISTS `politizr_demo`.`p_m_charte`;
CREATE TABLE `politizr_demo`.`p_m_charte` LIKE `politizr_beta`.`p_m_charte`;
INSERT INTO `politizr_demo`.`p_m_charte` SELECT * FROM `politizr_beta`.`p_m_charte`;

DROP TABLE IF EXISTS `politizr_demo`.`p_m_moderation_type`;
CREATE TABLE `politizr_demo`.`p_m_moderation_type` LIKE `politizr_beta`.`p_m_moderation_type`;
INSERT INTO `politizr_demo`.`p_m_moderation_type` SELECT * FROM `politizr_beta`.`p_m_moderation_type`;

DROP TABLE IF EXISTS `politizr_demo`.`p_notification`;
CREATE TABLE `politizr_demo`.`p_notification` LIKE `politizr_beta`.`p_notification`;
INSERT INTO `politizr_demo`.`p_notification` SELECT * FROM `politizr_beta`.`p_notification`;

DROP TABLE IF EXISTS `politizr_demo`.`p_n_type`;
CREATE TABLE `politizr_demo`.`p_n_type` LIKE `politizr_beta`.`p_n_type`;
INSERT INTO `politizr_demo`.`p_n_type` SELECT * FROM `politizr_beta`.`p_n_type`;

DROP TABLE IF EXISTS `politizr_demo`.`p_order`;
CREATE TABLE `politizr_demo`.`p_order` LIKE `politizr_beta`.`p_order`;
INSERT INTO `politizr_demo`.`p_order` SELECT * FROM `politizr_beta`.`p_order`;

DROP TABLE IF EXISTS `politizr_demo`.`p_order_archive`;
CREATE TABLE `politizr_demo`.`p_order_archive` LIKE `politizr_beta`.`p_order_archive`;
INSERT INTO `politizr_demo`.`p_order_archive` SELECT * FROM `politizr_beta`.`p_order_archive`;

DROP TABLE IF EXISTS `politizr_demo`.`p_o_email`;
CREATE TABLE `politizr_demo`.`p_o_email` LIKE `politizr_beta`.`p_o_email`;
INSERT INTO `politizr_demo`.`p_o_email` SELECT * FROM `politizr_beta`.`p_o_email`;

DROP TABLE IF EXISTS `politizr_demo`.`p_o_order_state`;
CREATE TABLE `politizr_demo`.`p_o_order_state` LIKE `politizr_beta`.`p_o_order_state`;
INSERT INTO `politizr_demo`.`p_o_order_state` SELECT * FROM `politizr_beta`.`p_o_order_state`;

DROP TABLE IF EXISTS `politizr_demo`.`p_o_payment_state`;
CREATE TABLE `politizr_demo`.`p_o_payment_state` LIKE `politizr_beta`.`p_o_payment_state`;
INSERT INTO `politizr_demo`.`p_o_payment_state` SELECT * FROM `politizr_beta`.`p_o_payment_state`;

DROP TABLE IF EXISTS `politizr_demo`.`p_o_payment_type`;
CREATE TABLE `politizr_demo`.`p_o_payment_type` LIKE `politizr_beta`.`p_o_payment_type`;
INSERT INTO `politizr_demo`.`p_o_payment_type` SELECT * FROM `politizr_beta`.`p_o_payment_type`;

DROP TABLE IF EXISTS `politizr_demo`.`p_o_subscription`;
CREATE TABLE `politizr_demo`.`p_o_subscription` LIKE `politizr_beta`.`p_o_subscription`;
INSERT INTO `politizr_demo`.`p_o_subscription` SELECT * FROM `politizr_beta`.`p_o_subscription`;

DROP TABLE IF EXISTS `politizr_demo`.`p_qualification`;
CREATE TABLE `politizr_demo`.`p_qualification` LIKE `politizr_beta`.`p_qualification`;
INSERT INTO `politizr_demo`.`p_qualification` SELECT * FROM `politizr_beta`.`p_qualification`;

DROP TABLE IF EXISTS `politizr_demo`.`p_q_mandate`;
CREATE TABLE `politizr_demo`.`p_q_mandate` LIKE `politizr_beta`.`p_q_mandate`;
INSERT INTO `politizr_demo`.`p_q_mandate` SELECT * FROM `politizr_beta`.`p_q_mandate`;

DROP TABLE IF EXISTS `politizr_demo`.`p_q_organization`;
CREATE TABLE `politizr_demo`.`p_q_organization` LIKE `politizr_beta`.`p_q_organization`;
INSERT INTO `politizr_demo`.`p_q_organization` SELECT * FROM `politizr_beta`.`p_q_organization`;

DROP TABLE IF EXISTS `politizr_demo`.`p_q_type`;
CREATE TABLE `politizr_demo`.`p_q_type` LIKE `politizr_beta`.`p_q_type`;
INSERT INTO `politizr_demo`.`p_q_type` SELECT * FROM `politizr_beta`.`p_q_type`;

DROP TABLE IF EXISTS `politizr_demo`.`p_r_action`;
CREATE TABLE `politizr_demo`.`p_r_action` LIKE `politizr_beta`.`p_r_action`;
INSERT INTO `politizr_demo`.`p_r_action` SELECT * FROM `politizr_beta`.`p_r_action`;

DROP TABLE IF EXISTS `politizr_demo`.`p_r_badge`;
CREATE TABLE `politizr_demo`.`p_r_badge` LIKE `politizr_beta`.`p_r_badge`;
INSERT INTO `politizr_demo`.`p_r_badge` SELECT * FROM `politizr_beta`.`p_r_badge`;

DROP TABLE IF EXISTS `politizr_demo`.`p_r_badge_archive`;
CREATE TABLE `politizr_demo`.`p_r_badge_archive` LIKE `politizr_beta`.`p_r_badge_archive`;
INSERT INTO `politizr_demo`.`p_r_badge_archive` SELECT * FROM `politizr_beta`.`p_r_badge_archive`;

DROP TABLE IF EXISTS `politizr_demo`.`p_r_badge_family`;
CREATE TABLE `politizr_demo`.`p_r_badge_family` LIKE `politizr_beta`.`p_r_badge_family`;
INSERT INTO `politizr_demo`.`p_r_badge_family` SELECT * FROM `politizr_beta`.`p_r_badge_family`;

DROP TABLE IF EXISTS `politizr_demo`.`p_r_badge_family_archive`;
CREATE TABLE `politizr_demo`.`p_r_badge_family_archive` LIKE `politizr_beta`.`p_r_badge_family_archive`;
INSERT INTO `politizr_demo`.`p_r_badge_family_archive` SELECT * FROM `politizr_beta`.`p_r_badge_family_archive`;

DROP TABLE IF EXISTS `politizr_demo`.`p_r_badge_type`;
CREATE TABLE `politizr_demo`.`p_r_badge_type` LIKE `politizr_beta`.`p_r_badge_type`;
INSERT INTO `politizr_demo`.`p_r_badge_type` SELECT * FROM `politizr_beta`.`p_r_badge_type`;

DROP TABLE IF EXISTS `politizr_demo`.`p_r_badge_type_archive`;
CREATE TABLE `politizr_demo`.`p_r_badge_type_archive` LIKE `politizr_beta`.`p_r_badge_type_archive`;
INSERT INTO `politizr_demo`.`p_r_badge_type_archive` SELECT * FROM `politizr_beta`.`p_r_badge_type_archive`;

DROP TABLE IF EXISTS `politizr_demo`.`p_r_metal_type`;
CREATE TABLE `politizr_demo`.`p_r_metal_type` LIKE `politizr_beta`.`p_r_metal_type`;
INSERT INTO `politizr_demo`.`p_r_metal_type` SELECT * FROM `politizr_beta`.`p_r_metal_type`;

DROP TABLE IF EXISTS `politizr_demo`.`p_tag`;
CREATE TABLE `politizr_demo`.`p_tag` LIKE `politizr_beta`.`p_tag`;
INSERT INTO `politizr_demo`.`p_tag` SELECT * FROM `politizr_beta`.`p_tag`;

DROP TABLE IF EXISTS `politizr_demo`.`p_tag_archive`;
CREATE TABLE `politizr_demo`.`p_tag_archive` LIKE `politizr_beta`.`p_tag_archive`;
INSERT INTO `politizr_demo`.`p_tag_archive` SELECT * FROM `politizr_beta`.`p_tag_archive`;

DROP TABLE IF EXISTS `politizr_demo`.`p_t_tag_type`;
CREATE TABLE `politizr_demo`.`p_t_tag_type` LIKE `politizr_beta`.`p_t_tag_type`;
INSERT INTO `politizr_demo`.`p_t_tag_type` SELECT * FROM `politizr_beta`.`p_t_tag_type`;
