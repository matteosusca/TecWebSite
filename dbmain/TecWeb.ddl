-- *********************************************
-- * SQL MySQL generation                      
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.2              
-- * Generator date: Sep 20 2021              
-- * Generation date: Mon Dec 26 12:51:51 2022 
-- * LUN file: /home/sysosus/Documents/TecWebSite/TecWeb.lun 
-- * Schema: TecWeb-logico/1-1-1 
-- ********************************************* 


-- Database Section
-- ________________ 

create database TecWeb-logico;
use TecWeb-logico;


-- Tables Section
-- _____________ 

create table amicizia (
     user1 varchar(30) not null,
     user2 varchar(30) not null,
     constraint IDamicizia primary key (user2, user1));

create table COMMENTO (
     id_commento int not null auto_increment,
     corpo varchar(100) not null,
     timestamp date not null,
     username_autore varchar(30) not null,
     id_post int not null auto_increment,
     constraint IDCOMMENTO primary key (id_commento),
     constraint IDCOMMENTO_1 unique (timestamp, username_autore));

create table COMPAGNIA (
     id_compagnia int not null auto_increment,
     nome varchar(30) not null,
     descrizione varchar(100) not null,
     username_creatore varchar(30) not null,
     constraint IDCOMPAGNIA_ID primary key (id_compagnia));

create table EVENTO (
     id_evento int not null auto_increment,
     nome varchar(50) not null,
     descrizione varchar(300) not null,
     data_creazione date not null,
     data_evento date not null,
     data_fine date not null,
     is_evento_utente char not null,
     id_compagnia_organizzatrice int,
     username_organizzatore varchar(30),
     constraint IDEVENTO primary key (id_evento));

create table INVITO_COMPAGNIA (
     id_evento int not null,
     id_compagnia int not null,
     constraint IDinvito_compagnia primary key (id_evento, id_compagnia));

create table INVITO_UTENTE (
     id_evento int not null,
     username varchar(30) not null,
     constraint IDinvito_utente primary key (id_evento, username));

create table ISCRIZIONE_COMPAGNIA (
     id_compagnia int not null,
     id_evento int not null,
     constraint IDiscrizione_c primary key (id_evento, id_compagnia));

create table ISCRIZIONE_UTENTE (
     id_evento int not null,
     username varchar(30) not null,
     constraint IDiscrizione_u primary key (id_evento, username));

create table LIKE (
     id_post int not null,
     username varchar(30) not null,
     timestamp date not null,
     constraint IDLIKE primary key (username, id_post));

create table LOGIN (
     username varchar(30) not null,
     mail varchar(30) not null,
     password varchar(50) not null,
     constraint FKlogin_ID primary key (username));

create table MEDIA (
     id_media int not null auto_increment,
     url varchar(100) not null,
     tipo_media varchar(50) not null,
     constraint IDMEDIA_ID primary key (id_media));

create table partecipazione (
     username_membro varchar(30) not null,
     id_compagnia int not null,
     ruolo_membro varchar(10) not null,
     constraint IDpartecipazione primary key (id_compagnia, username_membro));

create table POST (
     id_post int not null auto_increment,
     id_media int,
     descrizione varchar(100) not null,
     timestamp date not null,
     username_autore varchar(30) not null,
     constraint IDPOST primary key (id_post),
     constraint FKcontenuto_ID unique (id_media));

create table UTENTE (
     username varchar(30) not null,
     mail varchar(30) not null,
     data nascita date not null,
     nome  varchar(30) not null,
     cognome varchar(30) not null,
     constraint IDUTENTE_ID primary key (username));


-- Constraints Section
-- ___________________ 

alter table amicizia add constraint FKaccettante
     foreign key (user2)
     references UTENTE (username);

alter table amicizia add constraint FKrichiedente
     foreign key (user1)
     references UTENTE (username);

alter table COMMENTO add constraint FKper
     foreign key (id_post)
     references POST (id_post);

alter table COMMENTO add constraint FKscrittura
     foreign key (username_autore)
     references UTENTE (username);

-- Not implemented
-- alter table COMPAGNIA add constraint IDCOMPAGNIA_CHK
--     check(exists(select * from partecipazione
--                  where partecipazione.id_compagnia = id_compagnia)); 

alter table COMPAGNIA add constraint FKcreazione
     foreign key (username_creatore)
     references UTENTE (username);

alter table EVENTO add constraint FKorganizzazione_c
     foreign key (id_compagnia_organizzatrice)
     references COMPAGNIA (id_compagnia);

alter table EVENTO add constraint FKorganizzazione_u
     foreign key (username_organizzatore)
     references UTENTE (username);

alter table INVITO_COMPAGNIA add constraint FKinv_COM
     foreign key (id_compagnia)
     references COMPAGNIA (id_compagnia);

alter table INVITO_COMPAGNIA add constraint FKinv_EVE
     foreign key (id_evento)
     references EVENTO (id_evento);

alter table INVITO_UTENTE add constraint FKinv_UTE
     foreign key (username)
     references UTENTE (username);

alter table INVITO_UTENTE add constraint FKinv_EVE
     foreign key (id_evento)
     references EVENTO (id_evento);

alter table ISCRIZIONE_COMPAGNIA add constraint FKisc_EVE
     foreign key (id_evento)
     references EVENTO (id_evento);

alter table ISCRIZIONE_COMPAGNIA add constraint FKisc_COM
     foreign key (id_compagnia)
     references COMPAGNIA (id_compagnia);

alter table ISCRIZIONE_UTENTE add constraint FKisc_UTE
     foreign key (username)
     references UTENTE (username);

alter table ISCRIZIONE_UTENTE add constraint FKisc_EVE
     foreign key (id_evento)
     references EVENTO (id_evento);

alter table LIKE add constraint FKeffettuazione
     foreign key (username)
     references UTENTE (username);

alter table LIKE add constraint FKa
     foreign key (id_post)
     references POST (id_post);

alter table LOGIN add constraint FKlogin_FK
     foreign key (username)
     references UTENTE (username);

-- Not implemented
-- alter table MEDIA add constraint IDMEDIA_CHK
--     check(exists(select * from POST
--                  where POST.id_media = id_media)); 

alter table partecipazione add constraint FKpar_COM
     foreign key (id_compagnia)
     references COMPAGNIA (id_compagnia);

alter table partecipazione add constraint FKpar_UTE
     foreign key (username_membro)
     references UTENTE (username);

alter table POST add constraint FKcontenuto_FK
     foreign key (id_media)
     references MEDIA (id_media);

alter table POST add constraint FKpubblicazione
     foreign key (username_autore)
     references UTENTE (username);

-- Not implemented
-- alter table UTENTE add constraint IDUTENTE_CHK
--     check(exists(select * from LOGIN
--                  where LOGIN.username = username)); 


-- Index Section
-- _____________ 

