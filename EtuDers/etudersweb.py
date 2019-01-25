# -*- coding: utf-8 -*-

from flask import Flask, render_template, request, Response
import json
import os
import sys

reload(sys)
sys.setdefaultencoding('utf8')
application=Flask(__name__)

basedir = os.path.abspath(os.path.dirname(__file__))


from etudersUtil import dersListesiAl
from etuders import programOlustur, ogrenciDersProgramiGetir



@application.route("/")
def mainPage():
    return render_template('Layout.html', dersListesi=dersListesiAl())


@application.route('/programhesapla/', methods=['POST'])
def programhesapla():
    derslistesi=request.form.getlist('derslistesi[]')
    cakisma=request.form.get('cakisma')
    cakismalimit=cakisma
    if not cakisma:
        cakismalimit=2

    ipadres=request.headers.get('CF-Connecting-IP', request.remote_addr)
    programlar=programOlustur(derslistesi, cakismalimit, ipadres)
    return Response(json.dumps([sonuc.__dict__ for sonuc in programlar], default=str))


@application.route('/programsorgula/<ogrenciNo>', methods=['GET'])
def programsorgula(ogrenciNo):
    ipadres=request.headers.get('CF-Connecting-IP', request.remote_addr)
    programlar=ogrenciDersProgramiGetir(ogrenciNo, ipadres)
    return Response(json.dumps(programlar.__dict__, default=str))


if __name__ == "__main__":
    application.run(host='0.0.0.0')
