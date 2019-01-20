# -*- coding: utf-8 -*-
"""This is the class definition module for EtuDers"""
import os

import ssl
import json
import requests
import re
import urllib2
import urllib3

from datetime import datetime

from etudersweb import application
from etudersDB import db, Ogrenci, DersKayit, DersBilgi

from sqlalchemy import cast, String

urllib3.disable_warnings()
Context = ssl._create_unverified_context()
Basedir = os.path.abspath(os.path.dirname(__file__))



# Okulun sitesinden ders programları listesini elde eder, bunu yaparken oturum noyu kullanır.
def dersListesiAl():
    params = dict(
        dil='tr',
        oturumNo=oturum.getOturumNo()
    )
    headers = {
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36",
        "accept": "application/json, text/plain, */*",
        "accept-language": "tr-TR,tr;q = 0.9,en-US;q = 0.8,en;q = 0.7"
    }
    dersListUrl = 'https://program.etu.edu.tr/DersProgrami/api/ders/getlist/'
    dersListesi = requests.get(
        url=dersListUrl, params=params, headers=headers).json()
    return dersListesi

def dersBilgisiAl(dersid, subeno):
    params = dict(
        dil='tr',
        oturumNo=oturum.getOturumNo()
    )
    headers = {"User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36",
                "accept": "application/json, text/plain, */*", "accept-language": "tr-TR,tr;q = 0.9,en-US;q = 0.8,en;q = 0.7"}
    dersUrl = 'https://program.etu.edu.tr/DersProgrami/api/dersprogramplan/dersProgram/' + \
        str(dersid)+'/'+str(subeno)
    ders = requests.get(url=dersUrl, params=params, headers=headers).json()
    return ders

def dersAdiAl(dersid):
    params = dict(
        dil='tr',
        oturumNo=oturum.getOturumNo()
    )
    headers = {"User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36",
                "accept": "application/json, text/plain, */*", "accept-language": "tr-TR,tr;q = 0.9,en-US;q = 0.8,en;q = 0.7"}
    dersAdiUrl = 'https://program.etu.edu.tr/DersProgrami/api/ders/get/' + \
            str(dersid)
    dersadi = requests.get(
            url=dersAdiUrl, params=params, headers=headers).json()
    return dersadi

def subeListesiAl(dersid, subeno):
    params = dict(
        dil='tr',
        oturumNo=oturum.getOturumNo()
    )
    headers = {
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36",
        "accept": "application/json, text/plain, */*",
        "accept-language": "tr-TR,tr;q = 0.9,en-US;q = 0.8,en;q = 0.7"
    }
    subeListesiUrl = 'https://program.etu.edu.tr/DersProgrami/api/sube/ogrencilist/' + \
        str(dersid)+'/'+str(subeno)
    
    subeListesi = requests.get(
        url=subeListesiUrl, params=params, headers=headers).json()
    return subeListesi

def fetchAndUpdateDB():
    db.create_all()
    dersListesi=dersListesiAl()
    for dersno in dersListesi:
        dersBilgisi=dersAdiAl(dersno['DersID'])
        checkDersRecordExist(dersBilgisi)
        subeListesi=subeListesiAl(dersno['DersID'], 0)
        for subeBilgisi in subeListesi:
            for ogrenciBilgisi in subeBilgisi['Ogrenci']:
                checkOgrenciRecordExist(ogrenciBilgisi)
                addRowIntoDersKayit(ogrenciBilgisi['OgrenciNo'], dersno['DersID'], subeBilgisi['SubeNo'])

def checkDersRecordExist(dersBilgisi):
    if db.session.query(DersBilgi.dersId).filter_by(dersId=cast(dersBilgisi['DersID'], String)).scalar() is None:
        db.session.add(DersBilgi(dersId=dersBilgisi['DersID'], 
            dersAdi=dersBilgisi['DersAdi'], 
            dersKodu=dersBilgisi['DersKodu'], 
            oKodu=dersBilgisi['OptikKodu'], 
            kisaAdi=dersBilgisi['DersKisaAdi']))
        db.session.commit()

def checkOgrenciRecordExist(ogrenciBilgisi):
    if db.session.query(Ogrenci.ogrenciNo).filter_by(ogrenciNo=ogrenciBilgisi['OgrenciNo']).scalar() is None:
        db.session.add(Ogrenci(ogrenciNo=ogrenciBilgisi['OgrenciNo'], 
            ad=ogrenciBilgisi['Ad'], 
            soyad=ogrenciBilgisi['Soyad'], 
            birimAdi=ogrenciBilgisi['BirimAdi'], 
            programAdi=ogrenciBilgisi['ProgramAdi'], 
            sinif=ogrenciBilgisi['Sinif'], 
            mail=ogrenciBilgisi['Mail']))
        db.session.commit()

def addRowIntoDersKayit(ogrenciNo, dersNo, subeNo):
    db.session.add(
        DersKayit(ogrNo=ogrenciNo, 
            dersId=dersNo, 
            subeNo=subeNo))
    db.session.commit()

class Oturum:
    def __init__(self):
        requests.Session().close()
        self.session = requests.Session()

        self.oturumAktif = False
        self.oturumNo = self.getOturumNo()

    # oturum noyu elde etme fonksiyonu, burada öncelikle oturum noyu kontrol ederek hala geçerli olup olmadığını kontrol ederiz.
    def getOturumNo(self):
        self.oturumKontrolEt()
        if not self.oturumAktif:
            self.oturumGuncelle()
        return self.oturumNo
    # mevcut oturum kontrol edilir, bunu yapabilmek için de 0413 sayfasına request atıp, bizi yönlendirdiği sayfanın ders programı sayfası olup olmadığına bakılmaktadır.
    # eğer ders programı sayfasına yönlendirmiyorsa, mevcut login sessionımız bitmiş demektir, oturum aktif false yapılır.

    def oturumKontrolEt(self):
        self.oturumAktif = False
        headersGet = {"User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36",
                      "accept": "text/html,application/xhtml+xml,application/xml;q = 0.9,image/webp,image/apng,*/*;q = 0.8", "accept-language": "tr-TR,tr;q = 0.9,en-US;q = 0.8,en;q = 0.7", "cache-control": "max-age = 0", "upgrade-insecure-requests": "1"}
        r = self.session.get(
            'https://ubs.etu.edu.tr/Ogrenci/Ogr0413/Default.aspx?lang = tr-TR', headers=headersGet, verify=False)
        # Login yapılmış durumda
        if re.search(r'https:\/\/program\.etu\.edu\.tr\/DersProgrami\/\?oturumNo=(.*)', r.url) is not None:
            self.oturumNo = re.search(
                r'https:\/\/program\.etu\.edu\.tr\/DersProgrami\/\?oturumNo=(.*)', r.url).group(1)
            self.oturumAktif = True

            #print('Login session resumed.')

    # Ubs sistemine giriş yapılır
    def oturumGuncelle(self):
        req = urllib2.Request('https://ubs.etu.edu.tr/')
        response = urllib2.urlopen(req, context=Context)
        the_page = response.read()

        viewstate = re.search(
            r'<input .* id="__VIEWSTATE".* value="(.*)".*\/>', the_page).group(1)
        viewstategenerator = re.search(
            r'<input .* id="__VIEWSTATEGENERATOR".* value="(.*)".*\/>', the_page).group(1)
        eventvalidation = re.search(
            r'<input .* id="__EVENTVALIDATION".* value="(.*)".*\/>', the_page).group(1)

        payload = {
            '__EVENTTARGET': '',
            '__EVENTARGUMENT': '',
            '__VIEWSTATE': viewstate,
            '__VIEWSTATEGENERATOR': viewstategenerator,
            '__EVENTVALIDATION': eventvalidation,
            'txtLogin': os.environ['txtLogin'],
            'txtPassword': os.environ['txtPassword'],
            'btnLogin': 'Giriş'
        }

        self.session.cookies.clear()
        headers = {"User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36", "accept": "text/html,application/xhtml+xml,application/xml;q = 0.9,image/webp,image/apng,*/*;q = 0.8",
                   "accept-language": "tr-TR,tr;q = 0.9,en-US;q = 0.8,en;q = 0.7", "cache-control": "max-age = 0", "content-type": "application/x-www-form-urlencoded", "upgrade-insecure-requests": "1"}
        p = self.session.post(
            'https://ubs.etu.edu.tr/login.aspx?lang = tr-TR', data=payload, headers=headers)

        if p.status_code == 200:
            if not p.history:
                # Login failed
                print('Login failed.')
            else:
                # Login success
                print('Login success.')
                headersGet = {"User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36",
                              "accept": "text/html,application/xhtml+xml,application/xml;q = 0.9,image/webp,image/apng,*/*;q = 0.8", "accept-language": "tr-TR,tr;q = 0.9,en-US;q = 0.8,en;q = 0.7", "cache-control": "max-age = 0", "upgrade-insecure-requests": "1"}
                r = self.session.get(
                    'https://ubs.etu.edu.tr/Ogrenci/Ogr0413/Default.aspx?lang = tr-TR', headers=headersGet)
                print(r.url)

                self.oturumNo = re.search(
                    r'https:\/\/program\.etu\.edu\.tr\/DersProgrami\/\?oturumNo=(.*)', r.url).group(1)
                self.oturumAktif = True
                return

        else:
            print("Login status code error, status code: " +
                  p.status_code+", headers: "+p.headers)

        self.oturumAktif = False
oturum=Oturum()
class Ders:
    def __init__(self, dersid, subeno):
        # Okulun sitesinden ders program ve ders bilgisi sayfalarından ilgili dersin bilgisini çeker.
        ders = dersBilgisiAl(dersid, 0)
        dersadi = dersAdiAl(dersid)
        self.derskodu = dersadi['DersKodu']
        self.dersAdi = dersadi['DersAdi']
        self.Subeler = list()
        for subeler in ders:
            self.Subeler.append(Sube(
                subeler['SubeNo'], subeler['OgretimUyesi'], subeler['DersProgramPlan'], self.derskodu))

class Plan:
    def __init__(self):
        self.grid = [[list() for _ in range(6)] for _ in range(13)]
        self.saatsayisi = 0
        self.cakismasayisi = 0

    def __str__(self):
        return json.dumps(self.grid)

    def subeEkle(self, sube):
        for saat in sube.Saatler:
            d = datetime.strptime(saat.bas, '%H:%M:%S')
            saatindeks = 0
            saatindeks = d.hour-8
            gunindeks = saat.gun-1
            if saat.yer[0] != "-":
                self.grid[saatindeks][gunindeks].append(saat)
                self.saatsayisi = self.saatsayisi+1
        self.cakismaHesapla()

    def cakismaHesapla(self):
        self.cakismasayisi = 0
        for i in range(13):
            for j in range(6):
                if self.grid[i][j]:
                    if len(self.grid[i][j]) > 1:
                        self.cakismasayisi = self.cakismasayisi+1

class Saat:
    def __init__(self, bas, bit, gun, yer, subeno, dersno):
        self.bas = bas
        self.bit = bit
        self.gun = gun
        self.yer = yer
        self.subeno = subeno
        self.dersno = dersno

    def __repr__(self):
        return self.dersno+"-"+str(self.subeno)

class Sube:
    def __init__(self, subeno, hoca, saatler, derskodu):
        self.Saatler = list()
        self.DersNo = derskodu
        self.SubeNo = subeno
        self.DersKodu = derskodu
        self.OgretimUyesi = hoca
        for sube in saatler:
            for saat in sube['OgrenciDersProgram']:
                if saat['DersKoduList'][0]:
                    self.Saatler.append(Saat(
                        saat['Baslangic'], saat['Bitis'], saat['Gun'], saat['DersKoduList'], self.SubeNo, self.DersKodu))
                elif saat['DersKodu'] and saat['DersKodu'] != "-":
                    self.Saatler.append(Saat(
                        saat['Baslangic'], saat['Bitis'], saat['Gun'], saat['DersKoduList'], self.SubeNo, saat['DersKodu']))
