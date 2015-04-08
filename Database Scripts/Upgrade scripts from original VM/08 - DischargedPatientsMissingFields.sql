ALTER TABLE `ED`.`DischargedPatients` ADD COLUMN `FlagsDischargeScreen` CHAR(4) NULL DEFAULT 'NNNN' AFTER `ClericalID`,
 ADD COLUMN `FlagsTreatment` CHAR(3) NULL DEFAULT 'NNN' AFTER `FlagsDischargeScreen`,
 ADD COLUMN `FlagsReferral` VARCHAR(7) NULL DEFAULT '------' AFTER `FlagsTreatment`,
 ADD COLUMN `FlagsDiagnostics` CHAR(4) NULL DEFAULT '---' AFTER `FlagsReferral`,
 ADD COLUMN `FlagsBarriers` VARCHAR(6) NULL DEFAULT '-----' AFTER `FlagsDiagnostics`,
 ADD COLUMN `Diagnosis1Certainty` INTEGER UNSIGNED NULL DEFAULT 0 AFTER `FlagsBarriers`,
 ADD COLUMN `Diagnosis2Certainty` INTEGER UNSIGNED NULL DEFAULT 0 AFTER `Diagnosis1Certainty`,
 ADD COLUMN `Diagnosis3Certainty` INTEGER UNSIGNED NULL DEFAULT 0 AFTER `Diagnosis2Certainty`;