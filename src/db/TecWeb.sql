create table amicizia (
     user1 varchar(30) not null,
     user2 varchar(30) not null,
     constraint IDamicizia primary key (user2, user1));

create table COMMENTO (
     id_commento -- Sequence attribute not implemented -- not null,
     corpo varchar(100) not null,
     timestamp date not null,
     username_autore varchar(30) not null,
     id_post -- Sequence attribute not implemented -- not null,
     constraint IDCOMMENTO primary key (id_commento),
     constraint IDCOMMENTO_1 unique (timestamp, username_autore));

create table COMPAGNIA (
     id_compagnia -- Sequence attribute not implemented -- not null,
     nome varchar(30) not null,
     descrizione varchar(100) not null,
     username_creatore varchar(30) not null,
     constraint IDCOMPAGNIA_ID primary key (id_compagnia));

create table EVENTO (
     id_evento -- Sequence attribute not implemented -- not null,
     nome varchar(50) not null,
     descrizione varchar(300) not null,
     data_creazione date not null,
     data_evento date not null,
     data_fine date not null,
     is_evento_utente char not null,
     id_compagnia_organizzatrice -- Sequence attribute not implemented --,
     username_organizzatore -- Sequence attribute not implemented --,
     constraint IDEVENTO primary key (id_evento));

create table INVITO_COMPAGNIA (
     id_evento -- Sequence attribute not implemented -- not null,
     id_compagnia -- Sequence attribute not implemented -- not null,
     constraint IDinvito_compagnia primary key (id_evento, id_compagnia));

create table INVITO_UTENTE (
     id_evento -- Sequence attribute not implemented -- not null,
     username varchar(30) not null,
     constraint IDinvito_utente primary key (id_evento, username));

create table ISCRIZIONE_COMPAGNIA (
     id_compagnia -- Sequence attribute not implemented -- not null,
     id_evento -- Sequence attribute not implemented -- not null,
     constraint IDiscrizione_c primary key (id_evento, id_compagnia));

create table ISCRIZIONE_UTENTE (
     id_evento -- Sequence attribute not implemented -- not null,
     username varchar(30) not null,
     constraint IDiscrizione_u primary key (id_evento, username));

create table LIKE (
     id_post -- Sequence attribute not implemented -- not null,
     username varchar(30) not null,
     timestamp date not null,
     constraint IDLIKE primary key (username, id_post));

create table LOGIN (
     username varchar(30) not null,
     mail varchar(30) not null,
     password varchar(50) not null,
     constraint FKlogin_ID primary key (username));

create table MEDIA (
     id_media -- Sequence attribute not implemented -- not null,
     url varchar(100) not null,
     tipo_media varchar(50) not null,
     constraint IDMEDIA_ID primary key (id_media));

create table partecipazione (
     username_membro varchar(30) not null,
     id_compagnia -- Sequence attribute not implemented -- not null,
     ruolo_membro varchar(10) not null,
     constraint IDpartecipazione primary key (id_compagnia, username_membro));

create table POST (
     id_post -- Sequence attribute not implemented -- not null,
     id_media -- Sequence attribute not implemented --,
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

alter table amicizia add constraint FKaccettante
     foreign key (user2)
     references UTENTE;

alter table amicizia add constraint FKrichiedente
     foreign key (user1)
     references UTENTE;

alter table COMMENTO add constraint FKper
     foreign key (id_post)
     references POST;

alter table COMMENTO add constraint FKscrittura
     foreign key (username_autore)
     references UTENTE;

alter table COMPAGNIA add constraint IDCOMPAGNIA_CHK
     check(exists(select * from partecipazione
                  where partecipazione.id_compagnia = id_compagnia)); 

alter table COMPAGNIA add constraint FKcreazione
     foreign key (username_creatore)
     references UTENTE;

alter table EVENTO add constraint FKorganizzazione_c
     foreign key (id_compagnia_organizzatrice)
     references COMPAGNIA;

alter table EVENTO add constraint FKorganizzazione_u
     foreign key (username_organizzatore)
     references UTENTE;

alter table INVITO_COMPAGNIA add constraint FKinv_COM
     foreign key (id_compagnia)
     references COMPAGNIA;

alter table INVITO_COMPAGNIA add constraint FKinv_EVE
     foreign key (id_evento)
     references EVENTO;

alter table INVITO_UTENTE add constraint FKinv_UTE
     foreign key (username)
     references UTENTE;

alter table INVITO_UTENTE add constraint FKinv_EVE
     foreign key (id_evento)
     references EVENTO;

alter table ISCRIZIONE_COMPAGNIA add constraint FKisc_EVE
     foreign key (id_evento)
     references EVENTO;

alter table ISCRIZIONE_COMPAGNIA add constraint FKisc_COM
     foreign key (id_compagnia)
     references COMPAGNIA;

alter table ISCRIZIONE_UTENTE add constraint FKisc_UTE
     foreign key (username)
     references UTENTE;

alter table ISCRIZIONE_UTENTE add constraint FKisc_EVE
     foreign key (id_evento)
     references EVENTO;

alter table LIKE add constraint FKeffettuazione
     foreign key (username)
     references UTENTE;

alter table LIKE add constraint FKa
     foreign key (id_post)
     references POST;

alter table LOGIN add constraint FKlogin_FK
     foreign key (username)
     references UTENTE;

alter table MEDIA add constraint IDMEDIA_CHK
     check(exists(select * from POST
                  where POST.id_media = id_media)); 

alter table partecipazione add constraint FKpar_COM
     foreign key (id_compagnia)
     references COMPAGNIA;

alter table partecipazione add constraint FKpar_UTE
     foreign key (username_membro)
     references UTENTE;

alter table POST add constraint FKcontenuto_FK
     foreign key (id_media)
     references MEDIA;

alter table POST add constraint FKpubblicazione
     foreign key (username_autore)
     references UTENTE;

alter table UTENTE add constraint IDUTENTE_CHK
     check(exists(select * from LOGIN
                  where LOGIN.username = username)); 
