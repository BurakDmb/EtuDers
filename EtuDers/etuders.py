# -*- coding: utf-8 -*-
"""This is the main module of the app EtuDers, it has functions to calculate alternative timetables."""


from copy import deepcopy
from etudersDB import db, LoggingEnabled, Log, OgrenciLog
from etudersUtil import Plan, ogrenciDersProgramSorgula, ogrenciAraSinavListele, dersAl
import sys
reload(sys)
sys.setdefaultencoding('utf8')



# Oturum classı, bu class sayesinde her sorgu sırasında tekrar okulun sistemine giriş yapmak yerine mevcut session'ı
# ve oturum nonun kullanılması sağlanır.





def programOlustur(derslistesi, limit, ipAdres):
    dersler = list()
    for dersno in derslistesi:
        dersler.append(dersAl(dersno, 0, True))  # 0 tum subeler icin
    if LoggingEnabled:
        db.session.add(Log(dersId=', '.join(map(str, derslistesi)), ip=ipAdres))
        db.session.commit()
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
    dersListesi = ogrenciDersProgramSorgula(ogrenciNo)
    program = Plan()
    for dersKayit in dersListesi:
        program.subeEkle(dersAl(dersKayit.dersId, dersKayit.subeNo).Subeler[0])
    if LoggingEnabled:
        db.session.add(OgrenciLog(ogrenciNo=ogrenciNo, ip=ipAdres))
        db.session.commit()
    return program



def ogrenciSinavProgramiGetir(ogrenciNo, ipAdres):
    sinavListesi = ogrenciAraSinavListele(ogrenciNo)
    # if LoggingEnabled:
    #    db.session.add(OgrenciLog(ogrenciNo=ogrenciNo, ip=ipAdres))
    #    db.session.commit()
    return sinavListesi

# Eski fonksiyon, artık kullanılmıyor
def cakismali(program, limit):
    uygunOlanlar = list()
    for a in range(limit+1):
        for j in range(len(program)):
            if program[j].cakismasayisi == a:
                uygunOlanlar.append(program[j])
    return uygunOlanlar
