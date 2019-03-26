# -*- coding: utf-8 -*-

from flask import Flask, render_template, request, Response
import json
import os
import sys
from flask_cors import CORS
from flask_sqlalchemy import SQLAlchemy

reload(sys)
sys.setdefaultencoding('utf8')
application=Flask(__name__)
cors = CORS(application, resources={r"/api/*": {"origins": "*"}})
basedir = os.path.abspath(os.path.dirname(__file__))



def checkSystemVariables():
    if 'DATABASE_URL' not in os.environ and 'HEROKU_POSTGRESQL_BROWN_URL' not in os.environ:
        print("You must set system variables DATABASE_URL and HEROKU_POSTGRESQL_BROWN_URL for this program to work!")
        sys.exit(1)
    if 'txtLogin' not in os.environ and 'txtPassword' not in os.environ:
        print("You must set system variables txtLogin and txtPassword for this program to work!")
        sys.exit(1)


checkSystemVariables()
application.config['SQLALCHEMY_DATABASE_URI'] = os.environ['DATABASE_URL']
application.config['SQLALCHEMY_BINDS']={
    'db1': os.environ['DATABASE_URL'],
    'db2': os.environ['HEROKU_POSTGRESQL_BROWN_URL']
}

application.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
db=SQLAlchemy(application)
db.create_all(bind='db1')
db.create_all(bind='db2')




def getDB():
    global db
    if db:
        return db
    else:
        return None



from etudersUtil import dersListesiAl, servisListesiAl, dersBilgisiDump
from etuders import programOlustur, ogrenciDersProgramiGetir, ogrenciSinavProgramiGetir





@application.route("/")
def mainPage():
    return render_template('Layout.html', dersListesi=dersListesiAl())


@application.route('/api/programhesapla/', methods=['POST'])
def programhesapla():
    derslistesi=request.form.getlist('derslistesi[]')
    cakisma=request.form.get('cakisma')
    cakismalimit=cakisma
    if not cakisma:
        cakismalimit=2

    ipadres=request.headers.get('CF-Connecting-IP', request.remote_addr)
    programlar=programOlustur(derslistesi, cakismalimit, ipadres)
    return Response(json.dumps([sonuc.__dict__ for sonuc in programlar], default=str))


@application.route('/api/programsorgula/<ogrenciNo>', methods=['GET'])
def programsorgula(ogrenciNo):
    ipadres=request.headers.get('CF-Connecting-IP', request.remote_addr)
    programlar=ogrenciDersProgramiGetir(ogrenciNo, ipadres)
    return Response(json.dumps(programlar.__dict__, default=str))


@application.route('/api/sinavprogramsorgula/<ogrenciNo>', methods=['GET'])
def sinavprogramsorgula(ogrenciNo):
    ipadres=request.headers.get('CF-Connecting-IP', request.remote_addr)
    programlar=ogrenciSinavProgramiGetir(ogrenciNo, ipadres)
    return Response(json.dumps(programlar, default=str))

@application.route('/api/servissorgula/', methods=['GET'])
def servisprogramsorgula():
    servisListesi=servisListesiAl()
    return Response(json.dumps(servisListesi, default=str))


@application.route('/api/dumpDersler/', methods=['GET'])
def dumpDersler():
    dersBilgisiDump(True)
    return Response()


if __name__ == "__main__":
    application.run(host='0.0.0.0')
