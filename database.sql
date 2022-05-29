create database riddler;

use riddler;

create table Utenti(
    Username varchar(64) primary key,
    Email varchar(64) unique,
    Nome varchar(64) NOT NULL,
    PasswordHash varchar(255),
    DataNascita date,
    Sesso char,
    GifProfilo varchar(255)
) engine=INNODB;

create table Indovinelli(
    ID integer primary key AUTO_INCREMENT,
    Utente varchar(64),
    Titolo varchar(255) NOT NULL,
    Descrizione varchar(2048) NOT NULL,
    Soluzione varchar(1024),
    Data datetime,
    Stato ENUM('ATTESA', 'ACCETTATO', 'RIFIUTATO') NOT NULL,
    Sorrisi integer NOT NULL,
    NCommenti integer NOT NULL,

    index Utente(Utente),
    foreign key(Utente) references Utenti(Username) on delete set null on update cascade
) engine=INNODB;

create table Commenti(
    ID integer primary key AUTO_INCREMENT,
    Utente varchar(64),
    Indovinello integer,
    Testo varchar(2048) NOT NULL,
    Data datetime,
    Sorrisi integer NOT NULL,

    index Utente(Utente),
    index Indovinello(Indovinello),
    foreign key(Utente) references Utenti(Username) on delete cascade on update cascade,
    foreign key(Indovinello) references Indovinelli(ID) on delete cascade on update cascade
) engine=INNODB;

create table Sorrisi(
    Utente varchar(64),
    Commento integer,
    Data datetime,

    primary key(Utente, Commento),

    index Utente(Utente),
    index Commento(Commento),
    foreign key(Utente) references Utenti(Username) on delete cascade on update cascade,
    foreign key(Commento) references Commenti(ID) on delete cascade on update cascade
) engine=INNODB;

create table Notifiche(
    ID integer primary key AUTO_INCREMENT,
    Utente varchar(64),
    Testo integer,
    Data date,

    index Utente(Utente),
    foreign key(Utente) references Utenti(Username) on delete cascade on update cascade
) engine=INNODB;

delimiter //
create trigger addSorriso
after insert on Sorrisi
for each row
begin
    update Indovinelli set Sorrisi=Sorrisi+1 where ID=(select Indovinello from Commenti where new.Commento = ID LIMIT 1);
    update Commenti set Sorrisi=Sorrisi+1 where new.Commento = ID;
end //
delimiter ;

delimiter //
create trigger removeSorriso
after delete on Sorrisi
for each row
begin
    update Indovinelli set Sorrisi=Sorrisi-1 where ID=(select Indovinello from Commenti where old.Commento = ID LIMIT 1);
    update Commenti set Sorrisi=Sorrisi-1 where old.Commento = ID;
end //
delimiter ;

delimiter //
create trigger addCommento
after insert on Commenti
for each row
begin
    update Indovinelli set NCommenti=NCommenti+1 where ID = new.Indovinello;
end //
delimiter ;

-- delimiter //
-- create trigger addNotificaCommento
-- after insert on Commenti
-- for each row
-- begin
--     TODO;
-- end //
-- delimiter ;