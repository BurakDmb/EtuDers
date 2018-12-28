# -*- coding: utf-8 -*-

import sys
reload(sys)
sys.setdefaultencoding('utf8')
from flask import Flask, render_template, request, jsonify, Response
application = Flask(__name__)

from etuders import Ders, programOlustur, cakismali, dersListesiAl
import json
import os
basedir = os.path.abspath(os.path.dirname(__file__))
from datetime import datetime
from flask_sqlalchemy import SQLAlchemy




@application.route("/")
def hello():
    
    return render_template('Layout.html',dersListesi=dersListesiAl())


@application.route('/programhesapla/', methods=['POST'])
def programhesapla():
    #request.form.keys()[0]
    
    derslistesi=request.form.getlist('derslistesi[]')
    cakisma=request.form.get('cakisma')
    cakismalimit=cakisma
    if not cakisma:
        cakismalimit=2
    ipAdres=request.remote_addr
    programlar=programOlustur(derslistesi,cakismalimit,ipAdres)
    #cakismaResult=cakismali(programlar,cakismalimit)
    return Response(json.dumps([sonuc.__dict__ for sonuc in programlar], default=str))

@application.route("/test1")
def hello1():
    #tmpders=Ders(31970,0)
    #print(tmpders.dersAdi, tmpders.derskodu)
    #return tmpders.dersAdi+', '+tmpders.derskodu
    dersler=[Ders(31970,0), Ders(40281,0)]
    programlar=programOlustur(dersler,2,"")
    sonuclar=cakismali(programlar,2)
    return Response(json.dumps([sonuc.__dict__ for sonuc in sonuclar], default=str), mimetype='application/json')

if __name__ == "__main__":
    application.run(host='0.0.0.0')