# -*- coding: utf-8 -*-
import sys
reload(sys)
sys.setdefaultencoding('utf8')
from datetime import datetime
from copy import deepcopy
from flask_sqlalchemy import SQLAlchemy
from etudersweb import application

import urllib2
import urllib3
urllib3.disable_warnings()
import re
import requests
import json
import os
import ssl
context = ssl._create_unverified_context()
basedir = os.path.abspath(os.path.dirname(__file__))

application.config['SQLALCHEMY_DATABASE_URI'] = os.environ['DATABASE_URL']
db=SQLAlchemy(application)

class Log(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    dersId = db.Column(db.String(6), nullable=False)
    ip = db.Column(db.String(16), nullable=False)
    date = db.Column(db.DateTime, nullable=False, default=datetime.utcnow)

    def __repr__(self):
        return '<DersID: %r, IP: %r, Date: %r>' % self.dersId, self.ip, self.date




#Oturum classı, bu class sayesinde her sorgu sırasında tekrar okulun sistemine giriş yapmak yerine mevcut session'ı ve oturum nonun kullanılması sağlanır.
class Oturum:

    def __init__(self):
        requests.Session().close()
        self.session=requests.Session()

        self.oturumAktif=False
        self.oturumNo=self.getOturumNo()

    #oturum noyu elde etme fonksiyonu, burada öncelikle oturum noyu kontrol ederek hala geçerli olup olmadığını kontrol ederiz.    
    def getOturumNo(self):
        self.oturumKontrolEt()
        if not self.oturumAktif:
            self.oturumGuncelle()
        return self.oturumNo
    #mevcut oturum kontrol edilir, bunu yapabilmek için de 0413 sayfasına request atıp, bizi yönlendirdiği sayfanın ders programı sayfası olup olmadığına bakılmaktadır.
    #eğer ders programı sayfasına yönlendirmiyorsa, mevcut login sessionımız bitmiş demektir, oturum aktif false yapılır.
    def oturumKontrolEt(self):
        self.oturumAktif=False
        headersGet= {"User-Agent":"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36","accept":"text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8","accept-language":"tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7","cache-control":"max-age=0","upgrade-insecure-requests":"1"}
        r = self.session.get('https://ubs.etu.edu.tr/Ogrenci/Ogr0413/Default.aspx?lang=tr-TR',headers=headersGet, verify=False)
        #Login yapılmış durumda
        if re.search(r'https:\/\/program\.etu\.edu\.tr\/DersProgrami\/\?oturumNo=(.*)', r.url) is not None:
            self.oturumNo=re.search(r'https:\/\/program\.etu\.edu\.tr\/DersProgrami\/\?oturumNo=(.*)', r.url).group(1)
            self.oturumAktif=True
            
            #print('Login session resumed.')
    
    #Ubs sistemine giriş yapılır
    def oturumGuncelle(self):
        req = urllib2.Request('https://ubs.etu.edu.tr/')
        response = urllib2.urlopen(req, context=context)
        the_page = response.read()

        viewstate=re.search(r'<input .* id="__VIEWSTATE".* value="(.*)".*\/>', the_page).group(1)
        viewstategenerator=re.search(r'<input .* id="__VIEWSTATEGENERATOR".* value="(.*)".*\/>', the_page).group(1)
        eventvalidation=re.search(r'<input .* id="__EVENTVALIDATION".* value="(.*)".*\/>', the_page).group(1)

        
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
        headers = {"User-Agent":"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36","accept":"text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8","accept-language":"tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7","cache-control":"max-age=0","content-type":"application/x-www-form-urlencoded","upgrade-insecure-requests":"1"}
        p = self.session.post('https://ubs.etu.edu.tr/login.aspx?lang=tr-TR', data=payload, headers=headers)
        
        
        if p.status_code==200:
            if not p.history:
                #Login failed
                print('Login failed.')
            else:
                #Login success
                print('Login success.')
                headersGet= {"User-Agent":"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36","accept":"text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8","accept-language":"tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7","cache-control":"max-age=0","upgrade-insecure-requests":"1"}
                r = self.session.get('https://ubs.etu.edu.tr/Ogrenci/Ogr0413/Default.aspx?lang=tr-TR',headers=headersGet)
                print(r.url)
                
                self.oturumNo=re.search(r'https:\/\/program\.etu\.edu\.tr\/DersProgrami\/\?oturumNo=(.*)', r.url).group(1)
                self.oturumAktif=True
                return

        else:
            print("Login status code error, status code: "+p.status_code+", headers: "+p.headers)
            
        self.oturumAktif=False
oturum=Oturum()
class Ders:
    def __init__(self,dersid, subeno):
        params = dict(
            dil='tr',
            oturumNo=oturum.getOturumNo()
        )
        headers = {"User-Agent":"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36","accept":"application/json, text/plain, */*","accept-language":"tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7"}
        dersUrl = 'https://program.etu.edu.tr/DersProgrami/api/dersprogramplan/dersProgram/'+str(dersid)+'/'+str(subeno)
        dersAdiUrl = 'https://program.etu.edu.tr/DersProgrami/api/ders/get/'+str(dersid)
        #Okulun sitesinden ders program ve ders bilgisi sayfalarından ilgili dersin bilgisini çeker.
        ders = requests.get(url=dersUrl, params=params, headers=headers).json()
        dersadi = requests.get(url=dersAdiUrl, params=params, headers=headers).json()
        self.derskodu=dersadi['DersKodu']
        self.dersAdi=dersadi['DersAdi']
        self.Subeler=list()
        for subeler in ders:
            self.Subeler.append(Sube(subeler['SubeNo'], subeler['OgretimUyesi'], subeler['DersProgramPlan'], self.derskodu))
class Plan:
    def __init__(self):
        self.grid = [[list() for _ in range(6)] for _ in range(13)]
        self.saatsayisi=0
        self.cakismasayisi=0

    def __str__(self):
        return json.dumps(self.grid)

    def subeEkle(self, sube):
        for saat in sube.Saatler:
            d = datetime.strptime(saat.bas, '%H:%M:%S')
            saatindeks=0
            saatindeks=d.hour-8
            gunindeks= saat.gun-1
            if saat.yer[0]!="-":
                self.grid[saatindeks][gunindeks].append(saat)
                self.saatsayisi=self.saatsayisi+1
        self.cakismaHesapla()
        
    def cakismaHesapla(self):
        self.cakismasayisi=0
        for i in range(13):
            for j in range(6):
                if self.grid[i][j]:
                    if len(self.grid[i][j])>1:
                        self.cakismasayisi=self.cakismasayisi+1
class Saat:
    def __init__(self, bas, bit, gun, yer, subeno, dersno):
        self.bas=bas
        self.bit=bit
        self.gun=gun
        self.yer=yer
        self.subeno=subeno
        self.dersno=dersno
    def __repr__(self):
        return self.dersno+"-"+str(self.subeno)
class Sube:
    def __init__(self, subeno, hoca, saatler, derskodu):
        self.Saatler=list()
        self.DersNo=derskodu
        self.SubeNo=subeno
        self.DersKodu=derskodu
        self.OgretimUyesi=hoca
        for sube in saatler:
            for saat in sube['OgrenciDersProgram']:
                if saat['DersKoduList'][0]:
                    self.Saatler.append(Saat(saat['Baslangic'], saat['Bitis'], saat['Gun'], saat['DersKoduList'], self.SubeNo, self.DersKodu))
                elif saat['DersKodu'] and saat['DersKodu']!="-":
                    self.Saatler.append(Saat(saat['Baslangic'], saat['Bitis'], saat['Gun'], saat['DersKoduList'], self.SubeNo, saat['DersKodu']))

def programOlustur(derslistesi ,limit, ipAdres):
    dersler=list()
    for dersno in derslistesi:
        dersler.append(Ders(dersno,0)) #0 tum subeler icin
        db.session.add(Log(dersId=dersno, ip=ipAdres))
    db.session.commit()    
    return alternatifProgramlariHesapla(dersler, 0, [Plan()], limit)


#Recursion ders programlarını hesaplama fonksiyonu
def alternatifProgramlariHesapla(dersListesi, mevcutDersIndex, mevcutProgram, limit):
    if len(dersListesi)==mevcutDersIndex:
        return mevcutProgram
    tmpList=list()
    for i in range(len(mevcutProgram)):
        for j in range(len(dersListesi[mevcutDersIndex].Subeler)):
            tmpPlan=deepcopy(mevcutProgram[i])
            tmpPlan.subeEkle(dersListesi[mevcutDersIndex].Subeler[j])
            if tmpPlan.cakismasayisi<=limit:    #eğer hesaplanan ders programının cakışma sayısı limiti aştı ise bunu listeye eklemiyoruz ve listeyi birazcık optimize etmiş oluyoruz, gereksiz programları hesaplamayarak
                tmpList.append(tmpPlan)
    mevcutProgram=tmpList
    return alternatifProgramlariHesapla(dersListesi, mevcutDersIndex+1, mevcutProgram, limit)

#Eski fonksiyon, artık kullanılmıyor
def cakismali(program, limit):
    uygunOlanlar=list()
    for a in range(limit+1):
        for j in range(len(program)):
            if program[j].cakismasayisi==a:
                uygunOlanlar.append(program[j])
    return uygunOlanlar

#Okulun sitesinden ders programları listesini elde eder, bunu yaparken oturum noyu kullanır.
def dersListesiAl():
    params = dict(
            dil='tr',
            oturumNo=oturum.getOturumNo()
        )
    headers = {"User-Agent":"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36","accept":"application/json, text/plain, */*","accept-language":"tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7"}
    dersListUrl = 'https://program.etu.edu.tr/DersProgrami/api/ders/getlist/'
    dersListesi = requests.get(url=dersListUrl, params=params, headers=headers).json()
    return dersListesi
