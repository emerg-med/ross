ALTER TABLE `ED`.`Patients` ADD COLUMN `Diagnosis1Certainty` INTEGER UNSIGNED NOT NULL DEFAULT 0 AFTER `FlagsBarriers`,
 ADD COLUMN `Diagnosis2Certainty` INTEGER UNSIGNED NOT NULL DEFAULT 0 AFTER `Diagnosis1Certainty`,
 ADD COLUMN `Diagnosis3Certainty` INTEGER UNSIGNED NOT NULL DEFAULT 0 AFTER `Diagnosis2Certainty`;