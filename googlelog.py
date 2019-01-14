import json
import sys
import gspread
from oauth2client.service_account import ServiceAccountCredentials
GDOCS_OAUTH_JSON       = 'Raspberry Pi Weather MEMS-aa95af44553f.json'
GDOCS_SPREADSHEET_NAME = 'Raspberry Pi data'
def login_open_sheet(oauth_key_file, spreadsheet):   
		try:
			scope =  ['https://spreadsheets.google.com/feeds',
			 'https://www.googleapis.com/auth/drive']
			credentials = ServiceAccountCredentials.from_json_keyfile_name(oauth_key_file, scope)
			gc = gspread.authorize(credentials)
			worksheet = gc.open(spreadsheet).sheet1
			return worksheet
		except Exception as ex:
			print('Nem sikerult belepni.')
			print('Bejelentkezes sikertelen, hiba:', ex)
			sys.exit(1)
def glog(h,t,dewpoint,date):		
	worksheet = None
	if worksheet is None:
		worksheet = login_open_sheet(GDOCS_OAUTH_JSON, GDOCS_SPREADSHEET_NAME)    
	humidity, temp = h,t 
	try:
		worksheet.append_row((float(temp), float(humidity)/100,float(dewpoint),date.strftime("%Y.%m.%d %H:%M")))
		print('Google: OK')
	except:        
		print('Google: Google dokumentum naplózása sikertelen')
		worksheet = None


