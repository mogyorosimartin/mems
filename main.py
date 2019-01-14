import Adafruit_DHT as dht
import time
import datetime
import mysql
import math
import googlelog as gl
import csvlog as csvl
import argparse

parser= argparse.ArgumentParser(description='Raspberry-alapú időjárásállomás')
parser.add_argument('-t',dest='time', help='Mérési gyakoriság percben', type=float, default=1)
parser.add_argument('-cam',dest='cam', help='Kép készitése Igen/Nem', type=str, default='Igen')
parser.add_argument('-csv',dest='csvname', help='CSV fájl neve', type=str, default='log')


FREQUENCYINSECONDS=parser.parse_args().time*60
cam=parser.parse_args().cam
csvname=parser.parse_args().csvname

print('Naplózás {:} percenként...'.format(FREQUENCYINSECONDS/60))
while True:
		h,t = dht.read_retry(dht.DHT22, 4)
		b = 17.62 
		c = 243.12
		gamma = (b * float(t/(c + t))) + math.log(h/ 100.0)
		dewpoint = (c * gamma) / (b - gamma)
		while h==None or t==None:
			h,t = dht.read_retry(dht.DHT22, 4)
			time.sleep(FREQUENCYINSECONDS)
		h='{0:0.1f}'.format(h)
		t='{0:0.1f}'.format(t)
		dewpoint='{0:0.1f}'.format(dewpoint)
		date=datetime.datetime.now()
		date = date.replace(microsecond=0)
		mysql.mysqllog(h,t,dewpoint,date)
		csvl.csvlog(h,t,dewpoint,date,csvname,cam)
		gl.glog(h,t,dewpoint,date)
		print('Naplózott adatok:',t+'°C',h+'%',dewpoint+'°C', date)
		print('Ctrl+C megnyomásával megszakithatja a folyamatot...')
		time.sleep(FREQUENCYINSECONDS)
