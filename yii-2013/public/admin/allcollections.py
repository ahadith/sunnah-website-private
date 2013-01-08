import sys

collections = ['bukhari', 'muslim', 'malik', 'tirmidhi', 'abudawud', 'nasai', 'ibnmajah', 'nawawi40', 'riyadussaliheen', 'shamail', 'qudsi40', 'bulugh']

for collection in collections:
	print sys.argv[1].replace(":collection:", collection)
