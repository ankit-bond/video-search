from pymongo import MongoClient
import json
import os
from pprint import pprint
from bson import json_util
import sys
import pymongo

client = MongoClient()
db = client.search.youtube

# file = os.listdir("/home/ankit/Downloads/Last")

# value = "India"
value = sys.argv[1]
# cursor = db.find({'$text':{'$search':value}}).limit(5)

cursor = db.find({'$text':{'$search':value}}, {'score':{'$meta': 'textScore'}})
cursor.sort([('score',{'$meta' : 'textScore'}),('videoInfo.statistics.viewCount',pymongo.DESCENDING)])

json_docs = []
for doc in cursor:
	t = json_util.dumps(doc)
	# l = json.loads(t)
	# print(t)
	json_docs.append(t)

print('#####'.join(json_docs))

	













	# print(type(doc))
	# print(json.dumps(docs))
	# json_docs.append(doc)

# for ele in json_docs:
	# pprint(ele)
	# pprint(doc)
	# json_parsed = json.loads(str1)
	# print(json.dumps(json_parsed, indent = 4, sort_keys = True))
	# json_doc = json.dumps(doc,default = json_util.default)
	# json_docs.append(json_doc)
	# pprint(doc)
# pprint(json_docs[0])