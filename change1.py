from pymongo import MongoClient
import json
import os
from pprint import pprint
from bson import json_util
import sys

client = MongoClient()
db = client.search.youtube

value = sys.argv[1]

cursor = db.find({"videoInfo.id":value},{"videoInfo.statistics.viewCount": 1})

json_docs = []
for doc in cursor:
	new = int(doc['videoInfo']['statistics']['viewCount'])

cur = db.update({"videoInfo.id":value},{'$set':{"videoInfo.statistics.viewCount" : new+1}})