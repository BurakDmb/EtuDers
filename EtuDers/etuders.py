# -*- coding: utf-8 -*-
"""This is the main module of the app EtuDers, it has functions to calculate alternative timetables."""


import os
import json
from copy import deepcopy
from datetime import datetime
import requests
from etudersDB import getDb, LoggingEnabled, Log, OgrenciLog, Ogrenci, DersBilgi, DersKayit
from etudersUtil import Ders, Plan, oturum
import sys
reload(sys)
sys.setdefaultencoding('utf8')



# Oturum classı, bu class sayesinde her sorgu sırasında tekrar okulun sistemine giriş yapmak yerine mevcut session'ı
# ve oturum nonun kullanılması sağlanır.





def programOlustur(derslistesi, limit, ipAdres):
    dersler = list()
    for dersno in derslistesi:
        dersler.append(Ders(dersno, 0))  # 0 tum subeler icin
    if LoggingEnabled:
        getDb().session.add(Log(dersId=', '.join(map(str, derslistesi)) , ip=ipAdres))
        getDb().session.commit()
    return sorted(alternatifProgramlariHesapla(dersler, 0, [Plan()], limit), key=lambda r: r.cakismasayisi)


# Recursion ders programlarını hesaplama fonksiyonu
def alternatifProgramlariHesapla(dersListesi, mevcutDersIndex, mevcutProgram, limit):
    if len(dersListesi) == mevcutDersIndex:
        return mevcutProgram
    tmpList = list()
    for i in range(len(mevcutProgram)):
        for j in range(len(dersListesi[mevcutDersIndex].Subeler)):
            tmpPlan = deepcopy(mevcutProgram[i])
            tmpPlan.subeEkle(dersListesi[mevcutDersIndex].Subeler[j])
            if tmpPlan.cakismasayisi <= limit:  # eğer hesaplanan ders programının cakışma sayısı limiti aştı ise bunu listeye eklemiyoruz ve listeyi birazcık optimize etmiş oluyoruz, gereksiz programları hesaplamayarak
                tmpList.append(tmpPlan)
    mevcutProgram = tmpList
    return alternatifProgramlariHesapla(dersListesi, mevcutDersIndex+1, mevcutProgram, limit)


def ogrenciDersProgramiGetir(ogrenciNo, ipAdres):
    dersListesi = getDb().session.query(Ogrenci.ogrenciNo).filter_by(ogrenciNo=ogrenciNo).all
    #exists = Db.session.query(Ogrenci.ogrenciNo).filter_by(name=ogrenciNo).scalar() is not None
    dersler = list()
    program = Plan()
    for dersKayit in dersListesi:
        program.subeEkle(Ders(dersKayit.dersid, dersKayit.subeno).Subeler[0])  # 0 tum subeler icin
    if LoggingEnabled:
        getDb().session.add(OgrenciLog(ogrenciNo=ogrenciNo , ip=ipAdres))
        getDb().session.commit()
    return program


# Eski fonksiyon, artık kullanılmıyor
def cakismali(program, limit):
    uygunOlanlar = list()
    for a in range(limit+1):
        for j in range(len(program)):
            if program[j].cakismasayisi == a:
                uygunOlanlar.append(program[j])
    return uygunOlanlar

