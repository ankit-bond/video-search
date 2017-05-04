from pymongo import MongoClient
import json
import os

client = MongoClient()
db = client.search.youtube
file = os.listdir("test")

for i in range(len(file)):
	file[i] = "test/" + file[i]
	new_page = open(file[i],"r")
	json_parsed = json.loads(new_page.read())
	final_result = db.insert(json_parsed)

# db.createIndex({"videoInfo.snippet.description":"text","videoInfo.snippet.tags": "text","videoInfo.snippet.channelTitle": "text","videoInfo.snippet.title": "text"},{"weights":{"videoInfo.snippet.description":4,"videoInfo.snippet.tags":7,"videoInfo.snippet.channelTitle":2,"videoInfo.snippet.title":10},"name": "TextIndex"})