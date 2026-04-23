-- ============================================================
--  WiredSpace S.r.l. – Database Schema
--  Progetto GPOI | Anno Scolastico 2024/2025
-- ============================================================

CREATE DATABASE IF NOT EXISTS wiredspace_pro CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE wiredspace_pro;

-- -----------------------------------------------------------
-- TABELLA 1: utenti (clienti + admin + tecnici)
-- -----------------------------------------------------------
CREATE TABLE utenti (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(50)  NOT NULL UNIQUE,
    email       VARCHAR(100) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    nome        VARCHAR(60)  NOT NULL,
    cognome     VARCHAR(60)  NOT NULL,
    telefono    VARCHAR(20)  DEFAULT NULL,
    ruolo       ENUM('cliente','tecnico','admin') NOT NULL DEFAULT 'cliente',
    azienda     VARCHAR(100) DEFAULT NULL,
    data_reg    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    attivo      TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

-- -----------------------------------------------------------
-- TABELLA 2: servizi
-- -----------------------------------------------------------
CREATE TABLE servizi (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nome        VARCHAR(100) NOT NULL,
    descrizione TEXT         NOT NULL,
    icona       VARCHAR(10)  DEFAULT '🏠',
    immagine    VARCHAR(255) DEFAULT NULL,
    prezzo_base DECIMAL(10,2) DEFAULT NULL,
    attivo      TINYINT(1)   NOT NULL DEFAULT 1,
    ordine      TINYINT UNSIGNED DEFAULT 0
) ENGINE=InnoDB;

-- -----------------------------------------------------------
-- TABELLA 3: progetti (impianti installati)
-- -----------------------------------------------------------
CREATE TABLE progetti (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    titolo       VARCHAR(150) NOT NULL,
    cliente_id   INT          NOT NULL,
    servizio_id  INT          NOT NULL,
    tecnico_id   INT          DEFAULT NULL,
    descrizione  TEXT         DEFAULT NULL,
    indirizzo    VARCHAR(200) DEFAULT NULL,
    stato        ENUM('richiesta','in_corso','completato','sospeso') NOT NULL DEFAULT 'richiesta',
    data_inizio  DATE         DEFAULT NULL,
    data_fine    DATE         DEFAULT NULL,
    budget       DECIMAL(10,2) DEFAULT NULL,
    note         TEXT         DEFAULT NULL,
    data_crea    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id)  REFERENCES utenti(id) ON DELETE CASCADE,
    FOREIGN KEY (servizio_id) REFERENCES servizi(id) ON DELETE RESTRICT,
    FOREIGN KEY (tecnico_id)  REFERENCES utenti(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- -----------------------------------------------------------
-- TABELLA 4: preventivi
-- -----------------------------------------------------------
CREATE TABLE preventivi (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id   INT          NOT NULL,
    servizio_id  INT          NOT NULL,
    nome_ref     VARCHAR(100) NOT NULL,
    email_ref    VARCHAR(100) NOT NULL,
    telefono_ref VARCHAR(20)  DEFAULT NULL,
    azienda      VARCHAR(100) DEFAULT NULL,
    descrizione  TEXT         NOT NULL,
    indirizzo    VARCHAR(200) DEFAULT NULL,
    superficie   INT          DEFAULT NULL,
    budget_est   DECIMAL(10,2) DEFAULT NULL,
    stato        ENUM('nuovo','in_lavorazione','inviato','accettato','rifiutato') NOT NULL DEFAULT 'nuovo',
    importo_prop DECIMAL(10,2) DEFAULT NULL,
    note_admin   TEXT         DEFAULT NULL,
    data_rich    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id)  REFERENCES utenti(id) ON DELETE CASCADE,
    FOREIGN KEY (servizio_id) REFERENCES servizi(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- -----------------------------------------------------------
-- TABELLA 5: interventi (storico tecnico)
-- -----------------------------------------------------------
CREATE TABLE interventi (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    progetto_id  INT          NOT NULL,
    tecnico_id   INT          NOT NULL,
    tipo         ENUM('installazione','manutenzione','riparazione','sopralluogo','collaudo') NOT NULL,
    descrizione  TEXT         NOT NULL,
    data_interv  DATE         NOT NULL,
    ore_lavoro   DECIMAL(4,1) DEFAULT NULL,
    costo        DECIMAL(10,2) DEFAULT NULL,
    esito        ENUM('completato','parziale','da_completare') NOT NULL DEFAULT 'completato',
    FOREIGN KEY (progetto_id) REFERENCES progetti(id) ON DELETE CASCADE,
    FOREIGN KEY (tecnico_id)  REFERENCES utenti(id)   ON DELETE RESTRICT
) ENGINE=InnoDB;

-- -----------------------------------------------------------
-- TABELLA 6: contatti (form contatti pubblico)
-- -----------------------------------------------------------
CREATE TABLE contatti (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    nome      VARCHAR(100) NOT NULL,
    email     VARCHAR(100) NOT NULL,
    telefono  VARCHAR(20)  DEFAULT NULL,
    oggetto   VARCHAR(200) NOT NULL,
    messaggio TEXT         NOT NULL,
    letto     TINYINT(1)   NOT NULL DEFAULT 0,
    data_inv  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
--  DATI DI ESEMPIO
-- ============================================================

INSERT INTO utenti (username,email,password,nome,cognome,telefono,ruolo,azienda) VALUES
('admin',      'admin@wiredspace.it',  '$2y$12$placeholder_admin',  'Admin',    'Sistema',   '+39 02 1234567', 'admin',   'WiredSpace S.r.l.'),
('marco.t',    'marco@wiredspace.it',  '$2y$12$placeholder_tecnico', 'Marco',    'Tecchini',  '+39 333 1111111','tecnico', 'WiredSpace S.r.l.'),
('luca.b',     'luca@wiredspace.it',   '$2y$12$placeholder_tecnico', 'Luca',     'Bianchi',   '+39 333 2222222','tecnico', 'WiredSpace S.r.l.'),
('mario.r',    'mario@example.com',    '$2y$12$placeholder_cliente', 'Mario',    'Rossi',     '+39 347 3333333','cliente', 'Rossi Costruzioni'),
('giulia.v',   'giulia@example.com',   '$2y$12$placeholder_cliente', 'Giulia',   'Verdi',     '+39 347 4444444','cliente', NULL),
('tech.milan', 'info@techmi.it',       '$2y$12$placeholder_cliente', 'Roberto',  'Milanesi',  '+39 02 9999999', 'cliente', 'TechMilan S.p.A.');

INSERT INTO servizi (nome, descrizione, icona, prezzo_base, ordine) VALUES
('Domotica Integrata',      'Sistemi completi per la gestione intelligente di luce, clima, tapparelle, elettrodomestici e molto altro. Controllo totale dal tuo smartphone.',         '💡', 5000.00,  1),
('Sicurezza e Controllo',   'Impianti di videosorveglianza, antintrusione e controllo accessi per la massima sicurezza. Sistemi certificati e monitorati 24/7.',                      '🔒', 3000.00,  2),
('Efficienza Energetica',   'Monitoraggio e gestione dei consumi per ottimizzare l energia e ridurre gli sprechi. Integrazione con fonti rinnovabili e reportistica dettagliata.',    '🌿', 4000.00,  3),
('Audio e Video Multiroom', 'Soluzioni audio e video di alta qualità per ogni ambiente, in perfetta armonia. Diffusione musicale e home theater integrati.',                          '🎵', 6000.00,  4),
('Reti e Infrastrutture',   'Progettazione e realizzazione di reti cablate, Wi-Fi e infrastrutture di comunicazione ad alte prestazioni per uffici ed edifici.',                    '📡', 2500.00,  5),
('Manutenzione',            'Contratti di manutenzione periodica e assistenza tecnica remota e on-site. Interventi rapidi garantiti entro 24 ore.',                                   '🔧', 800.00,   6);

INSERT INTO progetti (titolo,cliente_id,servizio_id,tecnico_id,descrizione,indirizzo,stato,data_inizio,data_fine,budget) VALUES
('Domotica uffici TechMilan',       6,1,2,'Installazione sistema KNX per controllo luci e clima su 3 piani','Via Montenapoleone 5, Milano','completato','2025-01-10','2025-02-28',45000.00),
('Videosorveglianza Rossi Costr.',  4,2,3,'Sistema TVCC IP con 12 telecamere esterne e 6 interne','Via Roma 22, Brescia',             'completato','2025-02-01','2025-02-20',12000.00),
('Efficienza energetica residenz.',  5,3,2,'Monitoraggio consumi con gateway IoT e pannelli solari integrati','Via Verdi 8, Bergamo',  'in_corso',  '2025-03-15',NULL,         18000.00),
('Multiroom audio villa privata',    5,4,3,'Sistema audio Sonos su 8 zone con controllo vocale Alexa','Via dei Pini 3, Como',          'richiesta', NULL,        NULL,         25000.00),
('Rete aziendale TechMilan sede 2',  6,5,2,'Infrastruttura Wi-Fi 6 e rete cablata cat.6A su 2000mq','Viale Certosa 12, Milano',       'in_corso',  '2025-04-01',NULL,         30000.00);

INSERT INTO preventivi (cliente_id,servizio_id,nome_ref,email_ref,telefono_ref,azienda,descrizione,indirizzo,superficie,budget_est,stato,importo_prop) VALUES
(4,1,'Mario Rossi',  'mario@example.com', '+39 347 3333333','Rossi Costruzioni','Voglio automatizzare i 500mq dei miei uffici con controllo luci e clima','Via Roma 22, Brescia',    500,40000.00,'accettato',43000.00),
(5,3,'Giulia Verdi', 'giulia@example.com','+39 347 4444444',NULL,               'Monitoraggio consumi casa e integrazione fotovoltaico','Via Verdi 8, Bergamo',                        120,15000.00,'inviato',  17500.00),
(6,5,'Roberto Milan','info@techmi.it',    '+39 02 9999999', 'TechMilan S.p.A.', 'Nuova sede 2000mq, serve infrastruttura rete completa','Viale Certosa 12, Milano',                   2000,25000.00,'accettato',29800.00);

INSERT INTO interventi (progetto_id,tecnico_id,tipo,descrizione,data_interv,ore_lavoro,costo,esito) VALUES
(1,2,'sopralluogo',   'Sopralluogo iniziale e rilievo planimetrico dei 3 piani',     '2025-01-10',4.0, 400.00, 'completato'),
(1,2,'installazione', 'Posa cavi bus KNX e montaggio attuatori piano terra',          '2025-01-20',8.0, 800.00, 'completato'),
(1,3,'installazione', 'Installazione pannelli touch e configurazione scene',           '2025-02-10',6.0, 600.00, 'completato'),
(1,2,'collaudo',      'Collaudo generale sistema e formazione personale',             '2025-02-28',4.0, 400.00, 'completato'),
(2,3,'installazione', 'Montaggio telecamere esterne perimetrali',                     '2025-02-05',8.0, 800.00, 'completato'),
(2,3,'collaudo',      'Configurazione NVR e test registrazioni',                      '2025-02-20',4.0, 400.00, 'completato'),
(3,2,'sopralluogo',   'Analisi consumi esistenti e progetto gateway IoT',             '2025-03-15',3.0, 300.00, 'completato'),
(3,2,'installazione', 'Installazione gateway e sensori piano terra (in corso)',        '2025-04-10',6.0, 600.00, 'da_completare');

INSERT INTO contatti (nome,email,telefono,oggetto,messaggio) VALUES
('Francesco Neri',  'fneri@gmail.com',    '+39 348 1234567','Informazioni domotica casa','Salve, vorrei avere informazioni sui sistemi domotici per la mia abitazione di 200mq. Grazie.'),
('Studio Arch. Boni','boni@archilab.it', '+39 02 8888888', 'Collaborazione architetti','Siamo uno studio di architettura interessato a partnership per progetti residenziali premium.'),
('Comune di Sesto', 'tecnico@sesto.it',   '+39 02 7777777','Edificio pubblico domotica','Il comune è interessato ad automatizzare il palazzo municipale di 3000mq.');
