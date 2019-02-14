# -*- coding: utf-8 -*-
"""This is the Db module for EtuDers"""
from etudersweb import getDB
from datetime import datetime

db=getDB()
LoggingEnabled = True

class Log(db.Model):
    __bind_key__ = 'db2'
    id = db.Column(db.Integer, primary_key=True)
    dersId = db.Column(db.Text, nullable=False)
    ip = db.Column(db.Text, nullable=False)
    date = db.Column(db.DateTime, nullable=False, default=datetime.utcnow)

    def __repr__(self):
        return '<DersID: %r, IP: %r, Date: %r>' % self.dersId, self.ip, self.date

class OgrenciLog(db.Model):
    __bind_key__ = 'db2'
    id = db.Column(db.Integer, primary_key=True)
    ogrenciNo = db.Column(db.Text, nullable=False)
    ip = db.Column(db.Text, nullable=False)
    date = db.Column(db.DateTime, nullable=False, default=datetime.utcnow)

    def __repr__(self):
        return '<OgrenciNo: %r, IP: %r, Date: %r>' % self.ogrenciNo, self.ip, self.date

class Ogrenci(db.Model):
    __bind_key__ = 'db1'
    id = db.Column(db.Integer, primary_key=True)
    ogrenciNo = db.Column(db.Text, nullable=False)
    ad = db.Column(db.Text)
    soyad = db.Column(db.Text)
    birimAdi = db.Column(db.Text)
    programAdi = db.Column(db.Text)
    sinif = db.Column(db.Text)
    mail = db.Column(db.Text)

    def __repr__(self):
            return '<OgrenciNo: %r, Ad: %r,  Soyad: %r,  BirimAdi: %r,  ProgramAdi: %r,  Sinif: %r,  Mail: %r>' % self.ogrenciNo, self.ad, self.soyad, self.birimAdi, self.programAdi, self. sinif, self.mail


class DersBilgi(db.Model):
    __bind_key__ = 'db1'
    id = db.Column(db.Integer, primary_key=True)
    dersId = db.Column(db.Text, nullable=False)
    dersAdi = db.Column(db.Text)
    dersKodu = db.Column(db.Text)
    oKodu = db.Column(db.Text)
    kisaAdi = db.Column(db.Text)

    def __repr__(self):
        return '<DersId: %r, DersAdi: %r,  DersKodu: %r,  DersOKodu: %r,  DersKisaAdi: %r>' % (self.dersId, self.dersAdi, self.dersKodu, self.oKodu, self.kisaAdi)

class DersKayit(db.Model):
    __bind_key__ = 'db1'
    id = db.Column(db.Integer, primary_key=True)
    ogrNo = db.Column(db.Text, nullable=False)
    dersId = db.Column(db.Text)
    subeNo = db.Column(db.Text)

    def __str__(self):
        return '<OgrNo: %r, DersId: %r,  SubeNo: %r>' % (self.ogrNo, self.dersId, self.subeNo)
