from pymongo import MongoClient
import json
import os
from pprint import pprint
from bson import json_util
import sys

client = MongoClient()
db = client.search.youtube

# file = os.listdir("/home/ankit/Downloads/Last")

# value = "_4QaOc_u2c0"
value = sys.argv[1]
# cursor = db.find({'$text':{'$search':value}}).limit(5)

cursor = db.find({"videoInfo.id":value})
# cursor.sort([('score',{'$meta' : 'textScore'})])
# cursor.sort([('score', {'$meta': 'textScore'})])
# print(type(cursor))
json_docs = []
for doc in cursor:
	t = json_util.dumps(doc)
# 	# l = json.loads(t)
# 	# print(t)
	json_docs.append(t)

print('#####'.join(json_docs))