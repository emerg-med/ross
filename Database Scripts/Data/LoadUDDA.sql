load data local infile '/tmp/UDDA_WB.txt'
into table UDDA
fields terminated by '\t'
lines terminated by '\r\n'
(UDDAUniqueID, `Primary`, Secondary, Diagnosis, SearchTerms, ICD10Code);