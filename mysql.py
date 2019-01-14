import pymysql.cursors
import sqlconnect as sc
import time




def mysqllog(h,t,dewpoint,date):
	try:
		connection = pymysql.connect(
		  host=sc.host,
		  user=sc.user,
		  passwd=sc.passwd,
		  database=sc.database,
		  
		)
		mycursor = connection.cursor()
		sql = 'INSERT INTO RaspberryPiWeatherLog(Homerseklet,Paratartalom,Harmatpont, Datum) VALUES (%s, %s,%s, %s)'
		val = (str(t),str(h),str(dewpoint),str(date))
		mycursor.execute(sql, val)
		connection.commit()	
		connection.close()
		print('MYSQL:  OK')
	except pymysql.InternalError as err:
		code, message = err.args
		print('MYSQL:  ERROR:',code,message)
