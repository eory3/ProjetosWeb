
CREATE DATABASE rh;
USE rh;

CREATE TABLE entrevista (
  id int(11) NOT NULL,
  nome varchar(255) NOT NULL,
  idade int(11) NOT NULL,
  sexo varchar(10) NOT NULL,
  tecnologia varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO entrevista (id, nome, idade, sexo, tecnologia) VALUES
(1, 'Teste', 22, 'masculino', 'PHP');

CREATE TABLE novatecnologia (
  idTecnologia int(11) NOT NULL,
  nome varchar(255) NOT NULL,
  vaga int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO novatecnologia (idTecnologia, nome, vaga) VALUES
(1, 'PHP', 2),
(2, 'JAVA', 2),
(3, 'HTML5', 3),
(4, 'CSS3', 1),
(5, 'BootStrap', 3);

ALTER TABLE entrevista
  ADD PRIMARY KEY (id);

ALTER TABLE novatecnologia
  ADD PRIMARY KEY (idTecnologia);

ALTER TABLE entrevista
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE novatecnologia
  MODIFY idTecnologia int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;