Create Table dataset(News_Text text(65000), label char(4));
LOAD DATA INFILE 'TheOmega.csv' 
INTO TABLE dataset
  FIELDS
    TERMINATED BY ','
    ENCLOSED BY '"'
    ESCAPED BY ''
  LINES
    TERMINATED BY '\n'
  IGNORE 1 LINES;
  
  
  ALTER TABLE `dataset` ADD `News_Article_Number` INT(255) NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`News_Article_Number`);