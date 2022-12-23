-- *********************************************
-- * SQL MySQL generation                      
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.2              
-- * Generator date: Sep 20 2021              
-- * Generation date: Fri Dec 23 14:29:46 2022 
-- * LUN file: /home/panini/Documents/scuola/web/TecWebSite/TecWeb.lun 
-- * Schema: TecWeb-logico/1-1-1 
-- ********************************************* 


-- Database Section
-- ________________ 

create database TecWeb-logico;
use TecWeb-logico;


-- Tables Section
-- _____________ 

create table amicizia (
     Ric_username char(1) not null,
     username char(1) not null,
     constraint IDamicizia primary key (username, Ric_username));

create table COMMENTO (
     id_commento char(1) not null,
     corpo -- Compound attribute -- not null,
     timestamp char(1) not null,
     username_autore char(1) not null,
     id_post char(1) not null,
     constraint IDCOMMENTO primary key (id_commento),
     constraint IDCOMMENTO_1 unique (timestamp, username_autore));

create table COMPAGNIA (
     id_compagnia char(1) not null,
     nome char(1) not null,
     descrizione char(1) not null,
     username_creatore char(1) not null,
     constraint IDCOMPAGNIA_ID primary key (id_compagnia));

create table EVENTO (
     id_evento char(1) not null,
     nome char(1) not null,
     descrizione char(1) not null,
     data_creazione char(1) not null,
     data_evento char(1) not null,
     durata char(1) not null,
     tipo_evento char(1) not null,
     id_compagnia_organizzatrice char(1),
     username_organizzatore char(1),
     constraint IDEVENTO primary key (id_evento));

create table iscrizione_c (
     id_compagnia char(1) not null,
     id_evento char(1) not null,
     constraint IDiscrizione_c primary key (id_evento, id_compagnia));

create table iscrizione_u (
     id_evento char(1) not null,
     username char(1) not null,
     constraint IDiscrizione_u primary key (id_evento, username));

create table LIKE (
     id_post char(1) not null,
     username char(1) not null,
     timestamp char(1) not null,
     constraint IDLIKE primary key (username, id_post));

create table LOGIN (
     username char(1) not null,
     mail char(1) not null,
     password char(1) not null,
     constraint FKlogin_ID primary key (username));

create table MEDIA (
     id_media char(1) not null,
     url char(1) not null,
     tipo_media char(1) not null,
     constraint IDMEDIA_ID primary key (id_media));

create table POST (
     id_post char(1) not null,
     id_media char(1),
     descrizione char(1) not null,
     timestamp char(1) not null,
     username_autore char(1) not null,
     constraint IDPOST primary key (id_post),
     constraint FKcontenuto_ID unique (id_media));

create table partecipazione (
     username_membro char(1) not null,
     id_compagnia char(1) not null,
     ruolo_membro char(1) not null,
     constraint IDpartecipazione primary key (id_compagnia, username_membro));

create table UTENTE (
     username char(1) not null,
     mail char(1) not null,
     data nascita char(1) not null,
     nome  char(1) not null,
     cognome char(1) not null,
     constraint IDUTENTE_ID primary key (username));


-- Constraints Section
-- ___________________ 

alter table amicizia add constraint FKaccettante
     foreign key (username)
     references UTENTE (username);

alter table amicizia add constraint FKrichiedente
     foreign key (Ric_username)
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

alter table iscrizione_c add constraint FKisc_EVE
     foreign key (id_evento)
     references EVENTO (id_evento);

alter table iscrizione_c add constraint FKisc_COM
     foreign key (id_compagnia)
     references COMPAGNIA (id_compagnia);

alter table iscrizione_u add constraint FKisc_UTE
     foreign key (username)
     references UTENTE (username);

alter table iscrizione_u add constraint FKisc_EVE
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

alter table POST add constraint FKcontenuto_FK
     foreign key (id_media)
     references MEDIA (id_media);

alter table POST add constraint FKpubblicazione
     foreign key (username_autore)
     references UTENTE (username);

alter table partecipazione add constraint FKpar_COM
     foreign key (id_compagnia)
     references COMPAGNIA (id_compagnia);

alter table partecipazione add constraint FKpar_UTE
     foreign key (username_membro)
     references UTENTE (username);

-- Not implemented
-- alter table UTENTE add constraint IDUTENTE_CHK
--     check(exists(select * from LOGIN
--                  where LOGIN.username = username)); 


-- Index Section
-- _____________ 

