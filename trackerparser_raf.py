# a simple tcp server

import SocketServer
import decimaldegrees as dd
import MySQLdb

class EchoRequestHandler(SocketServer.BaseRequestHandler ):
    def setup(self):
        print self.client_address, 'connected!'
        #self.request.send('hi ' + str(self.client_address) + '\n')

    def handle(self):
        data = 'dummy'
        while data:
            data = self.request.recv(1024)
            #self.request.send(data)
            inizio = data.find(',A')+3
            fine = inizio+24
	    
            if data.find(',A') != -1: 
		print data[inizio:fine]
		data = data[inizio:fine]
		LatiG = data[0:2]
		print 'LatiG: ' + LatiG
		LatiM = data[2:9]
		print 'LatiM: ' + LatiM
		#LatiS = data[5:9]
		#LatiS = LatiS[:2] + "."+ LatiS[2:5]
		#print 'LatiS: ' + LatiS
		

		LongG = data[13:15]
		print 'LongG: ' + LongG
		LongM = data[15:22]
		print 'LongM: ' + LongM
		#LongS = data[18:22]
		#LongS = LongS[:2] + "."+ LongS[2:5]
		#print 'LongS: ' + LongS

		# Input coordinate in DMS format
		#coord = { "degrees": 121, "minutes": 8, "seconds": 6 }

		# Convert coordinate from DMS to DD
		Latitudine = dd.dms2decimal(LatiG, LatiM, 0)
		print Latitudine	
		Longitudine = dd.dms2decimal(LongG, LongM, 0)
		print Longitudine	
		conn = MySQLdb.connect(host="localhost",
		user="tracker",
		passwd="yourpasswordhere",
		db="tracker"
		)


		cursore = conn.cursor()

		cursore.execute('INSERT INTO positions (lat, lon) VALUES('+ str(Latitudine) +','+ str(Longitudine) +')')

	    if data.strip() == 'bye':
                return

    def finish(self):
        print self.client_address, 'disconnected!'
        self.request.send('bye ' + str(self.client_address) + '\n')

    #server host is a tuple ('host', port)
server = SocketServer.ThreadingTCPServer(('', 4433), EchoRequestHandler)
server.serve_forever()
