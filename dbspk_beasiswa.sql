/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     21/10/2019 17:41:34                          */
/*==============================================================*/


drop table if exists KRITERIA;

drop table if exists NILAI;

drop table if exists RANGE;

drop table if exists SISWA;

/*==============================================================*/
/* Table: KRITERIA                                              */
/*==============================================================*/
create table KRITERIA
(
   ID_KRITERIA          int not null,
   NAMA_KRITERIA        varchar(100),
   ATRIBUT              char(1),
   BOBOT                float,
   primary key (ID_KRITERIA)
);

/*==============================================================*/
/* Table: NILAI                                                 */
/*==============================================================*/
create table NILAI
(
   ID_RANGE             int not null,
   NIS                  char(6) not null,
   NORMALISASI          float,
   HASIL                float,
   primary key (ID_RANGE, NIS)
);

/*==============================================================*/
/* Table: RANGE                                                 */
/*==============================================================*/
create table RANGE
(
   ID_RANGE             int not null,
   ID_KRITERIA          int not null,
   KETERANGAN           varchar(100),
   NILAI                float,
   primary key (ID_RANGE)
);

/*==============================================================*/
/* Table: SISWA                                                 */
/*==============================================================*/
create table SISWA
(
   NIS                  char(6) not null,
   NAMA_SISWA           varchar(200),
   JENIS_KELAMIN        char(1),
   ALAMAT               text,
   PEKERJAAN_ORANGTUA   varchar(100),
   PENGHASILAN_ORANGTUA float,
   JUMLAH_SAUDARA       int,
   primary key (NIS)
);

alter table NILAI add constraint FK_NILAI foreign key (ID_RANGE)
      references RANGE (ID_RANGE) on delete restrict on update restrict;

alter table NILAI add constraint FK_NILAI2 foreign key (NIS)
      references SISWA (NIS) on delete restrict on update restrict;

alter table RANGE add constraint FK_MEMILIKI foreign key (ID_KRITERIA)
      references KRITERIA (ID_KRITERIA) on delete restrict on update restrict;

