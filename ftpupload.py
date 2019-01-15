import ftplib
import ftpsecret

host=ftpsecret.host
port=ftpsecret.port
user=ftpsecret.user
passw=ftpsecret.passw
def ftpupload(iname):
	#iname='test.png'
	f = ftplib.FTP()
	f.connect(host,port)
	f.login(user, passw)
	
	file = open('/home/pi/Weather/Images/{}'.format(iname),'rb')                  # file to send
	#print('/home/pi/Weather/{}'.format(iname))
	f.storbinary('STOR weather/{}'.format(iname), file)     # send the file
	file.close()                                    # close file and FTP
	f.quit()
