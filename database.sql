CREATE DATABASE IF NOT EXISTS cop_word CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cop_word;

-- Tabelas principais
CREATE TABLE IF NOT EXISTS grupos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  letra VARCHAR(1) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS selecoes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL UNIQUE,
  continente VARCHAR(50) NOT NULL,
  grupo_id INT NOT NULL,
  CONSTRAINT fk_selecao_grupo FOREIGN KEY (grupo_id) REFERENCES grupos(id) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  idade INT NOT NULL,
  cargo VARCHAR(20) NOT NULL,
  selecao_id INT NOT NULL,
  CONSTRAINT fk_usuario_selecao FOREIGN KEY (selecao_id) REFERENCES selecoes(id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS jogos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  mandante_id INT NOT NULL,
  visitante_id INT NOT NULL,
  data_hora DATETIME NOT NULL,
  estadio VARCHAR(100) NOT NULL,
  fase VARCHAR(50) NOT NULL,
  grupo_id INT NULL,
  CONSTRAINT fk_jogo_mandante FOREIGN KEY (mandante_id) REFERENCES selecoes(id) ON UPDATE CASCADE,
  CONSTRAINT fk_jogo_visitante FOREIGN KEY (visitante_id) REFERENCES selecoes(id) ON UPDATE CASCADE,
  CONSTRAINT fk_jogo_grupo FOREIGN KEY (grupo_id) REFERENCES grupos(id) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS resultados (
  id INT AUTO_INCREMENT PRIMARY KEY,
  jogo_id INT NOT NULL UNIQUE,
  gols_mandante INT NOT NULL,
  gols_visitante INT NOT NULL,
  CONSTRAINT fk_resultado_jogo FOREIGN KEY (jogo_id) REFERENCES jogos(id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Estatísticas persistidas (abordagem B)
CREATE TABLE IF NOT EXISTS estatisticas_selecao (
  selecao_id INT PRIMARY KEY,
  jogos INT NOT NULL DEFAULT 0,
  vitorias INT NOT NULL DEFAULT 0,
  empates INT NOT NULL DEFAULT 0,
  derrotas INT NOT NULL DEFAULT 0,
  gols_pro INT NOT NULL DEFAULT 0,
  gols_contra INT NOT NULL DEFAULT 0,
  saldo_gols INT NOT NULL DEFAULT 0,
  pontos INT NOT NULL DEFAULT 0,
  CONSTRAINT fk_stats_selecao FOREIGN KEY (selecao_id) REFERENCES selecoes(id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seeds de exemplo
INSERT INTO grupos (letra) VALUES ('A'), ('B')
ON DUPLICATE KEY UPDATE letra = VALUES(letra);

-- Seleções (4 seleções)
INSERT INTO selecoes (nome, continente, grupo_id) VALUES
('Brasil', 'América do Sul', (SELECT id FROM grupos WHERE letra='A')),
('Alemanha', 'Europa', (SELECT id FROM grupos WHERE letra='A')),
('Argentina', 'América do Sul', (SELECT id FROM grupos WHERE letra='B')),
('França', 'Europa', (SELECT id FROM grupos WHERE letra='B'))
ON DUPLICATE KEY UPDATE continente = VALUES(continente), grupo_id = VALUES(grupo_id);

-- Usuários (exemplos simples)
INSERT INTO usuarios (nome, idade, cargo, selecao_id) VALUES
('Neymar', 30, 'jogador', (SELECT id FROM selecoes WHERE nome='Brasil')),
('Tite', 60, 'técnico', (SELECT id FROM selecoes WHERE nome='Brasil')),
('Messi', 35, 'jogador', (SELECT id FROM selecoes WHERE nome='Argentina')),
('Deschamps', 50, 'técnico', (SELECT id FROM selecoes WHERE nome='França'));

-- Jogos (4 jogos, 2 por grupo)
INSERT INTO jogos (mandante_id, visitante_id, data_hora, estadio, fase, grupo_id) VALUES
((SELECT id FROM selecoes WHERE nome='Brasil'),
 (SELECT id FROM selecoes WHERE nome='Alemanha'),
 '2026-06-10 16:00:00', 'Estádio A', 'Grupos', (SELECT id FROM grupos WHERE letra='A')),
((SELECT id FROM selecoes WHERE nome='Alemanha'),
 (SELECT id FROM selecoes WHERE nome='Brasil'),
 '2026-06-18 16:00:00', 'Estádio B', 'Grupos', (SELECT id FROM grupos WHERE letra='A')),
((SELECT id FROM selecoes WHERE nome='Argentina'),
 (SELECT id FROM selecoes WHERE nome='França'),
 '2026-06-11 18:00:00', 'Estádio C', 'Grupos', (SELECT id FROM grupos WHERE letra='B')),
((SELECT id FROM selecoes WHERE nome='França'),
 (SELECT id FROM selecoes WHERE nome='Argentina'),
 '2026-06-19 18:00:00', 'Estádio D', 'Grupos', (SELECT id FROM grupos WHERE letra='B'));

-- Resultados (pelo menos 2 resultados)
INSERT INTO resultados (jogo_id, gols_mandante, gols_visitante) VALUES
((SELECT id FROM jogos j
  JOIN selecoes sm ON sm.id = j.mandante_id
  JOIN selecoes sv ON sv.id = j.visitante_id
  WHERE sm.nome='Brasil' AND sv.nome='Alemanha' AND j.data_hora='2026-06-10 16:00:00'), 2, 1),
((SELECT id FROM jogos j
  JOIN selecoes sm ON sm.id = j.mandante_id
  JOIN selecoes sv ON sv.id = j.visitante_id
  WHERE sm.nome='Argentina' AND sv.nome='França' AND j.data_hora='2026-06-11 18:00:00'), 1, 1)
ON DUPLICATE KEY UPDATE gols_mandante = VALUES(gols_mandante), gols_visitante = VALUES(gols_visitante);

-- Inicializa estatísticas zeradas para todas as seleções
INSERT INTO estatisticas_selecao (selecao_id) 
SELECT s.id FROM selecoes s
ON DUPLICATE KEY UPDATE selecao_id = selecao_id;

-- Recalcula estatísticas básicas via updates procedurais (script simples)
-- Nota: As estatísticas serão atualizadas automaticamente pelo sistema ao editar/registrar resultados.
