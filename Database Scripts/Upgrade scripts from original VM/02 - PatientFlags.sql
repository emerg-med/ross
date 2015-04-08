ALTER TABLE `ED`.`Patients` ADD COLUMN `FlagsDischargeScreen` CHAR(4) NOT NULL DEFAULT 'NNNN' AFTER `ClericalID`,
 ADD COLUMN `FlagsTreatment` CHAR(3) NOT NULL DEFAULT 'NNN' AFTER `FlagsDischargeScreen`,
 ADD COLUMN `FlagsReferral` CHAR(6) NOT NULL DEFAULT '------' AFTER `FlagsTreatment`,
 ADD COLUMN `FlagsDiagnostics` CHAR(3) NOT NULL DEFAULT '---' AFTER `FlagsReferral`,
 ADD COLUMN `FlagsBarriers` CHAR(5) NOT NULL DEFAULT '-----' AFTER `FlagsDiagnostics`;