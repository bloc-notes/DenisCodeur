use BD4B4Guelleh

drop table PHPCoursSession, PHPSession, PHPDocument, PHPCategorie, PHPUtilisateur, PHPCours

create table PHPCours (
	sigleCours varchar(7) constraint PK_sigleCours primary key,
	titre varchar(50),
	nomProf varchar(50)
)

create table PHPUtilisateur(
	--id int constraint PK_idUser primary key,
	nomUtilisateur varchar(25) constraint PK_idUser primary key,
	motDePasse varchar(15),
	statutAdmin bit,
	nomComplet varchar(30),
	courriel varchar(50)
)

create table PHPCategorie (
	description varchar(15) constraint PK_cat primary key
)

create table PHPDocument( 
	session varchar(6),
	sigleCours varchar(7) constraint FK_sigleCoursDoc foreign key references PHPCours(sigleCours),
	dateCours smalldatetime,
	noSequence int,
	dateAccesDebut smalldatetime,
	dateAccesFin smalldatetime,
	titre varchar(100),
	description varchar(255),
	nbPages int,
	cat varchar(15) constraint FK_cat foreign key references PHPCategorie(description),
	noVersion int,
	dateVersion smalldatetime,
	hyperLien varchar(255),
	ajoutePar varchar(25) constraint FK_idUserDoc foreign key references PHPUtilisateur(nomUtilisateur),
	Suppression int 
)

create table PHPSession(
	description varchar(6) constraint PK_session primary key,
	dateDebut smalldatetime,
	dateFin smalldatetime
)

create table PHPCoursSession(
	session varchar(6) constraint FK_session foreign key references PHPSession(description),
	cours varchar(7) constraint FK_sigleCoursSession foreign key references PHPCours(sigleCours),
	prof varchar(25) constraint FK_idUserCoursSession foreign key references PHPUtilisateur(nomUtilisateur)
)

insert into PHPCours (sigleCours, titre, nomProf) values ('420-4W5', 'Web Serveur', 1)
insert into PHPUtilisateur (nomUtilisateur, nomUtilisateur, motDePasse, statutAdmin, nomComplet, courriel) values (1, 'test', '123', 1, 'LM-Brousseau', 'test@cgodin.qc.ca')
insert into PHPCategorie (description) values ('Projet')
insert into PHPDocument (session, sigleCours, dateCours, noSequence, dateAccesDebut, dateAccesFin, titre, description, nbPages, cat, noVersion, dateVersion, hyperLien, ajoutePar) 
				values ('H-2018', '420-4W5', '2018-03-23', 1, '2018-03-23', '2018-05-18', 'Énoncé', 'Description', 21, 'Projet', 1, '2018-03-23', '25(...).pdf', 1)
insert into PHPSession (description, dateDebut, dateFin) values ('H-2018', '2018-01-22', '2018-05-30')
insert into PHPCoursSession (session, cours, prof) values ('H-2018', '420-4W5', 1)

select * from PHPSession