# -*- coding: utf-8 -*-
"""This is the Db module for EtuDers"""
import os
from etudersweb import application

from flask import g
from datetime import datetime
from flask_sqlalchemy import SQLAlchemy

LoggingEnabled = True
application.config['SQLALCHEMY_DATABASE_URI'] = os.environ['DATABASE_URL']
application.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
if not application.config['SQLALCHEMY_DATABASE_URI']:
    LoggingEnabled = False

def getDb():
    with application.app_context():
        if 'Db' not in g:
            g.Db = SQLAlchemy(application)
        return g.Db

class Log(getDb().Model):
    id = getDb().Column(getDb().Integer, primary_key=True)
    dersId = getDb().Column(getDb().String(6), nullable=False)
    ip = getDb().Column(getDb().String(16), nullable=False)
    date = getDb().Column(getDb().DateTime, nullable=False, default=datetime.utcnow)

    def __repr__(self):
        return '<DersID: %r, IP: %r, Date: %r>' % self.dersId, self.ip, self.date

class OgrenciLog(getDb().Model):
    id = getDb().Column(getDb().Integer, primary_key=True)
    ogrenciNo = getDb().Column(getDb().String(6), nullable=False)
    ip = getDb().Column(getDb().String(16), nullable=False)
    date = getDb().Column(getDb().DateTime, nullable=False, default=datetime.utcnow)

    def __repr__(self):
        return '<OgrenciNo: %r, IP: %r, Date: %r>' % self.ogrenciNo, self.ip, self.date

class Ogrenci(getDb().Model):
    id = getDb().Column(getDb().Integer, primary_key=True)
    ogrenciNo = getDb().Column(getDb().Text, nullable=False)
    ad = getDb().Column(getDb().Text)
    soyad = getDb().Column(getDb().Text)
    birimAdi = getDb().Column(getDb().Text)
    programAdi = getDb().Column(getDb().Text)
    sinif = getDb().Column(getDb().Text)
    mail = getDb().Column(getDb().Text)

    def __repr__(self):
            return '<OgrenciNo: %r, Ad: %r,  Soyad: %r,  BirimAdi: %r,  ProgramAdi: %r,  Sinif: %r,  Mail: %r>' % self.ogrenciNo, self.ad, self.soyad, self.birimAdi, self.programAdi, self. sinif, self.mail

    
class DersBilgi(getDb().Model):
    id = getDb().Column(getDb().Integer, primary_key=True)
    dersId = getDb().Column(getDb().Text, nullable=False)
    dersAdi = getDb().Column(getDb().Text)
    dersKodu = getDb().Column(getDb().Text)
    oKodu = getDb().Column(getDb().Text)
    kisaAdi = getDb().Column(getDb().Text)
    def __repr__(self):
        return '<DersId: %r, DersAdi: %r,  DersKodu: %r,  DersOKodu: %r,  DersKisaAdi: %r>' % self.dersId, self.dersAdi, self.dersKodu, self.oKodu, self.kisaAdi

class DersKayit(getDb().Model):
    id = getDb().Column(getDb().Integer, primary_key=True)
    ogrNo = getDb().Column(getDb().Text, nullable=False)
    dersId = getDb().Column(getDb().Text)
    subeNo = getDb().Column(getDb().Text)
    def __repr__(self):
        return '<OgrNo: %r, DersId: %r,  SubeNo: %r>' % self.ogrNo, self.dersId, self.subeNo


    