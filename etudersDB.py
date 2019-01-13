# -*- coding: utf-8 -*-
"""This is the Db module for EtuDers"""
import os
from etudersweb import application

from datetime import datetime
from flask_sqlalchemy import SQLAlchemy

LoggingEnabled = True
application.config['SQLALCHEMY_DATABASE_URI'] = os.environ['DATABASE_URL']
if not application.config['SQLALCHEMY_DATABASE_URI']:
    LoggingEnabled = False
Db = SQLAlchemy(application)


class Log(Db.Model):
    id = Db.Column(Db.Integer, primary_key=True)
    dersId = Db.Column(Db.String(6), nullable=False)
    ip = Db.Column(Db.String(16), nullable=False)
    date = Db.Column(Db.DateTime, nullable=False, default=datetime.utcnow)

    def __repr__(self):
        return '<DersID: %r, IP: %r, Date: %r>' % self.dersId, self.ip, self.date
