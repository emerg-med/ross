ALTER TABLE `ED`.`UDDA` ADD COLUMN `Description` TINYTEXT NOT NULL DEFAULT '' AFTER `ICD10Code`;
UPDATE `ED`.`UDDA` SET Description = CONCAT(Secondary, ' - ', Diagnosis)