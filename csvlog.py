import csv
import os
import time
import subprocess
import ftpupload
import sys

def csvlog(h,t,dewpoint,date,csvname,cam):
	try:
		with open('{:s}.csv'.format(csvname), 'a')as csv_file:
			csv_writer=csv.writer(csv_file, delimiter=',')		
			csv_writer.writerow([('{:s}'.format(t)),'{:s}'.format(h),'{:s}'.format(dewpoint),
			'{:%Y.%m.%d %H:%M}'.format(date)])		
				
			csv_file.flush()
			if(cam=='Igen' or cam=='igen'):			
				#os.system('fswebcam -r 1280x720 {:%Y_%m_%d__%H_%M}.jpg >/dev/null'.format(date))
				with open(os.devnull, 'wb') as devnull:
					subprocess.check_call(['fswebcam', '-r', '1280x720','-S','21','--timestamp','%Y-%m-%d %H:%M','--banner-colour','#FF000000','--line-colour','#FF000000','--title','Hőmérséklet:{:s}°C     Páratartalom:{:s}%     Harmatpont:{:s}°C'.format(t,h,dewpoint),'/home/pi/Weather/Images/{:%Y_%m_%d__%H_%M}.png'.format(date)], stdout=devnull, stderr=subprocess.STDOUT)
				ftpupload.ftpupload('{:%Y_%m_%d__%H_%M}.png'.format(date))
		#print('{:%Y_%m_%d__%H_%M}.png'.format(date))
			
		
		print('CSV:    OK')			
	except:
		print('CSV:    ERROR', sys.exc_info()[0])		
		 
